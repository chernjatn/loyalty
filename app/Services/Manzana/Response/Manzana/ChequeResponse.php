<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response;

use Throwable;
use Money\Money;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Ultra\Shop\Exceptions\LoyaltyException;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests\ChequeRequest;
use Ultra\Shop\Services\Order\OrderItem;
use Ultra\Shop\VO\Coupon;

class ChequeResponse
{
    protected const COUPON_BORDER      = 'Причина: ';
    protected const EXT_CPN_KEY        = 'MNZ_PC26';

    protected SoapResponseRaw $response;
    protected ?Collection $items       = null;
    protected ?string $error           = null;
    protected ?Collection $coupons     = null;
    protected ?ChequeBonusResponse $bonusesResponse = null;

    public function __construct(ChequeRequest $request, SoapResponseRaw $response)
    {
        try {
            $this->response = $response;
            $resp = (object) (data_get($response->getResponse(), 'ProcessRequestResult.ChequeResponse.0') ?? throw new LoyaltyException(__('common.error_default')));

            if (!empty($resp->ReturnCode ?? null)) throw new LoyaltyException($resp->Message);

            $this->bonusesResponse = new ChequeBonusResponse($response);

            if (!isset($resp->Item)) throw new LoyaltyException($resp->Message ?? __('common.error_default'));

            $this->items = collect($resp->Item)->mapWithKeys(
                static fn ($item) => [$item->Article => new ChequeResponseItem($item, (float) ($resp->Summ ?? throw new LoyaltyException('wrong summ')), (float) ($resp->ChargedBonus ?? 0))]
            );

            $this->coupons = $request->getRegularCoupons()->union($request->getExtendedCoupons());

            if (!empty($resp->Coupons)) {
                foreach ($resp->Coupons->Coupon as $couponRaw) {
                    transform(
                        $this->coupons->get($couponRaw->Number ?? $couponRaw->TypeID),
                        function (Coupon $coupon) use ($couponRaw) {
                            $coupon->setStatus(!empty($couponRaw->ApplicabilityCode));
                            $coupon->setStatusMessage(Str::after($couponRaw->ApplicabilityMessage, self::COUPON_BORDER));
                        }
                    );
                }
            }

            if ($request->getExtendedCoupons()->isNotEmpty()) {
                $extendedCouponActivated = collect($resp->Item)->contains(
                    function ($item) {
                        foreach ($item->ExtendedAttribute ?? [] as $extendedAttr) {
                            if ($extendedAttr->Key == self::EXT_CPN_KEY) return true;
                        }
                        return false;
                    }
                );
                $request->getExtendedCoupons()->each(function (Coupon $coupon) use ($extendedCouponActivated) {
                    transform(
                        $this->coupons->get($coupon->getNumber()),
                        function (Coupon $coupon) use ($extendedCouponActivated) {
                            $coupon->setStatus($extendedCouponActivated);
                            $coupon->setStatusMessage($extendedCouponActivated ? __('order.coupon_applied') : __('order.coupon_invalid'));
                        }
                    );
                });
            }
        } catch (Throwable $e) {
            (new LoyaltyException($e->getMessage(), $e->getCode(), $e))->report();
            $this->setError($e->getMessage());
        }
    }

    public function getResponse(): SoapResponseRaw
    {
        return $this->response;
    }

    public function getPaidByBonus(): ?Money
    {
        return $this->bonusesResponse->getPaidByBonus();
    }

    public function getBonusesReceive(): ?Money
    {
        return $this->bonusesResponse->getBonusesReceive();
    }

    public function getItem(OrderItem $orderItem): ?ChequeResponseItem
    {
        return $this->items?->get($orderItem->getSellable()->getArticle());
    }

    public function isError(): bool
    {
        return !is_null($this->getError());
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    private function setError(?string $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function getCoupons(): Collection
    {
        return $this->coupons ?? new Collection();
    }
}

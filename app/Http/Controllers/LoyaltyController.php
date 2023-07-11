<?php

namespace App\Http\Controllers;

use App\Requests\PhoneRequest;
use App\Requests\ClientCreateRequest;
use App\Requests\SmsVerificationRequest;
use App\Requests\CardRequest;
use App\Services\Loyalty\LoyaltyManager;
use App\Services\Sms\NotificationService;
use App\Services\Sms\SmsNotifiable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class LoyaltyController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * check if there is a card
     * @param PhoneRequest $request
     */
    public function checkIsCard(PhoneRequest $request)
    {
        $existsCard = $this->getLoyaltyManager()->existsCard($request->getPhone());

        return response()->success()
            ->setData([
                'status' => true,
                'existsCard' => $existsCard
            ]);
    }

    /**
     * send code via sms
     * @param PhoneRequest $request
     */
    public function verify(PhoneRequest $request)
    {
        $smsVerification = new NotificationService(new SmsNotifiable(session()->getId(), $request->getPhone()));

        return response()->success()
            ->setData([
                'status' => true,
                'expiration time' => $smsVerification->sendCode()
            ]);
    }

    /**
     * get a card
     * @param SmsVerificationRequest $request
     */
    public function card(SmsVerificationRequest $request)
    {
        $cardClient = $this->getLoyaltyManager()->getLoyCardByPhone($request->getPhone())->first()->getNumber();

        return response()->success()
            ->setData([
                'status' => true,
                'card' => $cardClient
            ]);
    }

    /**
     * get active balance
     * @param CardRequest $request
     */
    public function balance(CardRequest $request)
    {
        $activeBalance = $this->getLoyaltyManager()->getLoyCardByPhone($request->getPhone())->first()->getBalance();

        return response()->success()
            ->setData([
                'status' => true,
                'activeBalance' => $activeBalance
            ]);
    }

    /**
     * creates a new client with binding card or will update existing fields
     * @param ClientCreateRequest $request
     */
    public function create(ClientCreateRequest $request)
    {
        $cardClient = $this->getLoyaltyManager()->registerLoyCard($request->getDTO())->getNumber();

        return response()->success()
            ->setData([
                'status' => true,
                'card' => $cardClient
            ]);
    }

    public function getLoyaltyManager()
    {
        return new LoyaltyManager(app());
    }
}

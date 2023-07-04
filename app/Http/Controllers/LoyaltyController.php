<?php

namespace App\Http\Controllers;

use App\Requests\PhoneRequest;
use App\Requests\ClientCreateRequest;
use App\Requests\SmsVerificationRequest;
use App\Requests\CardRequest;
use App\Services\Sms\NotificationService;
use App\Services\Sms\SmsNotifiable;

class LoyaltyController extends Controller
{
    /**
     * check if there is a card
     * @param PhoneRequest $request
     */
    public function checkIsCard(PhoneRequest $request)
    {
        $existsCard = $this->loyaltyManager->existsCard($request->getPhone());

        return getResponse()->success()
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

        return getResponse()->success()
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
        $cardClient = $this->loyaltyManager->getLoyCardByPhone($request->getPhone())->first()->getNumber();

        return getResponse()->success()
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
        $activeBalance = $this->loyaltyManager->getLoyCardByPhone($request->getPhone())->first()->getBalance();

        return getResponse()->success()
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
        $cardClient = $this->loyaltyManager->registerLoyCard($request->getDTO())->getNumber();

        return getResponse()->success()
            ->setData([
                'status' => true,
                'card' => $cardClient
            ]);
    }
}

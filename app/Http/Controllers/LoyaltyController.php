<?php

namespace App\Http\Controllers;

use App\Requests\CardRequest;
use App\Requests\ClientCreateRequest;
use App\Requests\PhoneRequest;
use App\Requests\SmsVerificationRequest;
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


    public function checkIsCard(PhoneRequest $request)
    {
        $existsCard = $this->getLoyaltyManager()->existsCard($request->getPhone());

        return response([
            'status' => true,
            'existsCard' => $existsCard,
        ]);
    }


    public function verify(PhoneRequest $request)
    {
        $smsVerification = new NotificationService(new SmsNotifiable(session()->getId(), $request->getPhone()));

        return response([
            'status' => true,
            'expirationTime' => $smsVerification->sendCode()->toTimeString(),
        ]);
    }


    public function card(SmsVerificationRequest $request)
    {
        $cardClient = $this->getLoyaltyManager()->getLoyCardByPhone($request->getPhone())?->number;

        return response([
            'status' => true,
            'card' => $cardClient,
        ]);
    }


    public function balance(CardRequest $request)
    {
        $activeBalance = $this->getLoyaltyManager()->getLoyCardByPhone($request->getPhone())?->balance;

        return response([
            'status' => true,
            'activeBalance' => $activeBalance,
        ]);
    }


    public function create(ClientCreateRequest $request)
    {
        $cardClient = $this->getLoyaltyManager()->registerLoyCard($request->getDTO())->number;

        return response([
            'status' => true,
            'card' => $cardClient,
        ]);
    }


    public function getLoyaltyManager()
    {
        return new LoyaltyManager(app());
    }
}

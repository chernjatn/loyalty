<?php

namespace App\Http\Controllers;

use App\Services\Loyalty\LoyaltyManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Enums\LoyaltyType;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LoyaltyManager $loyaltyManager;

    public function __construct(LoyaltyManager $loyaltyManager)
    {
        $this->loyaltyManager = $loyaltyManager;
    }
}

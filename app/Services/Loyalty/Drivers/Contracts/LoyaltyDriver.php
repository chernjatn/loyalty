<?php

namespace App\Services\Loyalty\Drivers\Contracts;

use App\DTO\CustomerAddDTO;
use App\Entity\LoyaltyCustomer;
use App\Entity\LoyCard;
use App\Entity\Phone;
use Illuminate\Support\Collection;

interface LoyaltyDriver
{
    public function getLoyCardByPhone(Phone $phone): ?Collection;

    public function getLoyaltyCustomerByPhone(Phone $phone, bool $useCache = true): ?LoyaltyCustomer;

    public function registerLoyCard(CustomerAddDTO $customerAddDTO): LoyCard;
}

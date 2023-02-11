<?php
namespace App\Services\Loyalty\Drivers\Contracts;

use Illuminate\Support\Collection;
use App\Entity\Phone;
use App\Entity\LoyCard;
use App\DTO\CustomerAddDTO;

interface LoyaltyDriver
{
    public function getLoyCardByPhone(Phone $phone): ?Collection;
    //public function getLoyaltyCustomerByPhone($phone, bool $useCache = true): ?Customer;
    public function registerLoyCard(CustomerAddDTO $customerAddDTO): LoyCard;
}

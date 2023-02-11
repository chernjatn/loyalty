<?php

namespace App\Services\Loyalty;

use Illuminate\Support\Manager;
use App\Services\Loyalty\Drivers\Manzana\ManzanaDriver;

class LoyaltyManager extends Manager
{
    protected function createManzanaDriver()
    {
        return $this->container->make(ManzanaDriver::class);
    }

    public function getDefaultDriver()
    {
        return 'manzana';
    }
}

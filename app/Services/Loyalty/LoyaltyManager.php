<?php

namespace App\Services\Loyalty;

use App\Services\Loyalty\Drivers\Manzana\ManzanaDriver;
use Illuminate\Support\Manager;

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

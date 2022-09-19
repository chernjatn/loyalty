<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO;

use Carbon\Carbon;
use Ultra\Shop\Contracts\Loyalty\FavoriteCategory as FavoriteCategoryContract;

class FavoriteCategory implements FavoriteCategoryContract
{
    private string $guid;
    private string $name;
    private ?Carbon $dateTo = null;

    public function __construct(string $guid, string $name, ?Carbon $dateTo = null)
    {
        $this->guid   = $guid;
        $this->name   = $name;
        $this->dateTo = $dateTo;
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDateTo(): ?Carbon
    {
        return $this->dateTo;
    }
}

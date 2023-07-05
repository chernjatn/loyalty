<?php
use App\Enums\LoyaltyType;
use App\Response\Response;
use App\Services\Loyalty\LoyaltyManager;

function loyaltyType(): LoyaltyType
{
    return app(LoyaltyType::class);
}

function getResponse(): Response
{
    return app(Response::class);
}

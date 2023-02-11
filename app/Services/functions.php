<?php
use App\Enums\LoyaltyType;
use App\Response\Response;

function loyaltyType(): LoyaltyType
{
    return app(LoyaltyType::class);
}

function getResponse(): Response
{
    return app(Response::class);
}

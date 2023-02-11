<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana;

use Illuminate\Support\Collection;
use Webkul\Core\Models\Channel;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests\ExtendedAttribute\BindRequest;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests\ExtendedAttribute\GetRequest;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\ExtendedAttribute\EAValue;

class ExtendedAttributesManager
{
    public function __construct(
        private Channel $channel,
        private Contact $contact,
    ) {
    }

    /**
     * @return Collection<string, EAValue>
     */
    public function getAll(): Collection
    {
        return (new GetRequest($this->channel, $this->contact))->processRequest();
    }

    public function get(string $key): ?EAValue
    {
        return $this->getAll()->get($key);
    }

    public function bind(string $key, EAValue $value): bool
    {
        return (new BindRequest($this->channel, $this->contact, $key, $value))->processRequest();
    }
}

<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Webkul\Core\Models\Channel;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;

abstract class BaseByContactRequest extends JSONRequest
{
    public function __construct(Channel $channel, protected Contact $contact)
    {
        parent::__construct($channel);
    }
}

<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Enums\LoyCardType;
use App\Entity\LoyCard;

class LoyCardCreateRequest extends BaseByContactRequest
{
    private const REQUEST_APE_PATH  = '/Card/CreateBindVirtualCard';

    public function processRequest(): ?LoyCard
    {
        $emissionTplAutoreg = $this->config['emission_tpl_autoreg'];

        return transform(
            $this->post(
                $this->managerDomain . self::REQUEST_APE_PATH,
                $this->preparePostSuperQuery([
                    'ContactId'                  => $this->contact->id,
                    'EmissionTemplateExternalId' => $emissionTplAutoreg
                ]),
                'Number'
            ),
            fn ($cardNumber) => new LoyCard($cardNumber)
        );
    }
}

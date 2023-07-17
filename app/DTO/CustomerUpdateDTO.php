<?php

namespace Ultra\Shop\DTO\Entity;

use LogicException;
use App\DTO\CustomerAddDTO;

class CustomerUpdateDTO extends CustomerAddDTO
{
    public function __construct(array $fields)
    {
        $fields['password']  = '';

        parent::__construct($fields);
    }

    protected function rules()
    {
        $rules = parent::rules();

        $rules['email'][0]    = 'required';
        $rules['prefConn'][0] = 'nullable';

        unset($rules['phone']);
        unset($rules['password']);

        return $rules;
    }

    public function getPassword(): string
    {
        throw new LogicException('cant get password on update');
    }
}

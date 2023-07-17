<?php

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

return [
    'custom' => [
        'sms_verification_code'  => 'Введите код из смс',
        'sms_verification_wrong' => 'Неверный код, попробуйте еще раз',
        'too_many_attempts'      => 'Превышено количество попыток. Попробуйте через :seconds секунд',
        'too_many_attempts_s'    => 'Превышено количество попыток. Попробуйте позже',
    ]
];

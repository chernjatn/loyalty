<?php

return [
    'loyaltyType' => [
        'superapteka' => [
            'supports_favoritable_categories' => true,
            'default_utm_campaign' => 'Интернет магазин',
            //          'default_loy_card_type'           => LoyCardType::SUPERAPTEKA,
            'loy_card_default_auth' => 2500332293609,
            'loy_card_default_unauth' => 2500332293609,
            'emission_tpl_autoreg' => 'virtual_auto_sa',
            'org_name' => '',
            'app_id' => 335656,
            'organization' => 356565,
            'brand' => 1,
            'soap' => [
                'auth' => [
                    'login' => '',
                    'password' => '',
                ],
                'wsdl' => '',
            ],
            'json' => [
                'customer_domain' => '',
                'manager_domain' => '',
                'partner_id' => '',
                'super_session' => '',
            ],
            'extended' => [
                'common' => [
                    'Atr_SUPERAPTEKA' => 'Интернет магазин',
                    'Atp_SUPERAPTEKA' => 'Интернет-магазин_СУПЕРАПТЕКА_все чеки',
                    'Atp_3' => 'Супераптека',
                    'Ats_Im_sa' => 'Интернет магазин',
                ],
                'delivery' => [
                    'Atp_del_sa' => 'Доставка сайт супераптека',
                ],
                'pickup' => [],
            ],
        ],
        'ozerki' => [
            'supports_favoritable_categories' => true,
            'default_utm_campaign' => 'Интернет магазин',
            //        'default_loy_card_type'           => LoyCardType::ZOZ,
            'loy_card_default_auth' => 2500189805123,
            'loy_card_default_unauth' => 2500189805123,
            'emission_tpl_autoreg' => 'virtual_auto_oz',
            'org_name' => '',
            'app_id' => 36,
            'organization' => 3,
            'brand' => 1,
            'soap' => [
                'auth' => [
                    'login' => '',
                    'password' => '',
                ],
                'wsdl' => '',
            ],
            'json' => [
                'customer_domain' => '',
                'manager_domain' => '',
                'partner_id' => '',
                'super_session' => '',
            ],
            'extended' => [
                'common' => [
                    'Atr_Im1' => 'Интернет магазин',
                    'Ats_Im_oz' => 'Интернет магазин',
                    'Atp_Im1' => '',
                    'Atp_1' => '',
                    'Im2' => '',
                ],
                'delivery' => [
                    'Atp_del_oz' => 'Доставка сайт озерки',
                ],
                'pickup' => [],
            ],
        ],
    ],
];

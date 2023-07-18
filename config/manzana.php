<?php

return [
    'loyaltyType'                => [
        'superapteka' => [
            'supports_favoritable_categories' => true,
            'default_utm_campaign'            => 'Интернет магазин',
  #          'default_loy_card_type'           => LoyCardType::SUPERAPTEKA,
            'loy_card_default_auth'           => 2500332293609,
            'loy_card_default_unauth'         => 2500332293609,
            'emission_tpl_autoreg'            => 'virtual_auto_sa',
            'org_name'                        => 'superapteka',
            'app_id'                          => 33,
            'organization'                    => 3,
            'brand'                           => 1,
            'soap'                            => [
                'auth' => [
                    'login'    => 'ozerki\internetapteka',
                    'password' => 'dAru_Yx8P',
                ],
                'wsdl'     => 'http://mnz-crm.erkapharm.com:8083/posprocessing.asmx?wsdl',
            ],
            'json'                    => [
                'customer_domain'   => 'https://mnz-cos.erkapharm.com/CustomerOfficeService',
                'manager_domain'    => 'https://mnz-mos.erkapharm.com/ManagerOfficeService',
                'partner_id'        => '67F23196-1DF8-E611-80D8-00155DFA8043',
                'super_session'     => '01A02BFE-1EFD-46C7-812E-446EC4A34FB1',
            ],
            'extended'                => [
                'common' => [
                    'Atr_SUPERAPTEKA' => 'Интернет магазин',
                    'Atp_SUPERAPTEKA' => 'Интернет-магазин_СУПЕРАПТЕКА_все чеки',
                    'Atp_3'           => 'Супераптека',
                    'Ats_Im_sa'       => 'Интернет магазин',
                ],
                'delivery' => [
                    'Atp_del_sa'      => 'Доставка сайт супераптека',
                ],
                'pickup' => []
            ],
        ],
        'ozerki'      => [
            'supports_favoritable_categories' => true,
            'default_utm_campaign'            => 'Интернет магазин',
    #        'default_loy_card_type'           => LoyCardType::ZOZ,
            'loy_card_default_auth'           => 2500189805123,
            'loy_card_default_unauth'         => 2500189805123,
            'emission_tpl_autoreg'            => 'virtual_auto_oz',
            'org_name'                        => 'ozerki',
            'app_id'                          => 36,
            'organization'                    => 3,
            'brand'                           => 1,
            'soap'                            => [
                'auth' => [
                    'login'    => 'ozerki\internetapteka',
                    'password' => 'dAru_Yx8P',
                ],
                'wsdl'     => 'http://mnz-crm.erkapharm.com:8083/posprocessing.asmx?wsdl',
            ],
            'json'                    => [
                'customer_domain'   => 'https://mnz-cos.erkapharm.com/CustomerOfficeService',
                'manager_domain'    => 'https://mnz-mos.erkapharm.com/ManagerOfficeService',
                'partner_id'        => '5C0F2C5E-69A6-E611-80D2-00155DFA8043',
                'super_session'     => 'eb8d87d4-2dd8-43c2-a05a-40f72b51381f',
            ],
            'extended'                => [
                'common' => [
                    'Atr_Im1'         => 'Интернет магазин',
                    'Ats_Im_oz'       => 'Интернет магазин',
                    'Atp_Im1'         => 'Интернет-магазин_Озерки_все чеки',
                    'Atp_1'           => 'Озерки',
                    'Im2'             => 'Solgar',
                ],
                'delivery' => [
                    'Atp_del_oz'      => 'Доставка сайт озерки',
                ],
                'pickup' => []
            ],
        ]
    ],
    'partner_loycard_type' => [
//        '77506BDD-D5C5-E611-80D3-00155DFA8043' => LoyCardType::ZOZ,
//        '5C0F2C5E-69A6-E611-80D2-00155DFA8043' => LoyCardType::ZOZ,
//        '5E156FB8-D15D-E811-80BF-001DD8B769F3' => LoyCardType::SUPERSAMSON,
//        '8848908C-1DF8-E611-80D8-00155DFA8043' => LoyCardType::YA_BUDU_JIT,
//        '67F23196-1DF8-E611-80D8-00155DFA8043' => LoyCardType::SUPERAPTEKA,
//        '6FA124EB-D9D4-EB11-80D2-B246FB4E9C35' => LoyCardType::APTEKA_RU,
    ],
];

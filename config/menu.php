<?php

return [
    'sidebar' => [
        [
            'type' => 'group',
            'label' => 'Home',
            'required_features' => [1],
            'children' => [
                [
                    'type' => 'single',
                    'label' => 'Home',
                    'icon' => 'icon-home',
                    'url' => 'home',
                    'active' => '\View::shared("menu_active") == "home"',
                ],
                [
                    'type' => 'single',
                    'label' => 'Home Setting',
                    'icon' => 'fa fa-cog',
                    'url' => 'setting/home/user',
                    'active' => '\View::shared("menu_active") == "setting-home-user"',
                ],
            ]
        ],

        [
            'type' => 'group',
            'label' => 'Accounts',
            'children' => [
                [
                    'type' => 'tree',
                    'label' => 'User',
                    'icon' => 'icon-home',
                    'children' => [
                        [
                            'label' => 'New User',
                            'active' => '\View::shared("submenu_active") == "user-new"',
                            'url' => 'user/create',
                            'required_features' => [4],
                        ],
                        [
                            'label' => 'New Pemda',
                            'active' => '\View::shared("submenu_active") == "pemda-new"',
                            'url' => 'user/pemda/create',
                            'required_features' => [4],
                        ],
                        [
                            'label' => 'User List',
                            'url' => 'user',
                            'required_features' => [2],
                            'active' => '\View::shared("submenu_active") == "user-list"'
                        ],
                        [
                            'label' => 'Log Activity',
                            'active' => '\View::shared("submenu_active") == "user-log"',
                            'url' => 'user/activity',
                            'required_features' => [7],
                        ],
                        
                    ],
                ],
            ],
        ],
        [
            'type' => 'group',
            'label' => 'Browse',
            'children' => [
                [
                    'label' => 'Tukang Sedot',
                    'type' => 'tree',
                    'icon' => 'fa fa-university',
                    'required_features' => [323,324,325,326,327,348],
                    'children' => [
                        [
                            'label' => 'New Tukang Sedot',
                            'url' => 'tukang-sedot/create',
                            'active' => '\View::shared("submenu_active") == "tukang-sedot-new"',
                            'required_features' => [325],
                        ],
                        [
                            'label' => 'Tukang Sedot List',
                            'url' => 'tukang-sedot',
                            'active' => '\View::shared("submenu_active") == "tukang-sedot-list"',
                            'required_features' => [323,324,326,327],
                        ],
                        [
                            'label' => 'Candidate List',
                            'url' => 'tukang-sedot/candidate',
                            'required_features' => [323,324,326,327],
                            'active' => '\View::shared("submenu_active") == "tukang-sedot-candidate"',
                            'badge' => [
                                'type' => 'warning',
                                'value' => 'tukang_sedot_register_pending',
                            ]
                        ],
                    ],
                    'badge' => [
                        'type' => 'warning',
                        'value' => 'tukang-sedot',
                    ]
                ],
                [
                    'label' => 'Outlet',
                    'icon' => 'icon-pointer',
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Outlet',
                            'url' => 'outlet/create',
                            'required_features' => [26],
                            'required_configs' => [82],
                        ],
                       
                        [
                            'label' => 'Outlet List',
                            'active' => '\View::shared("submenu_active") == "outlet-list"',
                            'url' => 'outlet/list',
                            'required_features' => [24],
                        ],
                       
                        [
                            'label' => 'Manage Location',
                            'active' => '\View::shared("submenu_active") == "manage-location"',
                            'url' => 'outlet/manage-location',
                            'required_configs' => [2,3],
                            'required_features' => [27],
                        ],
                    ]
                ],
                [
                    'label' => 'Commission Sedot WC',
                    'icon' => 'fa fa-money',
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Commission',
                            'active' => '\View::shared("submenu_active") == "commission-sedot-wc-new"',
                            'url' => 'tukang-sedot/commission/create',
                        ],
                       
                        [
                            'label' => 'Commission List',
                            'active' => '\View::shared("submenu_active") == "commission-sedot-wc-list"',
                            'url' => 'tukang-sedot/commission',
                        ],
                    ]
                ],
                [
                    'label' => 'Setting Global Sedot WC',
                    'active' => '\View::shared("menu_active") == "setting-global-comiisission-sedot"',
                    'url' => 'setting/setting-global-commission-sedot-wc',
                    'icon' => 'fa fa-cog'
                ],
                [
                    'label' => 'User Rating',
                    'type' => 'tree',
                    'icon' => 'icon-star',
                    'children' => [
                        [
                            'label' => 'User Rating List',
                            'url' => 'user-rating',
                            'required_features' => [352],
                        ],
                        [
                            'label' => 'User Rating Setting',
                            'url' => 'user-rating/setting',
                            'required_features' => [353],
                        ],
                    ]
                ],
                
            ],
        ],
        [
            'type' => 'group',
            'label' => 'Order',
            'children' => [
                [
                    'type' => 'tree',
                    'label' => 'Transaction',
                    'icon' => 'fa fa-shopping-cart',
                    'children' => [
                        [
                            'label' => 'Transaction List',
                            'required_features' => [69],
                            'active' => '\View::shared("submenu_active") == "transaction"',
                            'url' => 'transaction',
                            'badge' => [
                                'type' => 'warning',
                                'value' => 'transaction_pending',
                            ]
                        ],
                    ],
                    'badge' => [
                        'type' => 'warning',
                        'value' => 'transaction_pending',
                    ]
                ],
                [
                    'label' => 'Failed Void Payment',
                    'required_features' => [299],
                    'active' => '\View::shared("menu_active") == "failed-void-payment"',
                    'url' => 'transaction/failed-void-payment',
                    'icon' => 'fa fa-exclamation-triangle'
                ],
                [
                        'label' => 'Points History',
                        'required_features' => [93],
                        'active' => '\View::shared("menu_active") == "balance"',
                        'url' => 'transaction/balance',
                        'icon' => 'fa fa-clock-o'
                ],
                [
                    'type' => 'tree',
                    'label' => 'Order Settings',
                    'icon' => 'fa fa-cogs',
                    'children' => [
                        [
                            'label' => 'Setting Fee',
                            'required_features' => [250],
                            'active' => '\View::shared("submenu_active") == "setting-fee"',
                            'url' => 'transaction/setting/all-fee'
                        ],
                        [
                            'label' => 'Available Payment Method',
                            'required_features' => [250],
                            'active' => '\View::shared("submenu_active") == "setting-payment-method"',
                            'url' => 'transaction/setting/available-payment'
                        ],
                        [
                            'label' => 'Available Delivery',
                            'required_features' => [320],
                            'active' => '\View::shared("submenu_active") == "delivery-setting-available"',
                            'url' => 'transaction/setting/available-delivery'
                        ],
                        [
                            'label' => 'Setting Refund Reject Order',
                            'required_features' => [250],
                            'active' => '\View::shared("submenu_active") == "refund-reject-order"',
                            'url' => 'transaction/setting/refund-reject-order'
                        ]
                    ]
                ],
            ]
        ],

        [
            'type' => 'group',
            'label' => 'Settings',
            'children' => [
                [
                    'label' => 'Mobile Apps Home',
                    'required_features' => [15, 16, 17, 18, 144, 145, 146, 147, 241, 246],
                    'active' => '\View::shared("menu_active") == "setting-home"',
                    'url' => 'setting/home',
                    'icon' => 'icon-screen-tablet '
                ],
                
                [
                    'label' => 'Version Control',
                    'required_features' => [354],
                    'active' => '\View::shared("menu_active") == "setting-version"',
                    'url' => 'version',
                    'icon' => 'fa fa-info-circle'
                ],
                [
                    'label' => 'Custom Page',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Custom Page',
                            'required_features' => [150],
                            'url' => 'custom-page/create'
                        ],
                        [
                            'label' => 'Custom Page List',
                            'required_features' => [149,151,152,153],
                            'active' => '\View::shared("submenu_active") == "custom-page-list"',
                            'url' => 'custom-page'
                        ],
                    ],
                    'icon' => 'icon-book-open'
                ],
                [
                    'label' => 'Intro Apps',
                    'required_features' => [168],
                    'required_configs' => [108],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Intro First Install',
                            'url' => 'setting/intro/first'
                        ]
                    ],
                    'icon' => 'icon-screen-tablet'
                ],
                [
                    'label' => 'Confirmation Messages',
                    'required_features' => [162,163],
                    'url' => 'setting/confirmation-messages',
                    'icon' => 'icon-speech'
                ],
                [
                    'label' => 'Maintenance Mode',
                    'required_features' => [220],
                    'url' => 'setting/maintenance-mode',
                    'icon' => 'icon-wrench'
                ],
                [
                    'label' => 'Time Expired OTP and Email',
                    'required_features' => [251,252],
                    'url' => 'setting/time-expired',
                    'icon' => 'fa fa-envelope'
                ],
            ],
        ],
        [
            'type' => 'group',
            'label' => 'CRM',
            'children' => [
                [
                    'label' => 'CRM Setting',
                    'required_features' => [],
                    'icon' => 'icon-settings',
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Text Replace',
                            'required_features' => [96],
                            'active' => '\View::shared("submenu_active") == "textreplace"',
                            'url' => 'textreplace'
                        ],
                        [
                            'label' => 'Email Header & Footer',
                            'required_features' => [97],
                            'active' => '\View::shared("submenu_active") == "email"',
                            'url' => 'email-header-footer'
                        ]
                    ]
                ],
                [
                    'label' => 'Contact Us',
                    'required_features' => [83,84],
                    'active' => '\View::shared("submenu_active") == "enquiries-list"',
                    'url' => 'enquiries',
                    'icon' => 'icon-action-undo'
                ],
                [
                    'label' => 'Forward Contact Us',
                    'required_features' => [83,84],
                    'active' => '\View::shared("submenu_active") == "contact-us-autoresponse-forward-contact-us"',
                    'url' => 'autoresponse/contact-us/forward-contact-us',
                    'icon' => 'icon-action-undo'
                ],
            ]
        ],
        [
            'type' => 'group',
            'label' => 'About',
            'children' => [
                [
                    'label' => 'FAQ',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New FAQ',
                            'required_features' => [89],
                            'url' => 'setting/faq/create'
                        ],
                        [
                            'label' => 'List FAQ',
                            'required_features' => [88],
                            'active' => '\View::shared("submenu_active") == "faq-list"',
                            'url' => 'setting/faq'
                        ],
                        [
                            'label' => 'Sorting FAQ List',
                            'required_features' => [88],
                            'active' => '\View::shared("submenu_active") == "faq-sort"',
                            'url' => 'setting/faq/sort'
                        ],
                    ],
                    'icon' => 'icon-question'
                ],
                
            ],
        ],
    ],
];

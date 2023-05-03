<?php

return [
    'sidebar' => [
        /** SAMPLE AVAILABLE PARAMETER
        [
            'type' => 'tree', // 'group' / 'tree' / 'heading' / 'single'
            'label' => 'Menu Title',
            'icon' => 'fa fa-home',
            'url' => '/',
            'active' => '\View::shared("menu_active") == "user"', // cukup taruh di child nya aja, parent otomatis
            'children' => [],
            'required_configs' => [1,2], // kalau parent tidak ada ketentuan khusus cukup taruh di child nya aja
            'required_configs_rule' => 'or',
            'required_features' => [1,2], // kalau parent tidak ada ketentuan khusus cukup taruh di child nya aja
            'required_features_rule' => 'or',
            'badge' => [
                'type' => 'info', // info | success | warning | danger
                'value' => 'total_home', // for eval
            ],
        ],
        */

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
                        [
                            'type' => 'group',
                            'required_configs' => [40],
                            'required_features' => [92],
                            'children' => [
                                [
                                    'label' => '[Response] Pin Sent',
                                    'url' => 'user/autoresponse/pin-sent',
                                    'required_configs' => [41],
                                ],
                                [
                                    'label' => '[Response] Pin Create',
                                    'url' => 'user/autoresponse/pin-create',
                                    'required_configs' => [131],
                                ],
                                [
                                    'label' => '[Response] Pin Verified',
                                    'url' => 'user/autoresponse/pin-verify',
                                    'required_configs' => [42],
                                ],
                                [
                                    'label' => '[Response] Email Verify',
                                    'url' => 'user/autoresponse/email-verify',
                                    'required_configs' => [106],
                                ],
                                [
                                    'label' => '[Response] Pin Changed First Time',
                                    'url' => 'user/autoresponse/pin-changed',
                                    'required_configs' => [43],
                                ],
                                [
                                    'label' => '[Response] Pin Changed Forgot Password',
                                    'url' => 'user/autoresponse/pin-changed-forgot-password',
                                    'required_configs' => [43],
                                ],
                                [
                                    'label' => '[Response] Pin Forgot',
                                    'url' => 'user/autoresponse/pin-forgot',
                                    'required_configs' => [83],
                                ],
                                [
                                    'label' => '[Response] Login Success',
                                    'url' => 'user/autoresponse/login-success',
                                    'required_configs' => [44],
                                ],
                                [
                                    'label' => '[Response] Login Failed',
                                    'url' => 'user/autoresponse/login-failed',
                                    'required_configs' => [45],
                                ],
                                [
                                    'label' => '[Response] Login First Time',
                                    'url' => 'user/autoresponse/login-first-time',
                                    'required_configs' => [43],
                                ],
                            ],
                        ],
                    ],
                ],
                /** HIDE
                [
                    'label' => 'Admin Outlet',
                    'type' => 'tree',
                    'icon' => 'icon-eye',
                    'required_configs' => [5],
                    'children' => [
                        [
                            'label' => 'New Admin Outlet',
                            'url' => 'user/adminoutlet/create',
                            'required_features' => [4],
                        ],
                        [
                            'label' => 'Admin Outlet List',
                            'active' => '\View::shared("submenu_active") == "admin-outlet-list"',
                            'url' => 'user/adminoutlet',
                            'required_features' => [9],
                        ],
                    ],
                ],
                */
                [
                    'label' => 'Membership',
                    'url' => 'membership',
                    'icon' => 'icon-badge',
                    'required_configs' => [20],
                    'required_features' => [11, 13],
                ],
                [
                    'label' => 'Setting Point Reset',
                    'url' => 'setting/point_reset',
                    'icon' => 'fa fa-refresh',
                    'required_configs' => [18,77],
                    'required_configs_rule' => 'and',
                    'required_features' => [457],
                ],
                [
                    'label' => 'Profile Completion',
                    'type' => 'tree',
                    'icon' => 'icon-users',
                    'required_features' => [148],
                    'children' => [
                        [
                            'label' => 'User Profile Completion',
                            'url' => 'setting/complete-profile',
                        ],
                        [
                            'label' => '[Response] User Profile Completion Point Bonus',
                            'url' => 'user/autoresponse/complete-user-profile-point-bonus',
                        ],
                    ],
                ],
                [
                    'type' => 'group',
                    'required_configs' => [19,78],
                    'required_features' => [359],
                    'required_configs_rule' => 'and',
                    'children' => [
                        [
                            'icon' => 'fa fa-refresh',
                            'label' => 'Setting ' . env('POINT_NAME', 'Points') . ' Reset',
                            'url' => 'setting/balance_reset',
                        ],
                        [
                            'icon' => 'fa fa-envelope',
                            'label' => '[Email] ' . env('POINT_NAME', 'Points') . ' Reset',
                            'url' => 'autoresponse/balance-resets/report-point-reset',
                        ],
                    ],
                ],
                [
                    'type' => 'tree',
                    'label' => 'User Mitra',
                    'icon' => 'fa fa-user-plus',
                    'children' => [
                        [
                            'label' => 'User Mitra List',
                            'active' => '\View::shared("submenu_active") == "user-franchise-list"',
                            'url' => 'user/user-franchise',
                            'required_features' => [301,302,304],
                        ],
                        [
                            'label' => 'New User Mitra',
                            'url' => 'user/user-franchise/create',
                            'required_features' => [303],
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [304],
                            'children' => [
                                [
                                    'label' => 'Export & Import',
                                    'active' => '\View::shared("submenu_active") == "user-franchise-import"',
                                    'url' => 'user/user-franchise/import',
                                ],
                                [
                                    'label' => '[Response] New User Mitra',
                                    'url' => 'user/autoresponse-franchise/new-user-franchise',
                                ],
                                [
                                    'label' => '[Response] Reset Password User Mitra',
                                    'url' => 'user/autoresponse-franchise/reset-password-user-franchise',
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'tree',
                    'label' => 'Doctor',
                    'icon' => 'icon-users',
                    'children' => [
                        [
                            'label' => 'New User Doctor',
                            'required_features' => [329],
                            'url' => 'doctor/create',
                            'active' => '\View::shared("submenu_active") == "doctor-create"',
                        ],
                        [
                            'label' => 'Doctor List',
                            'required_features' => [328],
                            'url' => 'doctor',
                            'active' => '\View::shared("submenu_active") == "doctor-list"',
                        ],
                        [
                            'label' => '[Master] Specialist',
                            'required_features' => [336],
                            'active' => '\View::shared("submenu_active") == "doctor-specialist"',
                            'url' => 'doctor/specialist',
                        ],
                        // [
                        //  'label' => '[Master] Specialist Category',
                        //  'required_features' => [340],
                        //  'active' => '\View::shared("submenu_active") == "doctor-specialist-category"',
                        //  'url' => 'doctor/specialist-category',
                        // ],
                        [
                            'label' => '[Master] Service',
                            'required_features' => [344],
                            'active' => '\View::shared("submenu_active") == "doctor-service"',
                            'url' => 'doctor/service',
                        ],
                        [
                            'label' => 'Doctor Recommendation',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "doctor-recommendation"',
                            'url' => 'doctor/recommendation'
                        ],
                        [
                            'label' => '[Response] Doctor Pin Forgot',
                            'required_features' => [328],
                            'active' => '\View::shared("submenu_active") == "doctor-autoresponse-doctor-pin-forgot"',
                            'url' => 'doctor/autoresponse/doctor-pin-forgot'
                        ],
                        [
                            'label' => '[Response] Doctor Pin Sent',
                            'required_features' => [328],
                            'active' => '\View::shared("submenu_active") == "doctor-autoresponse-doctor-pin-sent"',
                            'url' => 'doctor/autoresponse/doctor-pin-sent'
                        ],
                        [
                            'label' => 'Req Update Data',
                            'required_features' => [356,357,358],
                            'active' => '\View::shared("submenu_active") == "doctor-update-data"',
                            'children' => [
                                [
                                    'label' => 'List Request',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "doctor-update-data-list"',
                                    'url' => 'doctor/update-data',
                                    'badge' => [
                                        'type' => 'warning',
                                        'value' => 'doctor_request_update_data_pending',
                                    ]
                                ],
                                [
                                    'label' => '[Response] Approve Request',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "doctor-autoresponse-approve-doctor-request-update-data"',
                                    'url' => 'doctor/autoresponse/approve-doctor-request-update-data'
                                ],
                                [
                                    'label' => '[Response] Reject Request',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "doctor-autoresponse-reject-doctor-request-update-data"',
                                    'url' => 'doctor/autoresponse/reject-doctor-request-update-data'
                                ],
                            ],
                            'badge' => [
                                'type' => 'warning',
                                'value' => 'doctor_request_update_data_pending',
                            ]
                        ],
                    ],
                    'badge' => [
                        'type' => 'warning',
                        'value' => 'doctor_request_update_data_pending',
                    ]
                ],
            ],
        ],
        [
            'type' => 'group',
            'label' => 'Browse',
            'children' => [
                [
                    'label' => 'News',
                    'type' => 'tree',
                    'icon' => 'icon-feed',
                    'required_configs' => [34],
                    'children' => [
                        [
                            'label' => 'New News',
                            'url' => 'news/create',
                            'required_features' => [21],
                        ],
                        [
                            'label' => 'News List',
                            'active' => '\View::shared("submenu_active") == "news-list"',
                            'url' => 'news',
                            'required_features' => [19],
                        ],
                        [
                            'type' => 'group',
                            'required_configs' => [124],
                            'children' => [
                                [
                                    'label' => 'News Category',
                                    'active' => '\View::shared("submenu_active") == "news-category"',
                                    'url' => 'news/category',
                                    'required_features' => [164,166,167],
                                ],
                                [
                                    'label' => 'New News Category',
                                    'url' => 'news/category/create',
                                    'required_features' => [165],
                                ],
                            ],
                        ],
                        [
                            'label' => 'News Featured',
                            'active' => '\View::shared("submenu_active") == "news-featured"',
                            'url' => 'news/featured',
                            'required_features' => [19],
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [120,122],
                            'children' => [
                                [
                                    'label' => '[Forward] Create News',
                                    'url' => 'autoresponse/news/create-news',
                                ],
                                [
                                    'label' => '[Forward] Update News',
                                    'url' => 'autoresponse/news/update-news',
                                ],
                            ],
                        ],
                    ]
                ],
                [
                    'label' => 'Brand',
                    'type' => 'tree',
                    'icon' => 'icon-badge',
                    'required_configs' => [95],
                    'children' => [
                        [
                            'label' => 'New Brand',
                            'url' => 'brand/create',
                            'required_features' => [156],
                        ],
                        [
                            'label' => 'List Brand',
                            'active' => '\View::shared("submenu_active") == "brand-list"',
                            'url' => 'brand',
                            'required_features' => [155,157,158,159],
                        ],
                        [
                            'label' => 'Inactive Brand Image',
                            'url' => 'brand/inactive-image',
                            'required_features' => [157],
                            'required_configs' => [132],
                        ],
                    ]
                ],
                [
                    'label' => 'Merchant',
                    'type' => 'tree',
                    'icon' => 'fa fa-university',
                    'required_features' => [323,324,325,326,327,348],
                    'children' => [
                        [
                            'label' => 'Setting Register Introduction',
                            'url' => 'merchant/setting/register-introduction',
                            'required_features' => [326],
                        ],
                        [
                            'label' => 'Setting Register Success',
                            'url' => 'merchant/setting/register-success',
                            'required_features' => [326],
                        ],
                        [
                            'label' => 'Setting Register Approved',
                            'url' => 'merchant/setting/register-approved',
                            'required_features' => [326],
                        ],
                        [
                            'label' => 'Setting Register Rejected',
                            'url' => 'merchant/setting/register-rejected',
                            'required_features' => [326],
                        ],
                        [
                            'label' => 'New Merchant',
                            'url' => 'merchant/create',
                            'active' => '\View::shared("submenu_active") == "merchant-new"',
                            'required_features' => [325],
                        ],
                        [
                            'label' => 'Merchant List',
                            'url' => 'merchant',
                            'active' => '\View::shared("submenu_active") == "merchant-list"',
                            'required_features' => [323,324,326,327],
                        ],
                        [
                            'label' => 'Candidate List',
                            'url' => 'merchant/candidate',
                            'required_features' => [323,324,326,327],
                            'active' => '\View::shared("submenu_active") == "merchant-candidate"',
                            'badge' => [
                                'type' => 'warning',
                                'value' => 'merchant_register_pending',
                            ]
                        ],
                        [
                            'label' => 'Withdrawal',
                            'url' => 'merchant/withdrawal',
                            'required_features' => [348],
                            'badge' => [
                                'type' => 'warning',
                                'value' => 'withdrawal_pending',
                            ]
                        ],
                        [
                            'label' => '[Response] Register Merchant',
                            'url' => 'autoresponse/merchant/register-merchant',
                            'required_features' => [326],
                        ],
                        [
                            'label' => '[Response] Approve Merchant',
                            'url' => 'autoresponse/merchant/approve-merchant',
                            'required_features' => [326],
                        ],
                        [
                            'label' => '[Response] Rejected Merchant',
                            'url' => 'autoresponse/merchant/rejected-merchant',
                            'required_features' => [326],
                        ],
                        [
                            'label' => '[Response] Merchant Withdrawal',
                            'url' => 'autoresponse/merchant/merchant-withdrawal',
                            'required_features' => [326],
                        ],
                    ],
                    'badge' => [
                        'type' => 'warning',
                        'value' => 'merchant',
                    ]
                ],
                [
                    'label' => 'Reseller',
                    'type' => 'tree',
                    'icon' => 'fa fa-users',
                    'required_features' => [],
                    'required_configs' => [141],
                    'children' => [
                        [
                            'label' => 'Candidate Reseller List',
                            'url' => 'merchant/reseller/candidate',
                            'required_features' => [],
                        ],
                        [
                            'label' => 'Reseller List',
                            'url' => 'merchant/reseller',
                            'required_features' => [],
                        ]
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
                            'label' => 'List User Franchise',
                            'active' => '\View::shared("submenu_active") == "outlet-list-user-franchise"',
                            'url' => 'outlet/list/user-franchise',
                            'required_configs' => [133],
                            'required_features' => [247],
                        ],
                        [
                            'label' => 'Outlet List',
                            'active' => '\View::shared("submenu_active") == "outlet-list"',
                            'url' => 'outlet/list',
                            'required_features' => [24],
                        ],
                        [
                            'label' => 'Online Shop Outlet',
                            'url' => 'setting/default_outlet',
                            'required_features' => [199],
                        ],
//                      [
//                          'label' => 'QR Code Outlet',
//                          'active' => '\View::shared("submenu_active") == "outlet-qrcode"',
//                          'url' => 'outlet/qrcode',
//                          'required_features' => [24,27],
//                      ],
                        [
                            'label' => 'Outlet Holiday Setting',
                            'active' => '\View::shared("submenu_active") == "outlet-holiday"',
                            'url' => 'outlet/holiday',
                            'required_configs' => [4],
                            'required_features' => [34],
                        ],
                        [
                            'label' => 'Manage Location',
                            'active' => '\View::shared("submenu_active") == "manage-location"',
                            'url' => 'outlet/manage-location',
                            'required_configs' => [2,3],
                            'required_features' => [27],
                        ],
                        [
                            'label' => 'Export Import Outlet',
                            'active' => '\View::shared("submenu_active") == "outlet-export-import"',
                            'url' => 'outlet/export-import',
                            'required_configs' => [2,3],
                            'required_features' => [32,33],
                        ],
                        [
                            'label' => 'Export Import PIN',
                            'active' => '\View::shared("submenu_active") == "export-outlet-pin"',
                            'url' => 'outlet/export-outlet-pin',
                            'required_features' => [261],
                        ],
                        [
                            'label' => 'Outlet Apps Access Feature',
                            'active' => '\View::shared("submenu_active") == "outlet-pin-response"',
                            'url' => 'outlet/autoresponse/request_pin',
                            'required_configs' => [5,101],
                            'required_features' => [40],
                        ],
//                      [
//                          'type' => 'group',
//                          'required_features' => [120,122],
//                          'children' => [
//                              [
//                                  'label' => '[Response] Outlet Pin Sent',
//                                  'url' => 'autoresponse/outlet/outlet-pin-sent',
//                                  'required_configs' => [134],
//                              ],
//                              [
//                                  'label' => '[Response] Outlet Pin Sent User Franchise',
//                                  'url' => 'autoresponse/outlet/outlet-pin-sent-user-franchise',
//                              ],
//                              [
//                                  'label' => '[Response] Request Admin User Franchise',
//                                  'url' => 'autoresponse/outlet/request-admin-user-franchise',
//                              ],
//                              [
//                                  'label' => '[Forward] Incomplete Outlet Data',
//                                  'url' => 'outlet/autoresponse/incomplete-outlet-data',
//                              ],
//                          ],
//                      ],
                        [
                            'label' => 'Outlet Group Filter',
                            'type' => 'tree',
                            'children' => [
                                [
                                    'label' => 'New Outlet Group Filter',
                                    'url' => 'outlet-group-filter/create',
                                    'required_features' => [296],
                                ],
                                [
                                    'label' => 'Outlet Group Filter List',
                                    'active' => '\View::shared("child_active") == "outlet-group-filter-list"',
                                    'url' => 'outlet-group-filter',
                                    'required_features' => [294, 295, 297, 298],
                                ],
                            ],
                        ],
                    ]
                ],
                [
                    'label' => 'Product',
                    'icon' => 'icon-wallet',
                    'type' => 'tree',
                    'required_features' => [43,44,45,46,47,48,49,50,51,52],
                    'children' => [
                        [
                            'label' => 'Category List',
                            'active' => '\View::shared("submenu_active") == "product-category-list"',
                            'url' => 'product/category',
                            'required_features' => [43,44,45,46,47],
                        ],
                        [
                            'label' => 'New Product',
                            'url' => 'product/create',
                            'required_features' => [50],
                        ],
                        [
                            'label' => 'Product List',
                            'active' => '\View::shared("submenu_active") == "product-list"',
                            'url' => 'product',
                            'required_features' => [48],
                        ],
                        [
                            'required_features' => [48],
                            'type' => 'group',
                            'children' => [
                                [
                                    'label' => 'Visible Product List',
                                    'required_features' => [51],
                                    'active' => '\View::shared("submenu_active") == "product-list-visible"',
                                    'url' => 'product/visible'
                                ],
                                [
                                    'label' => 'Hidden Product List',
                                    'required_features' => [51],
                                    'active' => '\View::shared("submenu_active") == "product-list-hidden"',
                                    'url' => 'product/hidden'
                                ],
                                [
                                    'label' => 'Product Photo Default',
                                    'required_features' => [51],
                                    'active' => '\View::shared("submenu_active") == "product-photo-default"',
                                    'url' => 'product/photo/default'
                                ],
                                [
                                    'label' => 'Product Recommendation',
                                    'required_features' => [51],
                                    'active' => '\View::shared("submenu_active") == "product-recommendation"',
                                    'url' => 'product/recommendation'
                                ],
                            ],
                        ]
                    ]
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
                        // [
                        //     'label' => 'User Rating Report Outlet',
                        //     'required_features' => [352],
                        //     'active' => '\View::shared("submenu_active") == "user-rating-report-outlet"',
                        //     'url' => 'user-rating/report/outlet'
                        // ],
                        [
                            'label' => 'User Rating Report Product',
                            'required_features' => [352],
                            'active' => '\View::shared("submenu_active") == "user-rating-report-product"',
                            'url' => 'user-rating/report/product'
                        ],
                        [
                            'label' => 'User Rating Report Doctor',
                            'required_features' => [352],
                            'active' => '\View::shared("submenu_active") == "user-rating-report-doctor"',
                            'url' => 'user-rating/report/doctor'
                        ],
                        [
                            'label' => '[Response] Rating Doctor',
                            'url' => 'user-rating/autoresponse/doctor',
                            'active' => '\View::shared("submenu_active") == "user-rating-response-doctor"',
                            'required_features' => [353],
                        ],
                        [
                            'label' => '[Response] Rating Product',
                            'required_features' => [353],
                            'url' => 'user-rating/autoresponse/product',
                            'active' => '\View::shared("submenu_active") == "user-rating-response-product"',
                        ],
                    ]
                ],
                /** HIDE
                [
                    'label' => 'Topping',
                    'required_features' => [],
                    'required_configs' => [91],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Topping',
                            'required_features' => [181],
                            'active' => '\View::shared("submenu_active") == "product-modifier-new"',
                            'url' => 'product/modifier/create'
                        ],
                        [
                            'label' => 'Topping List',
                            'required_features' => [182, 183, 184],
                            'active' => '\View::shared("submenu_active") == "product-modifier-list"',
                            'url' => 'product/modifier'
                        ],
                        [
                            'label' => 'Manage Position',
                            'required_features' => [183],
                            'active' => '\View::shared("submenu_active") == "product-modifier-position"',
                            'url' => 'product/modifier/position'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [185, 186],
                            'children' => [
                                [
                                    'label' => 'Topping Price',
                                    'active' => '\View::shared("submenu_active") == "product-modifier-price"',
                                    'url' => 'product/modifier/price'
                                ],
                                [
                                    'label' => 'Topping Detail',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-modifier-detail"',
                                    'url' => 'product/modifier/detail'
                                ],
                                [
                                    'label' => 'Topping Inventory Brand',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-modifier-inventory-brand"',
                                    'url' => 'product/modifier/inventory-brand'
                                ],
                                [
                                    'label' => 'Export & Import Topping',
                                    'required_features' => [],
                                    'type' => 'tree',
                                    'children' => [
                                        [
                                            'label' => 'Import Topping',
                                            'required_features' => [],
                                            'active' => '\View::shared("submenu_active") == "product-modifier-import-global"',
                                            'url' => 'product/import/modifier'
                                        ],
                                        [
                                            'label' => 'Import Topping Price',
                                            'required_features' => [],
                                            'active' => '\View::shared("submenu_active") == "product-modifier-import-price"',
                                            'url' => 'product/import/modifier-price'
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-puzzle-piece'
                ],
                */
//              [
//                  'label' => 'Product Variant NON PRICE (NO SKU)',
//                  'required_features' => [],
//                  'type' => 'tree',
//                  'children' => [
//                      [
//                          'label' => 'New Product Variant NON PRICE (NO SKU)',
//                          'required_features' => [284],
//                          'active' => '\View::shared("submenu_active") == "product-modifier-group-new"',
//                          'url' => 'product/modifier-group/create'
//                      ],
//                      [
//                          'type' => 'group',
//                          'required_features' => [283, 285, 286, 287],
//                          'children' => [
//                              [
//                                  'label' => 'Product Variant NON PRICE (NO SKU) List',
//                                  'required_features' => [],
//                                  'active' => '\View::shared("submenu_active") == "product-modifier-group-list"',
//                                  'url' => 'product/modifier-group'
//                              ],
//                              [
//                                  'label' => 'Product Variant NON PRICE (NO SKU) Price',
//                                  'required_features' => [],
//                                  'active' => '\View::shared("submenu_active") == "product-modifier-group-price"',
//                                  'url' => 'product/modifier-group/price'
//                              ],
//                              [
//                                  'label' => 'Product Variant NON PRICE (NO SKU) Detail',
//                                  'required_features' => [],
//                                  'active' => '\View::shared("submenu_active") == "product-modifier-group-detail"',
//                                  'url' => 'product/modifier-group/detail'
//                              ],
//                              [
//                                  'label' => 'Manage Position Product Variant NON PRICE (NO SKU)',
//                                  'required_features' => [],
//                                  'active' => '\View::shared("submenu_active") == "product-modifier-group-position"',
//                                  'url' => 'product/modifier-group/position'
//                              ],
//                              [
//                                  'label' => 'Export & Import Product Variant NON PRICE (NO SKU)',
//                                  'required_features' => [],
//                                  'type' => 'tree',
//                                  'children' => [
//                                      [
//                                          'label' => 'Import Product Variant NON PRICE (NO SKU)',
//                                          'required_features' => [],
//                                          'active' => '\View::shared("submenu_active") == "product-modifier-group-import-global"',
//                                          'url' => 'product/modifier-group/import'
//                                      ],
//                                      [
//                                          'label' => 'Import Product Variant NON PRICE (NO SKU) Price',
//                                          'required_features' => [],
//                                          'active' => '\View::shared("submenu_active") == "product-modifier-group-import-price"',
//                                          'url' => 'product/modifier-group/import-price'
//                                      ],
//                                  ],
//                              ],
//                              [
//                                  'label' => 'Inventory Brand',
//                                  'required_features' => [],
//                                  'active' => '\View::shared("submenu_active") == "product-modifier-group-inventory-brand"',
//                                  'url' => 'product/modifier-group/inventory-brand'
//                              ],
//                          ]
//                      ],
//                  ],
//                  'icon' => 'fa fa-glass'
//              ],
                [
                    'label' => 'Product Variant (SKU)',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Variant',
                            'required_features' => [279],
                            'url' => 'product-variant/create'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [278, 279, 281],
                            'children' => [
                                [
                                    'label' => 'Variant List',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-variant-list"',
                                    'url' => 'product-variant'
                                ],
                                [
                                    'label' => 'Variant Position',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-variant-position"',
                                    'url' => 'product-variant/position'
                                ],
                                [
                                    'label' => 'Remove Product Variant (SKU)',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-variant-group-remove"',
                                    'url' => 'product-variant-group/list-group'
                                ],
                                [
                                    'label' => 'Product Variant (SKU) List',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-variant-group-list"',
                                    'url' => 'product-variant-group/list'
                                ],
                                [
                                    'label' => 'Product Variant (SKU) Price',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-variant-group-price"',
                                    'url' => 'product-variant-group/price'
                                ],
                                [
                                    'label' => 'Product Variant (SKU) Detail',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-variant-group-detail"',
                                    'url' => 'product-variant-group/detail'
                                ],
                                [
                                    'label' => 'Export & Import',
                                    'required_features' => [],
                                    'type' => 'tree',
                                    'children' => [
                                        [
                                            'label' => 'Import Variant',
                                            'required_features' => [],
                                            'active' => '\View::shared("submenu_active") == "product-variant-import-global"',
                                            'url' => 'product-variant/import'
                                        ],
                                        [
                                            'label' => 'Import Product Variant (SKU)',
                                            'required_features' => [],
                                            'active' => '\View::shared("submenu_active") == "product-variant-group-import-global"',
                                            'url' => 'product-variant-group/import'
                                        ],
                                        [
                                            'label' => 'Import Product Variant (SKU) Price',
                                            'required_features' => [],
                                            'active' => '\View::shared("submenu_active") == "product-variant-group-import-price"',
                                            'url' => 'product-variant-group/import-price'
                                        ],
                                    ],
                                ],
                            ]
                        ],
                    ],
                    'icon' => 'fa fa-coffee'
                ],
            ],
        ],
        [
            'label' => 'Request Hair Stylist',
            'required_features' => [],
            'type' => 'tree',
            'children' => [
                [
                    'label' => 'New Request Hair Stylist',
                    'required_features' => [378],
                    'url' => 'recruitment/hair-stylist/request/new'
                ],
                [
                    'label' => 'List Request Hair Stylist',
                    'required_features' => [379, 380, 381, 382, 378],
                    'active' => '\View::shared("submenu_active") == "list-req-hair-stylist"',
                    'url' => 'recruitment/hair-stylist/request'
                ],
            ],
            'icon' => 'fa fa-male'
        ],
        [
            'label' => 'Hair Stylist Group',
            'required_features' => [],
            'type' => 'tree',
            'children' => [
                [
                    'label' => 'New Hair Stylist Group',
                    'required_features' => [394],
                    'active' => '\View::shared("submenu_active") == "new-hair-stylist-group"',
                    'url' => 'recruitment/hair-stylist/group/create'
                ],
                [
                    'label' => 'List Hair Stylist Group',
                    'required_features' => [393,378],
                    'active' => '\View::shared("submenu_active") == "list-hair-stylist-group"',
                    'url' => 'recruitment/hair-stylist/group'
                ],
            ],
            'icon' => 'fa fa-life-ring'
        ],
        [
            'label' => 'Default Income HS',
            'required_features' => [],
            'type' => 'tree',
            'children' => [
                [
                    'label' => 'Salary Incentive Default HS',
                    'required_features' => [425],
                    'active' => '\View::shared("submenu_active") == "default-hair-stylist-insentif"',
                    'url' => 'recruitment/hair-stylist/default/insentif'
                ],
                [
                    'label' => 'Salary Cuts Default HS',
                    'required_features' => [426],
                    'active' => '\View::shared("submenu_active") == "default-hair-stylist-potongan"',
                    'url' => 'recruitment/hair-stylist/default/potongan'
                ],
            ],
            'icon' => 'fa fa-money'
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
                        [
                            'label' => '[Response] Payment Status',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "transaction-autoresponse-payment-status"',
                            'url' => 'transaction/autoresponse/payment-status'
                        ],
                        [
                            'label' => '[Response] Merchant Transaction New',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "transaction-autoresponse-merchant-transaction-new"',
                            'url' => 'transaction/autoresponse/merchant-transaction-new'
                        ],
                        [
                            'label' => '[Response] Transaction Accepted',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "transaction-autoresponse-transaction-accepted"',
                            'url' => 'transaction/autoresponse/transaction-accepted'
                        ],
                        [
                            'label' => '[Response] Transaction Reject',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "transaction-autoresponse-transaction-reject"',
                            'url' => 'transaction/autoresponse/transaction-reject'
                        ],
                        [
                            'label' => '[Response] Transaction Delivery Confirm',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "transaction-autoresponse-transaction-delivery-confirm"',
                            'url' => 'transaction/autoresponse/transaction-delivery-confirm'
                        ],
                        [
                            'label' => '[Response] Delivery Status Update',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "delivery-status-update"',
                            'url' => 'transaction/autoresponse/delivery-status-update'
                        ],
                        [
                            'label' => '[Response] Transaction Delivery Received',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "transaction-autoresponse-transaction-delivery-received"',
                            'url' => 'transaction/autoresponse/transaction-delivery-received'
                        ],
                        [
                            'label' => '[Response] Transaction Completed',
                            'required_features' => [93],
                            'active' => '\View::shared("submenu_active") == "transaction-autoresponse-transaction-success"',
                            'url' => 'transaction/autoresponse/transaction-success'
                        ],
                        [
                            'label' => '[Response] Transaction Point Achievement',
                            'required_features' => [93],
                            'url' => 'transaction/autoresponse/transaction-point-achievement'
                        ]
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
                [
                    'label' => 'Consultation',
                    'icon' => 'fa fa-user',
                    'required_features' => [351],
                    'children' => [
                        [
                            'label' => 'List Consultation',
                            'required_features' => [351],
                            'active' => '\View::shared("menu_active") == "consultation"',
                            'url' => 'consultation/be',
                            'badge' => [
                                'type' => 'warning',
                                'value' => 'transaction_consultation_pending',
                            ]
                        ],
                        [
                            'label' => 'Option Consultation',
                            'required_features' => [348],
                            'active' => '\View::shared("menu_active") == "consultation-option-settings"',
                            'url' => 'setting/consultation_option_setting',
                        ],
                        [
                            'label' => 'Setting Consultation',
                            'required_features' => [348],
                            'active' => '\View::shared("menu_active") == "consultation-settings"',
                            'url' => 'setting/consultation_setting',
                        ],
                        [
                            'label' => 'Doctor Autoresponse',
                            'required_features' => [348],
                            'active' => '\View::shared("menu_active") == "consultation-settings"',
                            'children' => [
                                [
                                    'label' => '[Response] Doctor Receive Message',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-doctor-received-chat"',
                                    'url' => 'consultation/autoresponse/doctor-received-chat'
                                ],
                                [
                                    'label' => '[Response] Consultation Has Started',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-consultation-has-started"',
                                    'url' => 'consultation/autoresponse/consultation-has-started'
                                ],
                            ],
                        ],
                        [
                            'label' => 'User Autoresponse',
                            'required_features' => [348],
                            'active' => '\View::shared("menu_active") == "consultation-settings"',
                            'children' => [
                                [
                                    'label' => '[Response] User Receive Message',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-user-received-chat"',
                                    'url' => 'consultation/autoresponse/user-received-chat'
                                ],
                                [
                                    'label' => '[Response] Consultation Reschedule',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-reschedule-consultation"',
                                    'url' => 'consultation/autoresponse/reschedule-consultation'
                                ],
                                [
                                    'label' => '[Response] Consultation Done',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-consultation-done"',
                                    'url' => 'consultation/autoresponse/consultation-done'
                                ],
                                [
                                    'label' => '[Response] Consultation Completed',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-consultation-completed"',
                                    'url' => 'consultation/autoresponse/consultation-completed'
                                ],
                                [
                                    'label' => '[Response] Consultation Missed',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-consultation-missed"',
                                    'url' => 'consultation/autoresponse/consultation-missed'
                                ],
                                [
                                    'label' => '[Response] Consultation Canceled',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "consultation-autoresponse-consultation-canceled"',
                                    'url' => 'consultation/autoresponse/consultation-canceled'
                                ]
                            ],
                        ],
                    ],
                    'badge' => [
                        'type' => 'warning',
                        'value' => 'transaction_consultation_pending',
                    ]
                ]
            ]
        ],

        /** HIDE
        [
            'type' => 'group',
            'label' => 'Order',
            'children' => [
                [
                    'label' => 'Product Transaction',
                    'required_features' => [],
                    'required_configs' => [13, 12],
                    'type' => 'tree',
                    'children' => [
                        [
                            'type' => 'group',
                            'required_features' => [69],
                            'children' => [
                                [
                                    'label' => 'Transaction Outlet Service',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "transaction-outlet-service"',
                                    'url' => 'transaction/outlet-service'
                                ],
                                [
                                    'label' => 'Transaction Home Service',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "transaction-home-service"',
                                    'url' => 'transaction/home-service'
                                ],
                                [
                                    'label' => 'Transaction Shop',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "transaction-shop"',
                                    'url' => 'transaction/shop'
                                ],
                                [
                                    'label' => 'Transaction Academy',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "transaction-academy"',
                                    'url' => 'transaction/academy'
                                ],
                            ],
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [469,397,407],
                            'children' => [
                                [
                                    'label' => 'Manage Outlet Service',
                                    'required_features' => [397,469],
                                    'active' => '\View::shared("submenu_active") == "manage-outlet-service"',
                                    'url' => 'transaction/outlet-service/manage'
                                ],
                                [
                                    'label' => 'Manage Home Service',
                                    'required_features' => [407,469],
                                    'active' => '\View::shared("submenu_active") == "manage-home-service"',
                                    'url' => 'transaction/home-service/manage'
                                ],
                            ],
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [93],
                            'children' => [
                                [
                                    'label' => '[Response] Transaction Success',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/transaction-success'
                                ],
                                [
                                    'label' => '[Response] Transaction Expired',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/transaction-expired'
                                ],
                                [
                                    'label' => '[Response] Order Accepted',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/order-accepted'
                                ],
                                [
                                    'label' => '[Response] Order Ready',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/order-ready'
                                ],
                                [
                                    'label' => '[Response] Order Taken',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/order-taken'
                                ],
                                [
                                    'label' => '[Response] Transaction Point Achievement',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/transaction-point-achievement'
                                ],
                                [
                                    'label' => '[Response] Transaction Failed Point Refund',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/transaction-failed-point-refund'
                                ],
                                [
                                    'label' => '[Response] Rejected Order Point Refund',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/rejected-order-point-refund'
                                ],
                                [
                                    'label' => '[Response] Transaction Rejected',
                                    'required_features' => [],
                                    'url' => 'autoresponse/transaction/transaction-rejected'
                                ],
                                [
                                    'label' => '[Response] Transaction Completed',
                                    'required_features' => [],
                                    'url' => 'autoresponse/transaction/transaction-completed'
                                ],
                                [
                                    'label' => '[Response] Delivery Status Update',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/delivery-status-update'
                                ],
                                [
                                    'label' => '[Forward] Delivery Rejected',
                                    'required_features' => [],
                                    'url' => 'autoresponse/transaction/delivery-rejected'
                                ],
                                [
                                    'label' => 'Outlet Service Response',
                                    'required_features' => [],
                                    'type' => 'tree',
                                    'children' => [
                                        [
                                            'label' => '[Response] Transaction Service Completed',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/transaction-service-completed'
                                        ],
                                        [
                                            'label' => '[Response] Transaction Product Taken',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/transaction-product-taken'
                                        ],
                                        [
                                            'label' => '[Response] HS - Transaction Service Created',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-hs---transaction-service-created'
                                        ],
                                        [
                                            'label' => '[Response] HS - Transaction Service Rejected',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-hs---transaction-service-rejected'
                                        ],
                                        [
                                            'label' => '[Response] HS - Transaction Service Completed',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-hs---transaction-service-completed'
                                        ],
                                        [
                                            'label' => '[Response] SPV - Transaction Product Created',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-spv---transaction-product-created'
                                        ],
                                        [
                                            'label' => '[Response] SPV - Transaction Product Rejected',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-spv---transaction-product-rejected'
                                        ],
                                        [
                                            'label' => '[Response] SPV - Transaction Product Taken',
                                            'required_features' => [],
                                            'url' => 'autoresponse/transaction-outlet-service-autoresponse/mitra-spv---transaction-product-taken'
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-shopping-cart'
                ],
                [
                    'label' => 'Manual Complete Payment',
                    'required_features' => [469],
                    'active' => '\View::shared("submenu_active") == "transaction-complete-payment"',
                    'url' => 'transaction/complete-payment',
                    'icon' => 'fa fa-check'
                ],
                [
                    'label' => 'Response With Code',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => '[Response] Order Taken With Code',
                            'required_features' => [318],
                            'url' => 'transaction/autoresponse/order-taken-with-code'
                        ],
                        [
                            'label' => '[Response] Order Taken Delivery With Code',
                            'required_features' => [318],
                            'url' => 'transaction/autoresponse/order-taken-delivery-with-code'
                        ],
                        [
                            'label' => 'New Code',
                            'required_features' => [317],
                            'url' => 'response-with-code/create'
                        ],
                        [
                            'label' => 'Code List',
                            'required_features' => [316,318,319],
                            'active' => '\View::shared("submenu_active") == "response-with-code-list"',
                            'url' => 'response-with-code'
                        ],
                    ],
                    'icon' => 'fa fa-qrcode'
                ],
                [
                    'label' => 'Failed Void Payment',
                    'required_features' => [299],
                    'active' => '\View::shared("menu_active") == "failed-void-payment"',
                    'url' => 'transaction/failed-void-payment',
                    'icon' => 'fa fa-exclamation-triangle'
                ],
                [
                    'label' => 'Point Log History',
                    'required_features' => [71],
                    'required_configs' => [18],
                    'active' => '\View::shared("menu_active") == "point"',
                    'url' => 'transaction/point',
                    'icon' => 'fa fa-history'
                ],
                [
                    'label' => 'Points ' . env('POINT_NAME', 'Points') . ' History',
                    'required_features' => [71],
                    'required_configs' => [19],
                    'active' => '\View::shared("menu_active") == "balance"',
                    'url' => 'transaction/balance',
                    'icon' => 'fa fa-clock-o'
                ],
                [
                    'label' => 'Order Settings',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Chart Of Account',
                            'required_features' => [400],
                            'active' => '\View::shared("submenu_active") == "chart-of-account"',
                            'url' => 'chartofaccount'
                        ],
                        [
                            'label' => 'Calculation Rule',
                            'required_features' => [58, 59, 60, 62],
                            'active' => '\View::shared("submenu_active") == "transaction-rule"',
                            'url' => 'transaction/setting/rule'
                        ],
                        [
                            'label' => 'Internal Courier',
                            'required_features' => [61,63],
                            'required_configs' => [13,14],
                            'required_configs_rule' => 'and',
                            'active' => '\View::shared("submenu_active") == "internal-courier"',
                            'url' => 'transaction/internalcourier'
                        ],
                        [
                            'label' => 'Global ' . env('POINT_NAME', 'Points') . ' Setting',
                            'required_features' => [58, 59, 60, 62],
                            'active' => '\View::shared("submenu_active") == "transaction-setting"',
                            'url' => 'transaction/setting/cashback'
                        ],
                        [
                            'label' => 'Setting Free Delivery',
                            'required_features' => [],
                            'required_configs' => [79],
                            'active' => '\View::shared("submenu_active") == "free-delivery"',
                            'url' => 'transaction/setting/free-delivery'
                        ],
                        [
                            'label' => 'Credit Card Payment Gateway',
                            'required_features' => [],
                            'required_configs' => [100],
                            'active' => '\View::shared("submenu_active") == "credit_card_payment_gateway"',
                            'url' => 'setting/credit_card_payment_gateway'
                        ],
                        [
                            'label' => 'Setting Payment Method',
                            'required_features' => [250],
                            'active' => '\View::shared("submenu_active") == "setting-payment-method"',
                            'url' => 'transaction/setting/available-payment'
                        ],
                        [
                            'label' => 'Setting Timer Payment Gateway',
                            'required_features' => [272],
                            'required_configs' => [120],
                            'active' => '\View::shared("submenu_active") == "setting-timer-payment-gateway"',
                            'url' => 'transaction/setting/timer-payment-gateway'
                        ],
                        [
                            'label' => 'Setting Refund Reject Order',
                            'required_features' => [250],
                            'active' => '\View::shared("submenu_active") == "refund-reject-order"',
                            'url' => 'transaction/setting/refund-reject-order'
                        ],
                        [
                            'label' => 'Setting Auto Reject Time',
                            'required_features' => [262],
                            'active' => '\View::shared("submenu_active") == "auto-reject-time"',
                            'url' => 'transaction/setting/auto-reject'
                        ],
                        [
                            'label' => 'Transaction Messages',
                            'required_features' => [321],
                            'active' => '\View::shared("submenu_active") == "transaction-messages"',
                            'url' => 'transaction/setting/transaction-messages'
                        ],
                    ],
                    'icon' => 'fa fa-cogs'
                ],
                [
                    'label' => 'Delivery Settings',
                    'required_features' => [320],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Available Delivery',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "delivery-setting-available"',
                            'url' => 'transaction/setting/available-delivery'
                        ],
                        [
                            'label' => 'Upload Logo Delivery',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "delivery-setting-upload-image"',
                            'url' => 'transaction/setting/delivery-upload-image'
                        ],
                        [
                            'label' => 'Outlet Availability',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "delivery-setting-outlet"',
                            'url' => 'transaction/setting/delivery-outlet'
                        ],
                        [
                            'label' => 'Import/Export Outlet Availability',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "delivery-setting-outlet-import"',
                            'url' => 'transaction/setting/delivery-outlet/import'
                        ],
                        [
                            'label' => 'Setting Package Detail Delivery',
                            'required_features' => [],
                            'required_configs' => [13],
                            'active' => '\View::shared("submenu_active") == "delivery-setting-package-detail"',
                            'url' => 'transaction/setting/package-detail-delivery'
                        ],
                        [
                            'label' => '[Forward] WeHelpYou Low Balance',
                            'required_features' => [],
                            'required_configs' => [137],
                            'active' => '\View::shared("submenu_active") == "forward-wehelpyou"',
                            'url' => 'transaction/setting/forward-why-low-balance'
                        ],
                    ],
                    'icon' => 'fa fa-truck'
                ],
                [
                    'label' => 'Payment Method',
                    'required_features' => [],
                    'required_configs' => [116],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Category',
                            'required_features' => [257],
                            'active' => '\View::shared("submenu_active") == "new-category"',
                            'url' => 'payment-method-category/create'
                        ],
                        [
                            'label' => 'Category List',
                            'required_features' => [258,259,260],
                            'active' => '\View::shared("submenu_active") == "category-list"',
                            'url' => 'payment-method-category'
                        ],
                        [
                            'label' => 'New Payment Method',
                            'required_features' => [253],
                            'active' => '\View::shared("submenu_active") == "new-payment-method"',
                            'url' => 'payment-method/create'
                        ],
                        [
                            'label' => 'Payment Method List',
                            'required_features' => [254,255,256],
                            'active' => '\View::shared("submenu_active") == "payment-method-list"',
                            'url' => 'payment-method'
                        ],
                    ],
                    'icon' => 'fa fa-credit-card'
                ],
                [
                    'label' => 'Outlet Product Price',
                    'required_features' => [62],
                    'active' => '\View::shared("menu_active") == "product-price"',
                    'url' => 'product/price',
                    'icon' => 'fa fa-tag'
                ],
                [
                    'label' => 'Outlet Different Price',
                    'required_features' => [62],
                    'active' => '\View::shared("menu_active") == "outlet-different-price"',
                    'url' => 'outlet/different-price',
                    'icon' => 'fa fa-check'
                ],
                [
                    'label' => 'Default Maximum Order',
                    'required_features' => [197,198],
                    'active' => '\View::shared("menu_active") == "default-max-order"',
                    'url' => 'setting/max_order',
                    'icon' => 'fa fa-shopping-cart'
                ],
                [
                    'label' => 'Outlet Maximum Order',
                    'required_features' => [192,198],
                    'active' => '\View::shared("menu_active") == "max-order"',
                    'url' => 'outlet/max-order',
                    'icon' => 'fa fa-shopping-cart'
                ],
                [
                    'label' => 'Manual Payment',
                    'required_features' => [],
                    'required_configs' => [17],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Payment Method',
                            'required_features' => [66],
                            'active' => '\View::shared("submenu_active") == "manual-payment-method-new"',
                            'url' => 'transaction/manualpayment/create'
                        ],
                        [
                            'label' => 'Payment Method List',
                            'required_features' => [64],
                            'active' => '\View::shared("submenu_active") == "manual-payment-method-list"',
                            'url' => 'transaction/manualpayment'
                        ],
                        [
                            'label' => 'Manual Payment Transaction',
                            'required_features' => [64],
                            'active' => '\View::shared("submenu_active") == "manual-payment-list"',
                            'url' => 'transaction/manualpayment/list'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [64],
                            'required_configs' => [25],
                            'children' => [
                                [
                                    'label' => 'Manual Payment Deals',
                                    'active' => '\View::shared("submenu_active") == "manual-payment-deals"',
                                    'url' => 'deals/manualpayment/list'
                                ],
                                [
                                    'label' => 'Bank List',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "bank"',
                                    'url' => 'transaction/manualpayment/banks'
                                ],
                                [
                                    'label' => 'Payment Method List',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "bank-method"',
                                    'url' => 'transaction/manualpayment/banks/method'
                                ],
                            ]
                        ],
                    ],
                    'icon' => 'fa fa-money'
                ],
                [
                    'label' => 'Report GoSend',
                    'required_features' => [249],
                    'active' => '\View::shared("menu_active") == "report-gosend"',
                    'url' => 'report/gosend',
                    'icon' => 'fa fa-truck'
                ],
                [
                    'label' => 'Report Wehelpyou',
                    'required_features' => [322],
                    'active' => '\View::shared("menu_active") == "report-wehelpyou"',
                    'url' => 'report/wehelpyou',
                    'icon' => 'fa fa-truck'
                ],
                [
                    'label' => 'Report Payment',
                    'required_features' => [263],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Midtrans',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "report-payment-midtrans"',
                            'url' => 'report/payment/midtrans'
                        ],
                        [
                            'label' => 'Xendit',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "report-payment-xendit"',
                            'url' => 'report/payment/xendit'
                        ],
                        // [
                        //  'label' => 'Ipay88',
                        //  'required_features' => [],
                        //  'active' => '\View::shared("submenu_active") == "report-payment-ipay88"',
                        //  'url' => 'report/payment/ipay88'
                        // ],
                        // [
                        //  'label' => 'ShopeePay',
                        //  'required_features' => [],
                        //  'active' => '\View::shared("submenu_active") == "report-payment-shopee"',
                        //  'url' => 'report/payment/shopee'
                        // ],
                        // [
                        //  'label' => 'List Export',
                        //  'required_features' => [],
                        //  'active' => '\View::shared("submenu_active") == "report-payment-export"',
                        //  'url' => 'report/payment/list-export'
                        // ],
                    ],
                    'icon' => 'fa fa-credit-card'
                ],
            ],
        ],
        [
            'type' => 'group',
            'label' => 'Invalid Transaction',
            'children' => [
                [
                    'label' => 'Mark as Pending Invalid',
                    'required_features' => [274],
                    'active' => '\View::shared("submenu_active") == "mark-as-pending-invalid"',
                    'url' => 'transaction/invalid-flag/mark-as-pending-invalid',
                    'icon' => 'fa fa-list-ul'
                ],
                [
                    'label' => 'Mark as Invalid',
                    'required_features' => [274],
                    'active' => '\View::shared("submenu_active") == "mark-as-invalid"',
                    'url' => 'transaction/invalid-flag/mark-as-invalid',
                    'icon' => 'fa fa-list-ul'
                ],
                [
                    'label' => 'Mark as Valid',
                    'required_features' => [275],
                    'active' => '\View::shared("submenu_active") == "mark-as-valid"',
                    'url' => 'transaction/invalid-flag/mark-as-valid',
                    'icon' => 'fa fa-list-ul'
                ],
                [
                    'label' => 'Log Invalid Flag',
                    'required_features' => [276],
                    'active' => '\View::shared("submenu_active") == "log-invalid-flag"',
                    'url' => 'transaction/log-invalid-flag/list',
                    'icon' => 'fa fa-list-ul'
                ],
            ],
        ],
         */
        [
            'type' => 'group',
            'label' => 'Promo',
            'children' => [
                [
                    'label' => 'Promo Campaign',
                    'required_features' => [],
                    'required_configs' => [93],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Promo Campaign',
                            'required_features' => [202],
                            'active' => '\View::shared("submenu_active") == "promo-campaign-create"',
                            'url' => 'promo-campaign/create'
                        ],
                        [
                            'label' => 'Promo Campaign List',
                            'required_features' => [200],
                            'active' => '\View::shared("submenu_active") == "promo-campaign-list"',
                            'url' => 'promo-campaign'
                        ],
                        [
                            'label' => 'Featured Merchant',
                            'required_features' => [204],
                            'active' => '\View::shared("submenu_active") == "promo-campaign-featured-merchant"',
                            'url' => 'promo-campaign/featured-merchant'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [120,122],
                            'children' => [
                                [
                                    'label' => '[Forward] Create Promo Campaign',
                                    'required_features' => [],
                                    'url' => 'autoresponse/promo-campaign/create-promo-campaign'
                                ],
                                [
                                    'label' => '[Forward] Update Promo Campaign',
                                    'required_features' => [],
                                    'url' => 'autoresponse/promo-campaign/update-promo-campaign'
                                ]
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-tag'
                ]
            ]
        ],
                /*
                 [
                    'label' => 'Deals',
                    'required_features' => [],
                    'required_configs' => [25,18],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Deals',
                            'required_features' => [74],
                            'active' => '\View::shared("submenu_active") == "deals-create"',
                            'url' => 'deals/create'
                        ],
                        [
                            'label' => 'Deals List',
                            'required_features' => [72],
                            'active' => '\View::shared("submenu_active") == "deals-list"',
                            'url' => 'deals'
                        ],
                        [
                            'type' => 'group',
                            'required_configs' => [18],
                            'children' => [
                                [
                                    'label' => 'New Point Deals',
                                    'required_features' => [74],
                                    'active' => '\View::shared("submenu_active") == "deals-point-create"',
                                    'url' => 'deals-point/create'
                                ],
                                [
                                    'label' => 'Deals Point List',
                                    'required_features' => [72],
                                    'active' => '\View::shared("submenu_active") == "deals-point-list"',
                                    'url' => 'deals-point'
                                ],
                            ],
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [95],
                            'children' => [
                                [
                                    'label' => '[Response] Claim Free Deals Success',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/claim-free-deals-success',
                                ],
                                [
                                    'label' => '[Response] Claim Paid Deals Success',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/claim-paid-deals-success',
                                ],
                                [
                                    'label' => '[Response] Claim Point Deals Success',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/claim-point-deals-success',
                                ],
                                [
                                    'label' => '[Response] Redeems Deals',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/redeem-voucher-success',
                                ],
                                [
                                    'label' => '[Forward] Create Deals',
                                    'required_features' => [],
                                    'url' => 'autoresponse/deals/create-deals'
                                ],
                                [
                                    'label' => '[Forward] Update Deals',
                                    'required_features' => [],
                                    'url' => 'autoresponse/deals/update-deals'
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-gift'
                ],
                [
                    'label' => 'Product Bundling',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Bundling Category',
                            'required_features' => [290],
                            'active' => '\View::shared("submenu_active") == "product-bundling-category-new"',
                            'url' => 'product-bundling/category/create'
                        ],
                        [
                            'label' => 'Bundling Category List',
                            'required_features' => [288],
                            'active' => '\View::shared("submenu_active") == "product-bundling-category"',
                            'url' => 'product-bundling/category'
                        ],
                        [
                            'label' => 'New Product Bundling',
                            'required_features' => [290],
                            'active' => '\View::shared("submenu_active") == "product-bundling-create"',
                            'url' => 'product-bundling/create'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [288],
                            'children' => [
                                [
                                    'label' => 'Product Bundling List',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-bundling-list"',
                                    'url' => 'product-bundling'
                                ],
                                [
                                    'label' => 'Manage Position',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-bundling-position"',
                                    'url' => 'product-bundling/position/assign'
                                ],
                                [
                                    'label' => 'Setting Name Brand Bundling',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "product-bundling-setting"',
                                    'url' => 'product-bundling/setting'
                                ],
                            ]
                        ],
                    ],
                    'icon' => 'icon-present'
                ],
                [
                    'label' => 'Inject Voucher',
                    'required_features' => [],
                    'required_configs' => [26],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Inject Voucher',
                            'required_features' => [79],
                            'active' => '\View::shared("submenu_active") == "inject-voucher-create"',
                            'url' => 'inject-voucher/create'
                        ],
                        [
                            'label' => 'Inject Voucher List',
                            'required_features' => [77],
                            'active' => '\View::shared("submenu_active") == "inject-voucher-list"',
                            'url' => 'inject-voucher'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [120,122],
                            'children' => [
                                [
                                    'label' => '[Response] Receive Inject Voucher',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/receive-inject-voucher',
                                ],
                                [
                                    'label' => '[Forward] Create Inject Voucher',
                                    'required_features' => [],
                                    'url' => 'autoresponse/inject-voucher/create-inject-voucher'
                                ],
                                [
                                    'label' => '[Forward] Update Inject Voucher',
                                    'required_features' => [],
                                    'url' => 'autoresponse/inject-voucher/update-inject-voucher'
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-birthday-cake'
                ],
                [
                    'label' => 'Welcome Voucher',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Welcome Voucher',
                            'required_features' => [189],
                            'active' => '\View::shared("submenu_active") == "welcome-voucher-create"',
                            'url' => 'welcome-voucher/create'
                        ],
                        [
                            'label' => 'Welcome Voucher List',
                            'required_features' => [187],
                            'active' => '\View::shared("submenu_active") == "welcome-voucher-list"',
                            'url' => 'welcome-voucher'
                        ],
                        [
                            'label' => 'Welcome Voucher Setting',
                            'required_features' => [187,190],
                            'active' => '\View::shared("submenu_active") == "welcome-voucher-setting"',
                            'url' => 'welcome-voucher/setting'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [293],
                            'children' => [
                                [
                                    'label' => '[Response] Welcome Voucher',
                                    'required_features' => [],
                                    'url' => 'autoresponse/welcome-voucher/receive-welcome-voucher'
                                ],
                                [
                                    'label' => '[Forward] Create Welcome Voucher',
                                    'required_features' => [],
                                    'url' => 'autoresponse/welcome-voucher/create-welcome-voucher'
                                ],
                                [
                                    'label' => '[Forward] Update Welcome Voucher',
                                    'required_features' => [],
                                    'url' => 'autoresponse/welcome-voucher/update-welcome-voucher'
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-ticket'
                ],
                [
                    'label' => 'Deals Transaction',
                    'required_features' => [72],
                    'active' => '\View::shared("menu_active") == "deals-transaction"',
                    'url' => 'deals/transaction',
                    'icon' => 'fa fa-bar-chart'
                ],
                [
                    'label' => 'Promo Cashback Setting',
                    'required_features' => [233],
                    'url' => 'promo-setting/cashback',
                    'icon' => 'fa fa-money'
                ],
                [
                    'label' => 'Referral',
                    'required_features' => [216],
                    'required_configs' => [115],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Referral Setting',
                            'required_features' => [],
                            'url' => 'referral/setting'
                        ],
                        [
                            'label' => 'Referral Report',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "referral-report"',
                            'url' => 'referral/report'
                        ],
                    ],
                    'icon' => 'fa fa-user-plus'
                ],
                [
                    'label' => 'Reward',
                    'required_features' => [],
                    'required_configs' => [73],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Reward',
                            'required_features' => [132],
                            'active' => '\View::shared("submenu_active") == "reward-create"',
                            'url' => 'reward/create'
                        ],
                        [
                            'label' => 'Reward List',
                            'required_features' => [130,131,133,134],
                            'active' => '\View::shared("submenu_active") == "reward-list"',
                            'url' => 'reward'
                        ],
                    ],
                    'icon' => 'icon-trophy'
                ],
                [
                    'label' => 'Spin The Wheel',
                    'required_features' => [],
                    'required_configs' => [76],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Item',
                            'required_features' => [131],
                            'active' => '\View::shared("submenu_active") == "spinthewheel-new"',
                            'url' => 'spinthewheel/create'
                        ],
                        [
                            'label' => 'Item List',
                            'required_features' => [130],
                            'active' => '\View::shared("submenu_active") == "spinthewheel-list"',
                            'url' => 'spinthewheel/list'
                        ],
                        [
                            'label' => 'Setting',
                            'required_features' => [134],
                            'active' => '\View::shared("submenu_active") == "spinthewheel-setting"',
                            'url' => 'spinthewheel/setting'
                        ],
                    ],
                    'icon' => 'fa fa-circle-o-notch'
                ],
                [
                    'label' => 'Subscription',
                    'required_features' => [],
                    'required_configs' => [84],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Subscription',
                            'required_features' => [172],
                            'active' => '\View::shared("submenu_active") == "subscription-create"',
                            'url' => 'subscription/create'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [173],
                            'children' => [
                                [
                                    'label' => 'Subscription List',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "subscription-list"',
                                    'url' => 'subscription'
                                ],
                                [
                                    'label' => 'Subscription Claim Report',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "subscription-claim-report"',
                                    'url' => 'subscription/claim-report'
                                ],
                                [
                                    'label' => 'Subscription Transaction Report',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "subscription-transaction-report"',
                                    'url' => 'subscription/transaction-report'
                                ],
                                [
                                    'label' => 'List Export',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "subscription-list-export"',
                                    'url' => 'subscription/list-export'
                                ],
                            ],
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [178],
                            'required_configs' => [133],
                            'children' => [
                                [
                                    'label' => '[Response] Get Free Subscription Success',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/get-free-subscription-success',
                                ],
                                [
                                    'label' => '[Response] Buy Paid Subscription Success',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/buy-paid-subscription-success',
                                ],
                                [
                                    'label' => '[Response] Buy Point Subscription Success',
                                    'required_features' => [],
                                    'url' => 'transaction/autoresponse/buy-point-subscription-success',
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-gift'
                ],
                [
                    'label' => 'Welcome Subscription',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Welcome Subscription',
                            'required_features' => [266],
                            'active' => '\View::shared("submenu_active") == "welcome-subscription-create"',
                            'url' => 'welcome-subscription/create'
                        ],
                        [
                            'label' => 'Welcome Subscription List',
                            'required_features' => [264],
                            'active' => '\View::shared("submenu_active") == "welcome-subscription-list"',
                            'url' => 'welcome-subscription'
                        ],
                        [
                            'label' => 'Welcome Subscription Setting',
                            'required_features' => [264,267],
                            'active' => '\View::shared("submenu_active") == "welcome-subscription-setting"',
                            'url' => 'welcome-subscription/setting'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [178],
                            'children' => [
                                [
                                    'label' => '[Response] Receive Welcome Subscription',
                                    'required_features' => [],
                                    'url' => 'autoresponse/welcome-subscription/receive-welcome-subscription'
                                ],
                                [
                                    'label' => '[Forward] Create Welcome Subscription',
                                    'required_features' => [],
                                    'url' => 'autoresponse/welcome-subscription/create-welcome-subscription'
                                ],
                                [
                                    'label' => '[Forward] Update Welcome Subscription',
                                    'required_features' => [],
                                    'url' => 'autoresponse/welcome-subscription/update-welcome-subscription'
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-ticket'
                ],
                [
                    'label' => 'Achievement',
                    'required_features' => [],
                    'required_configs' => [99],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Achievement',
                            'required_features' => [223],
                            'active' => '\View::shared("submenu_active") == "achievement-create"',
                            'url' => 'achievement/create'
                        ],
                        [
                            'label' => 'Achievement List',
                            'required_features' => [221],
                            'active' => '\View::shared("submenu_active") == "achievement-list"',
                            'url' => 'achievement'
                        ],
                        [
                            'label' => 'Report Achievement',
                            'required_features' => [226],
                            'type' => 'tree',
                            'children' => [
                                [
                                    'label' => 'Achievement',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "achievement-report"',
                                    'url' => 'achievement/report'
                                ],
                                [
                                    'label' => 'User Achievement',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "achievement-report-user"',
                                    'url' => 'achievement/report/user-achievement'
                                ],
                                [
                                    'label' => 'Membership Achievement',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "achievement-report-membership"',
                                    'url' => 'achievement/report/membership'
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-trophy'
                ],
                [
                    'label' => 'Quest',
                    'required_features' => [],
                    'required_configs' => [100],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Quest Voucher',
                            'required_features' => [],
                            'type' => 'tree',
                            'children' => [
                                [
                                    'label' => 'New Quest Voucher',
                                    'required_features' => [308],
                                    'active' => '\View::shared("child_active") == "quest-voucher-create"',
                                    'url' => 'quest-voucher/create'
                                ],
                                [
                                    'label' => 'Quest Voucher List',
                                    'required_features' => [306],
                                    'active' => '\View::shared("child_active") == "quest-voucher-list"',
                                    'url' => 'quest-voucher'
                                ],
                                [
                                    'label' => '[Forward] Create Quest Voucher',
                                    'required_features' => [120,122],
                                    'url' => 'autoresponse/quest-voucher/create-quest-voucher'
                                ],
                                [
                                    'label' => '[Forward] Update Quest Voucher',
                                    'required_features' => [120,122],
                                    'url' => 'autoresponse/quest-voucher/update-quest-voucher'
                                ],
                            ],
                        ],
                        [
                            'label' => 'New Quest',
                            'required_features' => [229],
                            'active' => '\View::shared("submenu_active") == "quest-create"',
                            'url' => 'quest/create'
                        ],
                        [
                            'label' => 'Quest List',
                            'required_features' => [227],
                            'active' => '\View::shared("submenu_active") == "quest-list"',
                            'url' => 'quest'
                        ],
                        [
                            'label' => 'Report Quest',
                            'required_features' => [232],
                            'active' => '\View::shared("submenu_active") == "quest-report"',
                            'url' => 'quest/report'
                        ],
                        [
                            'required_features' => [122],
                            'type' => 'group',
                            'children' => [
                                [
                                    'label' => '[Response] Quest Completed',
                                    'required_features' => [],
                                    'url' => 'autoresponse/quest/quest-completed'
                                ],
                                [
                                    'label' => '[Response] Receive Quest Point',
                                    'required_features' => [],
                                    'url' => 'autoresponse/quest/receive-quest-point'
                                ],
                                [
                                    'label' => '[Response] Receive Quest Voucher',
                                    'required_features' => [],
                                    'url' => 'autoresponse/quest/receive-quest-voucher'
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-bullseye'
                ],
                [
                    'label' => 'Rule Promo Payment Gateway',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Promo Payment Gateway',
                            'required_features' => [313],
                            'active' => '\View::shared("submenu_active") == "disburse-promo-pg-new"',
                            'url' => 'disburse/rule-promo-payment-gateway/create'
                        ],
                        [
                            'type' => 'group',
                            'required_features' => [311,312,314,315],
                            'children' => [
                                [
                                    'label' => 'Promo Payment Gateway List',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "disburse-promo-pg-list"',
                                    'url' => 'disburse/rule-promo-payment-gateway'
                                ],
                                [
                                    'label' => 'Promo Payment Gateway List Transaction',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "disburse-promo-pg-list-trx"',
                                    'url' => 'disburse/rule-promo-payment-gateway/list-trx'
                                ],
                                [
                                    'label' => 'Promo Payment Gateway Validation',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "disburse-promo-pg-validation"',
                                    'url' => 'disburse/rule-promo-payment-gateway/validation'
                                ],
                                [
                                    'label' => 'Promo Payment Gateway Validation Report',
                                    'required_features' => [],
                                    'active' => '\View::shared("submenu_active") == "disburse-promo-pg-validation-report"',
                                    'url' => 'disburse/rule-promo-payment-gateway/validation/report'
                                ],
                            ],
                        ],
                    ],
                    'icon' => 'fa fa-tag'
                ],
            ],
        ],
        */
        /*
                [
                    'label' => 'User Feedback',
                    'required_configs' => [90],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'User Feedback List',
                            'required_features' => [179],
                            'active' => '\View::shared("submenu_active") == "user-feedback-list"',
                            'url' => 'user-feedback'
                        ],
                        [
                            'label' => 'User Feedback Setting',
                            'required_features' => [212],
                            'active' => '\View::shared("submenu_active") == "feedback-setting"',
                            'url' => 'user-feedback/setting'
                        ],
                        [
                            'label' => 'Report User Feedback',
                            'required_features' => [179],
                            'active' => '\View::shared("submenu_active") == "user-feedback-report"',
                            'url' => 'user-feedback/report'
                        ],
                        [
                            'label' => '[Response] User Feedback',
                            'required_features' => [179],
                            'url' => 'user-feedback/autoresponse'
                        ],
                    ],
                    'icon' => 'fa fa-thumbs-o-up'
                ],
                [
                    'label' => 'Single Campaign',
                    'required_configs' => [50],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Campaign',
                            'required_features' => [100],
                            'active' => '\View::shared("submenu_active") == "campaign-create"',
                            'url' => 'campaign/create'
                        ],
                        [
                            'label' => 'Campaign List',
                            'required_features' => [98],
                            'active' => '\View::shared("submenu_active") == "campaign-list"',
                            'url' => 'campaign'
                        ],
                        [
                            'label' => 'Email Outbox',
                            'required_features' => [104],
                            'required_configs' => [51],
                            'active' => '\View::shared("submenu_active") == "campaign-email-outbox"',
                            'url' => 'campaign/email/outbox'
                        ],
                        [
                            'label' => 'SMS Outbox',
                            'required_features' => [106],
                            'required_configs' => [52],
                            'active' => '\View::shared("submenu_active") == "campaign-sms-outbox"',
                            'url' => 'campaign/sms/outbox'
                        ],
                        [
                            'label' => 'Push Outbox',
                            'required_features' => [108],
                            'required_configs' => [53],
                            'active' => '\View::shared("submenu_active") == "campaign-push-outbox"',
                            'url' => 'campaign/push/outbox'
                        ],
                        [
                            'label' => 'WhatsApp Outbox',
                            'required_features' => [108],
                            'required_configs' => [75],
                            'active' => '\View::shared("submenu_active") == "campaign-whatsapp-outbox"',
                            'url' => 'campaign/whatsapp/outbox'
                        ],
                    ],
                    'icon' => 'icon-speech'
                ],
                [
                    'label' => 'Promotion',
                    'required_configs' => [72],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Deals Promotion',
                            'required_features' => [111],
                            'active' => '\View::shared("submenu_active") == "new-deals-promotion"',
                            'url' => 'promotion/deals/create'
                        ],
                        [
                            'label' => 'Deals Promotion',
                            'required_features' => [109],
                            'active' => '\View::shared("submenu_active") == "deals-promotion"',
                            'url' => 'promotion/deals'
                        ],
                        [
                            'label' => 'New Promotion',
                            'required_features' => [111],
                            'active' => '\View::shared("submenu_active") == "promotion-create"',
                            'url' => 'promotion/create'
                        ],
                        [
                            'label' => 'Promotion List',
                            'required_features' => [109],
                            'active' => '\View::shared("submenu_active") == "promotion-list"',
                            'url' => 'promotion'
                        ],
                    ],
                    'icon' => 'icon-emoticon-smile'
                ],
                [
                    'label' => 'Point Injection',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Point Injection',
                            'required_features' => [207],
                            'active' => '\View::shared("submenu_active") == "point-injection-create"',
                            'url' => 'point-injection/create'
                        ],
                        [
                            'label' => 'List Point Injection',
                            'required_features' => [205,206,208,209,245],
                            'active' => '\View::shared("submenu_active") == "point-injection-list"',
                            'url' => 'point-injection'
                        ],
                    ],
                    'icon' => 'icon-diamond'
                ],
                [
                    'label' => 'Inbox Global',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Inbox Global',
                            'required_features' => [116],
                            'active' => '\View::shared("submenu_active") == "inboxglobal-create"',
                            'url' => 'inboxglobal/create'
                        ],
                        [
                            'label' => 'Inbox Global List',
                            'required_features' => [114],
                            'active' => '\View::shared("submenu_active") == "inboxglobal-list"',
                            'url' => 'inboxglobal'
                        ],
                    ],
                    'icon' => 'icon-feed'
                ],
                [
                    'label' => 'Redirect Complex',
                    'required_configs' => [119],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Redirect Complex',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "redirect-complex-create"',
                            'url' => 'redirect-complex/create'
                        ],
                        [
                            'label' => 'Redirect Complex List',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "redirect-complex-list"',
                            'url' => 'redirect-complex'
                        ],
                    ],
                    'icon' => 'fa fa-external-link'
                ],
            ],
        ],
        */
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
                /** HIDE
                [
                    'label' => 'Setting Outlet Apps',
                    'required_features' => [273],
                    'required_configs' => [138],
                    'active' => '\View::shared("menu_active") == "setting/outletapp"',
                    'url' => 'setting/outletapp',
                    'icon' => 'fa fa-tablet'
                ],
                */
                [
                    'label' => 'Setting Phone Number',
                    'required_features' => [210],
                    'required_configs' => [94],
                    'active' => '\View::shared("menu_active") == "setting-phone"',
                    'url' => 'setting/phone',
                    'icon' => 'fa fa-phone'
                ],
                [
                    'label' => 'Text Menu',
                    'required_features' => [160],
                    'active' => '\View::shared("menu_active") == "setting-text-menu"',
                    'url' => 'setting/text_menu',
                    'icon' => 'fa fa-bars'
                ],
                [
                    'label' => 'Fraud Detection',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'Fraud Detection Settings',
                            'required_features' => [192],
                            'active' => '\View::shared("submenu_active") == "fraud-detection-update"',
                            'url' => 'setting-fraud-detection'
                        ],
                        [
                            'label' => 'Report Fraud Device',
                            'required_features' => [193],
                            'active' => '\View::shared("submenu_active") == "report-fraud-device"',
                            'url' => 'fraud-detection/report/device'
                        ],
                        [
                            'label' => 'Report Fraud Transaction Day',
                            'required_features' => [194],
                            'active' => '\View::shared("submenu_active") == "report-fraud-transaction-day"',
                            'url' => 'fraud-detection/report/transaction-day'
                        ],
                        [
                            'label' => 'Report Fraud Transaction Week',
                            'required_features' => [195],
                            'active' => '\View::shared("submenu_active") == "report-fraud-transaction-week"',
                            'url' => 'fraud-detection/report/transaction-week'
                        ],
                        [
                            'label' => 'Report Fraud Transaction in Between',
                            'required_features' => [215],
                            'active' => '\View::shared("submenu_active") == "report-fraud-transaction-between"',
                            'url' => 'fraud-detection/report/transaction-between'
                        ],
                        [
                            'label' => 'Report Fraud Referral User',
                            'required_features' => [217],
                            'required_configs' => [115],
                            'active' => '\View::shared("submenu_active") == "report-fraud-referral-user"',
                            'url' => 'fraud-detection/report/referral-user'
                        ],
                        [
                            'label' => 'Report Fraud Referral',
                            'required_features' => [218],
                            'active' => '\View::shared("submenu_active") == "report-fraud-referral"',
                            'url' => 'fraud-detection/report/referral'
                        ],
                        [
                            'label' => 'Report Fraud Promo Code',
                            'required_features' => [219],
                            'active' => '\View::shared("submenu_active") == "report-fraud-promo-code"',
                            'url' => 'fraud-detection/report/promo-code'
                        ],
                        [
                            'label' => 'List User Fraud',
                            'required_features' => [196],
                            'active' => '\View::shared("submenu_active") == "suspend-user"',
                            'url' => 'fraud-detection/suspend-user'
                        ],
                    ],
                    'icon' => 'fa fa-exclamation'
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
                // [
                //  'label' => 'Settings Max Quota Consultations',
                //  'required_features' => [348],
                //  'url' => 'setting/max_consultation_quota',
                //  'icon' => 'fa fa-file'
                // ],
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
                    'label' => 'Single Campaign',
                    'required_configs' => [50],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New Campaign',
                            'required_features' => [100],
                            'active' => '\View::shared("submenu_active") == "campaign-create"',
                            'url' => 'campaign/create'
                        ],
                        [
                            'label' => 'Campaign List',
                            'required_features' => [98],
                            'active' => '\View::shared("submenu_active") == "campaign-list"',
                            'url' => 'campaign'
                        ],
                        [
                            'label' => 'Email Outbox',
                            'required_features' => [104],
                            'required_configs' => [51],
                            'active' => '\View::shared("submenu_active") == "campaign-email-outbox"',
                            'url' => 'campaign/email/outbox'
                        ],
                        [
                            'label' => 'SMS Outbox',
                            'required_features' => [106],
                            'required_configs' => [52],
                            'active' => '\View::shared("submenu_active") == "campaign-sms-outbox"',
                            'url' => 'campaign/sms/outbox'
                        ],
                        [
                            'label' => 'Push Outbox',
                            'required_features' => [108],
                            'required_configs' => [53],
                            'active' => '\View::shared("submenu_active") == "campaign-push-outbox"',
                            'url' => 'campaign/push/outbox'
                        ],
                        [
                            'label' => 'WhatsApp Outbox',
                            'required_features' => [108],
                            'required_configs' => [75],
                            'active' => '\View::shared("submenu_active") == "campaign-whatsapp-outbox"',
                            'url' => 'campaign/whatsapp/outbox'
                        ],
                    ],
                    'icon' => 'icon-speech'
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
                [
                    'label' => 'FAQ Doctor Apps',
                    'required_features' => [],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => 'New FAQ',
                            'required_features' => [89],
                            'url' => 'setting/faq-doctor/create'
                        ],
                        [
                            'label' => 'List FAQ',
                            'required_features' => [88],
                            'active' => '\View::shared("submenu_active") == "faq-doctor-list"',
                            'url' => 'setting/faq-doctor'
                        ],
                        [
                            'label' => 'Sorting FAQ List',
                            'required_features' => [88],
                            'active' => '\View::shared("submenu_active") == "faq-doctor-sort"',
                            'url' => 'setting/faq-doctor/sort'
                        ],
                    ],
                    'icon' => 'icon-question'
                ],
                [
                    'label' => 'Privacy Policy',
                    'required_features' => [350],
                    'url' => 'setting/privacypolicy',
                    'icon' => 'fa fa-lock'
                ],
                [
                    'label' => 'Privacy Policy Doctor Apps',
                    'required_features' => [350],
                    'url' => 'setting/privacypolicydoctor',
                    'icon' => 'fa fa-lock'
                ],
                [
                    'label' => 'Delivery Services',
                    'required_features' => [154],
                    'required_configs' => [96],
                    'url' => 'delivery-service',
                    'icon' => 'icon-social-dropbox'
                ],
            ],
        ],
        /** HIDE
        [
            'type' => 'group',
            'label' => 'Disburse',
            'required_features' => [],
            'children' => [
                [
                    'label' => 'Dashboard',
                    'required_features' => [234],
                    'active' => '\View::shared("menu_active") == "disburse-dashboard"',
                    'url' => 'disburse/dashboard',
                    'icon' => 'fa fa-th'
                ],
                [
                    'label' => 'List All',
                    'required_features' => [234],
                    'active' => '\View::shared("menu_active") == "disburse-list-all"',
                    'url' => 'disburse/list/all',
                    'icon' => 'fa fa-list'
                ],
                [
                    'label' => 'List Success',
                    'required_features' => [234],
                    'active' => '\View::shared("menu_active") == "disburse-list-success"',
                    'url' => 'disburse/list/success',
                    'icon' => 'fa fa-list'
                ],
                [
                    'label' => 'List Fail',
                    'required_features' => [234],
                    'active' => '\View::shared("menu_active") == "disburse-list-fail-action" || \View::shared("menu_active") == "disburse-list-fail"',
                    'url' => 'disburse/list/fail-action',
                    'icon' => 'fa fa-list'
                ],
                [
                    'label' => 'List Transaction Online',
                    'required_features' => [234],
                    'active' => '\View::shared("menu_active") == "disburse-list-trx"',
                    'url' => 'disburse/list/trx',
                    'icon' => 'fa fa-list'
                ],
                [
                    'label' => 'Settings',
                    'required_features' => [235],
                    'type' => 'tree',
                    'children' => [
                        [
                            'label' => '[Response] Failed Send Disburse',
                            'required_features' => [],
                            'url' => 'disburse/autoresponse/failed-send-disburse'
                        ],
                        [
                            'label' => 'Add Bank Account',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "disburse-setting-add-bank-account"',
                            'url' => 'disburse/setting/bank-account'
                        ],
                        [
                            'label' => 'Edit Bank Account',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "disburse-setting-edit-bank-account"',
                            'url' => 'disburse/setting/edit-bank-account'
                        ],
                        [
                            'label' => 'MDR',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "disburse-setting-mdr"',
                            'url' => 'disburse/setting/mdr'
                        ],
                        [
                            'label' => 'Global Setting',
                            'required_features' => [],
                            'active' => '\View::shared("submenu_active") == "disburse-setting-global"',
                            'url' => 'disburse/setting/global'
                        ],
                    ],
                    'icon' => 'fa fa-sliders'
                ],
            ],
        ],
        [
            'type' => 'group',
            'label' => 'Report',
            'required_features' => [125, 126, 127, 128, 129, 271],
            'children' => [
                [
                    'label' => 'Report',
                    'required_features' => [],
                    'active' => '\View::shared("submenu_active") == "report-single"',
                    'url' => 'report',
                    'icon' => 'icon-graph'
                ],
                [
                    'label' => 'Compare Report',
                    'required_features' => [],
                    'active' => '\View::shared("submenu_active") == "report-compare"',
                    'url' => 'report/compare',
                    'icon' => 'icon-graph'
                ],
                [
                    'label' => 'Global',
                    'required_features' => [125],
                    'active' => '\View::shared("submenu_active") == "report-global"',
                    'url' => 'report/global',
                    'icon' => 'icon-graph'
                ],
                [
                    'label' => 'Customer',
                    'required_features' => [126],
                    'active' => '\View::shared("submenu_active") == "report-customer"',
                    'url' => 'report/customer/summary',
                    'icon' => 'icon-graph'
                ],
                [
                    'label' => 'Product',
                    'required_features' => [127],
                    'active' => '\View::shared("submenu_active") == "report-product"',
                    'url' => 'report/product',
                    'icon' => 'icon-graph'
                ],
                [
                    'label' => 'Outlet',
                    'required_features' => [128],
                    'active' => '\View::shared("submenu_active") == "report-outlet"',
                    'url' => 'report/outlet',
                    'icon' => 'icon-graph'
                ],
                [
                    'label' => 'Shift',
                    'required_features' => [271],
                    'active' => '\View::shared("submenu_active") == "report-shift"',
                    'url' => 'report/shift/summary',
                    'icon' => 'icon-graph'
                ]
            ]
        ],
        */
    ],
];

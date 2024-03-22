<?php
return [
    [
        'cols' => [
            'SUM(End_User_Price)',
            'Category'
        ],
        'groupBy' => 'Category',
        'orderBy' => 'SUM(End_User_Price)',
        'orderType' => 'desc',
        'label' => 'Dash Sum Net Price By Rep',
        'is_horizontal' => false,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-6',
        'total_res' => true,
    ],
    [
        'cols' => [
            'SUM(End_User_Price)',
            'Brand'
        ],
        'groupBy' => 'Brand',
        'orderBy' => 'SUM(End_User_Price)',
        'orderType' => 'desc',
        'label' => 'Dash Sum Net Price By Brand',
        'is_horizontal' => false,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-4',
        'total_res' => true,
    ],
    [
        'cols' => [
            'count(Serial)',
            'representative'
        ],
        'groupBy' => 'representative',
        'orderBy' => 'count(Serial)',
        'orderType' => 'desc',
        'label' => 'Dash Sum Net Price By Sum Out',
        'is_horizontal' => true,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-10',
        'total_res' => true,
    ],
    [
        'cols' => [
            'SUM(End_User_Price)',
            'representative'
        ],
        'groupBy' => 'representative',
        'orderBy' => 'SUM(End_User_Price)',
        'orderType' => 'desc',
        'label' => 'Dash Sum Net Peice By Rep',
        'is_horizontal' => true,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-10',
        'total_res' => true,
    ],

];

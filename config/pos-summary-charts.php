<?php
return [
    [
        'cols' => [
            'SUM(customer_earning)',
            'region'
        ],
        'groupBy' => 'region',
        'orderBy' => 'SUM(customer_earning)',
        'orderType' => 'desc',
        'label' => 'Customer Earning By Region',
        'is_horizontal' => false,
        'js_function' => 'buildPieChart',
        'size' => 'col-md-6',
    ],
    [
        'cols' => [
            'SUM(company_earning)',
            'region'
        ],
        'groupBy' => 'region',
        'orderBy' => 'SUM(company_earning)',
        'orderType' => 'desc',
        'label' => 'Company Earning By Region',
        'is_horizontal' => false,
        'js_function' => 'buildPieChart',
        'size' => 'col-md-6',
    ],
    [
        'cols' => [
            'SUM(sum_cost)',
            'region'
        ],
        'groupBy' => 'region',
        'orderBy' => 'SUM(sum_cost)',
        'orderType' => 'desc',
        'label' => 'Sum Net Price By Region',
        'is_horizontal' => false,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-6',
    ],
    [
        'cols' => [
            'SUM(sum_net_price)',
            'City'
        ],
        'groupBy' => 'City',
        'orderBy' => 'SUM(sum_net_price)',
        'orderType' => 'desc',
        'label' => 'Sum Net Price By City',
        'is_horizontal' => true,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-6',
    ],

];

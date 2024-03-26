<?php
return [
    [
        'cols' => [
            'SUM(transaction_amount)',
            'customers_name'
        ],
        'groupBy' => 'customers_name',
        'orderBy' => 'SUM(transaction_amount)',
        'orderType' => 'desc',
        'label' => 'Balance Request By Date',
        'is_horizontal' => false,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-6',
    ],
    [
        'cols' => [
            'SUM(transaction_amount)',
            'customers_name'
        ],
        'groupBy' => ['customers_name','rep_id'],
        'orderBy' => 'SUM(transaction_amount)',
        'orderType' => 'desc',
        'label' => 'Balance Request By Rep',
        'is_horizontal' => false,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-6',
    ],
];

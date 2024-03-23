<?php
return [
    [
        'cols' => [
            'SUM(Amount)',
            'SenderName'
        ],
        'groupBy' => 'SenderName',
        'orderBy' => 'SUM(Amount)',
        'orderType' => 'desc',
        'label' => 'Transaction By Rep',
        'is_horizontal' => true,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-6',
//        'total_res' => true,
    ],
    [
        'cols' => [
            'SUM(Amount)',
            'SenderName'
        ],
        'groupBy' => 'SenderName',
        'orderBy' => 'SUM(Amount)',
        'orderType' => 'asc',
        'label' => 'Transaction By Date',
        'is_horizontal' => false,
        'js_function' => 'buildBarChart',
        'size' => 'col-md-6',
//        'total_res' => true,
    ],
];

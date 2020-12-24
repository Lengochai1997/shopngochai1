<?php

return [
    'status' => [
        1   => 'Chờ xử lý',
        2   => 'Thẻ đúng',
        3   => 'Thẻ sai',
        4   => 'Thẻ sai mệnh giá',
    ],
    'napthenhanh' => [
        'id' => env('NAPTHENHANH_ID'),
        'key' => env('NAPTHENHANH_KEY')
    ],

    'muacard' => [
        'key' => env('MUACARD_KEY'),
        'callback' => env('MUACARD_CALLBACK'),
    ],

    'partner_id' => env('NAPTHENHANH_ID'),
    'partner_key' => env('NAPTHENHANH_KEY'),

];

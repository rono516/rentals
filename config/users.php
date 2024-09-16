<?php

return [
    'superUser' => [
        'name' => env('SUPER_USER_NAME'),
        'email' => env('SUPER_USER_EMAIL'),
        'password' => env('SUPER_USER_PASSWORD'),
    ],
    'landlord' => [
        'name' => env('LANDLORD_NAME'),
        'email' => env('LANDLORD_EMAIL'),
        'password' => env('LANDLORD_PASSWORD'),
    ],

];

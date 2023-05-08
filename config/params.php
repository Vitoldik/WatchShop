<?php

return [
    'admin_email' => 'admin@mail.ru',
    'shop_name' => 'WatchShop',
    'pagination' => 3,
    'mailer' => [
        'dsn' => 'smtp://username:password@smtp.mailtrap.io:2525/?encryption=ssl&auth_mode=login&verify_peer=false',
        'from' => 'username@mail.com'
    ]
];
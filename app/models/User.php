<?php

namespace app\models;

use R;

class User extends AppModel {

    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => ''
    ];

    public $rules = [
        'required' => [
            ['login'],
            ['password'],
            ['name'],
            ['email'],
            ['address'],
        ],
        'email' => [
            ['email']
        ],
        'lengthMin' => [
            ['login', 3],
            ['password', 6]
        ]
    ];

    public function checkUnique(): bool {
        $user = R::findOne('user', 'login = ? OR email = ?', [$this->attributes['login'], $this->attributes['email']]);

        if (!$user)
            return true;

        if ($user->login === $this->attributes['login'])
            $this->errors['unique'][] = 'Account with this username is already registered!';

        if ($user->email === $this->attributes['email'])
            $this->errors['unique'][] = 'Account with this email is already registered!';

        return false;
    }
}
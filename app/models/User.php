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

    public function login($isAdmin = false): bool {
        $login = isset($_POST['login']) ? trim($_POST['login']) : null;
        $password = isset($_POST['password']) ? trim($_POST['password']) : null;

        if (!$login || !$password)
            return false;

        $query = "login = ?";

        if ($isAdmin)
            $query .= " AND role = 'admin'";

        $user = R::findOne('user', $query, [$login]);

        if (!$user)
            return false;

        if (!password_verify($password, $user->password))
            return false;

        foreach ($user as $k => $v) {
            if ($k === 'password')
                continue;

            $_SESSION['user'][$k] = $v;
        }

        return true;
    }

    public static function isAuthorized(): bool {
        return isset($_SESSION['user']);
    }

    public static function isAdmin(): bool {
        return self::isAuthorized() && $_SESSION['user']['role'] == 'admin';
    }
}
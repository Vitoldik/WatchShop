<?php

namespace app\utils;

use app\models\User;

class UserUtils {

    public static function createUser() {
        $user = new User();
        $user->load($_POST);

        if (!$user->validate($_POST) || !$user->checkUnique()) {
            $user->setErrorsToSession();
            $_SESSION['form_data'] = $_POST;
            return null;
        }

        $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);

        // Авторизуем зарегистрированного пользователя
        if ($id = $user->save('user')) {
            $_SESSION['success'] = 'Account registered!';

            $_SESSION['user']['id'] = $id;
            $_SESSION['user']['role'] = 'user';

            foreach ($user->attributes as $name => $value) {
                if ($name === 'password')
                    continue;

                $_SESSION['user'][$name] = $value;
            }

            return $id;
        }

        $_SESSION['error'] = 'User save error!';
        return null;
    }

}
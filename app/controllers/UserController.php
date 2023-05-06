<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController {

    public function signupAction() {
        if (!empty($_POST)) {
            $user = new User();
            $user->load($_POST);

            if (!$user->validate($_POST) || !$user->checkUnique()) {
                $user->setErrorsToSession();
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);

                if ($user->save('user')) {
                    $_SESSION['success'] = 'Account registered!';
                } else {
                    $_SESSION['error'] = 'User save error!';
                }
            }

            redirect();
        }

        $this->setMeta('Registration');
    }

    public function loginAction() {

    }

    public function logoutAction() {

    }

}
<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController {

    public function signupAction() {
        if (!empty($_POST)) {
            $user = new User();
            $user->load($_POST);

            if (!$user->validate($_POST)) {
                $user->setErrorsToSession();
            } else {
                $_SESSION['success'] = 'OK';
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
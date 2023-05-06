<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController {

    public function signupAction() {
        if (!empty($_POST)) {
            $user = new User();
            $user->load($_POST);
        }

        $this->setMeta('Registration');
    }

    public function loginAction() {

    }

    public function logoutAction() {

    }

}
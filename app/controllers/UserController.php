<?php

namespace app\controllers;

use app\models\User;
use app\utils\UserUtils;

class UserController extends AppController {

    public function signupAction() {
        if (User::isAuthorized())
            redirect('/');

        if (!empty($_POST))
            redirect(UserUtils::createUser() !== null ? '/' : '');

        $this->setMeta('Registration');
    }

    public function loginAction() {
        if (User::isAuthorized())
            redirect('/');

        if (!empty($_POST)) {
            $user = new User();

            if ($user->login()) {
                $_SESSION['success'] = 'Successful authorization!';
            } else {
                $_SESSION['error'] = 'Wrong user or password!';
                unset($_POST['password']);
                $_SESSION['form_data'] = $_POST;
            }

            redirect();
        }

        $this->setMeta('Login');
    }

    public function logoutAction() {
        if (isset($_SESSION['user']))
            unset($_SESSION['user']);

        redirect();
    }

}
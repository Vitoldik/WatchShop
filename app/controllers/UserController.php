<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController {

    public function signupAction() {
        if (User::isAuthorized())
            redirect('/');

        if (!empty($_POST)) {
            $user = new User();
            $user->load($_POST);

            if (!$user->validate($_POST) || !$user->checkUnique()) {
                $user->setErrorsToSession();
                $_SESSION['form_data'] = $_POST;
            } else {
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

                    redirect('/');
                } else {
                    $_SESSION['error'] = 'User save error!';
                }
            }

            redirect();
        }

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
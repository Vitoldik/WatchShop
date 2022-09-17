<?php

namespace app\controllers;

use watchShop\App;

class MainController extends AppController {

    public function indexAction() {
        $posts = \R::findAll('test');

        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключи');

        $name = 'test';
        $age = '24';

        $this->setData(compact('name', 'age', 'posts'));
    }
}
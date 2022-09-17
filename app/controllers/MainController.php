<?php

namespace app\controllers;

use watchShop\App;

class MainController extends AppController {

    public function indexAction() {
        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключи');

        $this->setData(['name' => 'Test', 'age' => 24]);
    }
}
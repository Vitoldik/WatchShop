<?php

namespace app\controllers;

use watchShop\App;
use watchShop\base\Controller;

class MainController extends AppController {

    public function indexAction() {
        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключи');

        $this->setData(['name' => 'Test', 'age' => 24]);
    }
}
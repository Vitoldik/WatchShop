<?php

namespace app\controllers;

use watchShop\App;
use watchShop\Cache;

class MainController extends AppController {

    public function indexAction() {
        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключи');
    }
}
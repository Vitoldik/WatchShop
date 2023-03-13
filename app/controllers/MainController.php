<?php

namespace app\controllers;

use watchShop\App;
use watchShop\Cache;

class MainController extends AppController {

    public function indexAction() {
        $brands = \R::find('brand', 'LIMIT 3');

        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключи');
        $this->setData(compact('brands'));
    }
}
<?php

namespace app\controllers;

use watchShop\App;

class PageController extends AppController {

    public function viewAction() {
        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключи');
    }
}
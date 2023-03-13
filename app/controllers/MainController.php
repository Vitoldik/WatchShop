<?php

namespace app\controllers;

use watchShop\App;
use watchShop\Cache;

class MainController extends AppController {

    public function indexAction() {
        $posts = \R::findAll('test');

        $this->setMeta(App::$app->getProperty('shop_name'), 'Описание', 'Ключи');

        $name = 'test';
        $age = '24';

        $names = ['Test', 'Test1', 'Test2', 'Test3'];

        $cache = Cache::instance();
        //$cache->set('test', $names, 60);
//
//        $cache->delete('test');
//        debug($cache->get('test'));

        $this->setData(compact('name', 'age', 'posts'));
    }
}
<?php

namespace app\controllers;

use app\widgets\currency\Currency;
use R;
use watchShop\App;
use watchShop\base\Controller;
use app\models\AppModel;
use watchShop\Cache;

class AppController extends Controller {

    public function __construct($route) {
        parent::__construct($route);
        new AppModel();

        $currencies = Currency::getCurrencies();
        App::$app->setProperty('currencies', $currencies);
        App::$app->setProperty('currency', Currency::getCurrency($currencies));
        App::$app->setProperty('categories', self::getCachedCategory());
    }

    public static function getCachedCategory() {
        $cache = Cache::instance();
        $categories = $cache->get('categories');

        if (!$categories) {
            $categories = R::getAssoc('SELECT * FROM category');
            $cache->set('categories', $categories);
        }

        return $categories;
    }

}
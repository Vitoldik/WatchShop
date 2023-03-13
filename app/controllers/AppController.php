<?php

namespace app\controllers;

use app\widgets\currency\Currency;
use watchShop\App;
use watchShop\base\Controller;
use app\models\AppModel;

class AppController extends Controller {

    public function __construct($route) {
        parent::__construct($route);
        new AppModel();
        setcookie('currency', 'EUR', time() + 3600 * 24 * 7, '/');

        $currencies = Currency::getCurrencies();
        App::$app->setProperty('currencies', $currencies);
        App::$app->setProperty('currency', Currency::getCurrency($currencies));

        debug(App::$app->getProperties());
    }

}
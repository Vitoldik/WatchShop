<?php

namespace app\widgets\currency;

use watchShop\App;

class Currency {

    protected string $tpl; // шаблон
    protected array $currencies; // список валют
    protected mixed $currency; // активная валюта

    public function __construct() {
        $this->tpl = __DIR__ . '/currency_tpl/currency.php';
        $this->run();
    }

    protected function run(): void {
        $this->currencies = App::$app->getProperty('currencies');
        $this->currency = App::$app->getProperty('currency');
        echo $this->getHtml();
    }

    public static function getCurrencies() {
        return \R::getAssoc("SELECT code, title, symbol_left, symbol_right, value, base 
                                 FROM currency 
                                 ORDER BY base DESC");
    }

    public static function getCurrency($currencies): mixed {
        if (isset($_COOKIE['currency']) && array_key_exists($_COOKIE['currency'], $currencies)) {
            $key = $_COOKIE['currency'];
        } else {
            $key = key($currencies);
        }

        $currency = $currencies[$key];
        $currency['code'] = $key;
        return $currency;
    }

    protected function getHtml(): bool|string {
        ob_start();
        require_once $this->tpl;
        return ob_get_clean();
    }
}
<?php

namespace watchShop;

class Db {

    use TSingleton;

    protected function __construct() {
        $db = require_once CONFIG_DIR . '/db.php';
        class_alias('\RedBeanPHP\R', '\R');
        ['dsn' => $dsn, 'user' => $user, 'password' => $password] = $db;
        \R::setup($dsn, $user, $password);

        if (!\R::testConnection()) {
            throw new \Exception('Ошибка соединения с базой данных!', 500);
        }

        \R::freeze(true); // выключить гибкий режим

        if (DEBUG) {
            \R::debug(true, 1);
        }
    }

}
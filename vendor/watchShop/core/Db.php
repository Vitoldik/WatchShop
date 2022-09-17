<?php

namespace watchShop;

class Db {

    use TSingleton;

    protected function __construct() {
        $db = require_once CONFIG_DIR . '/db.php';
    }

}
<?php

namespace watchShop\base;

use watchShop\Db;

abstract class Model {

    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct() {
        Db::instance();
    }

    public function load($data) {
        foreach ($this->attributes as $name => $value) {
            if (!isset($data[$name]))
                continue;

            $this->attributes[$name] = $data[$name];
        }
    }
}
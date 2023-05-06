<?php

namespace watchShop\base;

use Valitron\Validator;
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

    public function validate($data) {
        $validator = new Validator($data);
        $validator->rules($this->rules);

        if ($validator->validate())
            return true;

        $this->errors = $validator->errors();
        return false;
    }

    public function save($table) {
        $bean = \R::dispense($table);

        foreach ($this->attributes as $name => $value) {
            $bean->$name = $value;
        }

        return \R::store($bean);
    }

    public function setErrorsToSession() {
        $errors .= '<ul>';

        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }

        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }
}
<?php

namespace watchShop\base;

abstract class Controller {

    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $data = [];
    public $meta = [];

    public function  __construct($route) {
        $this->route = $route;
        ['controller' => $controller, 'action' => $action, 'prefix' => $prefix] = $route;
        $this->controller = $controller;
        $this->model = $controller;
        $this->view = $action;
        $this->prefix = $prefix;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setMeta($title = '', $desc = '', $keywords = '') {
        ['title' => $title, 'desc' => $desc, 'keywords' => $keywords] = $meta;

        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['key'] = $key;
    }
}
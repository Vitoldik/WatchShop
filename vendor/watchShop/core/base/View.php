<?php

namespace watchShop\base;

class View {

    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = [];

    public function  __construct($route, $layout = '', $view = '', $meta) {
        $this->route = $route;
        ['controller' => $controller, 'prefix' => $prefix] = $route;
        $this->controller = $controller;
        $this->model = $controller;
        $this->view = $view;
        $this->prefix = $prefix;
        $this->meta = $meta;

        $this->layout = $layout === false ? $this->layout = false : $layout ?: LAYOUT;
    }

}
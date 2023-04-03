<?php

namespace watchShop\base;

abstract class Controller {

    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = ['title' => '', 'desc' => '', 'keywords' => ''];

    public function  __construct(public $route) {
        ['controller' => $controller, 'action' => $action, 'prefix' => $prefix] = $route;
        $this->controller = $controller;
        $this->model = $controller;
        $this->view = $action;
        $this->prefix = $prefix;
    }

    public function getView() {
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setMeta($title = '', $desc = '', $keywords = '') {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }
}
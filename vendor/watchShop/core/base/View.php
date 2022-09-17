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

        $this->layout = $layout === false ? $this->layout = false : ($layout ?: LAYOUT);
    }

    public function render($data) {
        if (is_array($data))
            extract($data);

        $viewFile = APP_DIR . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";

        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean(); // сохраняем вид в перременную content для вызова
        } else {
            throw new \Exception("Не найден вид {$viewFile}", 500);
        }

        if ($this->layout !== false) {
            $layoutFile = APP_DIR . "/views/layouts/{$this->layout}.php";

            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("Не найден шаблон {$this->layout}");
            }
        }
    }

    public function getMeta() {
        ['title' => $title, 'desc' => $desc, 'keywords' => $keywords] = $this->meta;

        $output = "<title>$title</title>" . PHP_EOL;
        $output .= "<meta name='description' content='$desc'>" . PHP_EOL;
        $output .= "<meta name='keywords' content='$keywords'>" . PHP_EOL;

        return $output;
    }
}
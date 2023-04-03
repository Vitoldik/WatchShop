<?php

namespace app\widgets\menu;

use R;
use watchShop\App;
use watchShop\Cache;

class Menu {

    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;
    protected $container = 'ul';
    protected string $table = 'category';
    protected int $cache = 3600;
    protected string $cacheKey  = 'menu';
    protected array $attrs = [];
    protected $prepend = '';

    public function __construct($options = []) {
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';
        $this->setOptions($options);
        $this->run();
    }

    /**
     * Метод для заполнения опций
     * @param $options
     * @return void
     */
    protected function setOptions($options): void {
        foreach ($options as $k => $v) {
            // Проверяем, есть ли переменная с названием ключа массива в классе
            if (!property_exists($this, $k))
                continue;

            $this->$k = $v;
        }
    }

    protected function run(): void {
        $cache = Cache::instance();
        $this->menuHtml = $cache->get($this->cacheKey);

        if (!$this->menuHtml) {
            $this->data = App::$app->getProperty('menuData');

            if (!$this->data)
                $this->data = R::getAssoc("SELECT * FROM $this->table");

            // TODO работа с деревом меню
        }

        $this->output();
    }

    protected function output(): void {
        echo $this->menuHtml;
    }

    protected function getTree() {

    }

    protected function getMenuHtml($tree, $tab = '') {

    }

    protected function categoryToTemplate($category, $tab, $id) {

    }
}
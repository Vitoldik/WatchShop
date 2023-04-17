<?php

namespace app\widgets\menu;

use R;
use watchShop\App;
use watchShop\Cache;

class Menu {

    protected $data;
    protected array $tree;
    protected $menuHtml;
    protected $tpl;
    protected string $container = 'ul';
    protected string $class = 'menu';
    protected string $table = 'category';
    protected int $cache = 3600;
    protected string $cacheKey  = 'menu';
    protected array $attrs = [];
    protected string $prepend = '';

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
            $this->data = App::$app->getProperty('categories');

            if (!$this->data)
                $this->data = R::getAssoc("SELECT * FROM $this->table");

            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);

            if ($this->cache) {
                $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
            }
        }

        $this->output();
    }

    protected function output(): void {
        $attrs = '';

        if (!empty($this->attrs)) {
            foreach ($this->attrs as $k => $v) {
                $attrs .= " $k='$v' ";
            }
        }

        echo "<$this->container class='$this->class' $attrs>";
        echo $this->prepend;
        echo $this->menuHtml;
        echo "</$this->container>";
    }

    protected function getTree(): array {
        $tree = [];
        $data = $this->data;

        foreach ($data as $id => &$node) {
            if ($node['parent_id']) {
                $data[$node['parent_id']]['children'][$id] = &$node;
                continue;
            }

            $tree[$id] = &$node;
        }

        return $tree;
    }

    protected function getMenuHtml($tree, $tab = ''): string {
        $str = '';

        foreach ($tree as $id => $category) {
            $str .= $this->categoryToTemplate($category, $tab, $id);
        }

        return $str;
    }

    protected function categoryToTemplate($category, $tab, $id): bool|string {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}
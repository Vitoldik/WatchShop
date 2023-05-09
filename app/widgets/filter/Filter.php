<?php

namespace app\widgets\filter;

use R;
use RedBeanPHP\Cursor;
use watchShop\Cache;

class Filter {
    public array|int|null|Cursor $groups;
    public array|int|null|Cursor $attrs;
    public string $tpl;

    public function __construct() {
        $this->tpl = __DIR__ . '/filter_tpl.php';
        $this->run();
    }

    protected function run() {
        $cache = Cache::instance();
        $this->groups = $cache->get('filter_group');

        if (!$this->groups) {
            $this->groups = $this->getGroups();
            $cache->set('filter_group', $this->groups, 30);
        }

        $this->attrs = $cache->get('filter_attrs');

        if (!$this->attrs) {
            $this->attrs = $this->getAttrs();
            $cache->set('filter_attrs', $this->attrs, 30);
        }

        echo $this->getHTMl();
    }

    protected function getHTMl() {
        ob_start();
        $filter = self::getFilters();

        if (isset($filter))
            $filter = explode(',', $filter);

        require $this->tpl;
        return ob_get_clean();
    }

    protected function getGroups(): array|Cursor|int|null {
        return R::getAssoc('SELECT id, title FROM attribute_group');
    }

    protected function getAttrs(): array|Cursor|int|null {
        $data = R::getAssoc('SELECT * FROM attribute_value');
        $attrs = [];

        foreach ($data as $k => $v) {
            $attrs[$v['attr_group_id']][$k] = $v['value'];
        }

        return $attrs;
    }

    public static function getFilters(): array|string|null {
        return !empty($_GET['filter'])
            ? preg_replace('#[^\d,]#', '', $_GET['filter'])
            : null;
    }
}
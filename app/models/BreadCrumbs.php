<?php

namespace app\models;

use watchShop\App;

class BreadCrumbs {

    public static function getBreadCrumbsHtml($categoryId, $name = ''): string {
        $categories = App::$app->getProperty('categories');
        $breadCrumbsArr = self::getParts($categories, $categoryId);
        $breadCrumbs = "<li><a href='" . MAIN_URL . "'>Home</a></li>";

        if ($breadCrumbsArr) {
            foreach ($breadCrumbsArr as $alias => $title) {
                $breadCrumbs .= "<li><a href='" . MAIN_URL . "/category/$alias'>$title</a></li>";
            }
        }

        if ($name)
            $breadCrumbs .= "<li>$name</li>";

        return $breadCrumbs;
    }

    public static function getParts($categories, $id): bool|array {
        if (!$id)
            return false;

        $breadCrumbs = [];

        for ($i = 0; $i < count($categories); $i++) {
            if (isset($categories[$id])) {
                $breadCrumbs[$categories[$id]['alias']] = $categories[$id]['title'];
                $id = $categories[$id]['parent_id'];
                continue;
            }

            break;
        }

        return array_reverse($breadCrumbs, true);
    }

}
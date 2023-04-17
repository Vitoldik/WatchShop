<?php

namespace app\models;

class Product extends AppModel {

    public function setRecentlyViewed($id) {
        $recentlyViewed = $this->getAllRecentlyViewed();

        if (!$recentlyViewed) {
            setcookie('recentlyViewed', $id, time() + 3600 * 24, '/');
            return;
        }

        $recentlyViewed = explode(',', $recentlyViewed);

        if (in_array($id, $recentlyViewed))
            return;

        $recentlyViewed[] = $id;

        setcookie('recentlyViewed', implode(',', $recentlyViewed), time() + 3600 * 24, '/');
    }

    public function getRecentlyViewed(): array|bool {
        $recentlyViewed = $this->getAllRecentlyViewed();

        return $recentlyViewed
            ? array_slice(explode(',', $recentlyViewed), -3)
            : false;
    }

    public function getAllRecentlyViewed() {
        return $_COOKIE['recentlyViewed'] ?? false;
    }
}
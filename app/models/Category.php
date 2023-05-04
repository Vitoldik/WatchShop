<?php

namespace app\models;

use watchShop\App;

class Category extends AppModel {

    public function getIds($id): ?string {
        $categories = App::$app->getProperty('categories');
        $ids = null;

        foreach ($categories as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }

        return $ids;
    }

}
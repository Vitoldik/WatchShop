<?php

namespace app\controllers;

use R;

class ProductController extends AppController {

    /**
     * @throws \Exception - будет выброшено если товар не найден или не активен
     */
    public function viewAction() {
        $alias = $this->route['alias'];
        $product = R::findOne('product', 'alias = ? AND status = "1"', [$alias]);

        if (!$product) {
            throw new \Exception('Страница не найдена!', 404);
        }

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->setData(compact('product'));
    }

}
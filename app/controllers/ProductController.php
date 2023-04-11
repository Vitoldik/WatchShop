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

        $productId = $product->id;

        // Связанные товары
        $related = R::getAll('
            SELECT * FROM related_product t1
            JOIN product t2 ON t1.related_id = t2.id
            WHERE t1.product_id = ?
        ', [$productId]);

        // Галерея
        $gallery = R::findAll('gallery', 'product_id = ?', [$productId]);

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->setData(compact('product', 'related', 'gallery'));
    }

}
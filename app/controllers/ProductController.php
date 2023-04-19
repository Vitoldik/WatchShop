<?php

namespace app\controllers;

use app\models\BreadCrumbs;
use app\models\Product;
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

        /*
            Хлебные крошки (Breadcrumbs) — это навигационная цепочка, показывающая место страницы
            в иерархии сайта. Она нужна, чтобы пользователь мог быстро перейти на главную, в предыдущий
            раздел или в корневой каталог.
        */
        $breadCrumbs = BreadCrumbs::getBreadCrumbsHtml($product->category_id, $product->title);

        // Связанные товары
        $related = R::getAll('
            SELECT * FROM related_product t1
            JOIN product t2 ON t1.related_id = t2.id
            WHERE t1.product_id = ?
        ', [$productId]);

        // Просмотренные товары
        $productModel = new Product();
        $productModel->setRecentlyViewed($productId); // Записываем в куки просмотренный товар
        $recentlyViewed = $productModel->getRecentlyViewed();

        if ($recentlyViewed) {
            // R::genslots сгенерирует количество вопросительных знаков равное элементам массива
            $recentlyViewed = R::find('product', 'id IN (' . R::genslots($recentlyViewed) . ')', $recentlyViewed);
        }

        // Галерея
        $gallery = R::findAll('gallery', 'product_id = ?', [$productId]);

        // Модификации
        $modifications = R::findAll('modification', 'product_id = ?', [$product->id]);

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->setData(compact('product', 'related', 'gallery', 'recentlyViewed', 'breadCrumbs', 'modifications'));
    }

}
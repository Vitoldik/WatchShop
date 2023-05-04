<?php

namespace app\controllers;

use app\models\Category;
use R;

class CategoryController extends AppController {

    public function viewAction() {
        $alias = $this->route['alias'];
        $category = R::findOne('category', 'alias = ?', [$alias]);

        if (!$category)
            throw new \Exception('Страница не найдена', 404);

        // Хлебные крошки
        $breadcrumbs = '';

        $categoryModel = new Category();
        $categoryId = $category->id;
        $ids = $categoryModel->getIds($categoryId);
        $ids = $ids ? $ids . $categoryId : $categoryId;

        $products = R::find('product', "category_id IN ($ids)");
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->setData(compact('products', 'breadcrumbs'));
    }

}
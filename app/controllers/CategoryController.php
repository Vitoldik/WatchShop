<?php

namespace app\controllers;

use app\models\BreadCrumbs;
use app\models\Category;
use R;
use watchShop\App;
use watchShop\libs\Pagination;

class CategoryController extends AppController {

    public function viewAction() {
        $alias = $this->route['alias'];
        $category = R::findOne('category', 'alias = ?', [$alias]);

        if (!$category)
            throw new \Exception('Страница не найдена', 404);

        $categoryId = $category->id;
        $categoryModel = new Category();
        $ids = $categoryModel->getIds($categoryId);
        $ids = $ids ? $ids . $categoryId : $categoryId;

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = App::$app->getProperty('pagination');
        $totalPages = R::count('product', "category_id IN ($ids)");
        $pagination = new Pagination($page, $perPage, $totalPages);
        $startPage = $pagination->getStart();

        // Хлебные крошки
        $breadcrumbs = BreadCrumbs::getBreadCrumbsHtml($categoryId);

        $products = R::find('product', "category_id IN ($ids) LIMIT $startPage, $perPage");
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->setData(compact('products', 'breadcrumbs', 'pagination', 'totalPages'));
    }

}
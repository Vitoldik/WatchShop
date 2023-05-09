<?php

namespace app\controllers;

use app\models\BreadCrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
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
        $queryPart = '';
        $filter = Filter::getFilters();

        if (isset($filter))
            $queryPart = "AND id IN (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter))";

        $totalPages = R::count('product', "category_id IN ($ids) $queryPart");
        $pagination = new Pagination($page, $perPage, $totalPages);
        $startPage = $pagination->getStart();

        // Хлебные крошки
        $breadcrumbs = BreadCrumbs::getBreadCrumbsHtml($categoryId);

        $products = R::find('product', "category_id IN ($ids) $queryPart LIMIT $startPage, $perPage");

        if ($this->isAjax())
            $this->loadView('filter', compact('products', 'totalPages', 'pagination'));

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->setData(compact('products', 'breadcrumbs', 'pagination', 'totalPages'));
    }

}
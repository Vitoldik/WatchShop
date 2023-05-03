<?php

namespace app\controllers;

class SearchController extends AppController {

    public function typeaheadAction() {
        if ($this->isAjax() && !empty(trim($_GET['query']))) {
            $query = trim($_GET['query']);
            $products = \R::getAll('SELECT id, title FROM product WHERE title LIKE ? LIMIT 11', ["%$query%"]);
            echo json_encode($products);
        }

        die;
    }
}
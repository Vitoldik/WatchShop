<?php

namespace app\controllers;

use R;

class SearchController extends AppController {

    public function indexAction(){
        $query = $this->validateAndGet('s');
        $products = $query ? R::find('product', "title LIKE ?", ["%$query%"]) : null;
        $cleanedQuery = escapeSpecialChars($query);

        $this->setMeta("Search result: " . $cleanedQuery);
        $this->setData(compact('products', 'cleanedQuery'));
    }

    public function typeaheadAction() {
        if ($this->isAjax()) {
            $query = $this->validateAndGet('query');

            if ($query) {
                $products = R::getAll('SELECT id, title FROM product WHERE title LIKE ? LIMIT 11', ["%$query%"]);
                echo json_encode($products);
            }
        }

        die;
    }

    private function validateAndGet($key): string|null {
        return isset($_GET[$key]) && trim($_GET[$key]) !== ''
            ? $_GET[$key]
            : null;
    }
}
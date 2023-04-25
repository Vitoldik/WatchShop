<?php

namespace app\controllers;

use R;

class CartController extends AppController {

    public function addAction() {
        @['id' => $id, 'quantity' => $quantity, 'modification' => $modification_id] = $_GET;

        if (!isset($id))
            return false;

        $product = R::findOne('product', 'id = ?', [$id]);

        if (!$product)
            return false;

        $modification = isset($modification_id)
            ?  R::findOne('modification', 'id = ? AND product_id = ?', [$modification_id, $id])
            : null;

        debug($modification);
        die;
    }
}
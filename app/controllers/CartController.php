<?php

namespace app\controllers;

use app\models\Cart;
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

        $cartModel = new Cart();
        $cartModel->addToCart($product, $quantity, $modification);

        $this->sendCartResponse();
    }

    public function showAction() {
        $this->loadView('cart_modal');
    }

    public function deleteAction() {
        $id = $_GET['id'] ?? null;

        if (!$id)
            return false;

        if (isset($_SESSION['cart'][$id])) {
            $cart = new Cart();
            $cart->deleteItem($id);
        }

        $this->sendCartResponse();
    }

    public function clearAction() {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.quantity']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);
        $this->sendCartResponse();
    }

    private function sendCartResponse() {
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
            return;
        }

        redirect();
    }
}
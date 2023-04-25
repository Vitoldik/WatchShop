<?php

namespace app\models;

use watchShop\App;

class Cart extends AppModel {

    public function addToCart($product, $quantity = 1, $modification = null) {
        if (!isset($_SESSION['cart.currency']))
            $_SESSION['cart.currency'] = App::$app->getProperty('currency');

        $hasModification = $modification != null;

        $id = $product->id . ($hasModification ? "-$modification->id" : '');
        $title = $product->title . ($hasModification ? " ($modification->title)" : '');
        $price = $hasModification ? $modification->price : $product->price;

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'quantity' => $quantity,
                'title' => $title,
                'alias' => $product->alias,
                'price' => $price * $_SESSION['cart.currency']['value'],
                'img' => $product->img
            ];
        }

        $_SESSION['cart.quantity'] = isset($_SESSION['cart.quantity']) ? $_SESSION['cart.quantity'] + $quantity : $quantity;
        $_SESSION['cart.sum'] = ($_SESSION['cart.sum'] ?? 0) + $quantity * $price * $_SESSION['cart.currency']['value'];
    }

}
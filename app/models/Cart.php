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

    public function deleteItem($id) {
        $item = $_SESSION['cart'][$id];
        $_SESSION['cart.quantity'] -= $item['quantity'];
        $_SESSION['cart.sum'] -= $item['quantity'] * $item['price'];
        unset($_SESSION['cart'][$id]);
    }

    public static function recalculate($currency) {
        if (!isset($_SESSION['cart.currency']))
            return;

        $isBase = $_SESSION['cart.currency']['base'];

        if ($isBase) {
            $_SESSION['cart.sum'] *= $currency->value;
        } else {
            $_SESSION['cart.sum'] = $_SESSION['cart.sum'] / $_SESSION['cart.currency']['value'] * $currency->value;
        }

        foreach ($_SESSION['cart'] as $k => $v) {
            if ($isBase) {
                $_SESSION['cart'][$k]['price'] *= $currency->value;
                continue;
            }

            $_SESSION['cart'][$k]['price'] = $_SESSION['cart'][$k]['price'] / $_SESSION['cart.currency']['value'] * $currency->value;
        }

        foreach ($currency as $k => $v) {
            $_SESSION['cart.currency'][$k] = $v;
        }
    }
}
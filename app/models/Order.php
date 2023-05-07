<?php

namespace app\models;

use R;

class Order extends AppModel {

    public static function saveOrder($data) {
        $order = R::dispense('order');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $orderId = R::store($order);

        self::saveOrderProduct($orderId);
        return $orderId;
    }

    public static function saveOrderProduct($orderId) {

    }

    public static function mailOrder($orderId, $userEmail) {

    }
}
<?php

namespace app\models;

use R;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use watchShop\App;

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
        $queryPart = '';

        foreach ($_SESSION['cart'] as $productId => $product) {
            $productId = (int) $productId;
            $queryPart .= "($orderId, $productId, {$product['quantity']}, '{$product['title']}', {$product['price']}),";
        }

        $queryPart = rtrim($queryPart, ',');
        R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $queryPart");
    }

    public static function mailOrder($orderId, $userEmail) {
        $params = App::$app->getProperty('mailer');

        $transport = Transport::fromDsn($params['dsn']);
        $mailer = new Mailer($transport);

        // Create a message
        ob_start();
        require VIEWS_DIR . '/mail/mail_order.php';
        $mailHTML = ob_get_clean();

        $shopName = App::$app->getProperty('shop_name');

        $clientEmail = (new Email())
            ->from($params['from'])
            ->to($userEmail)
            ->subject( "$shopName | You made an order №$orderId")
            ->html($mailHTML);

        $adminEmail = (new Email())
            ->from($params['from'])
            ->to(App::$app->getProperty('admin_email'))
            ->subject("$shopName | Order №$orderId has been placed on your site")
            ->html($mailHTML);

        try {
            $mailer->send($clientEmail);
            $mailer->send($adminEmail);
        } catch (TransportException|TransportExceptionInterface) {
            $_SESSION['error'] = 'Error sending email, contact administrator!';
        }

        Cart::clearCart();
        $_SESSION['success'] = 'Order successfully completed! Manager will contact you soon...';
    }
}
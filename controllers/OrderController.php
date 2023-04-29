<?php

class OrderController
{

    static $db_con = null;

    public static function init()
    {
        self::$db_con = DBCONNECT::connect();
    }

    public static function getAllOrders()
    {
        $sql = self::$db_con->query("SELECT * FROM orders");
    }

    public static function getOrdersById($id)
    {
        $sql = self::$db_con->query("SELECT * FROM orders WHERE user_id = '" . $id . "'");
    }

    public static function makeOrder()
    {
        $quantity = mysqli_real_escape_string(self::$db_con, $_POST['quantity']);
        $orderNo = time();
        $amount = '';

        $sql = self::$db_con->query("INSERT INTO orders (order_no, product_id, user_id, quantity, price_to_pay) VALUES ('$orderNo', 1, '" . $_SESSION['id'] . "', '$quantity', '$amount')");
    }
}

OrderController::init();

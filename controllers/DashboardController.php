<?php

class DashboardController
{

    static $db_con = null;

    public static function init()
    {
        self::$db_con = DBCONNECT::connect();
    }

    public static function totalUsers()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM users WHERE id != 1");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }

    public static function totalCustomers()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM users WHERE role_id = 4");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }

    public static function totalTransporters()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM users WHERE role_id = 3");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }

    public static function totalOrders()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM orders");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }

    public static function totalProduct()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM products");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }

    public static function totalPayments()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM payments");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }

    public static function totalOrderById($id)
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM orders WHERE user_id = $id");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }

    public static function totalPaymentsById($id)
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM payments WHERE order_id = '" . $id . "'");
        $total  = mysqli_fetch_assoc($sql)['total'];
        echo $total;
    }
}

DashboardController::init();

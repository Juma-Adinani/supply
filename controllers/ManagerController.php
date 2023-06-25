<?php

class ManagerController
{
    static $db_con = null;

    public static function init()
    {
        self::$db_con = DBCONNECT::connect();
    }

    public static function totalProducts()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM products");
        return mysqli_fetch_assoc($sql)['total'];
    }

    public static function totalOrders($status)
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM orders WHERE status = '$status'");
        return mysqli_fetch_assoc($sql)['total'];
    }
}

ManagerController::init();

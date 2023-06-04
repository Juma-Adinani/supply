<?php

class CustomerController
{
    static $db_con = null;

    public static function init()
    {
        self::$db_con = DBCONNECT::connect();
    }

    public static function totalOrders()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM orders WHERE user_id = '" . $_SESSION['id'] . "'");
        return mysqli_fetch_assoc($sql)['total'];
    }
}

CustomerController::init();

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

    public static function getMyOrders()
    {
        $id = $_SESSION['id'];

        $sql = self::$db_con->query("SELECT * FROM orders");

        if (mysqli_num_rows($sql) == 0) {
            echo '
                    <tr>
                        <td colspan="9">Currently!, there is no available orders you made</td>
                    </tr>
                ';
        } else {
            $count = 0;
            while ($row = mysqli_fetch_object($sql)) {
                $count++;
                echo '
                        <tr>
                            <td>' . $count . '</td>
                            <td>' . $row->quantity . '</td>
                            <td>' . $row->order_date . '</td>
                            <td>' . number_format($row->total_price) . '</td>
                            <td>' . $row->status . '</td>
                        </tr>
                    ';
            }
        }
    }
}

CustomerController::init();

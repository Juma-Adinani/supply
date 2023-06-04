<?php

class ProductController
{
    static $db_con = null;

    public static function init()
    {
        self::$db_con = DBCONNECT::connect();
    }

    public static function getAllProducts()
    {
        $sql = self::$db_con->query("SELECT * FROM products");
        if (mysqli_num_rows($sql) == 0) {
            echo '<tr>
                    <td colspan="6" class="bg-warning">Currently, no available product registered</td>
                </tr>';
        } else {
            $count = 0;
            while ($row = mysqli_fetch_assoc($sql)) {
                $count++;
                echo '<tr>
                    <td>' . $count . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['description'] . '</td>
                    <td> Tsh ' . number_format($row['price'], 0) . '</td>
                    <td>
                        <a class="badge bg-primary">edit</a>&nbsp;
                        <a class="badge bg-danger">delete</a>
                    </td>
                </tr>';
            }
        }
    }

    public static function registerProduct()
    {
        $name = mysqli_real_escape_string(self::$db_con, $_POST['name']);
        $description = mysqli_real_escape_string(self::$db_con, $_POST['description']);
        $price = mysqli_real_escape_string(self::$db_con, $_POST['price']);

        self::$db_con->query("INSERT INTO products (name, description, price) VALUES ('$name', '$description', '$price')");

        if (!mysqli_error(self::$db_con)) {
            Helper::alert_message('success', 'product registered successfully!');
            Util::redirectTo('');
        } else {
            Helper::alert_message("danger", 'Failed to register product' . mysqli_error(self::$db_con));
        }
    }
}

ProductController::init();

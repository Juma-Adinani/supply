<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center mt-5">
            <div class="card col-5 mt-5 shadow-sm">
                <?php
                include './config/database_connection.php';
                $con = DBCONNECT::connect();

                if (isset($_POST['pay'])) {

                    $controlNumber = mysqli_real_escape_string($con, $_POST['control_number']);
                    $amount = mysqli_real_escape_string($con, $_POST['amount']);

                    $sql = $con->query("SELECT control_no, total_price, order_id
                                                FROM payments, orders
                                                WHERE payments.order_id = orders.id
                                                AND control_no = '$controlNumber'");
                    if (mysqli_num_rows($sql) == 0) {
                        echo '<div class="alert alert-danger">Control number is not correct!</div>';
                    } else {
                        $row = mysqli_fetch_assoc($sql);
                        if ($amount < $row['total_price']) {
                            echo '<div class="alert alert-danger">Not have sufficient funds!</div>';
                        } else {
                            $con->query("UPDATE payments SET amount = '$amount' WHERE control_no = '$controlNumber'");
                            $orderId = $row['order_id'];
                            $con->query("UPDATE orders SET status = 'PAID' WHERE id = '$orderId'");
                            echo '<div class="alert alert-success mt-3">Payments Made succesffully!</div>';
                        }
                    }
                }

                ?>
                <form action="" method="POST" class="p-5">
                    <div class="mb-3">
                        <label for="control_number" class="form-label">Control Number</label>
                        <input type="text" name="control_number" id="control_number" class="form-control" placeholder="Control No" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" required>
                    </div>
                    <button type="submit" name="pay" class="btn btn-primary">Make Payment</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
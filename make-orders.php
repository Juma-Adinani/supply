<?php
include './layouts/DashLayoutAbove.php';

if (!Authentication::isLoggedIn() || !Authentication::isCustomer()) {
    Util::redirectTo('login.php');
}
$con = mysqli_connect("localhost", "root", "", "supply_chain_db");
$products = [];
$sql = $con->query("SELECT * FROM products");
if (mysqli_num_rows($sql) != 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        $products[] = $row;
    }
}

$vehicles = [];
$sql = DBCONNECT::connect()->query("SELECT company_name, vehicles.id as id, plate_number FROM vehicles, transport_companies 
                                    WHERE vehicles.transport_company_id = transport_companies.id
                                    ");
while ($row = mysqli_fetch_assoc($sql)) {
    $vehicles[] = $row;
}


?>
<div class="container">
    <div class="card">
        <?php
        if (isset($_POST['order'])) {
            $control_number = rand(111111111, 999999999);
            $product = 1;
            $transportId = $_POST['vehicle'];
            $userId = $_SESSION['id'];
            $quantity = mysqli_real_escape_string($con, $_POST['quantity'][0]);
            $price = mysqli_real_escape_string($con, $_POST['price'][0]);

            $con->query("INSERT INTO orders (product_id, user_id, quantity, total_price) VALUES ('$product', '$userId', '$quantity', '$price')");

            $order_id = mysqli_insert_id($con);

            if (!mysqli_error($con)) {

                $con->query("INSERT INTO payments (control_no, order_id) VALUES ('$control_number', '$order_id')");

                $con->query("INSERT INTO transport_bookings(vehicle_id, order_id) VALUES ('$transportId', '" . $_SESSION['id'] . "')");

                Helper::alert_message('success', 'Order booked successfully, make payment now, with the controll number: ' . $control_number);
            }
        }
        ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <form action="" method="post">
                        <?php foreach ($products as $product) { ?>

                            <div class="col-12 mb-2">
                                <input type="text" class="form-control" name="product[]" value="<?= $product['name'] ?>" readonly>
                            </div>

                            <div class="col-12 mb-2">
                                <input type="number" class="form-control quantity-input" name="quantity[]" placeholder="Quantity" data-price="<?= $product['price'] ?>">
                            </div>

                            <div class="col-12 mb-2">
                                <input type="text" name="price[]" class="form-control price-input" value="<?= number_format($product['price'], 0) ?>" readonly>
                            </div>

                            <div class="col-12 mb-2">
                                <select name="vehicle" id="" class="form-select form-control">
                                    <option value="">select transport...</option>
                                    <?php
                                    foreach ($vehicles as $vehicle) {
                                        echo '<option value="' . $vehicle['id'] . '">' . $vehicle['company_name'] . ' - ' . $vehicle['plate_number'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" name="order" class="btn btn-sm btn-primary">Order</button>

                        <?php } ?>
                    </form>

                    <script>
                        // Get all quantity inputs and attach event listeners
                        var quantityInputs = document.querySelectorAll('.quantity-input');
                        quantityInputs.forEach(function(input) {
                            input.addEventListener('input', calculatePrice);
                        });

                        function calculatePrice() {
                            var quantityInput = this;
                            var priceInput = quantityInput.parentNode.parentNode.querySelector('.price-input');
                            var price = parseFloat(quantityInput.dataset.price);
                            var quantity = parseFloat(quantityInput.value);
                            var totalPrice = price * quantity;

                            if (!isNaN(totalPrice)) {
                                priceInput.value = totalPrice.toFixed(0);
                            } else {
                                priceInput.value = '';
                            }
                        }
                    </script>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include './layouts/DashLayoutBelow.php';

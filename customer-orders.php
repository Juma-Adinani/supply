<?php
include './layouts/DashLayoutAbove.php';

if (!Authentication::isLoggedIn() || !Authentication::isCustomer()) {
    Util::redirectTo('login.php');
}
?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">My Orders List</h5>
            <a href="make-orders.php" class="btn btn-primary">
                make order
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Quantity ordered</th>
                        <th>Total price</th>
                        <th>Ordered date</th>
                        <th>Transport</th>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            CustomerController::getMyOrders();
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include './layouts/DashLayoutBelow.php';

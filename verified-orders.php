<?php
include './layouts/DashLayoutAbove.php';

if (!Authentication::isLoggedIn() || !Authentication::isManager()) {
    Util::redirectTo('login.php');
}
?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Paid Orders' Lists</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Quantity ordered</th>
                        <th>Total price</th>
                        <th>Order date</th>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            ProductController::getOrders('PAID');
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

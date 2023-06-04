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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                make order
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                Helper::alert_message('success', 'ON PROGRES ...');
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include './layouts/DashLayoutBelow.php';

<?php
include './layouts/DashLayoutAbove.php';

if (!Authentication::isLoggedIn()) {
    Util::redirectTo('login.php');
}
?>
<div class="col-lg-12">
    <div class="single_element">
        <div class="quick_activity">
            <div class="row">
                <div class="col-12">
                    <?= $_SESSION['role'] ;?>
                    <div class="quick_activity_wrap quick_activity_wrap">
                        <?php
                        if (Authentication::isAdmin()) {
                            include './components/AdminDashboard.php';
                        }

                        if (Authentication::isCustomer()) {
                            include './components/CustomerDashboard.php';
                        }

                        if (Authentication::isManager()) {
                            include './components/ManagerDashboard.php';
                        }

                        if (Authentication::isTransporter()) {
                            include './components/TransporterDashboard.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include './layouts/DashLayoutBelow.php';

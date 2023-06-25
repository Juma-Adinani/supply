<?php
require_once './layouts/DashLayoutAbove.php';

if (Authentication::isLoggedIn() == false) {
    Util::redirectTo('login.php');
}
?>
<div class="col-lg-12">
    <div class="single_element">
        <div class="quick_activity">
            <div class="row">
                <div class="col-12">
                    <div class="quick_activity_wrap quick_activity_wrap">
                        <?php

                        require_once './components/AdminDashboard.php';

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include './layouts/DashLayoutBelow.php';

<?php
include './layouts/DashLayoutAbove.php';

if (!Authentication::isLoggedIn() || !Authentication::isTransporter()) {
    Util::redirectTo('login.php');
}
?>
<div class="container">
    <?php
    if (isset($_POST['save'])) {
        TransporterController::registerVehicle();
    }
    ?>
</div>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Vehicles List</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add vehicle
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Plate number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        TransporterController::getAllVehiclesById();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- A MODAL TO REGISTER Transporter-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register Transport Companies</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="plate" class="form-label">Vehicle plate number</label>
                            <input type="text" class="form-control" name="plate" id="plate" required placeholder="enter plate number">
                            <div class="invalid-feedback">
                                Please provide a valid vehicle name.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="save" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END A MODAL TO REGISTER TRANSPORTER -->

<?php
include './layouts/DashLayoutBelow.php';

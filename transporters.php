<?php
include './layouts/DashLayoutAbove.php';

if (!Authentication::isLoggedIn() || !Authentication::isAdmin()) {
    Util::redirectTo('login.php');
}
?>
<div class="container">
    <?php
    if (isset($_POST['save'])) {
        TransporterController::registerTransporter();
    }
    ?>
</div>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Transporters List</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add transporter
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Owner</th>
                            <th>Phone number</th>
                            <th>Email</th>
                            <th>Company name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        TransporterController::getAllTransporters();
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
                <h5 class="modal-title" id="exampleModalLabel">Register transporter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <?php
                if (mysqli_num_rows(DBCONNECT::connect()->query("SELECT * FROM transport_companies")) == 0) {
                    echo '<div class="m-3 alert alert-secondary">
                            You must add companies first, <a href="./companies.php">click here</a> to add transport companies
                        </div>';
                } else {
                ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" class="form-control" name="firstname" id="firstName" required placeholder="enter first name">
                                <div class="invalid-feedback">
                                    Please provide a valid first name.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle name</label>
                                <input type="text" class="form-control" name="middlename" id="middleName" placeholder="enter middlename">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" class="form-control" name="lastname" id="lastName" placeholder="enter lastname" required>
                                <div class="invalid-feedback">
                                    Please provide a valid last name.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email Adress</label>
                                <input type="email" class="form-control" name="email" placeholder="enter email address" id="email" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" placeholder="enter phone number" id="phone" required>
                                <div class="invalid-feedback">
                                    Please provide a valid phone number.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company" class="form-label">Company</label>
                                <select name="company" id="company" class="form-control form-select">
                                    <option value="">select company</option>
                                    <?php
                                    TransporterController::getCompanyOptions();
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select company.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary">Save changes</button>
                    </div>
                <?php
                }
                ?>
            </form>
        </div>
    </div>
</div>
<!--END A MODAL TO REGISTER TRANSPORTER -->

<?php
include './layouts/DashLayoutBelow.php';

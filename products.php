<?php
include './layouts/DashLayoutAbove.php';

if (!Authentication::isLoggedIn() || !Authentication::isManager()) {
    Util::redirectTo('login.php');
}
?>
<div class="container">
    <?php
    if (isset($_POST['save'])) {
        ProductController::registerProduct();
    }
    ?>
</div>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Product List</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add product
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product name</th>
                            <th>Product description</th>
                            <th>Product Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        ProductController::getAllProducts();
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
                <h5 class="modal-title" id="exampleModalLabel">Register product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">product name</label>
                            <input type="text" class="form-control" name="name" id="name" required placeholder="enter product name">
                            <div class="invalid-feedback">
                                Please provide a valid product name.
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Product description</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="price" class="form-label">Product price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="enter price" step="0.2" required>
                            <div class="invalid-feedback">
                                Please provide a valid last name.
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

<?php
include './layouts/AuthLayoutAbove.php';

if (isset($_POST['register'])) {
    Authentication::register();
}

?>
<div class="modal-header bg-white mb-3">
    <h5 style="color: teal;">Create Account</h5>
</div>
<form method="post" action="">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <input type="text" class="form-control <?php echo isset($_SESSION['error']['firstname']) ? 'is-invalid border border-danger' : '' ?>" placeholder="Firstname*" name="firstname" value="<?= $_SESSION['old_input']['firstname'] ?? '' ?>">
                <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['firstname'])) {
                    Helper::input_validation($_SESSION['message']['firstname']);
                } ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <input type="text" class="form-control <?php echo isset($_SESSION['error']['lastname']) ? 'is-invalid border border-danger' : '' ?>" placeholder=" lastname*" name="lastname" value="<?= $_SESSION['old_input']['lastname'] ?? '' ?>">
                <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['lastname'])) {
                    Helper::input_validation($_SESSION['message']['lastname']);
                } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <input type="email" class="form-control <?php echo isset($_SESSION['error']['email']) ? 'is-invalid border border-danger' : '' ?>" placeholder=" Email" name="email" value="<?= $_SESSION['old_input']['email'] ?? '' ?>">
                <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['email'])) {
                    Helper::input_validation($_SESSION['message']['email']);
                } ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <input type="tel" class="form-control <?php echo isset($_SESSION['error']['phone']) ? 'is-invalid border border-danger' : '' ?>" placeholder="Phone number*" name="phone" value="<?= $_SESSION['old_input']['phone'] ?? '' ?>">
                <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['phone'])) {
                    Helper::input_validation($_SESSION['message']['phone']);
                } ?>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <input type="password" class="form-control <?php echo isset($_SESSION['error']['password']) ? 'is-invalid border border-danger' : '' ?>" placeholder=" Password*" name="password">
        <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['password'])) {
            Helper::input_validation($_SESSION['message']['password']);
        } ?>
    </div>
    <div class="mb-3">
        <input type="password" class="form-control <?php echo isset($_SESSION['error']['confirm']) ? 'is-invalid border border-danger' : '' ?>" placeholder=" Confirm password" name="confirm">
        <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['confirm'])) {
            Helper::input_validation($_SESSION['message']['confirm']);
        } ?>
    </div>
    <button type="submit" class="btn_1 full_width text-center mb-4" name="register">Sign
        Up
    </button>
    <div class="text-end">Already have an account?
        <a href="./login.php">Log in
        </a>
    </div>
</form>
<?php
include './layouts/AuthLayoutBelow.php';
?>
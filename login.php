<?php
include './layouts/AuthLayoutAbove.php';
if (isset($_POST['login'])) {
    Authentication::login();
}
?>
<div class="modal-header bg-white mb-3">
    <h5 style="color: teal;">Sign In</h5>
</div>
<form method="POST">
    <div>
        <input type="tel" class="form-control <?php echo isset($_SESSION['error']['phone']) ? 'is-invalid border border-danger' : '' ?>" placeholder="Phone number*" name="phone" value="<?= $_SESSION['old_input']['phone'] ?? '' ?>">
        <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['phone'])) {
            Helper::input_validation($_SESSION['message']['phone']);
        } ?>
    </div>
    <div>
        <input type="password" class="form-control <?php echo isset($_SESSION['error']['password']) ? 'is-invalid border border-danger' : '' ?>" placeholder=" Password*" name="password">
        <?php if (isset($_SESSION['error']) && isset($_SESSION['message']['password'])) {
            Helper::input_validation($_SESSION['message']['password']);
        } ?>
    </div>
    <a href="#" class="small">Forget Password?
    </a>
    <button type="submit" class="btn_1 full_width text-center mb-4" name="login">Log
        in
    </button>
    <div class="text-end">
        Don't have an account?
        <a href="./register.php">create
        </a>
    </div>
</form>
<?php
include './layouts/AuthLayoutBelow.php';
?>
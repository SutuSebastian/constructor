<?php
$selector = $_GET['selector'];
$validator = $_GET['validator'];

if (empty($selector) || empty($validator)) {
    redirect('login');
}
if (!ctype_xdigit($selector) || !ctype_xdigit($validator)) {
    redirect('login');
}

?>

<div class="d-flex flex-column align-items-center justify-content-center h-100">
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                <h2 class="mb-3 font-weight-normal text-center">Reset Your Password</h2>
                <hr>
                <h6 class="text-muted text-center my-4">Enter your new password</h6>
                <input type="hidden" name="user_selector" value="<?php echo $selector ?>">
                <input type="hidden" name="user_validator" value="<?php echo $validator ?>">
                <input type="password" name="user_password" class="form-control text-center" placeholder="New password" required>
                <input type="password" name="user_password_repeat" class="form-control text-center" placeholder="Repeat new password" required>
                <button class="btn btn-dark btn-block my-3" type="submit" name="password_reset_submit"><i class="fas fa-sign-in-alt"></i> Reset Password</button>
            </form>
            <a href="" class="text-muted">
                <i class="fas fa-unlock"></i>
                Login
            </a>
        </div>
    </div>
    <a href="../" style="font-size: 14px" class="pt-3  text-muted"><i class="far fa-arrow-alt-circle-left"></i> <?php echo WEBSITE_TITLE; ?></a>
</div>

<?php if (LOGGED_IN) {
    require '404.php';
    return;
} ?>
<div class="d-flex flex-column align-items-center justify-content-center h-100">
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                <h1 class="mb-4 text-center font-weight-normal">cPanel</h1>
                <input type="text" name="username" class="form-control text-center" placeholder="Email or Username" autofocus required>
                <input type="password" name="password" class="form-control text-center" placeholder="Password" required>
                <button class="btn btn-dark btn-block my-3" type="submit" name="login_submit"><i class="fas fa-sign-in-alt"></i> Log in</button>
            </form>
            <a href="password-recovery" class="text-muted">Forgot your password?</a>
        </div>
    </div>
    <a href="../" style="font-size: 14px" class="pt-3 text-muted"><i class="far fa-arrow-alt-circle-left"></i> <?php echo WEBSITE_TITLE  ; ?></a>
</div>

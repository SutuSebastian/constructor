<div class="d-flex flex-column align-items-center justify-content-center h-100">
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                <h2 class="mb-3 font-weight-normal text-center">Password Recovery</h2>
                <hr>
                <h6 class="text-muted text-center my-4">Please enter your Email</h6>
                <input type="email" name="user_email" class="form-control text-center" placeholder="Email address" required>
                <button class="btn btn-dark btn-block my-3" type="submit" name="password_reset_request"><i class="fas fa-sign-in-alt"></i> Reset Password</button>
            </form>
            <a href="" class="text-muted">
                <i class="fas fa-unlock"></i>
                Login
            </a>
        </div>
    </div>
    <a href="../" style="font-size: 14px" class="pt-3 text-muted"><i class="far fa-arrow-alt-circle-left"></i> <?php echo WEBSITE_TITLE; ?></a>
</div>

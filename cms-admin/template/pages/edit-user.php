<?php

if (!is_admin()) {
    require 'template/pages/404.php';
    die;
}

if (empty($_GET['id'])) {
    echo "
    <div class='m-5 text-muted text-center'>
        <h1>Empty user ID</h1>
        <a href='user-settings'>Go back</a>
    </div>
    ";
    die;
}

$user_ID = $_GET['id'];

$user_result = $conn->query("SELECT * FROM users WHERE id = $user_ID");
$user = $user_result->fetch_object();

if (empty($user->id)) {
    echo "
    <div class='m-5 text-muted text-center'>
        <h1>Wrong user ID</h1>
        <a href='user-settings'>Go back</a>
    </div>
    ";
    die;
}

?>

<h5 class="mb-4 text-secondary">
    <a class="text-dark" href="user-settings">User Settings</a> > Edit > <?php echo $user->fullname ?> (<?php echo $user->username ?>)
</h5>

<div class="card">
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input class="form-control" name="user_fullname" value="<?php echo $user->fullname ?>">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="user_username" value="<?php echo $user->username ?>" readonly>
            </div>
            <div class="form-group">
                <label>E-Mail</label>
                <input type="email" class="form-control" name="user_email" value="<?php echo $user->email ?>">
            </div>
            <div class="form-group">
                <label>Account Type</label>
                <select class="form-control" name="user_type">
                    <option value="1" <?php if ($user->type == 1) { echo 'selected'; } ?> >user</option>
                    <option value="2" <?php if ($user->type == 2) { echo 'selected'; } ?> >admin</option>
                </select>
            </div>
            <input type="hidden" name="user_ID" value="<?php echo $_GET['id'] ?>">
            <button type="submit" class="btn btn-dark btn-sm" name="admin_panel_user_edit">Submit</button>
        </form>
    </div>
</div>

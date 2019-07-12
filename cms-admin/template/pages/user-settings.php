<?php
$users_query = $conn->query("SELECT * FROM users ORDER BY fullname");
$users_count = 1;

(USER_TYPE > 1) ? $user_type = 'admin' : $user_type = 'user';
?>

<h5 class="mb-4 text-secondary">
    User Settings
</h5>

<!-- ################## ADMIN MODALS  ################## -->

<?php if (is_admin()) { ?>

<button data-toggle="modal" data-target="#add_user_modal" class="btn btn-dark btn-sm" type="button" name="add_page_submit">
    <i class="fas fa-plus"></i>
    Add User
</button>

<!-- Add User Modal -->
<div class="modal fade" tabindex="-1" id="add_user_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" autocomplete="false" oninput='new_user_password_repeat.setCustomValidity(new_user_password_repeat.value != new_user_password.value ? "Passwords do not match." : "")'>
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" type="text" name="new_user_fullname" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" name="new_user_username" required>
                    </div>
                    <div class="form-group">
                        <label>E-Mail (Optional)</label>
                        <input class="form-control" type="email" name="new_user_email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="new_user_password" required>
                    </div>
                    <div class="form-group">
                        <label>Password (Repeat)</label>
                        <input class="form-control" type="password" name="new_user_password_repeat" required>
                    </div>
                    <div class="form-group">
                        <label>Administrator</label> <br>
                        <label class="switch">
                            <input name="new_user_type" type="checkbox" value="2">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer ">
                    <button type="button" class="btn  btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn  btn-dark" type="submit" name="add_user_submit">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-dark text-light text-center p-1">
        <h6 class="m-0">USERS LIST</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Account Type</th>
                    <th style="width: 14em">Last Activity</th>
                    <th style="width: 10px"></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($users_query->num_rows > 0) {
                while ($users_result = $users_query->fetch_object()) {
                $users_result->type > 1 ? $users_result->type = 'admin' : $users_result->type = 'user';
            ?>
                <tr>
                    <td><?php echo $users_count++ ?></td>
                    <td><?php echo $users_result->fullname; ?></td>
                    <td><?php echo $users_result->username; ?></td>
                    <td><?php echo $users_result->email; ?></td>
                    <td><?php echo $users_result->type; ?></td>
                    <td><?php echo $users_result->last_activity; ?></td>
                    <td class="text-center">
                        <?php (is_admin() && USER_ID == $users_result->id) ? $d_none = "d-none" : $d_none = null; ?>
                        <div class="dropdown <?php echo $d_none ?>">
                            <button type="button" id="edit_user_list" class="btn btn-default p-0 dropdown-toggle" data-toggle="dropdown" >
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="edit-user?id=<?php echo $users_result->id ?>">Edit</a>
                                <form action="" method="POST">
                                    <input type="hidden" name="user_ID" value="<?php echo $users_result->id ?>">
                                    <button onClick="return confirm('Remove user <?php echo $users_result->username ?>?')" type="submit" name="remove_user_submit" class="<?php echo $d_none ?> btn dropdown-item text-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
<!-- ################## END ADMIN MODALS  ################## -->

<!-- ################## USER MODALS  ################## -->
<!-- Change Password Modal -->
<div class="modal fade" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="change_password_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" method="POST" oninput='new_password_repeat.setCustomValidity(new_password_repeat.value != new_password.value ? "Passwords do not match." : "")'>
                <div class="modal-header">
                    <h5 class="modal-title">Change Your Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Old Password</label>
                        <input class="form-control" type="password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input class="form-control" type="password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password (Repeat)</label>
                        <input class="form-control" type="password" name="new_password_repeat" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark" type="submit" name="change_password_submit">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ################## END USER MODALS  ################## -->

<div class="card mt-4">
    <div class="card-header bg-dark text-light text-center p-1">
        <h6 class="m-0">PROFILE</h6>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group col-lg-4">
                    <label>Full Name</label>
                    <input class="form-control" name="user_fullname" placeholder="Your Full Name" value="<?php echo USER_FULLNAME ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label>Username</label>
                    <input class="form-control" name="user_username" placeholder="Account Username" value="<?php echo USER_USERNAME ?>" readonly>
                </div>
                <div class="form-group col-lg-4">
                    <label>E-Mail</label>
                    <input type="email" class="form-control" name="user_email" placeholder="Your E-Mail" value="<?php echo USER_EMAIL ?>">
                </div>
            </div>
            <h5 class="text-muted">Account Type</h5>
            <p><?php echo $user_type ?></p>
            <h5 class="text-muted">Password</h5>
            <p><a href="" data-toggle="modal" data-target="#change_password_modal" class="">Change password</a></p>
            <button type="submit" class="btn btn-dark btn-sm" name="edit_user_info_submit">Submit</button>
        </form>
    </div>
</div>

<?php

// ============ FILES ============
// add file CSS / JS
if (isset($_POST['add_file_submit']) && !empty($_POST)) {
    $file_name    = filter_file_name(sanatize($_POST['file_name']));
    $file_type    = $_POST['file_type'];
    $file_author  = USER_USERNAME;
    $file_status  = !empty($_POST['file_status']) ? $file_status = $_POST['file_status'] : $file_status = 0;
    $file_path    = "../template/assets/$file_type/$file_name.$file_type";

    $sql = "INSERT INTO files (name, type, status, created, modified, author) VALUES (?,?,?,?,'',?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssiss', $file_name, $file_type, $file_status, $current_date_time, $file_author);

    if (empty($file_name)) {
        $_SESSION['error'] = 'Empty file name!';
        return;
    }
    if (file_exists($file_path)) {
        $_SESSION['error'] = 'File already exists!';
        return;
    }

    if ($stmt->execute() && fopen($file_path, 'w')) {
        switch ($file_type) {
            case 'css':
                $_SESSION['success'] = 'CSS file added!';
            break;

            case 'js':
                $_SESSION['success'] = 'JS file added!';
            break;
        }
        $last_inserted_id = $conn->insert_id;
        return;
    } else {
        $_SESSION['error'] = 'Failed to create file!';
    }
    $stmt->close();
}

// edit file
if (isset($_POST['edit_file_submit']) && !empty($_POST)) {
    $file_ID         = $_POST['file_ID'];
    $file_type       = $_POST['file_type'];
    $old_file_name   = $_POST['old_file_name'];
    $file_author     = $_POST['file_author'];
    $file_name       = filter_file_name(sanatize($_POST['file_name']));

    $file_path       = "../template/assets/$file_type/$old_file_name.$file_type";
    $new_file_path   = "../template/assets/$file_type/$file_name.$file_type";

    if (!is_admin()) {
        if (USER_USERNAME !== $file_author) {
            $_SESSION['warning'] = "You're not allowed to do this!";
            reload();
        }
    }

    if (empty($file_name)) {
        $_SESSION['error'] = 'Empty file name!';
        reload();
    }

    if ($old_file_name !== $file_name) {
        if (file_exists($new_file_path)) {
            $_SESSION['error'] = 'File name already exists!';
            reload();
        }
    }

    $sql = "UPDATE files SET name=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $file_name, $file_ID);
    if ($stmt->execute() && rename($file_path, $new_file_path)) {
        $_SESSION['success'] = 'File updated!';
    } else {
        $_SESSION['error'] = 'There was an error!';
    }
    reload();
}

// update file status
if (isset($_POST['update_file_status']) && !empty($_POST)) {
    $file_ID     = $_POST['file_ID'];
    $file_status = $_POST['file_status'];

    switch ($file_status) {
        case '0':
            $status = 'excluded';
        break;
        case '1':
            $status = 'included';
        break;
    }

    $sql  = "UPDATE files SET status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('ii', $file_status, $file_ID);

    if ($stmt->execute()) {
        echo "File <b>".$status."</b>";
    } else {
        echo 'Couldnt update file!';
    }
}

// remove CSS & JS file
if (isset($_POST['remove_file_submit']) && !empty($_POST)) {
    $file_ID     = $_POST['file_ID'];
    $file_name   = $_POST['file_name'];
    $file_type   = $_POST['file_type'];
    $file_author = $_POST['file_author'];
    $file_path   = "../template/assets/$file_type/$file_name.$file_type";

    $sql = "DELETE FROM files WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $file_ID);

    if (!is_admin()) {
        if (USER_USERNAME !== $file_author) {
            $_SESSION['warning'] = "You're not allowed to do this!";
            reload();
        }
    }

    if (!file_exists($file_path)) {
        $_SESSION['error'] = 'File doesnt exist!';
        return;
    }

    if ($stmt->execute() && unlink($file_path)) {
        $_SESSION['success'] = "Removed $file_name.$file_type";
        $stmt->close();
        redirect('css-js-files');
    } else {
        $_SESSION['error'] = 'There was an erorr removing the file!';
    }
}

// editor file update
if (isset($_POST['file_update_submit']) && !empty($_POST)) {
    $file_ID      = $_POST['file_ID'];
    $file_name    = $_POST['file_name'];
    $file_type    = $_POST['file_type'];
    $editor_value = $_POST['editor_value'];
    $file_path    = "../template/assets/$file_type/$file_name.$file_type";

    $sql  = "UPDATE files SET modified=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $current_date_time, $file_ID);
    if($stmt->execute()){
        $_SESSION['success'] = 'updated the db';
    } else {
        $_SESSION['error'] = 'failed to update';
    }
    $stmt->close();

    if (file_put_contents($file_path, $editor_value)) {
        echo "Code updated";
    } else {
        echo "error";
    }
}

// ============ PAGES ============

// add page
if (isset($_POST['add_page_submit']) && !empty($_POST)) {
    $page_name    = filter_page_title(sanatize($_POST['page_name']));
    $published_status    = !empty($_POST['page_published_status']) ? $published_status = $_POST['page_published_status'] : $published_status = 0;
    $page_url     = filter_page_url(sanatize($_POST['page_link']));
    $page_author  = USER_USERNAME;
    $page_path    = "../template/pages/$page_url.php";

    $sql = "INSERT INTO pages (name, link, published, created, last_update, author) VALUES (?,?,?,?,'',?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssiss', $page_name, $page_url, $published_status, $current_date_time, $page_author);

    if (empty($page_name) || empty($page_url)) {
        $_SESSION['error'] = 'Empty page title or URL!';
        reload();
    }

    if (file_exists($page_path)) {
        $_SESSION['error'] = 'Page already exists!';
        reload();
    }

    if ($stmt->execute() && file_put_contents($page_path, " ")) {
        $_SESSION['success'] = 'Page added!';
        $last_inserted_id = $conn->insert_id;
        redirect("edit-page?id=$last_inserted_id");
    } else {
        $_SESSION['error'] = 'There was an erorr adding the page!';
    }
    $stmt->close();
}

// edit page
if (isset($_POST['edit_page_submit']) && !empty($_POST)) {
    $page_ID          = $_POST['page_ID'];
    $old_page_title   = $_POST['old_page_title'];
    $old_page_url     = $_POST['old_page_url'];
    $page_title       = filter_page_title(sanatize($_POST['page_title']));
    $page_url         = filter_page_url(sanatize($_POST['page_url']));
    $page_description = trim(preg_replace('/\s+/', ' ', $_POST['page_description']));
    $page_keywords    = sanatize($_POST['page_keywords']);
    $page_robots      = !empty($_POST['page_robots']) ? $page_robots = 'index, follow' : $page_robots = 'noindex, nofollow';
    $page_author      = $_POST['page_author'];
    $page_path        = "../template/pages/$old_page_url.php";
    $new_page_path    = "../template/pages/$page_url.php";

    if (!is_admin()) {
        if (USER_USERNAME !== $page_author) {
            $_SESSION['warning'] = "You're not allowed to do this!";
            reload();
        }
    }

    if ($old_page_url !== $page_url) {
        if (file_exists($new_page_path)) {
            $_SESSION['error'] = 'That URL is already taken!';
            reload();
        }
    }

    if (empty($page_title) || empty($page_url)) {
        $_SESSION['error'] = 'Empty page title or URL!';
        reload();
    }

    // fetch website settings and info
    $website_result = $conn->query("SELECT * FROM website WHERE id = 1");
    $website = $website_result->fetch_object();

    if ($old_page_url == WEBSITE_DEFAULT_PAGE) {
        $sql = "UPDATE website SET default_page=? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $page_url);
        $stmt->execute();
        $stmt->close();
    }

    $website_result->close();

    $sql = "UPDATE pages SET name=?, link=?, description=?, keywords=?, robots=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $page_title, $page_url, $page_description, $page_keywords, $page_robots, $page_ID);
    if ($stmt->execute() && rename($page_path, $new_page_path)) {
        $_SESSION['success'] = 'Page updated!';
    } else {
        $_SESSION['error'] = 'There was an error!';
    }
    reload();
}

// update page status
if (isset($_POST['page_published']) && !empty($_POST)) {
    $page_ID          = $_POST['page_ID'];
    $published_status = $_POST['page_published'];

    switch ($published_status) {
        case '0':
            $status = 'unpublished';
        break;
        case '1':
            $status = 'published';
        break;
    }

    $sql  = "UPDATE pages SET published=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('ii', $published_status, $page_ID);

    if ($stmt->execute()) {
        echo "Page <b>".$status."</b>";
    } else {
        echo 'Couldnt update page!';
    }
}

// editor page update
if (isset($_POST['editor_update_submit']) && !empty($_POST)) {
    $editor_value = $_POST['editor_value'];
    $page_link    = $_POST['page_link'];
    $page_path    = "../template/pages/$page_link.php";

    $sql  = "UPDATE pages SET last_update=? WHERE link=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $current_date_time, $page_link);
    if($stmt->execute()){
        $_SESSION['success'] = 'updated the db';
    } else {
        $_SESSION['error'] = 'failed to update';
    }
    $stmt->close();

    if (file_put_contents($page_path, $editor_value)) {
        echo "Code updated";
    } else {
        echo "error";
    }
}

// remove page
if (isset($_POST['remove_page_submit']) && !empty($_POST)) {

    $page_ID     = $_POST['page_ID'];
    $link        = $_POST['page_link'];
    $published   = $_POST['published_status'];
    $page_path   = "../template/pages/$link.php";
    $page_author = $_POST['page_author'];

    if (!is_admin()) {
        if (USER_USERNAME !== $page_author) {
            $_SESSION['warning'] = "You're not allowed to do this!";
            reload();
        }
    }

    $sql = "DELETE FROM pages WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $page_ID);

    if (!file_exists($page_path)) {
        $_SESSION['error'] = 'Page file doesnt exist!';
        return;
    }

    if ($stmt->execute() && unlink($page_path)) {
        $_SESSION['success'] = 'Page removed!';
        $stmt->close();
        redirect('pages');
    } else {
        $_SESSION['error'] = 'There was an erorr removing the page!';
    }
}

// ============ MEDIA FILES ============

// upload media files
if (isset($_POST['media_file_upload_submit']) && !empty($_POST)) {
    $files = array_filter($_FILES['media_file']['name']);
    $total = count($files);

    for ( $i=0 ; $i < $total ; $i++ ) {
        $media_file_tmp = $_FILES['media_file']['tmp_name'][$i];
        $media_file_path = "../template/media/" . $_FILES['media_file']['name'][$i];

        if (file_exists($media_file_path)) {
            $_SESSION['error'] = 'File already exists!';
            return;
        }

        if (!empty($media_file_tmp)) {
            if (move_uploaded_file($media_file_tmp, $media_file_path)) {
                $_SESSION['success'] = 'Files uploaded successfully!';
            }
        }
    }
    reload();
}

// remove media files
if (isset($_POST['media_file_delete_submit']) && !empty($_POST)) {
    is_user_allowed();
    $media_file_name = $_POST['media_file_name'];
    $media_file_path = "../template/media/$media_file_name";

    if (unlink($media_file_path)) {
        $_SESSION['success'] = 'File deleted successfully!';
    } else {
        $_SESSION['error'] = 'There was an error!';
    }
    reload();
}

// ============ ADD USER / LOGIN / PASSWORD CHANGE & RECOVERY ============

// add user
if (isset($_POST["add_user_submit"])) {
    $fullname        = sanatize($_POST['new_user_fullname']);
    $username        = sanatize($_POST['new_user_username']);
    $email           = sanatize_email($_POST['new_user_email']);
    $password        = sanatize($_POST['new_user_password']);
    $password_repeat = sanatize($_POST['new_user_password_repeat']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $account_type    = !empty($_POST['new_user_type']) ? $account_type = 2 : 1;
    $last_activity   = null;

    if (empty($fullname) || empty($username) || empty($password) || empty($password_repeat)) {
        $_SESSION["error"] = 'Empty fields!';
    }
    if ($password != $password_repeat) {
        $_SESSION["error"] = 'Passwords dont match!';
    }
    // if exist errors > redirect
    if(!empty($_SESSION['error'])) {
        return;
    }

    // check if username is taken
    $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $stmt->bind_result($is_username);
        $stmt->fetch();
        $stmt->close();

        if (!empty($is_username)) {
            $_SESSION["error"] = 'Username is already taken!';
            return;
        }
    }

    // check if email is taken
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $stmt->bind_result($is_email);
        $stmt->fetch();
        $stmt->close();

        if (!empty($is_email)) {
            $_SESSION["error"] = 'Email is already taken!';
            return;
        }
    }

    // insert into db the new user
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, type, last_activity) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("sssssi", $fullname, $username, $email, $hashed_password, $account_type, $last_activity);
    if ($stmt->execute()) {
        $_SESSION["success"] = 'User created successfully!';
    }
    $stmt->close();
    reload();
}

// remove user
if (isset($_POST["remove_user_submit"])) {
    is_user_allowed();

    $user_ID = $_POST['user_ID'];

    if (USER_ID == $user_ID) {
        $_SESSION['error'] = 'You cannot delete yourself!';
        reload();
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt -> bind_param("i", $user_ID);
    if ($stmt->execute()) {
        $stmt->close();
        $_SESSION['success'] = 'User removed!';
    } else {
        $_SESSION['error'] = 'There was an error!';
    }

    reload();
}

// login
if (isset($_POST["login_submit"])) {
    $post_username = sanatize($_POST['username']);
    $post_password = sanatize($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, fullname, email, password FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $post_username, $post_username);

    if ($stmt->execute()) {
        $stmt->bind_result($id, $username, $fullname, $email, $password);
        $stmt->fetch();
        $stmt->close();

        if (filter_var($post_username, FILTER_VALIDATE_EMAIL)) {
            if ($post_username != $email) {
                $_SESSION ["warning"] = 'Wrong email!';
                return;
            }
        } else {
            if ($post_username != $username) {
                $_SESSION ["warning"] = 'Wrong username!';
                return;
            }
        }

        if (!password_verify($post_password, $password)) {
            $_SESSION ["warning"] = 'Wrong password!';
            return;
        }

        $_SESSION['id'] = $id;
        $_SESSION ["success"] = "Welcome back, <b>$fullname</b> !";
        $last_activity = $conn->query("UPDATE users SET last_activity='$current_date_time' WHERE username='$post_username'");
        reload();
    } else {
          $_SESSION ["error"] = 'There was an error!';
    }
}

// change password
if (isset($_POST["change_password_submit"]) && !empty($_POST)) {
    $old_password        = sanatize($_POST['old_password']);
    $new_password        = sanatize($_POST['new_password']);
    $new_password_repeat = sanatize($_POST['new_password_repeat']);

    $stmt = $conn->prepare("SELECT password FROM users WHERE id=".USER_ID);
    $stmt->execute();
    $stmt->bind_result($current_password);
    $stmt->fetch();
    $stmt->close();

    if (empty($old_password && $new_password && $new_password_repeat)) {
        $_SESSION["error"] = 'Empty fields!';
    }
    if (!password_verify($old_password, $current_password)) {
        $_SESSION["error"] = 'Incorrect old password!';
    }
    if ($new_password !== $new_password_repeat) {
        $_SESSION["error"] = 'Passwords dont match!';
    }
    if(!empty($_SESSION['error'])) {
        return;
    }

    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $password_change = $conn->prepare("UPDATE users SET password=? WHERE id=".USER_ID);
    $password_change->bind_param("s", $new_password_hash);
    if ($password_change->execute()) {
        $_SESSION["success"] = 'Password changed successfully!';
        $password_change->close();
    }
    reload();
}

// password reset
if (isset($_POST['password_reset_submit']) && !empty($_POST)) {
    $user_selector        = $_POST['user_selector'];
    $user_validator       = $_POST['user_validator'];
    $user_password        = $_POST['user_password'];
    $user_password_repeat = $_POST['user_password_repeat'];
    $hashed_user_password = password_hash($user_password, PASSWORD_DEFAULT);

    $current_date = date('U');
    $token_binary = hex2bin($user_validator);

    if ($user_password != $user_password_repeat) {
        $_SESSION['error'] = 'Passwords dont match!';
        return;
    }

    $sql  = "SELECT email, token FROM password_reset WHERE selector=? AND expires >=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('ss', $user_selector, $current_date);
    $stmt -> execute();
    $stmt -> bind_result($email, $token);
    $stmt -> fetch();
    $stmt -> close();

    if (empty($email)) {
        $_SESSION['error'] = 'Your session has expired!';
        return;
    }
    if (!password_verify($token_binary, $token)) {
        $_SESSION['error'] = 'There was an error resetting your password';
        return;
    }

    $sql  = "SELECT id FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('s', $email);
    $stmt -> execute();
    $stmt -> bind_result(USER_ID);
    $stmt -> fetch();
    $stmt -> close();

    if (empty(USER_ID)) {
        $_SESSION['error'] = 'No account to reset the password to!';
        return;
    }

    $sql  = "UPDATE users SET password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('si', $hashed_user_password, USER_ID);
    $stmt -> execute();
    $stmt -> close();

    $sql  = "DELETE FROM password_reset WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('s', $email);
    $stmt -> execute();
    $stmt -> close();

    $_SESSION['success'] = 'Successfully reset the password';
    redirect_home();
}

// password reset request
if (isset($_POST['password_reset_request']) && !empty($_POST)) {
    $selector     = bin2hex(random_bytes(8));
    $token        = random_bytes(32);
    $hashedToken  = password_hash($token, PASSWORD_DEFAULT);
    $expires      = date("U") + 1800;
    $user_email   = sanatize_email($_POST['user_email']);

    $sql  = "SELECT email FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('s', $user_email);
    $stmt -> execute();
    $stmt -> bind_result($email);
    $stmt -> fetch();
    $stmt -> close();

    if (empty($email)) {
        $_SESSION['error'] = 'There is no account with this email!';
        return;
    }

    if (isset($_SERVER['HTTPS'])) {
        $url = "https://". $_SERVER['HTTP_HOST'] ."/cms-admin/create-new-password?selector=$selector&validator=". bin2hex($token);
    } else {
        $url = "http://". $_SERVER['HTTP_HOST'] ."/cms-admin/create-new-password?selector=$selector&validator=". bin2hex($token);
    }

    $sql = "DELETE FROM password_reset WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param("s", $user_email);
    $stmt -> execute();

    $sql = "INSERT INTO password_reset (email, selector, token, expires) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param("ssss", $user_email, $selector, $hashedToken, $expires);
    $stmt -> execute();

    $to = $user_email;
    $subject = "Password Recovery";

    $message  = "<p>We received a request to reset the password for the account $user_email.</p><br>";
    $message .= "<p>Click the link below to reset your password:</p>";
    $message .= "<p><a href='$url'>Reset Password</a></p>";
    $message .= "<br><br>";
    $message .= "<p>If this wasn't you, please ignore this message!</p>";

    $headers = "From: ". WEBSITE_TITLE ." <office@2fish.ro>\r\n";
    $headers .= "Reply-To: <office@2fish.ro>\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    $_SESSION['success'] = "Success! Please check your email to reset your password";
    redirect_home();
}

// ============ MONACO EDITOR ============

// editor page update: header, footer, navbar, link & script update
if (isset($_POST['template_update_submit']) && !empty($_POST)) {
    $editor_value = $_POST['editor_value'];
    $page_link    = $_POST['page_link'];
    $page_path    = "../template/inc/$page_link.php";

    if (file_put_contents($page_path, $editor_value)) {
        echo "Code updated";
    } else {
        echo "error";
    }
}

// ============ WEBSITE ============

// website identity
if (isset($_POST['identity_submit']) && !empty($_POST)) {
    is_user_allowed();
    $title        = sanatize($_POST['site_title']);
    $description  = sanatize($_POST['site_description']);
    $keywords     = sanatize($_POST['site_keywords']);
    $author       = sanatize($_POST['site_author']);
    $robots       = !empty($_POST['site_robots']) ? $robots = $_POST['site_robots'] : $robots = 'noindex, nofollow';
    $ga_code      = $_POST['ga_code'];
    $maintenance  = !empty($_POST['maintenance_status']) ? $maintenance = 1 : 0;
    $default_page = $_POST['default_page'];

    $sql = "UPDATE website SET title=?, description=?, keywords=?, author=?, robots=?, default_page=?, ga_code=?, maintenance=? WHERE id=1";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param('sssssssi', $title, $description, $keywords, $author, $robots, $default_page, $ga_code, $maintenance);

    if ($stmt -> execute()) {
        $_SESSION['success'] = 'Website settings updated!';
        $stmt->close();
    } else {
        $_SESSION['error'] = 'Failed to update!';
    }
    reload();
}

// add favicon
if (isset($_POST["add_favicon_submit"])) {
    is_user_allowed();
    // extract file information
    $imageName   = $_FILES['favicon']['name'];
    $imageSize   = $_FILES['favicon']['size'];
    $imageType   = $_FILES['favicon']['type'];
    $imageTmp    = $_FILES['favicon']['tmp_name'];
    $imageError  = $_FILES['favicon']['error'];
    $imageDest   = '../template/assets/img/favicon/'.$imageName;
    // extract file extension
    $fileExplode  = explode('.', $imageName);
    $imageExt     = strtolower(end($fileExplode));
    // allowed extensions
    $allowed  = array('ico', 'jpg', 'jpeg', 'png');
    $size     = 10*1024*1000; // 10 MB

    if ($imageError !== 0) {
        $_SESSION ["error"] = 'Unable to upload!';
    }
    if (!in_array($imageExt, $allowed)) {
        $_SESSION ["error"] = 'Extension not allowed!';
    }
    if ($imageSize > $size) {
        $_SESSION ["error"] = 'Size too big!';
    }
    if (file_exists($imageDest)) {
        $_SESSION ["error"] = '<strong>Ups!</strong> Already exists!';
    }

    if(!empty($_SESSION['error'])) {
        return;
    }

    $uploadIcon = move_uploaded_file($imageTmp, $imageDest);

    if (!$uploadIcon) {
        $_SESSION ["error"] = 'Unable to upload into folder! ** Check write privileges **';
        return;
    }

    $stmt = $conn->prepare("UPDATE website SET favicon=?");
    $stmt->bind_param("s", $imageName);
    if ($stmt->execute()) {
        $_SESSION ["success"] = 'Icon uploaded!';
        $stmt->close();
    } else {
        $_SESSION ["error"] = 'Unable to upload into the database!';
    }
    reload();
}

// delete favicon
if (isset($_POST["delete_favicon_submit"])) {
    is_user_allowed();
    $image  = $_POST['favicon'];
    $delete = unlink('../template/assets/img/favicon/'.$image);

    if (!$delete) {
        $_SESSION["error"] = 'Unable to delete from folder!';
        return;
    }

    $sql = "UPDATE website SET favicon=''";
    $stmt_remove = $conn->prepare($sql);
    if ($stmt_remove->execute()) {
        $_SESSION["success"] = 'Icon removed!';
        $stmt_remove->close();
    } else {
        $_SESSION["error"] = 'Unable to delete from the database!';
    }
    reload();
}

// admin panel user edit
if (isset($_POST["admin_panel_user_edit"]) && !empty($_POST)) {
    $user_ID           = $_POST['user_ID'];
    $user_type         = $_POST['user_type'];
    $user_fullname     = sanatize($_POST['user_fullname']);
    $user_email        = sanatize_email($_POST['user_email']);

    if (strlen($user_fullname) < 5) {
        $_SESSION["warning"] = 'Username too short!';
        return;
    }

    // check if email is taken
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = '$user_email' AND id != $user_ID");
    if ($stmt->execute()) {
        $stmt->bind_result($is_email);
        $stmt->fetch();
        $stmt->close();

        if (!empty($is_email)) {
            $_SESSION["error"] = 'Email is already taken!';
            reload();
        }
    }

    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, type=? WHERE id=$user_ID");
    $stmt->bind_param("ssi", $user_fullname, $user_email, $user_type);
    if ($stmt->execute()) {
        $stmt->close();
        $_SESSION["success"] = 'User info updated!';
    } else {
        $_SESSION["error"] = 'There was an error!';
    }
    reload();
}


// edit user profile
if (isset($_POST["edit_user_info_submit"]) && !empty($_POST)) {
    $post_fullname     = sanatize($_POST['user_fullname']);
    $post_email        = sanatize_email($_POST['user_email']);

    if (strlen($post_fullname) < 5) {
        $_SESSION["warning"] = 'Username too short!';
        return;
    }

    $email_result = $conn->query("SELECT email FROM users WHERE id = ".USER_ID);
    $user_email = $email_result->fetch_object();

    if ($user_email->email != $post_email) {
        // check if email is taken
        $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
        $stmt->bind_param("s", $post_email);

        if ($stmt->execute()) {
            $stmt->bind_result($is_email);
            $stmt->fetch();
            $stmt->close();

            if (!empty($is_email)) {
                $_SESSION["error"] = 'Email is already taken!';
                return;
            }
        }
    }

    $stmt = $conn->prepare("UPDATE users SET  fullname=?, email=? WHERE id=".USER_ID);
    $stmt->bind_param("ss", $post_fullname, $post_email);
    if ($stmt->execute()) {
        $stmt->close();
        $_SESSION["success"] = 'User info updated!';
    } else {
        $_SESSION["error"] = 'There was an error!';
    }
    reload();
}

?>

<?php
require 'engine/init.php';
require 'template/header.php';

if (LOGGED_IN) {
    if (GET_PAGE) {
        if (file_exists("template/pages/". GET_PAGE .".php")) {
            require "template/pages/". GET_PAGE .".php";;
        } else {
            require 'template/pages/404.php';
        }
    } else {
        require "template/pages/dashboard.php";
    }
} else {
    if (GET_PAGE) {
        switch (GET_PAGE) {
            case 'password-recovery':
                require 'template/recovery/password-recovery.php';
            break;
            case 'create-new-password':
                require 'template/recovery/create-new-password.php';
            break;
            default:
                require "template/pages/404.php";
            break;
        }
    } else {
        require "template/pages/login.php";
    }
}

require 'template/footer.php';
?>

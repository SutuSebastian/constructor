<?php
require 'engine/init.php';
require 'template/header.php';

if (!WEBSITE_MAINTENANCE || LOGGED_IN) {
    if (GET_PAGE) {
        if (is_published(GET_PAGE) && file_exists($page_path) || LOGGED_IN && file_exists($page_path)) {
            require $page_path;
        } else {
            require 'template/pages/404.php';
        }
    } else {
        require "template/pages/". WEBSITE_DEFAULT_PAGE .".php";
    }
} else {
  require 'template/pages/maintenance.php';
}

require 'template/footer.php';
?>

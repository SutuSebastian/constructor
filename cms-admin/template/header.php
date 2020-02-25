<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php get_title(); ?></title>

    <base href="<?php get_base_href(); ?>">

    <link rel="icon" href="../template/assets/img/favicon/<?php echo WEBSITE_FAVICON ?>">
    <meta name="robots" content="noindex, nofollow">
    <?php require 'inc/link-style.php'; ?>
</head>
<body>

    <div class="notification_body fadeInDown animated"><?php notification_handler(); ?></div>

    <?php if (LOGGED_IN) { require 'inc/navbar.php'; } ?>

    <div class="wrapper"> <!-- START Wrapper -->

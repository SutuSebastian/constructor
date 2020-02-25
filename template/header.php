<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php get_title(); ?></title>

    <base href="<?php get_base_href(); ?>">

    <meta name="description" content="<?php get_description(); ?>">
    <meta name="author" content="<?php get_author(); ?>">
    <meta name="keywords" content="<?php get_keywords(); ?>">
    <meta name="robots" content="<?php get_robots(); ?>">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php get_title(); ?>">
    <meta property="og:description" content="<?php get_description(); ?>">
    <meta property="og:url" content="<?php echo $_SERVER['SERVER_NAME']; ?>">
    <meta property="og:site_name" content="<?php echo ucfirst(preg_replace('/.com/', "", $_SERVER['SERVER_NAME'])); ?>">
    <meta property="og:image" content="https://<?php echo $_SERVER['SERVER_NAME']; ?>/<?php get_icon(); ?>">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@<?php echo $_SERVER['SERVER_NAME']; ?>">
    <meta name="twitter:title" content="<?php get_title(); ?>">
    <meta name="twitter:description" content="<?php get_description(); ?>">
    <meta name="twitter:image" content="https://<?php echo $_SERVER['SERVER_NAME']; ?>/<?php get_icon(); ?>">

    <link rel="icon" href="<?php get_icon(); ?>">

    <?php require "inc/link-style.php"; ?>

    <!-- Custom CSS-->
    <?php get_css(); ?>

    <?php get_ga_code(); ?>

</head>
<body>

    <?php if (!WEBSITE_MAINTENANCE || LOGGED_IN) { require "inc/navbar.php"; } ?>

    <main>

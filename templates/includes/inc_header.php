<!DOCTYPE html>
<html lang="<?php echo SITE_LANG; ?>">
    <head>
        <!-- Agregar basepath para definir a partir de donde se deben generar los enlaces y la carga de archivos -->
        <base href="<?php echo BASEPATH; ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo isset($d->title) ? $d->title.' - '.get_sitename() : get_sitename(); ?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://panel.gavadesign.com" />
        <meta property="og:title" content="Panel - Gava Design" />
        <!-- Favicon del sitio -->
        <?php echo get_favicon(); ?>
        <link rel="apple-touch-icon" sizes="180x180" href="<?=FAVICON.'favicon_180.png'?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?=FAVICON.'favicon_32.png'?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?=FAVICON.'favicon_16.png'?>" />
        <!-- <link rel="manifest" href="./site.webmanifest" /> -->
        <!-- <link rel="mask-icon" href="./assets/img/favicon/safari-pinned-tab.svg" color="#ffffff" /> -->
        <meta name="msapplication-TileColor" content="#ffffff" />
        <meta name="theme-color" content="#ffffff" />

        <!-- inc_styles.php -->
        <?php require_once INCLUDES.'inc_styles.php'; ?>

    </head>
    <body class="">
        
    <?php 
        set_session('permissions', get_permission_role($_SESSION['user_session']['user']['id_role']));
        require_once INCLUDES.'inc_sidebar.php' 
    ?>
        <main class="content">

        <?php require_once INCLUDES.'inc_nav.php' ?>

<!-- ends inc_header.php -->
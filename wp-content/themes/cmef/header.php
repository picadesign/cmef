<!DOCTYPE HTML>
<html <?php language_attributes('html') ?> >
    <head>
        <meta charset="<?php bloginfo( 'charset' ) ?>">
        <!-- Start Meta Tags -->
        <meta name="description" content="<?php bloginfo('description') ?>">
        <link rel="publisher" href="https://plus.google.com/[YOUR BUSINESS G+ PROFILE HERE]"/>

        <!--Put Open Graph Meta Tags Below-->
        <!-- End Meta Tags -->
        <title><?php wp_title() ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/stylesheets/style.css" media="screen" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' )?>" />
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <?php wp_head() ?>
    </head>
    <body <?php body_class() ?> >
        <div id="root" class="container container-twelve">
            <header class="container container-twelve">
                <div id="logo" class="">Logo</div>
                <div class="clearfix left">
                    <?php
                    wp_nav_menu();
                    ?>
                </div>
            </header>
            
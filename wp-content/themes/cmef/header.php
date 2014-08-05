<?php 
    global $current_user;
    global $post;$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    setlocale(LC_MONETARY, 'en_US');
    get_userdata();
    //echo '<pre>';
    //print_r($current_user);
    //echo '</pre>';
?>
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
        <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/stylesheets/style.css" media="screen, print" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' )?>" />
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=0.9">
        <?php wp_head() ?>
    </head>
    <body <?php body_class() ?> >
        <div id="root" class="">
            <div class="full-width bleed header top">
                <header class="container container-twelve">
                    <div id="top-header">
                        <div id="logo" class=""><a href="<?php bloginfo('url') ?>"></a></div>
                        <?php if(is_user_logged_in()) : ?>
                            <div class="logged-in alignright">Hello <span class="author-name"><a href="<?php echo get_author_posts_url( $current_user->ID, $current_user->user_nicename ); ?>"><?php echo $current_user->user_nicename; ?></a></span> | <span id="logout"><a href="<?php echo wp_logout_url("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" title="Logout">LOG OUT</a></span></div>
                        <?php endif; ?>
                    </div>
                </header>
            </div>
            <div class="full-width bleed header bottom">
                <div class="container container-twelve">
                    <div id="bottom-header">
                        <div class="alignright bottom-header-left">
                            <form role="search" class="alignleft" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                                    <input type="text" class="search<?php echo (is_user_logged_in() ? ' longer' : ''); ?>" value="" placeholder="Search" name="s" id="s" />
                            </form>
                            <?php if(!is_user_logged_in()) : ?>
                                <div class="sign-up alignleft">Sign Up / Log In</div>
                                <div class="login-box">
                                    <form name="loginform" id="loginform" action="<?php bloginfo('url') ?>/wp-login.php" method="post">
										<input type="text" name="log" id="user_login" placeholder="Username">
										<input type="password" name="pwd" id="user_pass" placeholder="Password">
										<input type="submit" name="wp-submit" id="wp-submit" class="button-primary alignright" value="Log In">
										<input type="hidden" name="redirect_to" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
										<div class="clear"></div>
										<input name="rememberme" type="checkbox" class="alignleft" id="rememberme" value="forever"><span class="remember-forgot">Remember Me &nbsp;|&nbsp;  <a href="">Forgot Password</a></span>
                                    </form>  
                                    <div class="register">
                                    	<span>Don't have an account? Click here to SIGN UP</span>
                                    </div>                              
                                </div>
                            <?php endif; ?>
                        </div>
                        <? wp_nav_menu( array( 'theme_location' => 'Main Navigation') ); ?>
                        
                    </div>
                </div>
            </div>
            <div class="container ">
            
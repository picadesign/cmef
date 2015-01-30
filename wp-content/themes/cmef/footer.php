            <div id="root_footer"></div>
        </div>
        </div>
        <div class="full-width bleed footer">
	        <footer id="footer" class="container container-sixteen">
	            <div class="three columns alpha">
                    <div class="logo smaller">
                        <a href=""></a>
                    </div>
                    <div class="social">
                        <ul>
                            <li class="mail"><a href="mailto:<?php echo antispambot( get_option('qs_contact_email'), 0 ) ?>?subject=Inquiry" title="Email CMEF"></a></li>
                            <li class="twitter"><a href="<?php echo get_option('qs_contact_twitter') ?>" target="_blank"></a></li>
                            <li class="facebook"><a href="<?php echo get_option('qs_contact_facebook') ?>" target="_blank"></a></li>
                            <li class="google"><a href="<?php echo get_option('qs_contact_google') ?>" target="_blank"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="three columns offset-by-one footer-menu">
                    <? wp_nav_menu( array( 'theme_location' => 'Footer Menu') ); ?>
                </div>
                <div class="nine columns omega address">
                    <span class="business-name"><?php bloginfo('name'); ?></span><br />
                    <span class="street"><?php echo (get_option('qs_contact_street')); ?></span><br/>
                    <span class="city"><?php echo get_option('qs_contact_city') . ', ' . get_option('qs_contact_state') . ', ' . get_option('qs_contact_zip'); ?></span><br />
                    <span class="email"><a href="mailto:<?php echo antispambot( get_option('qs_contact_email'), 0 ) ?>?subject=Inquiry" "Email CMEF"><?php echo antispambot( get_option('qs_contact_email'), 0 ) ?></a></span>
                    <br /><br />
                    <span class="copyright">© <?php echo date('Y'); ?> <?php echo bloginfo('name') . '. All Rights Reserved | '; ?>
                        <?php
                            $mailto_bug_submission_subject = "" . get_bloginfo('name') . " Website";
                            //Determine the current url's protocol scheme
                            if (isset($_SERVER['REQUEST_SCHEME'])) : $protocol = $_SERVER['REQUEST_SCHEME'] . "://";
                            else : $protocol = "http://"; endif;
                            //Build the current url - this is used for redirection in the login/logout process
                            $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $mailto_bug_submission_body = "Thank you for taking the time to report an issue on our website! This email generates important information to help us make the changes necessary to address the issue you're reporting.%0D%0A%0D%0A";

                            if (is_user_logged_in()) : 
                                global $current_user;
                                $mailto_bug_submission_body .= "User Login: {$current_user->data->user_login} %0D%0A";
                                $mailto_bug_submission_body .= "User ID: {$current_user->ID} %0D%0A";
                            else : 
                                $mailto_bug_submission_body .= "User: Not Logged In %0D%0A";
                            endif;

                            $mailto_bug_submission_body .= "Page: $protocol{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']} %0D%0A";
                            $mailto_bug_submission_body .= "Browser: {$_SERVER['HTTP_USER_AGENT']}%0D%0A%0D%0A";
                            $mailto_bug_submission_body .= "Please note as many additional details that you can provide per this issue:";
                        ?>
                        <a href="mailto:<?php echo antispambot('support@pica.is') ?>?subject=Website Issue: <?php echo $mailto_bug_submission_subject ?>&amp;body=<?php echo $mailto_bug_submission_body ?>" title="Submit a problem with this website" id="report-a-bug">Report a Bug</a>
                    </span>
                    <span class="pica-mark"><a href="http://www.pica.is" title="View Pica's Portfolio"><img src="<?php echo get_template_directory_uri(); ?>/images/assets/pica-icon.png" alt="Pica Design + Marketing"></a></span>
                </div>
	        </footer>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
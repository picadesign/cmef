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
                    <span class="copyright">© <?php echo date('Y'); ?> <?php echo bloginfo('name') . '. All Rights Reserved | '; ?><span id="report-a-bug">Report a Bug</span></span>
                    <span class="pica-mark"><a href="http://www.pica.is" title="View Pica's Portfolio"><img src="<?php echo get_template_directory_uri(); ?>/images/assets/pica-icon.png" alt="Pica Design + Marketing"></a></span>
                </div>
	        </footer>
        </div>
        <script type="text/javascript">
            var templateUrl = '<?php bloginfo('template_directory'); ?>';
        </script>
        <?php wp_footer(); ?>
    </body>
</html>
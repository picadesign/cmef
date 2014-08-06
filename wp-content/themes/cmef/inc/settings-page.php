<?php
// create custom plugin settings menu
add_action('admin_menu', 'authorizenet_create_menu');

function authorizenet_create_menu() {

	//create new top-level menu
	add_menu_page('Authorize.net Settings', 'Authorize.net Settings', 'administrator', __FILE__, 'authorizenet_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'authorizenet-settings-group', 'api_login_id' );
	register_setting( 'authorizenet-settings-group', 'api_transaction_key' );
	register_setting( 'authorizenet-settings-group', 'sandbox_mode' );
}

function authorizenet_settings_page() {
?>
<div class="wrap">
<h2>Your Plugin Name</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'authorizenet-settings-group' ); ?>
    <?php do_settings_sections( 'authorizenet-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">API Login ID</th>
        <td><input type="text" name="api_login_id" value="<?php echo get_option('api_login_id'); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">API Transaction Key</th>
        <td><input type="text" name="api_transaction_key" value="<?php echo get_option('api_transaction_key'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Sandbox Mode</th>
        <td><input type="checkbox" name="sandbox_mode" value="true" <?php checked( get_option('sandbox_mode'), 'true' ); ?>/></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>
<?php

add_action( 'show_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'yoursite_extra_user_profile_fields' );
function yoursite_extra_user_profile_fields( $user ) {
?>
  <h3><?php _e("Corps Member Information", "blank"); ?></h3>
  <table class="form-table">
    <tr>
      <th><label for="corps-region"><?php _e("Corps Region"); ?></label></th>
      <td>
          <input type="text" name="corps-region" id="corps-region" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'corps-region', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e("Please select your corps region."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="corps-year"><?php _e("Corps Year"); ?></label></th>
      <td>
          <input type="text" name="corps-year" id="corps-year" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'corps-year', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e("Please select your corps year."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="phone"><?php _e("Phone"); ?></label></th>
      <td>
          <input type="text" name="phone" id="phone" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e("Please enter your phone."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="street-1"><?php _e("Street 1"); ?></label></th>
      <td>
          <input type="text" name="street-1" id="street-1" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'street-1', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e("Please enter your street address"); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="street-2"><?php _e("Street 2"); ?></label></th>
      <td>
          <input type="text" name="street-2" id="street-2" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'street-2', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e(""); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="city"><?php _e("City"); ?></label></th>
      <td>
          <input type="text" name="city" id="city" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e("Please enter your city."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="state"><?php _e("State"); ?></label></th>
      <td>
          <input type="text" name="state" id="state" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e("Please enter your state."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="zip"><?php _e("Zip"); ?></label></th>
      <td>
          <input type="text" name="zip" id="zip" class="regular-text" 
              value="<?php echo esc_attr( get_the_author_meta( 'zip', $user->ID ) ); ?>" /><br />
          <span class="description"><?php _e("Please enter you zipcode."); ?></span>
      </td>
    </tr>
  </table>
<?php
}

add_action( 'personal_options_update', 'yoursite_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'yoursite_save_extra_user_profile_fields' );
function yoursite_save_extra_user_profile_fields( $user_id ) {
  $saved = false;
  if ( current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, 'corps-region', $_POST['corps-region']);
    update_user_meta( $user_id, 'corps-year', $_POST['corps-year']);
    update_user_meta( $user_id, 'phone', $_POST['phone']);
    update_user_meta( $user_id, 'street-1', $_POST['street-1']);
    update_user_meta( $user_id, 'street-2', $_POST['street-2']);
    update_user_meta( $user_id, 'city', $_POST['city']);
    update_user_meta( $user_id, 'state', $_POST['state']);
    update_user_meta( $user_id, 'zip', $_POST['zip']);
    $saved = true;
  }
  return true;
}
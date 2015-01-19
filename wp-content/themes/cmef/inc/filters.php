<?php 

function login_redirect( $redirect_to, $request, $user  ) {
  return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
} // end login_redirect
add_filter( 'login_redirect', 'login_redirect', 10, 3 );

<?php 

	add_action('wp_ajax_nopriv_get_homepage', 'get_homepage');
    add_action('wp_ajax_get_homepage', 'get_homepage');
    function get_homepage(){
    	$homepage = get_page(get_option('page_on_front'));
    	echo json_encode($homepage);

    	die();
    }
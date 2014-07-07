<?php 

	add_action('wp_ajax_nopriv_delete_exported_csv', 'delete_exported_csv');
    add_action('wp_ajax_delete_exported_csv', 'delete_exported_csv');
    function delete_exported_csv(){
    	print_r($_POST);
    	unlink(ABSPATH . $_POST['file']);
    	die();
    }
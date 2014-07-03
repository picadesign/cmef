<?php
	/*
		 ____                            ____                                          
		/\  _`\   __                    /\  _`\                  __                    
		\ \ \L\ \/\_\    ___     __     \ \ \/\ \     __    ____/\_\     __     ___    
		 \ \ ,__/\/\ \  /'___\ /'__`\    \ \ \ \ \  /'__`\ /',__\/\ \  /'_ `\ /' _ `\  
		  \ \ \/  \ \ \/\ \__//\ \L\.\_   \ \ \_\ \/\  __//\__, `\ \ \/\ \L\ \/\ \/\ \ 
		   \ \_\   \ \_\ \____\ \__/.\_\   \ \____/\ \____\/\____/\ \_\ \____ \ \_\ \_\
			\/_/    \/_/\/____/\/__/\/_/    \/___/  \/____/\/___/  \/_/\/___L\ \/_/\/_/
																		 /\____/       
																		 \_/__/
																																					 
		Graphic Design & Marketing | www.pica.is
	*/
	
	/***********************************************************
		My Green Downtown THEME SETUP
	***********************************************************/

	/* Theme Setup Action */
	add_action( 'init', 'mygreendowntown_theme_setup' );
	function mygreendowntown_theme_setup() {
		/** 
		* Everything should go in here.
		* Use full for getting post data like AJAX.
		*/

		// Load in our ajax
		include('inc/ajax.php');

		// Load Our Post Types
		include('inc/post-types.php');
		include('inc/helpers.php');

	}//mygreendowntown_theme_setup

	//Include the scripts
	include('inc/scripts.php');

	//Include the styles
	include('inc/styles.php');

	add_action( 'admin_init', 'custom_admin' );
	function custom_admin(){
		include('inc/custom-admin.php');
	}
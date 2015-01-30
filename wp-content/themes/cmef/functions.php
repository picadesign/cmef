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
	add_action( 'init', 'cmef_theme_setup' );
	function cmef_theme_setup() {
		/** 
		* Everything should go in here.
		* Use full for getting post data like AJAX.
		*/

		/**
		 * Load the custom sources.
		 * Below we include the csv writer.
		 * And the other plugin files that do not have much development activity on them.
		 * I've pulled the files from the plugin file.
		 * @todo: Document this function file more.
		 */

		// CSV Creater
		require dirname(__FILE__) . '/inc/custom-sources/AbstractBase.php';
		require dirname(__FILE__) . '/inc/custom-sources/Reader.php';
		require dirname(__FILE__) . '/inc/custom-sources/Writer.php';

		// Search Meta Boxes
		require dirname(__FILE__) . '/inc/custom-sources/wp-admin-search-meta.php';

		

		// Load in our ajax
		include('inc/ajax.php');
		// Load in the post attachments
		include('inc/post-attachments.php');
		// Load Our Post Types
		include('inc/post-types.php');
		//Load the taxonomies
		include('inc/taxonomies.php');
		// Load some helper functions
		include('inc/helpers.php');
		//Load the filters
		include('inc/filters.php');

		// Load the Menus
		include ('inc/menus.php');

		//Include the states
		include ('inc/php-states-dropdown.php');
		//Settings Page
		include ('inc/settings-page.php');




	}//cmef_theme_setup

	//Include the scripts
	include('inc/scripts.php');

	//Include the styles
	include('inc/styles.php');

	add_action( 'admin_init', 'custom_admin' );
	function custom_admin(){
		include('inc/custom-admin.php');
		//Author Meta Fields
		include ('inc/author-meta-fields.php');
	}
<?php

	add_theme_support('menus');

	//Register Some Menu Locations
	register_nav_menu( 'Main Navigation', 'Header Menu');				//User not logged in
	register_nav_menu( 'Main Navigation Logged In', 'Header Menu Logged In');		//User Logged in menu
	register_nav_menu( 'Footer Menu', 'Footer Menu');					//footer menu
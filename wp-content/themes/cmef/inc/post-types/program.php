<?php

	// Pretty self explanitory but we are creating the program post type.
	$labels = array(
		'name'               => _x( 'Programs', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Program', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Programs', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Program', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Program', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Program', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Program', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Program', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Program', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Programs', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Programs', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Programs:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Programs found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Programs found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'program' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'menu_icon'          => 'dashicons-color-scissors'
	);

	register_post_type( 'program', $args );
?>
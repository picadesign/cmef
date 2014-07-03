<?php
	
	// Pretty self explanitory but we are creating the expense post type.

	$labels = array(
		'name'               => _x( 'Expenses', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Expense', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Expenses', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Expense', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Expense', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Expense', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Expense', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Expense', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Expense', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Expenses', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Expenses', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Expenses:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Expenses found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Expenses found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'expense' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'menu_icon'          => 'dashicons-color-coin'
	);

	register_post_type( 'expense', $args );
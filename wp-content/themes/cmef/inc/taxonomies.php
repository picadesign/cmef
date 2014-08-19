<?php
	// Add new TFA Region taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'TFA Regions', 'taxonomy general name' ),
		'singular_name'     => _x( 'TFA Region', 'taxonomy singular name' ),
		'search_items'      => __( 'Search TFA Regions' ),
		'all_items'         => __( 'All TFA Regions' ),
		'parent_item'       => __( 'Parent TFA Region' ),
		'parent_item_colon' => __( 'Parent TFA Region:' ),
		'edit_item'         => __( 'Edit TFA Region' ),
		'update_item'       => __( 'Update TFA Region' ),
		'add_new_item'      => __( 'Add New TFA Region' ),
		'new_item_name'     => __( 'New TFA Region Name' ),
		'menu_name'         => __( 'TFA Regions' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tfa-region' ),
	);
	register_taxonomy( 'tfa-region', 'program', $args );

	// Add new Program Type taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Program Types', 'taxonomy general name' ),
		'singular_name'     => _x( 'Type of Program', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Types of Program' ),
		'all_items'         => __( 'All Program Types' ),
		'parent_item'       => __( 'Parent Program Type' ),
		'parent_item_colon' => __( 'Parent Program Type:' ),
		'edit_item'         => __( 'Edit Program Type' ),
		'update_item'       => __( 'Update Program Type' ),
		'add_new_item'      => __( 'Add New Program Type' ),
		'new_item_name'     => __( 'New Program Type Name' ),
		'menu_name'         => __( 'Types of Programs' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'program-type' ),
	);
	register_taxonomy( 'program-type', 'program', $args );

	// Add new Program Type taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Grade Levels', 'taxonomy general name' ),
		'singular_name'     => _x( 'Grade Level', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Grade Levels' ),
		'all_items'         => __( 'All Grade Levels' ),
		'parent_item'       => __( 'Parent Grade Level' ),
		'parent_item_colon' => __( 'Parent Grade Level:' ),
		'edit_item'         => __( 'Edit Grade Level' ),
		'update_item'       => __( 'Update Grade Level' ),
		'add_new_item'      => __( 'Add New Grade Level' ),
		'new_item_name'     => __( 'New Grade Level Name' ),
		'menu_name'         => __( 'Grade Levels' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'grade-level' ),
	);
	register_taxonomy( 'grade-level', 'program', $args );
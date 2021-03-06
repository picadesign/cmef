<?php	
	// Pretty self explanitory, but we are creating the program post type.
	$labels = array(
		'name'               => _x( 'Resources', 'post type general name'),
		'singular_name'      => _x( 'Resource', 'post type singular name'),
		'menu_name'          => _x( 'Resources', 'admin menu'),
		'name_admin_bar'     => _x( 'Resource', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'Resource'),
		'add_new_item'       => __( 'Add New Resource'),
		'new_item'           => __( 'New Resource'),
		'edit_item'          => __( 'Edit Resource'),
		'view_item'          => __( 'View Resource'),
		'all_items'          => __( 'All Resources'),
		'search_items'       => __( 'Search Resources'),
		'parent_item_colon'  => __( 'Parent Resources:'),
		'not_found'          => __( 'No Resources found.'),
		'not_found_in_trash' => __( 'No Resources found in Trash.')
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'resource', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'          => 'dashicons-format-aside',
		//'taxonomies' => array('tfa-region')
	);

	register_post_type( 'resource', $args );

	register_taxonomy(
		'resource_type',
		'resource',
		array(
			'label' => __( 'Resource Type' ),
			'rewrite' => array( 'slug' => 'resource_type', 'with_front' => false ),
			'query_var' => 'resource-type',
			'hierarchical' => true,

		)
	);
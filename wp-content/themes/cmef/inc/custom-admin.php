<?php

	// Add in the flat color dashicons so we can use them.
	wp_enqueue_style('dashicons-color', get_bloginfo('template_url') . '/stylesheets/admin.css');
	wp_enqueue_script('main-admin-script', get_bloginfo('template_url') . '/scripts/admin-scripts.js', $deps = array('jquery'), $ver = false, $in_footer = true);
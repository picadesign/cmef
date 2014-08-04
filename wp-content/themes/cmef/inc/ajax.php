<?php 

	add_action('wp_ajax_nopriv_delete_exported_csv', 'delete_exported_csv');
    add_action('wp_ajax_delete_exported_csv', 'delete_exported_csv');
    function delete_exported_csv(){
    	print_r($_POST);
    	unlink(ABSPATH . $_POST['file']);
    	die();
    }

    add_action('wp_ajax_nopriv_fetch_programs', 'ajax_fetch_programs');
    add_action('wp_ajax_fetch_programs', 'ajax_fetch_programs');
    function ajax_fetch_programs () {;
    	setlocale(LC_MONETARY, 'en_US');
    	global $post;
    	$args = array(
			'post_type'   => 'program',
			'offset' => $_POST['offset'] + 1,
			'posts_per_page' => 3
		);
		$the_query = new WP_Query( $args );
			if ($the_query->have_posts()) :;
    		while ($the_query->have_posts()) : $the_query->the_post() ;
    			$goal = get_post_meta(get_the_ID(), '_fundraising-goal', true);
		    	$program = $post;
		    	$program->author = get_the_author();
		    	$program->post_thumbnail = get_the_post_thumbnail($post->ID, $size = 'post-thumbnail', $attr = '');
		    	$program->placement_holder_image = '<img src="'. get_template_directory_uri() .'/images/placeholder.png" alt="">';
		    	$program->percentage_raised = (47523/(int) $goal)*100;
                //Also append the same data to an array for JS
    			$programsDataObject[] = $program;
    			$program->amount_raised = money_format('%.0n', 15000) . "\n";
    			$program->fundraiser_goal = money_format('%.0n', $goal) . "\n";
    			$program->twitter_url = get_post_meta($post->ID, '_social-networks', true)['twitter'];
    			$program->linkedin_url = get_post_meta($post->ID, '_social-networks', true)['linkedin'];
    			$program->facebook_url = get_post_meta($post->ID, '_social-networks', true)['facebook'];
    			$program->googel_url = get_post_meta($post->ID, '_social-networks', true)['google'];
    	endwhile;

    	echo json_encode($programsDataObject);
    	endif;
    	die(); 
    }//ajax_fetch_programs

    //Save Author
    add_action('wp_ajax_save_author', 'ajax_save_author');
    function ajax_save_author(){
        global $post;
        //Get the informatioan from the author.
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $description = $_POST['description'];
        $author_ID = $_POST['author_ID'];

        //Update the information.
        $user_id = wp_update_user(array(
            'ID' => $author_ID,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'description' => $description,
            'display_name' => $first_name . ' ' . $last_name
        ));
        die();
    }//end ajax_save_author
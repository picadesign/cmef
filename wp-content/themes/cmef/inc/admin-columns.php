<?php
    
    //add new columns to columns to the user table
    function new_modify_user_table( $column ) {
        $column['programs'] = 'Programs';
        unset($column['posts']);                //remove num-posts and secondary column
        unset($column['secondary_roles']);
        return $column;                         //send back the array;
    }
    add_filter( 'manage_users_columns', 'new_modify_user_table' );

    // render the columns content
    function new_modify_user_table_row( $val, $column_name, $user_id ) {
        $user = get_userdata( $user_id );
        switch ($column_name) {
            case 'programs' :       //if the column if the programs columns
                $query = new WP_Query(array('post_type' => 'program', 'author' => $user->ID, 'posts_per_page' => -1));  //Run new query
                if ( $query->have_posts() ) : 
                    while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php $return = '<a href="' .get_edit_post_link($post->ID) . '">'.get_the_title().'</a> '; ?>
                    <?php endwhile; 
                    wp_reset_postdata();
                endif;
                break;
            default:
        }
        return $return;
    }
    add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );
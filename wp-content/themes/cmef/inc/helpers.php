<?php
/**
 * is_edit_page 
 * function to check if the current page is a post edit page
 * 
 * @author Ohad Raz <admin@bainternet.info>
 * 
 * @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
 * @return boolean
 */
function is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

/**
 * Turn off the admin bar on the front end.
 */
add_filter('show_admin_bar', '__return_false');

add_action('admin_head-nav-menus.php', 'wpclean_add_metabox_menu_posttype_archive');
 
function wpclean_add_metabox_menu_posttype_archive() {
    add_meta_box('wpclean-metabox-nav-menu-posttype', 'Custom Post Type Archives', 'wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}
 
function wpclean_metabox_menu_posttype_archive() {
    $post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');
 
    if ($post_types) :
        $items = array();
        $loop_index = 999999;
 
        foreach ($post_types as $post_type) {
            $item = new stdClass();
            $loop_index++;
 
            $item->object_id = $loop_index;
            $item->db_id = 0;
            $item->object = 'post_type_' . $post_type->query_var;
            $item->menu_item_parent = 0;
            $item->type = 'custom';
            $item->title = $post_type->labels->name;
            $item->url = get_post_type_archive_link($post_type->query_var);
            $item->target = '';
            $item->attr_title = '';
            $item->classes = array();
            $item->xfn = '';
 
            $items[] = $item;
        }
 
        $walker = new Walker_Nav_Menu_Checklist(array());
 
        echo '<div id="posttype-archive" class="posttypediv">';
        echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
        echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
        echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
        echo '</ul>';
        echo '</div>';
        echo '</div>';
 
        echo '<p class="button-controls">';
        echo '<span class="add-to-menu">';
        echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'andromedamedia') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
        echo '<span class="spinner"></span>';
        echo '</span>';
        echo '</p>';
 
    endif;
}

/**
* Restrict the amount of text in the excerpt
*/

add_filter('excerpt_length', 'my_excerpt_length');
function my_excerpt_length($length) {
    return 175; // Or whatever you want the length to be.
}

/**
 * Add the ajaxurl variable for javascript
 */
add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() {
?>
<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}

/**
 * Add Project Donations
 */
function program_donation_total($program_id){
    global $post;
        /**
         * The WordPress Query class.
         * @link http://codex.wordpress.org/Function_Reference/WP_Query
         *
         */
        $args = array(
            //Type & Status Parameters
            'post_type'   => 'donation',
            //Custom Field Parameters
            'meta_key'       => '_program-id',
            'meta_value'     => $program_id,
            'posts_per_page' => -1
        );
    
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        $donation_total = 0;
            while ( $query->have_posts() ) :
            $query->the_post();
            //print_r($post->post_title);
            $donation_total += (int) get_post_meta( $post->ID , '_contribution-amount' , true );
            //print_r(get_post_meta( $post->ID , '_contribution-amount' , true ));
            endwhile;
        //echo '</div>';
    else :
        // no posts found
    endif; 
    wp_reset_postdata();

    //print_r($query);
    return (int) $donation_total;
}

function insert_attachment($file_handler,$post_id,$setthumb='false') {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload( $file_handler, $post_id );

}
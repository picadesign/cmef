<?php 

/*
    In this file we will include the scripts used in this template.
    By default I have included some standard script included and not included by wordpress
    Below in the wp_footer_injection action we will include any backbone template that need to be included.
    Please keep in mind comment out or remove any code or scripts you will not be using to speed the site up.

    Included by WordPress
       • Jquery
       • Backbone
       • Underscore

     - Your King,
        Jason Walker
 */


function enqueue_scripts(){
    wp_enqueue_script('redactor', get_bloginfo('template_url') . '/scripts/redactor.min.js', array('jquery'));
    wp_enqueue_script('mustache', get_bloginfo('template_url') . '/scripts/mustache/mustache.js', array('jquery'));
    wp_enqueue_script('masonry', get_bloginfo('template_url') . '/scripts/mustache/masonry.min.js', array('jquery'));
    wp_enqueue_script('cycle2', get_bloginfo('template_url') . '/scripts/jquery.cycle2.min.js', array('jquery'));
    wp_enqueue_script('lightbox', get_bloginfo('template_url') . '/scripts/lightbox.min.js', array('jquery'));
    wp_enqueue_script('forms', get_bloginfo('template_url') . '/scripts/jquery.form.js', array('jquery'));
    wp_enqueue_script('require', get_bloginfo('template_url') . '/scripts/require.js', array('jquery', 'backbone'), false, true);
    wp_enqueue_script('jquery-ui-accordion');

    wp_enqueue_script('views', get_bloginfo('template_url') . '/scripts/views/views.js', array('jquery', 'backbone', 'models'),  false, true);

    wp_enqueue_script('models', get_bloginfo('template_url') . '/scripts/models/models.js', array('jquery', 'backbone', 'collections'),  false, true);

    wp_enqueue_script('collections', get_bloginfo('template_url') . '/scripts/collections/collections.js', array('jquery', 'backbone'),  false, true);

    //wp_enqueue_script('app', get_bloginfo('template_url') . '/scripts/app.js', array('jquery', 'backbone', ''));

    //Only include jQuery
    wp_enqueue_script('main-script', get_bloginfo('template_url') . '/scripts/scripts.js', array('require', 'masonry', 'cycle2', 'lightbox', 'redactor', 'mustache', 'views'),  false, true);

    if(is_author()){
      wp_enqueue_script('author-editing', get_bloginfo('template_url') . '/scripts/front-end-editing/author-page.js', $deps = array('jquery', 'redactor'), $ver = false, $in_footer = true);
    }

}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

add_action('wp_footer', 'wp_footer_injection');
  function wp_footer_injection () { 
    global $post, $comments, $total_pages_of_posts ; ?>
  
  <script type="text/javascript">
    //Site settings client side requires
    <?php echo "var cmef_settings = " . json_encode(array(
        'siteURL' => get_bloginfo('url'),
        'ajaxURL' => get_bloginfo('url') . '/wp-admin/admin-ajax.php',
        'apiURL' => get_bloginfo('url') . '/wp-json.php',
        'templateURL' => get_bloginfo('template_url'),
        'total_pages_of_posts' => $total_pages_of_posts,
        'mustache_template_path' => get_bloginfo('template_url') . '/scripts/mustache-templates/',
        'paged' => 1,
        'post_ID' => $post->ID,
        'userID' => get_current_user_id(), 
        'userLoggedIn' => is_user_logged_in() ? true : false )) . "\n" ?>

        //Output our list of initial projects to load
        <?php echo "var postData = " . json_encode(array(
            'post_title' => $post->post_title,
            'ID' => $post->ID,
            'post_author' => $post->post_author,
            'post_date' => $post->post_date,
            'post_date_gmt' => $post->post_date_gmt,
            'post_content' => wpautop($post->post_content),
            'post_title' => $post->post_title,
            'post_excerpt' => $post->post_excerpt,
            'post_status' => $post->post_status,
            'comment_status' => $post->comment_status,
            'ping_status' => $post->ping_status,
            'post_password' => $post->post_password,
            'post_name' => $post->post_name,
            'to_ping' => $post->to_ping,
            'pinged' => $post->pinged,
            'post_modified' => $post->post_modified,
            'post_modified_gmt' => $post->post_modified_gmt,
            'post_content_filtered' => $post->post_content_filtered,
            'post_parent' => $post->post_parent,
            'guid' => $post->guid,
            'menu_order' => $post->menu_order,
            'post_type' => $post->post_type,
            'post_mime_type' => $post->post_mime_type,
            'comment_count' => $post->comment_count,
            'ancestors' => $post->ancestors,
            'filter' => $post->filter,
        )) . "\n" ?> 

        // Theres a little too much information to grab through ajax for our single program. Let's do it this way.
        <?php 
            if(is_singular( 'program' )):;
                echo "var singleProgram = " . json_encode(array(
                    'post_thumbnail_id' => get_post_thumbnail_id($post->ID),
                    'post_thumbnail_src' => wp_get_attachment_url( get_post_thumbnail_id($post->ID) )
                )) . "\n";
           endif;
        ?>

        <?php if (!empty($comments)) echo "var comments = " . json_encode($comments) . "\n"; ?>
    </script>
    <?php }
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

    wp_enqueue_script('require', get_bloginfo('template_url') . '/scripts/require.js', array('jquery', 'backbone'), false, true);

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
    global $post, $projectData, $comments, $total_pages_of_posts ; ?>
  
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
        'userLoggedIn' => is_user_logged_in() ? 1 : 0 )) . "\n" ?>

        //Output our list of initial projects to load
        <?php echo "var projectData = " . json_encode($projectData) . "\n" ?> 

        <?php if (!empty($comments)) echo "var comments = " . json_encode($comments) . "\n"; ?>
    </script>
    <?php }
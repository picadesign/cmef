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
    //Only include jQuery
    wp_enqueue_script('main-script', get_bloginfo('template_url') . '/scripts/scripts.js', $deps = array('jquery', 'mustache'), $ver = false, $in_footer = true);

    wp_enqueue_script('redactor', get_bloginfo('template_url') . '/scripts/redactor.min.js', $deps = array('jquery'), $ver = false, $in_footer = true);

    wp_enqueue_script('mustache', get_bloginfo('template_url') . '/scripts/mustache/mustache.js', $deps = array('jquery'), $ver = false, $in_footer = true);

    wp_enqueue_script('masonry', get_bloginfo('template_url') . '/scripts/mustache/masonry.min.js', $deps = array('jquery', 'main-script'), $ver = false, $in_footer = true);

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
        'templateURL' => get_bloginfo('theme_directory'),
        'total_pages_of_posts' => $total_pages_of_posts,
        'paged' => 1,
        'post_ID' => $post->ID,
        'userLoggedIn' => is_user_logged_in() ? 1 : 0 )) . "\n" ?>

        //Output our list of initial projects to load
        <?php echo "var projectData = " . json_encode($projectData) . "\n" ?> 

        <?php if (!empty($comments)) echo "var comments = " . json_encode($comments) . "\n"; ?>
    </script>
    <?php }
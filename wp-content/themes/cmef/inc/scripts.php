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

    if(is_author()){
      wp_enqueue_script('author-editing', get_bloginfo('template_url') . '/scripts/front-end-editing/author-page.js', $deps = array('jquery', 'redactor'), $ver = false, $in_footer = true);
    }

}
add_action('wp_enqueue_scripts', 'enqueue_scripts');
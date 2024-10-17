<?php

/* Page Slug Body Class */

function gb_add_slug_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

add_filter('body_class', 'gb_add_slug_body_class');

function ip_admin_bar_what_template()
{
    global $wp_admin_bar;
    global $template;
    if ($template) {
        $wp_admin_bar->add_menu(array(
            'id' => 'ip-template',
            'parent' => 'top-secondary',
            'title' => __(basename($template))
        ));
    }
}

add_action('wp_before_admin_bar_render', 'ip_admin_bar_what_template');
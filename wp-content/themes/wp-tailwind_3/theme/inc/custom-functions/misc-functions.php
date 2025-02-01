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

// Enable featured images on pages
function mytheme_setup() {
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for post thumbnails on pages
    add_post_type_support('page', 'thumbnail');
}
add_action('after_setup_theme', 'mytheme_setup');

/* Tailwind Background Color Classes for ACF Select */

function get_tailwind_bg_classes_for_acf()
{
    return [
        'bg-neutral-100' => 'Neutral',
        'bg-red-500' => 'Red',
        'bg-green-500' => 'Green',
        'bg-blue-500' => 'Blue',
        'bg-yellow-500' => 'Yellow',
        'bg-purple-500' => 'Purple'
    ];
}

function mdr_acf_load_field_choices($field)
{
    // Get the Tailwind background color classes
    $choices = get_tailwind_bg_classes_for_acf();

    // Set the choices for the select field
    $field['choices'] = $choices;

    return $field;
}

add_filter('acf/load_field/name=background_color', 'mdr_acf_load_field_choices');
<?php

/*
*
* Enqueues
*/

  // Enqueue Splide.js and CSS
function enqueue_splide_assets() {

  wp_enqueue_script(
      'splide-js',
      'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js',
      array(),
      null,
      true
  );

  wp_enqueue_style(
      'splide-css',
      'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css',
      array(),
      null
  );
}
add_action( 'wp_enqueue_scripts', 'enqueue_splide_assets' );

function enqueue_acf_options_page_script() {
  // Check if we are on an ACF options page
  $screen = get_current_screen();
  
  // Replace 'your-options-page-slug' with your actual ACF options page slug
  if ($screen && strpos($screen->id, 'site-settings_page_acf-options-header') !== false) {
      // Enqueue the script
      wp_enqueue_script(
        'acf-custom-js',
        get_theme_file_uri('/js/acf-custom.js'),
        array('jquery'),
        null,
        true
    );
  }
}
add_action('acf/input/admin_enqueue_scripts', 'enqueue_acf_options_page_script');

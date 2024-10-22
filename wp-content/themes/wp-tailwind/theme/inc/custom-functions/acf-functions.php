<?php

/**
 * Functions for ACF
 *
 */

 // Options Pages

 if( function_exists('acf_add_options_page') ) {

  // Parent options page: Site Settings
  $parent = acf_add_options_page(array(
      'page_title'    => 'Site Settings',
      'menu_title'    => 'Site Settings',
      'menu_slug'     => 'site-settings',
      'capability'    => 'edit_posts',
      'redirect'      => false
  ));

  // Child page: Header
  acf_add_options_sub_page(array(
      'page_title'    => 'Header Settings',
      'menu_title'    => 'Header',
      'parent_slug'   => $parent['menu_slug'],
  ));

  // Child page: Footer
  acf_add_options_sub_page(array(
      'page_title'    => 'Footer Settings',
      'menu_title'    => 'Footer',
      'parent_slug'   => $parent['menu_slug'],
  ));

  // Child page: Contact
  acf_add_options_sub_page(array(
      'page_title'    => 'Contact Settings',
      'menu_title'    => 'Contact',
      'parent_slug'   => $parent['menu_slug'],
  ));
}


// Register ACF Blocks

function mdr_register_acf_blocks()
{
  register_block_type(get_stylesheet_directory() . '/blocks/main-content');
}

add_action('init', 'mdr_register_acf_blocks');

// Spacing Helper Function

function mdr_get_block_styles($attributes)
{
  $styles = "";

  // Get our top, right, bottom, and left padding values
  if (! empty($attributes['spacing']['padding'])) {
    $paddingTop = $attributes['spacing']['padding']['top'] ? "padding-top: {$attributes['spacing']['padding']['top']};" : '';
    $paddingRight = $attributes['spacing']['padding']['right'] ? "padding-right: {$attributes['spacing']['padding']['right']};" : '';
    $paddingBottom = $attributes['spacing']['padding']['bottom'] ? "padding-bottom: {$attributes['spacing']['padding']['bottom']};" : '';
    $paddingLeft = $attributes['spacing']['padding']['left'] ? "padding-left: {$attributes['spacing']['padding']['left']};" : '';
    $styles .= "{$paddingTop}{$paddingRight}{$paddingBottom}{$paddingLeft}";
  }

  // Get our top, right, bottom, and left margin values
  if (! empty($attributes['spacing']['margin'])) {
    $marginTop = $attributes['spacing']['margin']['top'] ? "margin-top: {$attributes['spacing']['margin']['top']};" : '';
    $marginRight = $attributes['spacing']['margin']['right'] ? "margin-right: {$attributes['spacing']['margin']['right']};" : '';
    $marginBottom = $attributes['spacing']['margin']['bottom'] ? "margin-bottom: {$attributes['spacing']['margin']['bottom']};" : '';
    $marginLeft = $attributes['spacing']['margin']['left'] ? "margin-left: {$attributes['spacing']['margin']['left']};" : '';
    $styles .= "{$marginTop}{$marginRight}{$marginBottom}{$marginLeft}";
  }

  return $styles;
}

// Create variables dynamically for each field in a group

function mdr_get_acf_field_variables($field_group_key) {
  // Get all fields for the current post
  $fields = get_fields();
  
  if (!$fields) {
      return array();
  }
  
  $field_variables = array();
  
  foreach ($fields as $field_name => $field_value) {
      // Check if the field belongs to the specified group
      $field_object = get_field_object($field_name);
      
      if ($field_object && isset($field_object['parent']) && $field_object['parent'] == $field_group_key) {
          // Create a variable name using the field name
          $variable_name = $field_name;
          
          // Add the variable to our array
          $field_variables[$variable_name] = $field_value;
      }
  }
  
  return $field_variables;
}

// ACF File Naming
function mdr_custom_acf_json_filename($filename, $post, $load_path)
{
    $filename = str_replace(
        array(
            ' ',
            '_',
        ),
        array(
            '-',
            '-'
        ),
        $post['title']
    );

    $filename = strtolower($filename) . '.json';

    return $filename;
}

add_filter('acf/json/save_file_name', 'mdr_custom_acf_json_filename', 10, 3);

// Get the Site Logo from ACF options
$mdr_logo = get_field('mdr_logo', 'options', false);
if ( !empty($mdr_logo) ) {
    update_option('custom_logo', $mdr_logo, true); // Update Site Logo if not empty
}

// Get the Site Favicon from ACF options
$mdr_favicon = get_field('mdr_favicon', 'options', false);
if ( !empty($mdr_favicon) ) {
    update_option('site_icon', $mdr_favicon, true); // Update Site Favicon / Icon if not empty
}


/*
*  Populate ACF field (gravity_form_id) with list of gravity forms containing ids
 *************************************************************************************/

 function mdr_load_gravity_forms_into_acf_select_field($field)
 {
     $values = array();
     $forms = GFFormsModel::get_forms();
 
     if ($forms) {
         //Add empty option
         $field['choices']["0"] = 'Select a Form';
 
         foreach ($forms as $form) {
             $field['choices'][$form->id] = $form->title;
         }
     }
 
     return $field;
 }
 
 //Change gravity_form_id to the name of the ACF select field you want to populate
 add_filter('acf/load_field/name=form', 'mdr_load_gravity_forms_into_acf_select_field');

 /* Get width of image and divide by two to echo as max width for retina images */
function mdr_get_half_image_width($image_field, $layout_count)
{
    $image = get_sub_field($image_field);
    if ($image) {
        $image_id = $image['ID'];
        $metadata = wp_get_attachment_metadata($image_id);
        $image_width = $metadata['width'] / 2;

        // Output the CSS
        echo "<style>
        @media screen and (max-width: 1023px) {
            .layout-" . esc_attr($layout_count) . "-retina-max {
                max-width: " . $image_width . "px;
            }
        }
        </style>";

        return $image_width;
    }
    return null;
}

// Style ACF Layouts
function mdr_custom_admin_styles() {
    echo '<style>

        .acf-flexible-content .layout:nth-child(odd) {
            background-color: #f9f9f9;
        }


    </style>';
}
add_action('admin_head', 'mdr_custom_admin_styles');

// Function to extract the color palette from theme settings
function mdr_get_theme_colors()
{
    // Use WP_Theme_JSON_Resolver to get theme settings
    $theme_settings = WP_Theme_JSON_Resolver::get_theme_data()->get_settings();

    // Extract colors from the settings (adjust according to your theme.json structure)
    $colors = $theme_settings['color']['palette']['theme'] ?? [];

    // Prepare an array to hold the hexadecimal values of the colors
    $color_palette = [];
    foreach ($colors as $color) {
        $color_palette[] = $color['color'];
    }

    return $color_palette;
}

// Inject custom JS to modify the ACF color picker
add_action('acf/input/admin_footer', 'mdr_custom_acf_admin_footer_js');
function mdr_custom_acf_admin_footer_js()
{
    $color_palette = mdr_get_theme_colors();
    $json_palette = json_encode($color_palette);
    ?>
    <script type="text/javascript">
        (function ($) {
            acf.add_filter('color_picker_args', function (args, $field) {
                // Add your colors here
                args.palettes = <?php echo $json_palette ?>;
                return args;
            });
        })(jQuery);
    </script>
    <?php
}

function mdr_get_theme_json_colors()
{
    // Use the WP_Theme_JSON_Resolver class to get the theme's settings
    $theme_json_data = WP_Theme_JSON_Resolver::get_theme_data();
    $settings = $theme_json_data->get_settings();
    // Extract the color palette data
    if (isset($settings['color']['palette']) && is_array($settings['color']['palette']['theme'])) {
        return $settings['color']['palette']['theme'];
    }
    return [];
}

add_filter('acf/load_field', 'mdr_populate_acf_field_based_on_label');
function mdr_populate_acf_field_based_on_label($field)
{
    // Define the specific label to look for
    $target_description = 'Color Choices';
    // Check if the field's description matches the target description
    if (isset($field['instructions']) && $field['instructions'] === $target_description) {
        // Populate the field if it matches
        $colors = mdr_get_theme_json_colors();
        $ignore_slugs = ['background', 'foreground', 'primary', 'secondary'];
        $field['choices'] = [];
        foreach ($colors as $color) {
            if (isset($color['slug']) && isset($color['name']) && !in_array($color['slug'], $ignore_slugs)) {
                $field['choices'][$color['slug']] = $color['name'];
            }
        }
    }
    return $field;
}

// Function to load theme.json colors into ACF color picker
function populate_acf_color_picker_from_theme_json($field) {
    // Get theme.json settings
    $theme_colors = wp_get_global_settings(['color', 'palette']);

    // Check if there are colors in the palette
    if (!empty($theme_colors['theme'])) {
        $colors = $theme_colors['theme'];

        // Loop through each color in the palette and add to ACF color picker
        $choices = [];
        foreach ($colors as $color) {
            $choices[$color['color']] = $color['name']; // Color code and label
        }

        // Populate the color picker field choices
        $field['choices'] = $choices;
    }

    return $field;
}

// Hook the function to ACF color picker field (adjust 'your_color_picker_field' with the actual field name)
add_filter('acf/load_field/name=global_color_picker', 'populate_acf_color_picker_from_theme_json');

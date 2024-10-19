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
function my_custom_admin_styles() {
    echo '<style>

        .acf-flexible-content .layout:nth-child(odd) {
            background-color: #f9f9f9;
        }


    </style>';
}
add_action('admin_head', 'my_custom_admin_styles');
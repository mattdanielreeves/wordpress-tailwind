<?php

/**
 * Main Content
 */

// $data is what we're going to expose to our render template
$data = array(
  'test_field' => get_field('test_field'),

);

// Dynamic block ID
$block_id = 'main-content-' . $block['id'];


// Check if a custom ID is set in the block editor
if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

// Block classes
$class_name = 'main-content-block';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}

// Block alignment
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Block text alignment
if (!empty($block['alignText'])) {
  $class_name .= ' has-text-align-' . $block['alignText'];
}

if (! empty($block['fullHeight'])) {
  $class_name .= ' is-full-height';
}

if ($block['supports']['alignContent'] == 'matrix') {
  // If matrix
  // Replace spaces: center left becomes center-left
  $class_name = ' has-custom-content-position  is-position-' . str_replace(" ", "-", $block['alignContent']);
} else {
  // If not matrix, get the alignContent
  // either top, center, or bottom
  $class_name = ' is-vertically-aligned-' . $block['alignContent'];
}



// Set the background color classnames
if (! empty($block['backgroundColor'])) {
  $class_name .= ' has-background';
  $class_name .= ' has-' . $block['backgroundColor'] . '-background-color';
}

// Set the text color classnames
if (! empty($block['textColor'])) {
  $class_name .= ' has-text-color';
  $class_name .= ' has-' . $block['textColor'] . '-color';
}

/** 
 * Pass the block data into the template part
 */
get_template_part(
  'blocks/main-content/template',
  null,
  array(
    'block'      => $block,
    'is_preview' => $is_preview,
    'post_id'    => $post_id,
    'data'       => $data,
    'class_name' => $class_name,
    'block_id'   => $block_id,
  )
);

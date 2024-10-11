<?php

/**
 * Functions for ACF
 *
 */

/** Register ACF Blocks */

function mdr_register_acf_blocks()
{
  register_block_type(get_stylesheet_directory() . '/blocks/main-content');
}

add_action('init', 'mdr_register_acf_blocks');

/**
 * 
 * Spacing Helper Function
 */

function get_block_styles($attributes)
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

<?php

// Helper functions

if (!function_exists('display_text_or_text_area')) {
  function display_text_or_text_area($lines, $text, $text_area)
  {
    return $lines ? $text_area : $text;
  }
}

if (!function_exists('get_html_tag')) {
  function get_html_tag($tag)
  {
    $allowed_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p'];
    return in_array($tag, $allowed_tags) ? $tag : 'div';
  }
}

if (!function_exists('get_button_markup')) {
  function get_button_markup($button, $style, $text, $class, $text_color, $lines, $text_area)
  {
    if ($lines) {
      return ''; // No button if $lines is true
    }
    if ($button) {
      $url = $button['url'];
      $target = $button['target'] ? $button['target'] : '_self';
      $display_text = $lines ? $text_area : $text;
      return "<a href=\"$url\" target=\"$target\" class=\"$class $text_color $style absolute inset-0 w-full h-full flex items-center justify-center\">$display_text</a>";
    }
    return '';
  }
}
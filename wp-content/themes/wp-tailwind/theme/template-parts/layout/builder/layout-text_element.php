<?php
/**
 * Template part for displaying the text component
 *
 */

// Helper functions
if (!function_exists('get_acf_field')) {
  function get_acf_field($field_name)
  {
    return get_sub_field($field_name);
  }
}

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
      return "<a href=\"$url\" target=\"$target\" class=\"$class $text_color absolute inset-0 w-full h-full flex items-center justify-center\">$display_text</a>";
    }
    return '';
  }
}

// Fetch ACF fields
$lines = get_acf_field('lines');
$text = get_acf_field('text');
$text_area = get_acf_field('text_area');
$html_tag = get_acf_field('html_tag');
$button = get_acf_field('button');
$style = get_acf_field('style');
$class = get_acf_field('class'); // Fetch class separately
$background_color_data = get_sub_field('background_color');
$background = isset($background_color_data['global_color_picker'])
  ? esc_attr($background_color_data['global_color_picker'])
  : 'bg-gray-100';// Fetch background color

$text_color_data = get_sub_field('text_color');
$text_color = isset($text_color_data['text_color_global_color_picker'])
  ? esc_attr($text_color_data['text_color_global_color_picker'])
  : 'text-gray-100';// Fetch text color

// Determine content
$content = display_text_or_text_area($lines, $text, $text_area);
$tag = get_html_tag($html_tag);
$button_markup = get_button_markup($button, $style, $text, $class, $text_color, $lines, $text_area);
?>

<<?php echo $tag; ?> style="background-color: <?php echo $background; ?>;" class="
  <?php echo esc_attr($class); ?> <?php echo esc_attr($args['width'] ?? ''); ?> <?php echo $text_color; ?> items-center
  relative flex p-8">
  <?php if (!$button_markup) {
    echo '<span>' . $content . '</span>';
  } ?>
  <?php if ($button_markup) {
    echo $button_markup;
  } ?>
</<?php echo $tag; ?>>
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
  function get_button_markup($button, $style)
  {
    if ($button) {
      $url = $button['url'];
      $title = $button['title'];
      $target = $button['target'] ? $button['target'] : '_self';
      $class = isset($button['class']) ? $button['class'] : '';
      return "<a href=\"$url\" target=\"$target\" class=\"$class\">$title</a>";
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
$class = $args['class'];
$background_color_data = get_sub_field('background_color');
$background = isset($background_color_data['global_color_picker'])
  ? esc_attr($background_color_data['global_color_picker'])
  : 'bg-gray-100';// Fetch background color

$text_color_data = get_sub_field('text_color');
$text_color = isset($text_color_data['text_color_global_color_picker'])
  ? esc_attr($text_color_data['text_color_global_color_picker'])
  : 'bg-gray-100';// Fetch text color

// Determine content
$content = display_text_or_text_area($lines, $text, $text_area);
$tag = get_html_tag($html_tag);
$button_markup = get_button_markup($button, $style);
?>

<<?php echo $tag; ?> style="background-color: <?php echo $background; ?>;"" class="
  <?php echo esc_attr($class); ?> <?php echo esc_attr($args['width'] ?? ''); ?>">
  <?php echo $content; ?>
</<?php echo $tag; ?>>
<?php echo $button_markup; ?>
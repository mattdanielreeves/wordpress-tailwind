<?php
/**
 * Template part for displaying the text component
 *
 */

// Fetch ACF fields
$lines = get_sub_field('lines');
$text = get_sub_field('text');
$text_area = get_sub_field('text_area');
$html_tag = get_sub_field('html_tag');
$button = get_sub_field('button');
$style = get_sub_field('style');
$class = get_sub_field('class'); // Fetch class separately
$background_color_data = get_sub_field('background_color');
$background = isset($background_color_data['global_color_picker'])
  ? esc_attr($background_color_data['global_color_picker'])
  : 'bg-gray-100';// Fetch background color

$text_color_data = get_sub_field('text_color');
$text_color = isset($text_color_data['global_color_picker'])
  ? esc_attr($text_color_data['global_color_picker'])
  : 'text-gray-100';// Fetch text color

// Determine content
$content = display_text_or_text_area($lines, $text, $text_area);
$tag = get_html_tag($html_tag);
$button_markup = get_button_markup($button, $style, $text, $class, $text_color, $lines, $text_area);
?>

<<?php echo $tag; ?> style="background-color: <?php echo $background; ?>;"
  class="
  <?php echo esc_attr($class); ?> <?php echo esc_attr($args['width'] ?? ''); ?> items-center
  relative flex p-8 bg-[<?php echo $background; ?>] text-[<?php echo $text_color; ?>]">

  <?php if (!$button_markup) {
    echo '<span>' . $content . '</span>';
  } ?>
  <?php if ($button_markup) {
    echo $button_markup;
  } ?>
</<?php echo $tag; ?>>
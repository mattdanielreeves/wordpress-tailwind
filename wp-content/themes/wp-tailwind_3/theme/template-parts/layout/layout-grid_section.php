<?php
/**
 * Template part for displaying the main builder component
 *
 */

$type = $args['type'] ?? null;
$vertical = get_sub_field('content_position');
$sticky = get_sub_field('sticky');

$background_color_data = get_sub_field('background_color');
$background = isset($background_color_data['global_color_picker'])
  ? esc_attr($background_color_data['global_color_picker'])
  : 'bg-gray-100';// Fetch background color
$custom_class = get_sub_field('class');
?>

<div style="background-color:<?php echo $background; ?>"
  class="main-container mx-auto w-full <?php echo esc_attr($args['width'] ?? ''); ?> <?php echo $vertical; ?> <?php echo esc_attr($custom_class ?? ''); ?>"
  <?php if ($sticky): ?> x-data="{ isSticky: false }" x-init="() => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.isSticky = !entry.isIntersecting;
                });
            });
            observer.observe($el);
        }" :class="{ 'sticky': isSticky }" <?php endif; ?>>

  <?php
  global $blockNumber;
  $blockNumber = 0;

  if (have_rows('components')):

    while (have_rows('components')):
      the_row();

      $blockNumber++;
      $template_name = get_row_layout();
      $width_class = get_width_class();

      if ($type) {
        get_template_part('template-parts/layout/builder/layout', $template_name, array(
          'count' => $blockNumber,
          'name' => $template_name,
          'width' => $width_class,
          'type' => $type,
          'class' => $custom_class,
        ));
      } else {
        get_template_part('template-parts/layout/builder/layout', $template_name, array(
          'count' => $blockNumber,
          'name' => $template_name,
          'width' => $width_class,
          'class' => $custom_class,
        ));
      }

    endwhile;
  endif;
  ?>


</div>
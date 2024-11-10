<?php
/**
 * Template part for displaying the main builder component
 *
 */

$navigation_type = $args['type'];
$background_color_data = get_sub_field('background_color');
$background = isset($background_color_data['global_color_picker'])
  ? esc_attr($background_color_data['global_color_picker'])
  : 'bg-gray-100';// Fetch background color
$custom_class = get_sub_field('class');
?>
<div style="background-color:<?php echo $background; ?>"
  class="grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto w-full items-center <?php echo esc_attr($args['width'] ?? ''); ?>">
  <div
    class="grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto w-full col-span-12 items-center <?php echo esc_attr($custom_class ?? ''); ?>">
    <?php
    global $blockNumber;
    $blockNumber = 0;

    if (have_rows('components')):
      while (have_rows('components')):
        the_row();

        $blockNumber++;
        $template_name = get_row_layout();
        $width_class = get_width_class();


        get_template_part('template-parts/layout/builder/layout', $template_name, array(
          'count' => $blockNumber,
          'name' => $template_name,
          'width' => $width_class,
          'type' => $navigation_type,
          'class' => $custom_class,
        ));

      endwhile;

    endif;
    ?>

  </div>
</div>
<?php
/**
 * Template part for displaying the main builder component
 *
 */
?>
<div class="grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto">
  <?php
  global $blockNumber;
  $blockNumber = 0;

  if ($blocks = get_field('page_builder', 'option')['builder']):
    while (have_rows('builder', 'option')):
      the_row();
      $blockNumber++;
      $width_class = get_width_class();
      $template_name = get_row_layout();

      get_template_part('template-parts/layout/builder/layout', get_row_layout(), array(
        'count' => $blockNumber,
        'name' => $template_name,
        'width' => $width_class,
        'type' => $navigation_type,
      ));
    endwhile;
  endif;
  ?>

</div>
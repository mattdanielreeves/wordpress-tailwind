<?php
/**
 * Template part for displaying the navigation header component.
 */

// Helper functions to keep the template organized

$vertical = get_sub_field('content_position');

// Main navigation wrapper
if (have_rows('menu_wrapper')): ?>
  <nav class="main-navigation <?php echo esc_attr($args['width']); ?> <?php echo $vertical; ?>">
    <ul class="flex space-x-4">
      <?php
      // Loop through each repeater item in menu_wrapper
      while (have_rows('menu_wrapper')):
        the_row();
        $menu_item = get_sub_field('parent');
        if (is_array($menu_item)) {
          render_menu_item($menu_item, $args);
        }
      endwhile;
      ?>
    </ul>
  </nav>
<?php endif; ?>
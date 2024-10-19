<?php
/**
 * Template part for displaying the navigation header component
 *
 */
// Get the navigation type from the 'navigation_type' subfield
$navigation_type = get_sub_field('navigation_type');
?>
<div class="<?php echo esc_attr($args['width']); ?>">
<?php
    if($navigation_type == 'basic') {
      // Get the relationship field array from the 'navigation' subfield inside the 'navigation_options' group
      $navigation = get_sub_field('header_navigation');

      if ($navigation) {
      echo '<nav class="h-full" aria-label="Main Navigation"><ul class="flex h-full justify-center flex-wrap content-center" role="menubar">';
  
      $counter = 1; // Initialize the counter
  
      foreach ($navigation as $post) {
          // Setup post data
          setup_postdata($post);
  
          // Get the post permalink
          $url = get_permalink($post->ID);
  
          // Get the post title
          $title = get_the_title($post->ID);
  
          // Determine if this is the current page
          $current_class = (is_singular() && get_queried_object_id() == $post->ID) ? 'current-menu-item' : '';
  
          // Output the menu item with the counter class
          echo '<li class="h-auto max-h-fit ' . esc_attr($current_class) . ' menu-item-' . $counter . '" role="none">';
          echo '<a href="' . esc_url($url) . '" role="menuitem">' . esc_html($title) . '</a>';
          echo '</li>';
  
          $counter++; // Increment the counter
      }
  
      // Reset post data
      wp_reset_postdata();
  
      echo '</ul></nav>';
      }
    }
    if($navigation_type == 'standard') {
      if( have_rows('standard_menu', 'option') ):
          echo '<nav class="h-full" aria-label="Main Navigation"><ul class="flex h-full justify-center flex-wrap content-center" role="menubar">';
          while ( have_rows('standard_menu', 'option') ) : the_row();
              $parent_menu_item = get_sub_field('parent');
              if (is_array($parent_menu_item)) {
                  $url = esc_url($parent_menu_item['url']);
                  $title = esc_html($parent_menu_item['title']);
                  $current_class = (get_permalink() == $url) ? 'current-menu-item' : '';
                  echo '<li class="group relative ' . $current_class . '"><a href="' . $url . '">' . $title . '</a>';
                  
                  // Check for submenu items
                  $submenu_items = get_sub_field('submenu');
                  if ($submenu_items) {
                      echo '<ul class="submenu absolute left-0 hidden group-hover:block bg-white shadow-lg min-w-max">';
                      foreach ($submenu_items as $submenu_item) {
                          $submenu_url = get_permalink($submenu_item->ID);
                          $submenu_title = get_the_title($submenu_item->ID);
                          $submenu_current_class = (is_page($submenu_item->ID) || is_single($submenu_item->ID)) ? 'current-menu-item' : '';
                          echo '<li class="' . $submenu_current_class . '"><a href="' . esc_url($submenu_url) . '" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">' . esc_html($submenu_title) . '</a></li>';
                      }
                      echo '</ul>';
                  }
                  
                  echo '</li>';
              }
          endwhile;
          echo '</ul></nav>';
      endif;
    }

?>
</div>
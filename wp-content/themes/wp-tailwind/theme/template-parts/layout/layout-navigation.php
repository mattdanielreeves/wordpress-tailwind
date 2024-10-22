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
    
    if($navigation_type == 'standard') {
      if( have_rows('standard_menu', 'option') ):
          echo '<nav class="h-full" aria-label="Main Navigation"><ul class="flex h-full justify-center flex-wrap content-center" role="menubar">';
          while ( have_rows('standard_menu', 'option') ) : the_row();
              $parent_menu_item = get_sub_field('parent');
              if (is_array($parent_menu_item)) {
                  $url = esc_url($parent_menu_item['url']);
                  $title = esc_html($parent_menu_item['title']);
                  $current_class = (get_permalink() == $url) ? 'current-menu-item' : '';
                  $enable_submenu = get_sub_field('enable_submenu');
                  echo '<li class="group relative ' . $current_class . '" role="none"><a href="' . $url . '" role="menuitem" aria-haspopup="' . ($enable_submenu ? 'true' : 'false') . '" aria-expanded="false">' . $title . '</a>';
                  
                  if ($enable_submenu) {
                      echo '<span class="caret inline-block ml-2 transform transition-transform duration-300 group-hover:rotate-180">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                              </svg>
                            </span>';
                      
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
                  }
                  
                  echo '</li>';
              }
          endwhile;
          echo '</ul></nav>';
      endif;
    }
    if($navigation_type == 'mega_menu') {
        if ($blocks = get_field('mega_menu')):
            while (have_rows('mega_menu')): the_row();
              $blockNumber++;
              $width_clone = get_sub_field('width');
              $width = $width_clone['global_container_width'];
          
              $width_classes = [
                  'quarter' => 'col-span-1',
                  'half' => 'col-span-2',
                  'three-quarters' => 'col-span-3',
                  'full' => 'col-span-4',
              ];
              
              $width_class = $width_classes[$width] ?? '';
              $template_name = get_row_layout();
          
              get_template_part('template-parts/layout/mega-menu/layout', get_row_layout(), array(
                  'count' => $blockNumber,
                  'name' => $template_name,
                  'width' => $width_class,
              ));
            endwhile;
          endif;
    }

?>
</div>
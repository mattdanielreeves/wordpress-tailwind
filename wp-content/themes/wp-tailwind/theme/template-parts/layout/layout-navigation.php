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

    if ($navigation_type == 'standard') {
        if (have_rows('standard_menu', 'option')):
            echo '<nav class="h-full" aria-label="Main Navigation"><ul class="flex h-full justify-center flex-wrap content-center" role="menubar">';
            while (have_rows('standard_menu', 'option')):
                the_row();
                $parent_menu_item = get_sub_field('parent');
                if (is_array($parent_menu_item)) {
                    $url = esc_url($parent_menu_item['url']);
                    $title = esc_html($parent_menu_item['title']);
                    $current_class = (get_permalink() == $url) ? 'current-menu-item' : '';
                    $enable_submenu = get_sub_field('enable_submenu');
                    echo '<li class="group relative ' . $current_class . '" role="none"><a href="' . $url . '" tabindex="0" role="menuitem" aria-haspopup="' . ($enable_submenu ? 'true' : 'false') . '" aria-expanded="false">' . $title . '</a>';

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
                                echo '<li class="' . $submenu_current_class . '" tabindex="0"><a href="' . esc_url($submenu_url) . '" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">' . esc_html($submenu_title) . '</a></li>';
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
    if ($navigation_type == 'mega') {
        if (have_rows('standard_menu', 'option')):
            echo '<nav class="h-full grid content-center" aria-label="Main Navigation"><ul class="flex group/ul justify-center gap-0 flex-wrap content-center max-w-fit mx-auto h-full" role="menubar">';

            while (have_rows('standard_menu', 'option')):
                the_row();
                $background_color = get_sub_field('background_color') ?? 'bg-gray-100';
                $parent_menu_item = get_sub_field('parent');
                if (is_array($parent_menu_item)) {
                    $url = esc_url($parent_menu_item['url']);
                    $title = esc_html($parent_menu_item['title']);
                    $current_class = (get_permalink() == $url) ? 'current-menu-item' : '';
                    echo '<li x-data="{ isOpen: false, timeout: null }"
                    @mouseenter="isOpen = true; clearTimeout(timeout)"
                    @mouseleave="timeout = setTimeout(() => { isOpen = false }, 300)"
                    class="main-menu-item group ' . $current_class . ' z-10" tabindex="0" role="none">' . $title;

                    // Check if `mega_menu` layouts exist
                    if (have_rows('mega_menu')):
                        echo '<span class="caret inline-block ml-2 transition-transform duration-300 group-hover:rotate-180">';
                        echo '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                        echo '</span>';

                        // Render each layout inside `mega_menu`
                        echo '<div x-show="isOpen" x-transition:enter="transition ease-in-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-y-0 -translate-y-1/2"
                            x-transition:enter-end="opacity-100 transform scale-y-100 translate-y-0"
                            x-transition:leave="transition ease-in-out duration-300"
                            x-transition:leave-start="opacity-100 transform scale-y-100 translate-y-0"
                            x-transition:leave-end="opacity-0 transform scale-y-0 -translate-y-1/2"
                            class="min-h-[60vh] g absolute left-0 right-0 top-52 w-full ' . $background_color . ' py-10 z-10">';
                        echo '<div class="relative grid grid-cols-4 grid-flow-row auto-rows-auto auto-cols-fr max-w-screen-xl h-full mx-auto p-6">';

                        while (have_rows('mega_menu')):
                            the_row();
                            $width_clone = get_sub_field('width');
                            $width = $width_clone['global_container_width'];
                            $width_classes = [
                                'quarter' => 'col-span-1',
                                'half' => 'col-span-2',
                                'three-quarters' => 'col-span-3',
                                'full' => 'col-span-4',
                            ];
                            $width_class = $width_classes[$width] ?? '';

                            // Set sub-template variables
                            $sub_template_name = get_row_layout();
                            $heading = get_sub_field('heading');
                            $description = get_sub_field('description');

                            // Include the template part for each layout
                            get_template_part('template-parts/layout/mega-menu/layout', $sub_template_name, array(
                                'name' => $sub_template_name,
                                'width' => $width_class,
                                'heading' => $heading,
                                'description' => $description,
                            ));
                        endwhile;
                        echo '</div>';
                        echo '</div>';
                    endif;

                    echo '</li>';
                }
            endwhile;

            echo '</ul></nav>';
        endif;
    }

    ?>
</div>
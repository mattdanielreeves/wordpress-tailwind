<?php
/**
 * Template part for displaying the navigation header component
 *
 */
// Get the navigation type from the 'navigation_type' subfield

?>
<div class="<?php echo esc_attr($args['width'] ?? ''); ?>">

    <?php

    if (have_rows('standard_menu', 'option')):

        $nav_classes = $args['type'] ? 'content-center' : 'content-end';
        $ul_classes = $args['type'] ? 'flex-col' : '';

        echo '<nav class="h-full grid ' . $nav_classes . '" aria-label="Main Navigation"><ul class="flex group/ul justify-center gap-0 ' . $ul_classes . ' max-w-fit mx-auto h-full" role="menubar">';

        while (have_rows('standard_menu', 'option')):
            the_row();
            $background_color = get_sub_field('background_color') ?? 'bg-gray-100';
            $parent_menu_item = get_sub_field('parent');
            if (is_array($parent_menu_item)) {
                $url = esc_url($parent_menu_item['url'] ?? '#');
                $title = esc_html($parent_menu_item['title'] ?? 'Untitled');
                $has_mega = !empty(get_sub_field('mega_menu')) ? 'hover:cursor-default' : '';
                $current_class = (get_permalink() == $url) ? 'current-menu-item' : '';
                $enable_submenu = get_sub_field('enable_submenu') ?? false;
                $menu_position = $enable_submenu ? 'relative z-50 ' : '';
                $main_class = !$args['type'] ? 'main-menu-item ' : 'p-4 text-5xl';
                ?>

                <?php echo '<li x-data="{ isOpen: false, timeout: null }"
                    @mouseenter="isOpen = true; clearTimeout(timeout)"
                    @mouseleave="timeout = setTimeout(() => { isOpen = false }, 300)"
                    @keydown.enter="isOpen = true; clearTimeout(timeout)"
                    @keydown.space="isOpen = true; clearTimeout(timeout)"
                    @keydown.esc="isOpen = false; clearTimeout(timeout)"
                    @focusin="isOpen = true"
                    @focusout.window="isOpen = false"
                    aria-haspopup="' . ($enable_submenu || $has_mega ? 'true' : 'false') . '"
                    class="' . $main_class . ' group ' . $current_class . ' ' . $menu_position . ' z-10 hover:z-50" role="none"><a class="' . $has_mega . '" tabindex="0" href="' . $url . '">' . $title . '</a>';

                // Check if `mega_menu` layouts exist
                if (!$args['type'] && have_rows('mega_menu') && !$enable_submenu):
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
                            class="h-full max-h-[60vh] absolute left-0 right-0 top-auto mt-4 w-full ' . $background_color . ' py-10 z-10">';

                    echo '<div class="relative grid grid-cols-12 grid-rows-3  max-w-screen-xl h-full mx-auto p-6">';

                    while (have_rows('mega_menu')):
                        the_row();
                        $width_class = get_width_class();

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

                // Display submenu if enabled
                if (!$args['type'] && $enable_submenu) {
                    $submenu = is_array(get_sub_field('submenu')) ? get_sub_field('submenu') : [];
                    ?>
                    <?php
                    if (!empty($submenu)) {
                        echo '<span class="caret inline-block ml-2 transform transition-transform duration-300 group-hover:rotate-180">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        </span>';
                        echo '<ul class="submenu absolute left-0 hidden group-hover:block group-focus-within:block bg-white shadow-lg min-w-max z-20">';

                        // Check if submenu is an array before iterating
                        foreach ($submenu as $submenu_item) {
                            $submenu_url = get_permalink($submenu_item->ID);
                            $submenu_title = get_the_title($submenu_item->ID);
                            $submenu_current_class = (is_page($submenu_item->ID) || is_single($submenu_item->ID)) ? 'current-menu-item' : '';
                            echo '<li class="' . $submenu_current_class . '" ><a tabindex="0" href="' . esc_url($submenu_url) . '" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">' . esc_html($submenu_title) . '</a></li>';
                        }
                    }

                    echo '</ul>';
                }

                echo '</li>';
            }
        endwhile;

        echo '</ul></nav>';
    endif;


    ?>
</div>
<?php
/**
 * Template part for displaying the navigation header component.
 */

// Helper functions to keep the template organized
function get_nav_classes($type)
{
    return $type ? 'content-center' : 'content-end';
}

function get_ul_classes($type)
{
    return $type ? 'flex-col' : '';
}

function render_menu_item($item, $args)
{
    // Get parent item details and background color
    $url = esc_url($item['url'] ?? '#');
    $title = esc_html($item['title'] ?? 'Untitled');
    $is_current = (get_permalink() == $url) ? 'current-menu-item' : '';
    $main_class = !$args['type'] ? 'main-menu-item ' : 'p-4 text-5xl text-white';
    $has_mega = !empty(get_sub_field('mega_menu')) ? 'hover:cursor-default' : '';
    $enable_submenu = get_sub_field('enable_submenu') ?? false;
    $menu_position = $enable_submenu ? 'relative z-50 ' : '';
    $background_color = esc_attr(get_sub_field('background_color') ?? 'bg-gray-100'); // Fetch background color

    // Render main menu item
    echo '<li x-data="{ isOpen: false, timeout: null }"
        @mouseenter="isOpen = true; clearTimeout(timeout)"
        @mouseleave="timeout = setTimeout(() => { isOpen = false }, 300)"
        @keydown.enter="isOpen = true; clearTimeout(timeout)"
        @keydown.space="isOpen = true; clearTimeout(timeout)"
        @keydown.esc="isOpen = false; clearTimeout(timeout)"
        @focusin="isOpen = true"
        @focusout.window="isOpen = false"
        aria-haspopup="' . ($enable_submenu || $has_mega ? 'true' : 'false') . '"
        class="' . $main_class . ' group ' . $is_current . ' ' . $menu_position . ' z-10 hover:z-50" role="none">
        <a class="' . $has_mega . '" tabindex="0" href="' . $url . '">' . $title . '</a>';

    // Render mega menu or submenu based on conditions
    if (have_rows('mega_menu') && !$args['type'] && !$enable_submenu) {
        render_mega_menu($background_color);
    }

    if ($enable_submenu) {
        render_submenu();
    }

    echo '</li>';
}

function render_mega_menu($background_color)
{
    // Render mega menu wrapper with background color
    echo '<span class="caret inline-block ml-2 transition-transform duration-300 group-hover:rotate-180">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </span>';
    echo '<div x-show="isOpen" x-transition:enter="transition ease-in-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-y-0 -translate-y-1/2"
            x-transition:enter-end="opacity-100 transform scale-y-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-300"
            x-transition:leave-start="opacity-100 transform scale-y-100 translate-y-0"
            x-transition:leave-end="opacity-0 transform scale-y-0 -translate-y-1/2"
            class="h-full max-h-[60vh] absolute left-0 right-0 top-auto mt-4 w-full ' . $background_color . ' py-10 z-10">';

    // Container for mega menu items
    echo '<div class="relative grid grid-cols-12 grid-rows-3 max-w-screen-xl h-full mx-auto p-6 ' . $background_color . '">';

    // Render each mega menu layout
    while (have_rows('mega_menu')) {
        the_row();
        $sub_template_name = get_row_layout();
        get_template_part('template-parts/layout/mega-menu/layout', $sub_template_name, array(
            'width' => get_width_class(),
            'heading' => get_sub_field('heading'),
            'description' => get_sub_field('description'),
        ));
    }
    echo '</div></div>';
}

function render_submenu()
{
    // Render submenu with caret and list items
    $submenu = get_sub_field('submenu') ?: [];
    if (!empty($submenu)) {
        echo '<span class="caret inline-block ml-2 transform transition-transform duration-300 group-hover:rotate-180">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </span>';
        echo '<ul class="submenu absolute left-0 hidden group-hover:block group-focus-within:block bg-white shadow-lg min-w-max z-20">';

        // Render submenu items
        foreach ($submenu as $submenu_item) {
            $submenu_url = get_permalink($submenu_item->ID);
            $submenu_title = get_the_title($submenu_item->ID);
            $submenu_current_class = (is_page($submenu_item->ID) || is_single($submenu_item->ID)) ? 'current-menu-item' : '';
            echo '<li class="' . $submenu_current_class . '">
                    <a tabindex="0" href="' . esc_url($submenu_url) . '" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">' . esc_html($submenu_title) . '</a>
                  </li>';
        }
        echo '</ul>';
    }
}

?>

<div class="<?php echo esc_attr($args['width'] ?? ''); ?>">
    <?php if (have_rows('standard_menu', 'option')): ?>
        <?php
        $nav_classes = get_nav_classes($args['type']);
        $ul_classes = get_ul_classes($args['type']);
        ?>
        <nav class="h-full grid <?php echo $nav_classes; ?>" aria-label="Main Navigation">
            <ul class="flex group/ul justify-center gap-0 <?php echo $ul_classes; ?> max-w-fit mx-auto h-full"
                role="menubar">
                <?php
                // Loop through standard menu items and render each
                while (have_rows('standard_menu', 'option')) {
                    the_row();
                    $parent_menu_item = get_sub_field('parent');
                    if (is_array($parent_menu_item)) {
                        render_menu_item($parent_menu_item, $args);
                    }
                }
                ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
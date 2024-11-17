<?php

// Menu Functions

if (!function_exists('get_nav_classes')) {
  function get_nav_classes($type)
  {
    return $type ? 'content-start' : 'content-end';
  }
}

if (!function_exists('render_menu_item')) {

  function render_menu_item($item, $args)
  {
    $navigation_type = $args['type'] ?? '';
    // Get parent item details and background color
    $url = esc_url($item['url'] ?? '#');
    $title = esc_html($item['title'] ?? 'Untitled');
    $is_current = (get_permalink() == $url) ? 'current-menu-item' : '';
    $main_class = !$navigation_type ? 'main-menu-item ' : 'main-menu-item text-white font-lato font-light';
    $has_mega = !empty(get_sub_field('mega_menu')) ? 'hover:cursor-default' : '';
    $enable_submenu = get_sub_field('enable_submenu') ?? false;
    $menu_position = $enable_submenu ? 'relative z-50 ' : '';
    $background_color_data = get_sub_field('background_color');
    $background_color = isset($background_color_data['global_color_picker'])
      ? esc_attr($background_color_data['global_color_picker'])
      : 'bg-gray-100';// Fetch background color

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
    if (have_rows('mega_menu') && !$enable_submenu) {
      render_mega_menu($background_color);
    }

    if ($enable_submenu) {
      render_submenu();
    }

    echo '</li>';
  }
}

if (!function_exists('render_mega_menu')) {
  function render_mega_menu($background_color)
  {
    echo '<span class="caret inline-block ml-2 transition-transform duration-300 group-hover:rotate-180">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </span>';
    echo '<div x-show="isOpen" x-transition:enter="transition ease-in-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-x-0 -translate-x-1/2"
            x-transition:enter-end="opacity-100 transform scale-x-100 translate-x-0"
            x-transition:leave="transition ease-in-out duration-300"
            x-transition:leave-start="opacity-100 transform scale-x-100 translate-x-0"
            x-transition:leave-end="opacity-0 transform scale-x-0 -translate-x-1/2"
            class="mega h-full max-h-[60vh] absolute left-0 right-0 top-auto w-full mt-2 py-10 z-10" style="background-color: ' . htmlspecialchars($background_color, ENT_QUOTES, 'UTF-8') . ';">';

    echo '<div class="relative grid grid-cols-12 grid-rows-3 max-w-screen-xl h-full mx-auto p-6 ">';

    while (have_rows('mega_menu')) {
      the_row();
      $sub_template_name = get_row_layout();
      get_template_part('template-parts/layout/builder/mega-menu/layout', $sub_template_name, array(
        'width' => get_width_class(),
        'heading' => get_sub_field('heading'),
        'description' => get_sub_field('description'),
        'class' => get_sub_field('tab_class'),
      ));
    }
    echo '</div></div>';
  }
}

if (!function_exists('render_submenu')) {
  function render_submenu()
  {
    $submenu = get_sub_field('submenu') ?: [];
    if (!empty($submenu)) {
      echo '<span class="caret inline-block ml-2 transform transition-transform duration-300 group-hover:rotate-180">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </span>';
      echo '<ul class="submenu absolute left-0 hidden group-hover:block group-focus-within:block bg-white shadow-lg min-w-max z-20 mt-2">';

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
}
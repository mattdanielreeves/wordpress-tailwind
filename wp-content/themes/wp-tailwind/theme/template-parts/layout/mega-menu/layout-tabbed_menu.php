<?php
$tabs = get_sub_field('tabs'); // Assuming 'tabs' is a repeater field with each tab's data
if ($tabs && is_array($tabs)):
  $first_tab_key = array_key_first($tabs);
  ?>

  <div x-data="{ activeTab: '<?php echo esc_attr($first_tab_key); ?>' }"
    class="<?php echo esc_attr($args['width'] ?? 'default-width'); ?> grid grid-cols-4 gap-4">

    <!-- Tab Buttons (Col-span-1) -->
    <div class="col-span-1 border-r border-gray-200">
      <?php foreach ($tabs as $key => $tab): ?>
        <?php
        $tab_label = isset($tab['tab_label']) ? esc_html($tab['tab_label']) : 'Default Tab';
        ?>
        <button @click="activeTab = '<?php echo esc_attr($key); ?>'"
          :class="{'bg-gray-100': activeTab === '<?php echo esc_attr($key); ?>'}"
          class="w-full text-left px-4 py-2 hover:bg-gray-100 focus:outline-none transition">
          <?php echo $tab_label; ?>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Tab Content (Col-span-3) -->
    <div class="col-span-3">
      <?php foreach ($tabs as $key => $tab): ?>
        <?php
        // Verify 'menu' and 'global_menu' exist to avoid undefined array key errors
        $menu_items = isset($tab['tabbed_menu']['global_menu']) ? $tab['tabbed_menu']['global_menu'] : null;
        ?>
        <div x-show="activeTab === '<?php echo esc_attr($key); ?>'" x-cloak>
          <?php if ($menu_items): ?>
            <ul>
              <?php foreach ($menu_items as $menu_item): ?>
                <li>
                  <a href="<?php echo esc_url(get_permalink($menu_item->ID)); ?>"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <?php echo esc_html(get_the_title($menu_item->ID)); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="px-4 py-2 text-gray-500">No items available for this tab.</p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
<?php endif; ?>
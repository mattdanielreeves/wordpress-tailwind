<?php

$tabs = get_sub_field('tabs');
$description = get_sub_field('description');

if ($tabs && is_array($tabs)):
  $first_tab_key = array_key_first($tabs);

  ?>
  <div x-data="{ activeTab: '<?php echo esc_attr($first_tab_key); ?>' }"
    class="<?php echo esc_attr($args['width']); ?> grid grid-cols-4 gap-4 ">

    <!-- Tab Buttons (Col-span-1) -->
    <div class="col-span-1 border-r border-gray-200" role="tablist" aria-label="Tabbed Navigation">
      <?php foreach ($tabs as $key => $tab): ?>
        <?php
        $tab_label = isset($tab['tab_label']) ? esc_html($tab['tab_label']) : 'Default Tab';
        $tab_class = esc_attr($args['class']);
        ?>

        <button @mouseover="activeTab = '<?php echo esc_attr($key); ?>'"
          @keydown.enter.prevent="activeTab = '<?php echo esc_attr($key); ?>'"
          @keydown.space.prevent="activeTab = '<?php echo esc_attr($key); ?>'"
          :aria-selected="activeTab === '<?php echo esc_attr($key); ?>'"
          :tabindex="activeTab === '<?php echo esc_attr($key); ?>' ? 0 : 0" :class="{
          'bg-gray-100 font-semibold text-blue-600': activeTab === '<?php echo esc_attr($key); ?>',
          'focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2': true
          }" class="w-full text-left px-4 py-2 hover:bg-gray-100 transition <?php echo $tab_class; ?>" role="tab"
          id="tab-<?php echo esc_attr($key); ?>" aria-controls="tabpanel-<?php echo esc_attr($key); ?>">

          <?php echo $tab_label; ?>
        </button>
      <?php endforeach; ?>
      <div><?php echo $description; ?></div>
    </div>

    <!-- Tab Content (Col-span-3) -->
    <div class="col-span-3">
      <?php foreach ($tabs as $key => $tab): ?>
        <?php
        $menu_items = $tab['tabbed_menu']['global_menu'];
        $tab_class = isset($tab['tab_class']) ? esc_attr($tab['tab_class']) : '';
        ?>

        <div x-show="activeTab === '<?php echo esc_attr($key); ?>'" x-cloak role="tabpanel" tabindex="-1"
          id="tabpanel-<?php echo esc_attr($key); ?>" aria-labelledby="tab-<?php echo esc_attr($key); ?>"
          class="p-4 <?php echo $tab_class; ?>">

          <?php if ($menu_items): ?>
            <ul class="<?php echo esc_attr($args['width']); ?> flex flex-wrap w-full">
              <?php foreach ($menu_items as $menu_item): ?>
                <li class="w-1/5">
                  <a href="<?php echo esc_url(get_permalink($menu_item->ID)); ?>"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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
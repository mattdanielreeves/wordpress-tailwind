<?php

$tabs = get_sub_field('tabs');
$description = get_sub_field('description');
$button = get_sub_field('button');
$button_style = get_sub_field('button_style')['style'];

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
      <div class="mt-4 text-xl p-2"><?php echo $description;
      if ($button): ?>
          <div><?php $button_url = $button['url'];
          $button_title = $button['title'];
          $button_target = $button['target'] ? $button['target'] : '_self';
          ?>
            <a class="inline-block <?php echo $button_style; ?>" href="<?php echo esc_url($button_url); ?>"
              target="<?php echo esc_attr($button_target); ?>">
              <?php echo esc_html($button_title); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>

    </div>

    <!-- Tab Content (Col-span-3) -->
    <div class="grid col-span-3">
      <?php foreach ($tabs as $key => $tab):
        // Retrieve and format the image data manually
        $image_data = null;
        if (!empty($tab['image']['id'])) {
          $image_id = $tab['image']['id'];

          // Get the URL, alt text, and other metadata
          $image_src = wp_get_attachment_image_src($image_id, 'full');
          $image_url = $image_src[0] ?? '';
          $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

          // Default alt text to file name if none is set
          if (empty($alt_text)) {
            $path_parts = pathinfo($image_url);
            $alt_text = $path_parts['filename'];
          }

          // Get dimensions and aspect ratio
          $metadata = wp_get_attachment_metadata($image_id);
          $width = $metadata['width'] ?? '';
          $height = $metadata['height'] ?? '';
          $aspect_ratio = ($width && $height) ? calculateAspectRatio($width, $height) : '1 / 1';

          $image = [
            'id' => $image_id,
            'url' => $image_url,
            'alt' => $alt_text,
            'top' => $tab['image']['top'] ?? 50,
            'left' => $tab['image']['left'] ?? 50,
            'width' => $width,
            'height' => $height,
            'aspect_ratio' => $aspect_ratio,
          ];
        }
        $menu_items = $tab['tab_menu']['global_menu'];
        $tab_class = isset($tab['tab_class']) ? esc_attr($tab['tab_class']) : '';
        ?>

        <div x-show="activeTab === '<?php echo esc_attr($key); ?>'" x-cloak role="tabpanel" tabindex="-1"
          id="tabpanel-<?php echo esc_attr($key); ?>" aria-labelledby="tab-<?php echo esc_attr($key); ?>"
          class="col-span-12 md:col-span-6 lg:col-span-3 bg-white rounded-xl row-span-3 p-6 relative grid h-full w-full <?php echo $tab_class; ?>">
          <?php
          if ($image): ?>

            <div class="mb-4 relative overflow-hidden w-full col-span-3 flex flex-wrap max-h-[30vh]" style="">
              <img src="<?php echo esc_url($image['url']); ?>"
                style="object-fit: cover; object-position: <?php echo esc_attr($image['left']) . '% ' . esc_attr($image['top']); ?>%; width:100%; height:100%;" />
            </div>

          <?php endif; ?>
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
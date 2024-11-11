<?php
/**
 * Template part for displaying the header content
 *
 * @package wp-tailwind
 */

$navigation_type = get_field('always_mobile', 'header');
$always_mobile_settings = get_field('always_mobile_settings', 'header');

// Helper functions
function get_background_style($settings)
{
	$background_type = $settings['background'] ?? '';
	$background_image = $settings['background_image'] ?? null;
	$background_color = $settings['background_color']['global_color_picker'] ?? '';

	$background_style = '';

	switch ($background_type) {
		case 'color':
			// Set background color
			$background_style = "background-color: $background_color;";
			break;
		case 'image':
			// Set background image
			if (is_array($background_image) && isset($background_image['id'])) {
				$background_url = wp_get_attachment_url($background_image['id']);
				if ($background_url) {
					$background_style = "background-image: url('" . esc_url($background_url) . "'); background-size: cover;";
					if (isset($background_image['top']) && isset($background_image['left'])) {
						$background_style .= " background-position: " . esc_attr($background_image['left']) . "% " . esc_attr($background_image['top']) . "%;";
					}
				}
			} else {
				$background_url = $background_image['url'] ?? '';
				$background_style = "background-image: url('" . esc_url($background_url) . "'); background-size: cover;";
			}
			break;
		// Add other cases as needed
	}

	return $background_style;
}

function get_animation_class()
{
	// Retrieve the selected value from the always_mobile_settings group
	$position = get_field('always_mobile_settings', 'header')['animation']; // Replace 'select_field_name' with the actual field name

	// Define an array that maps each position to a Tailwind translate class
	$translate_classes = [
		'top' => '-translate-y-[100vh]',    // Slide in from the top
		'right' => 'translate-x-[100vw]',   // Slide in from the right
		'bottom' => 'translate-y-[100vh]',  // Slide in from the bottom
		'left' => '-translate-x-[100vw]',   // Slide in from the left
	];

	// Return the corresponding class or a default if none matches
	return isset($translate_classes[$position]) ? $translate_classes[$position] : '';
}

function render_site_logo()
{
	$site_logo = get_field('mdr_logo', 'option');
	if ($site_logo) {
		echo '<img :class="{\'brightness-0 invert transition delay-300\': open}" class="logo" src="' . esc_url($site_logo['url']) . '" alt="' . esc_attr($site_logo['alt']) . '" />';
	}
}

function render_hamburger_button()
{
	echo '<button
    @click="open = !open; document.body.classList.toggle(\'overflow-hidden\', open)" class="hamburger-button fixed top-0 right-0 z-50"
        @keydown.window.escape="open = false; document.body.classList.remove(\'overflow-hidden\')"
            x-data x-init="$el.classList.add(\'slide-fade-in\')">
            <div :class="{\'open\': open}" class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
          </button>';
}

function render_inner_header_classes($navigation_type)
{
	return $navigation_type ? 'transform transition-all duration-700 ease-in-out fixed left-0 right-0 top-0 bottom-0 before:absolute before:top-0 before:h-full before:w-full before:bottom:0 before:left-0 before:right-0 before:bg-black before:opacity-70' : 'max-w-screen-xl';
}

?>

<header id="header" class="flex flex-col justify-end " <?php if ($navigation_type): ?> x-data="{ open: false }" <?php endif; ?>>

	<?php if ($navigation_type): ?>
		<?php
		$background_style = get_background_style($always_mobile_settings);
		?>

		<div class="always-mobile flex justify-between">
			<div class="max-w-xs">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<?php render_site_logo(); ?>
				</a>
			</div>

			<?php render_hamburger_button(); ?>
		</div>
	<?php endif; ?>
	<?php if ($navigation_type): ?>
		<div
			:class="{'opacity-0 <?php echo esc_attr(get_animation_class()); ?>': !open, 'opacity-100 translate-x-0 translate-y-0': open}"
			style="<?php echo esc_attr($background_style); ?>"
			class="inner-header bg-blend-lighten grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto <?php echo render_inner_header_classes($navigation_type); ?>">
		<?php endif; ?>
		<?php
		global $blockNumber;
		$blockNumber = 0;
		$post_id = isset($args['post_id']) ? $args['post_id'] : '';
		if ($blocks = get_field('builder', $post_id)): ?>
			<div class="grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto w-full col-span-12">
				<?php while (have_rows('builder', $post_id)):
					the_row();
					$blockNumber++;
					$width_class = get_width_class();
					$template_name = get_row_layout();

					get_template_part('template-parts/layout/layout', get_row_layout(), array(
						'count' => $blockNumber,
						'name' => $template_name,
						'width' => $width_class,
						'type' => $navigation_type,
					));
				endwhile; ?>
			</div>
		<?php endif; ?>

		<?php if ($navigation_type): ?>
		</div>

	<?php endif; ?>

</header>
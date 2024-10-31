<?php
/**
 * Template part for displaying the header content
 *
 * @package wp-tailwind
 */

$navigation_type = get_field('always_mobile', 'option');

// Helper functions

function get_background_image_style($settings)
{
	$background_image = $settings['background_image'];
	$background_url = $background_image['url'] ?? '';
	return $background_url ? "style=\"background-image: url('" . esc_url($background_url) . "'); background-size: cover;\"" : "";
}

function render_site_logo()
{
	$site_logo = get_field('mdr_logo', 'option');
	if ($site_logo) {
		echo '<img :class="{\'brightness-0 invert transition delay-300 fixed-logo\': open}" class="logo" src="' . esc_url($site_logo['url']) . '" alt="' . esc_attr($site_logo['alt']) . '" />';
	}
}

function render_hamburger_button()
{
	echo '<button
    @click="open = !open; document.body.classList.toggle(\'overflow-hidden\', open)" class="hamburger-button fixed top-0 right-0 z-50"
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
	return $navigation_type ? 'transform transition-all duration-700 ease-in-out fixed left-0 right-0 top-0 bottom-0 bg-red-900 p-20 before:absolute before:top-0 before:h-full before:w-full before:bottom:0 before:left-0 before:right-0 before:bg-black before:opacity-70' : 'max-w-screen-xl';
}

?>

<header id="header" class="flex flex-col justify-end " <?php if ($navigation_type): ?> x-data="{ open: false }" <?php endif; ?>>

	<?php if ($navigation_type): ?>
		<?php
		$always_mobile_settings = get_field('always_mobile_settings', 'option');
		$background_style = get_background_image_style($always_mobile_settings);
		?>

		<div class="always-mobile flex justify-between z-50">
			<div class="max-w-xs">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<?php render_site_logo(); ?>
				</a>
			</div>

			<?php render_hamburger_button(); ?>
		</div>
	<?php endif; ?>
	<?php if ($navigation_type): ?>
		<div :class="{'opacity-0 translate-x-[100vw]': !open, 'opacity-100 translate-x-0': open}" <?php echo $background_style; ?>
			class="inner-header bg-blend-lighten grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto <?php echo render_inner_header_classes($navigation_type); ?>">
		<?php endif; ?>
		<?php
		global $blockNumber;
		$blockNumber = 0;

		if ($blocks = get_field('header', 'option')):
			while (have_rows('header', 'option')):
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
			endwhile;
		endif;
		?>

		<?php if ($navigation_type): ?>
		</div>
	<?php endif; ?>

</header>
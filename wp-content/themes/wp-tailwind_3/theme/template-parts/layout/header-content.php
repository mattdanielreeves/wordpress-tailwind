<?php
/**
 * Template part for displaying the header content
 *
 * @package wp-tailwind
 */

$navigation_type = get_field('always_mobile', 'header');
$always_mobile_settings = get_field('always_mobile_settings', 'header');

$minimum_height = get_field('minimum_height', 'header')['footer_height'] ?? '';

?>

<header id="header" class="flex flex-col justify-end" <?php if ($navigation_type): ?> x-data="{ open: false }" <?php endif; ?> x-init="const updateMinHeight = () => {
				if (window.innerWidth >= 768) {
						$el.style.minHeight = '<?php echo $minimum_height; ?>';
				} else {
						$el.style.minHeight = '';
				}
		};
		updateMinHeight();
		window.addEventListener('resize', updateMinHeight);
">

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
			class="inner-header bg-blend-lighten grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto z-50 <?php echo render_inner_header_classes($navigation_type); ?> hidden"
			x-init="$el.classList.remove('hidden')">
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

	<?php if (!$navigation_type && $mobile_blocks = get_field('builder', 'mobile')): ?>
		<div x-data="{ open: false }" class="relative md:hidden">
			<!-- Hamburger Button (Always visible) -->
			<button @click="open = !open" class="hamburger-button p-4 bg-gray-800 text-white rounded fixed top-0 right-0 z-50">
				<div :class="{'open': open}" class="hamburger">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</button>

			<!-- Mobile Menu Content -->
			<div x-show="open" @click.away="open = false" @keydown.escape.window="open = false"
				x-transition:enter="transform transition-all ease-in-out duration-300" x-transition:enter-start="translate-x-full"
				x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-all ease-in-out duration-300"
				x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
				class="mobile-menu-content md:hidden grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto w-full col-span-12 fixed inset-0 bg-white z-40 shadow-lg overflow-auto">

				<?php while (have_rows('builder', 'mobile')):
					the_row(); ?>
					<?php
					$blockNumber++;
					$width_class = get_width_class();
					$template_name = get_row_layout();
					get_template_part('template-parts/layout/layout', get_row_layout(), array(
						'count' => $blockNumber,
						'name' => $template_name,
						'width' => $width_class,
						'type' => $navigation_type,
					));
					?>
				<?php endwhile; ?>

			</div>


		</div>

	<?php endif; ?>
</header>
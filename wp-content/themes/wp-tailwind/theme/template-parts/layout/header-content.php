<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-tailwind
 */
$navigation_type = get_field('always_mobile', 'option');

?>
<header id="header"
	class="flex flex-col justify-end <?php if ($navigation_type === true): ?>overflow-x-hidden<?php endif; ?>" <?php if ($navigation_type === true): ?>x-data="{ open: false }" <?php endif; ?>>
	<?php if ($navigation_type === true): ?>
		<div class="always-mobile flex justify-between z-50">
			<div class="max-w-xs">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="">
					<?php

					// Get the image array from the 'site_logo' subfield inside the 'branding' group
					$site_logo = get_field('mdr_logo', 'option');

					if ($site_logo) {
						// Extract the URL and alt text from the image array
						$site_logo_url = $site_logo['url'];
						$site_logo_alt = $site_logo['alt'];
						?>
						<img src="<?php echo esc_url($site_logo_url); ?>" alt="<?php echo esc_attr($site_logo_alt); ?>" />
						<?php
					}
					?>
				</a>
			</div>
			<!-- Hamburger Icon -->
			<button @click="open = !open" class="hamburger-button" x-data x-init="$el.classList.add('slide-fade-in')">
				<div :class="{'open': open}" class="hamburger">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</button>

		</div>
	<?php endif; ?>
	<div <?php if ($navigation_type === true): ?>:class="{'translate-x-[100vw]': !open, 'translate-x-0': open}" <?php endif; ?>
		class="inner-header grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr <?php if ($navigation_type != true): ?>max-w-screen-xl<?php endif; ?> mx-auto  <?php if ($navigation_type === true): ?>transform transition-transform duration-300 ease-in-out absolute left-0 right-0 top-0 bottom-0 bg-red-500 p-20<?php endif; ?>">
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

		<?php if ($navigation_type === true): ?>
		</div>
	<?php endif; ?>
</header>
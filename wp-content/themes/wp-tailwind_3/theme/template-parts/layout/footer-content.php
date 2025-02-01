<?php

/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-tailwind
 */
$footer_height = get_field('footer_height', 'footer');
$background_color = get_field('background_color', 'footer')['global_color_picker'];
?>

<footer style="background-color:<?php echo $background_color; ?>" id="colophon">

	<?php
	global $blockNumber;
	$blockNumber = 0;
	$post_id = isset($args['post_id']) ? $args['post_id'] : '';
	if ($blocks = get_field('builder', $post_id)): ?>
		<div <?php if ($footer_height) { ?>style="min-height:<?php echo $footer_height; ?>;" <?php } ?>class="grid grid-cols-12 grid-flow-row auto-rows-auto auto-cols-fr mx-auto w-full col-span-12">
			<?php while (have_rows('builder', $post_id)):
				the_row();
				$blockNumber++;
				$width_class = get_width_class();
				$template_name = get_row_layout();

				get_template_part('template-parts/layout/layout', get_row_layout(), array(
					'count' => $blockNumber,
					'name' => $template_name,
					'width' => $width_class,
				));
			endwhile; ?>
		</div>
	<?php endif; ?>

</footer><!-- #colophon -->
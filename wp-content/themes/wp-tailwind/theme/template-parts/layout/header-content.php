<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-tailwind
 */
?>


<header id="primary" class="grid grid-col-4 grid-flow-row auto-rows-auto auto-cols-fr">	
	<?php
			global $blockNumber;
			$blockNumber = 0;

			if ($blocks = get_field('header', 'option')):
				while (have_rows('header', 'option')): the_row();
					$blockNumber++;
					$width = get_sub_field('width');
	
					$width_classes = [
							'quarter' => 'col-span-1',
							'half' => 'col-span-2',
							'three-quarters' => 'col-span-3',
							'full' => 'col-span-4',
					];
					
					$width_class = $width_classes[$width] ?? '';
					$template_name = get_row_layout();

					get_template_part('template-parts/layout/layout', get_row_layout(), array(
							'count' => $blockNumber,
							'name' => $template_name,
							'width' => $width_class,
					));
				endwhile;
			endif;
			?>
		</header>


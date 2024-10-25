<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-tailwind
 */
 $announcements = get_field('announcements', 'option');
 $announcement = $announcements['text'];
 $bg_color = $announcements['background_custom_colors']["global_color_picker"];
 $link = $announcements['link'];
 $link_url = $link['url'] ?? '';
 $link_title = $link['title'] ?? '';
 $tag = $link_url ? 'a' : 'div';

 ?>
<header id="header" class="flex flex-col">

<div id="announcement-bar">

<<?php echo $tag; ?> href="<?php echo esc_url($link_url); ?>" style="background-color:<?php echo $bg_color; ?>" class="flex relative text-white px-4 py-2">
        <div class=""><?php echo esc_html($announcement); ?></div>
</<?php echo $tag; ?>>

</div>
	<div style="" class="grid grid-cols-4 grid-flow-row auto-rows-auto auto-cols-fr max-w-screen-xl mx-auto">
	<?php
			global $blockNumber;
			$blockNumber = 0;

			if ($blocks = get_field('header', 'option')):
				while (have_rows('header', 'option')): the_row();
					$blockNumber++;
					$width_clone = get_sub_field('width');
					$width = $width_clone['global_container_width'];
	
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
			</div>
		</header>


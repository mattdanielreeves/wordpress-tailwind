<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_tailwind
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		if (is_sticky() && is_home() && !is_paged()) {
			printf('<span">%s</span>', esc_html_x('Featured', 'post', 'wp_tailwind'));
		}
		if (is_singular()):
			the_title('<h1 class="entry-title">', '</h1>');
		else:
			the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
		endif;
		?>
	</header><!-- .entry-header -->

	<?php wp_tailwind_post_thumbnail(); ?>

	<div <?php wp_tailwind_content_class('entry-content'); ?>>
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div>' . __('Pages:', 'wp_tailwind'),
				'after' => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php wp_tailwind_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-${ID} -->
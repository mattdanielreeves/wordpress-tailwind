<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package wp_tailwind
 */

get_header();
?>

<section id="primary">
	<main id="main">

		<div>
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e('Page Not Found', 'wp_tailwind'); ?></h1>
			</header><!-- .page-header -->

			<div <?php wp_tailwind_content_class('page-content'); ?>>
				<p>
					<?php esc_html_e('This page could not be found. It might have been removed or renamed, or it may never have existed.', 'wp_tailwind'); ?>
				</p>
				<?php get_search_form(); ?>
			</div><!-- .page-content -->
		</div>

	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();

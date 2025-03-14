<?php
/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp-tailwind
 */
global $is_in_header;
$is_in_header = true;
?><!doctype html>
<html <?php language_attributes(); ?> hidden>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<script type="module">
		import { setup, silent } from "https://cdn.skypack.dev/twind/shim";

		// Custom configuration
		setup({
			mode: silent,
		});
	</script>

</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="page">
		<a href="#content" class="sr-only"><?php esc_html_e('Skip to content', 'wp-tailwind'); ?></a>

		<?php
		get_template_part('template-parts/layout/header-content', null, array('post_id' => 'header'));
		?>

		<div id="content">
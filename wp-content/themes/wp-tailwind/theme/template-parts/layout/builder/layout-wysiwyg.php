<?php
/**
 * Template part for displaying the WYSIWYG component
 *
 */

// Fetch ACF fields
$wysiwyg = get_sub_field('wysiwyg');
$class = get_sub_field('class'); // Fetch class separately

?>

<div class="<?php echo esc_attr($class); ?> <?php echo esc_attr($args['width'] ?? ''); ?>">
  <?php echo $wysiwyg; ?>
</div>
<?php
/**
 * Template part for displaying the image component
 *
 */

$width = isset($args['width']) ? $args['width'] : '';

$image = get_acf_image('image');
$link = get_acf_link('image_link');
$image_class = get_sub_field('image_class');

$aspect_ratio = ($image && isset($image['width']) && isset($image['height'])) ? calculateAspectRatio($image['width'], $image['height']) : '1 / 1';
?>

<?php if ($image): ?>
  <?php if ($link): ?>
    <a class="flex relative <?php echo esc_attr($width); ?> <?php echo esc_attr($class); ?>"
      href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target']); ?>">
    <?php endif; ?>

    <div class="relative <?php echo esc_attr($width); ?>" style="aspect-ratio: <?php echo esc_attr($aspect_ratio); ?>;">
      <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
        style="object-fit: cover; object-position: <?php echo esc_attr($image['left']) . '% ' . esc_attr($image['top']); ?>%; width: 100%; height: 100%;"
        class="<?php echo esc_attr($image_class); ?>">

    </div>

    <?php if ($link): ?>
    </a>
  <?php endif; ?>
<?php endif; ?>
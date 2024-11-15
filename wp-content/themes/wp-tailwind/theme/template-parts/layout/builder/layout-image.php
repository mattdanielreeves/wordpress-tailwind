<?php
/**
 * Template part for displaying the image component
 *
 */

$class = isset($args['class']) ? $args['class'] : '';
$width = isset($args['width']) ? $args['width'] : '';

// Helper functions
if (!function_exists('get_acf_image')) {
  function get_acf_image($field_name)
  {
    $image = get_sub_field($field_name);
    if ($image) {
      $image_src = wp_get_attachment_image_src($image['id'], 'full');
      $image_url = $image_src[0];
      $alt_text = get_post_meta($image['id'], '_wp_attachment_image_alt', true);

      // If alt text is empty, use the image file name
      if (empty($alt_text)) {
        $path_parts = pathinfo($image_url);
        $alt_text = $path_parts['filename'];
      }

      // Get image dimensions
      $metadata = wp_get_attachment_metadata($image['id']);
      $width = $metadata['width'];
      $height = $metadata['height'];

      return [
        'id' => $image['id'],
        'url' => $image_url,
        'alt' => $alt_text,
        'top' => $image['top'],
        'left' => $image['left'],
        'width' => $width,
        'height' => $height
      ];
    }
    return null;
  }
}

if (!function_exists('get_acf_link')) {
  function get_acf_link($field_name)
  {
    $link = get_sub_field($field_name);
    if ($link) {
      return [
        'url' => $link['url'],
        'target' => $link['target'] ? $link['target'] : '_self'
      ];
    }
    return null;
  }
}

$image = get_acf_image('image');
$link = get_acf_link('image_link');

// Ensure the gcd function exists
if (!function_exists('gcd')) {
  function gcd($a, $b)
  {
    return ($b == 0) ? $a : gcd($b, $a % $b);
  }
}

// Ensure the calculateAspectRatio function exists
if (!function_exists('calculateAspectRatio')) {
  function calculateAspectRatio($width, $height)
  {
    $gcd = gcd($width, $height);
    return ($width / $gcd) . ' / ' . ($height / $gcd);
  }
}

// Replace the highlighted code with the new function call
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
        class="<?php echo esc_attr($class); ?>">
    </div>

    <?php if ($link): ?>
    </a>
  <?php endif; ?>
<?php endif; ?>
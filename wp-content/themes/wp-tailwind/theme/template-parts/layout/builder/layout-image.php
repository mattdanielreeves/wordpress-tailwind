<?php
/**
 * Template part for displaying the image component
 *
 */
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

$image = get_acf_image('image');
$link = get_acf_link('image_link');
$width = $args['width'] ?? '';

// Calculate aspect ratio
$aspect_ratio = $image ? ($image['width'] / $image['height']) : 1;
?>

<?php if ($image): ?>
  <?php if ($link): ?>
    <a class="<?php echo $width; ?>" href="<?php echo esc_url($link['url']); ?>"
      target="<?php echo esc_attr($link['target']); ?>">
    <?php endif; ?>

    <div class="<?php echo $width; ?>" style="aspect-ratio: <?php echo esc_attr($aspect_ratio); ?>;">
      <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
        style="object-fit: cover; object-position: <?php echo esc_attr($image['left']) . '% ' . esc_attr($image['top']); ?>%; width: 100%; height: 100%;">
    </div>

    <?php if ($link): ?>
    </a>
  <?php endif; ?>
<?php endif; ?>
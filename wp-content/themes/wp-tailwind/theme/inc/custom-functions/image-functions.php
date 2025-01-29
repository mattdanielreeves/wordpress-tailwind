<?php
// Image Functions

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

      // Calculate aspect ratio
      $aspect_ratio = ($width && $height) ? calculateAspectRatio($width, $height) : '1 / 1';

      return [
        'id' => $image['id'],
        'url' => $image_url,
        'alt' => $alt_text,
        'top' => $image['top'],
        'left' => $image['left'],
        'width' => $width,
        'height' => $height,
        'aspect_ratio' => $aspect_ratio
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
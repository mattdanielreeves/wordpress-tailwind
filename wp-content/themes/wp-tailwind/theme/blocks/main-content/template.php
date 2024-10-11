<?php

/**
 * Main Content Block template.
 *
 * @param array $block The block settings and attributes.
 */

// The block attributes
$block = $args['block'];

// The block data
$data = $args['data'];

// The block ID
$block_id = $args['block_id'];

// The block class names
$class_name = $args['class_name'];


$attrs = get_block_wrapper_attributes(); ?>

<!-- Our front-end template -->
<div id="<?php echo $block_id; ?>" <?php echo $attrs; ?> class="<?php echo $class_name; ?>">
  <?php
  if ($data['test_field']) {
    echo "<p>" . $data['test_field'] . "</p>";
  }
  ?>
</div>
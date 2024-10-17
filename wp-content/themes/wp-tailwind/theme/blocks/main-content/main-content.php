<?php

/**
 * Main Content Block template.
 *
 * @param array $block The block settings and attributes.
 */

// The block attributes
$block_id = 'main-content-' . $block['id'];


// Check if a custom ID is set in the block editor
if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$main_content_fields = mdr_get_acf_field_variables('group_670827c9f1324');


extract($main_content_fields);


if( !empty($block['alignText']) ) {
  $class_name = ' has-text-align-' . $block['alignText'];
}

$attrs = get_block_wrapper_attributes(
  [
    'class' => $class_name
  ]
);
 ?>

<?php
    $allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/image', 'core/button', 'core/buttons', 'core/columns', 'core/column', 'core/detail', 'core/column', 'core/embed', 'acf/main-content' );
    $template = array(
      array('core/heading', array(
          'level' => 2,
          'content' => 'This is a default heading',
      )),
      array( 'core/paragraph', array(
          'content' => 'This is placeholder paragraph text.',
      ) )
  );?>

<!-- Our front-end template test grid-->
<div id="<?php echo $block_id; ?>" <?php if(!$is_preview)echo $attrs; ?>>

 <InnerBlocks 
    template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>"  
    allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
/>

</div>
<?php



?>

<div
    class="test <?php echo esc_attr($args['width']); ?> bg-white rounded-xl row-span-3 p-6 relative flex flex-col h-full w-full">
    <h2><?php echo $args['heading']; ?></h2>
    <p><?php echo $args['description']; ?></p>
</div>
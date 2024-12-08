<?php
/**
 * Template part for displaying the info section component.
 *
 * @package wp-tailwind
 */


?>

<div
    class="<?php echo esc_attr($args['width']); ?> bg-white rounded-xl row-span-3 p-6 relative flex flex-col h-full w-full">
    <?php
    $image = get_acf_image('image');

    if ($image) { ?>
        <div class="relative"
            style="background-image:url('<?php echo esc_url($image['url']); ?>'); background-size:cover; background-position:<?php echo esc_attr($image['left']) . '% ' . esc_attr($image['top']); ?>%; width:100%; height:100%;">

        </div>
    <?php } ?>
    <h2><?php echo $args['heading']; ?></h2>
    <p><?php echo $args['description']; ?></p>
</div>
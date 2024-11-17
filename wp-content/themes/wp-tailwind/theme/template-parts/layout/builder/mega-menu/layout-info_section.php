<?php
/**
 * Template part for displaying the info section component.
 *
 * @package wp-tailwind
 */


?>

<div
    class="test <?php echo esc_attr($args['width']); ?> bg-white rounded-xl row-span-3 p-6 relative flex flex-col h-full w-full">
    <?php
    $image = get_acf_image('image');

    if ($image) { ?>
        <div class="relative" style="aspect-ratio: <?php echo esc_attr($image['aspect_ratio']); ?>;">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                style="object-fit: cover; object-position: <?php echo esc_attr($image['left']) . '% ' . esc_attr($image['top']); ?>%; width: 100%; height: 100%;">
        </div>
    <?php } ?>
    <h2><?php echo $args['heading']; ?></h2>
    <p><?php echo $args['description']; ?></p>
</div>
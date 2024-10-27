<?php
/**
 * Template part for displaying the cta header component
 *
 */
?>

<div class="<?php echo esc_attr($args['width']); ?> flex justify-center">
    <?php
    // Get the group field array from ACF
    
    // Check if the repeater field has rows of data
    if (have_rows('buttons')) {
        while (have_rows('buttons')) {
            the_row();
            // Get the sub field value
            $button = get_sub_field('button');
            $button_url = $button['url'] ?? '';
            $button_title = $button['title'] ?? '';

            if ($button_url && $button_title) {
                echo '<div class="h-full content-end"><a class="inline-flex flex-wrap content-end btn" href="' . esc_url($button_url) . '">' . esc_html($button_title) . '</a></div>';
            }
        }
    }

    ?>
</div>
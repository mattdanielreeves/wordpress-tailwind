<?php
/**
 * Template part for displaying the cta header component
 *
 */
?>

<div class="<?php echo esc_attr($args['width']); ?>">
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
                    echo '<a class="flex flex-wrap content-center h-full" href="' . esc_url($button_url) . '" class="btn">' . esc_html($button_title) . '</a>';
                }
            }
        }

    ?>
</div>
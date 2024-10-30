<?php
/**
 * Template part for displaying the branding header component
 *
 */
?>
<?php if (!$args['type']): ?>
    <div class="<?php echo esc_attr($args['width']); ?>">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="">
            <?php

            // Get the image array from the 'site_logo' subfield inside the 'branding' group
            $site_logo = get_field('mdr_logo', 'option');

            if ($site_logo) {
                // Extract the URL and alt text from the image array
                $site_logo_url = $site_logo['url'];
                $site_logo_alt = $site_logo['alt'];
                ?>
                <img src="<?php echo esc_url($site_logo_url); ?>" alt="<?php echo esc_attr($site_logo_alt); ?>" />
                <?php
            }
            ?>
        </a>
    </div>
<?php endif; ?>
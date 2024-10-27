<?php
/**
 * Template part for displaying the navigation header mega-menu menu component
 *
 */
$links = get_sub_field('choose_links');
if ($links): ?>
    <div class="<?php echo esc_attr($args['width']); ?> flex flex-wrap w-full">
        <?php foreach ($links as $link): ?>
            <div class="w-1/5">
                <a href="<?php echo esc_url(get_permalink($link->ID)); ?>"><?php echo esc_html(get_the_title($link->ID)); ?></a>
            </div>
        <?php endforeach; ?>

    </div>

<?php endif; ?>
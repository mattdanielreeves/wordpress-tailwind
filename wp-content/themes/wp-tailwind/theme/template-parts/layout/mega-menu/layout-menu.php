<?php
/**
 * Template part for displaying the navigation header mega-menu menu component
 *
 */
$links = get_sub_field('choose_links');
if ($links): ?>
    <div class="<?php echo esc_attr($args['width']); ?>">
        <?php foreach ($links as $link): ?>
            <a href="<?php echo esc_url(get_permalink($link->ID)); ?>"><?php echo esc_html(get_the_title($link->ID)); ?></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

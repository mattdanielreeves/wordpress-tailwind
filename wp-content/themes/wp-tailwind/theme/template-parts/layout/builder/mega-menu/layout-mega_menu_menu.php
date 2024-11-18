<?php
/**
 * Template part for displaying the navigation header mega-menu menu component
 *
 */

$links = get_sub_field('choose_links');
$content_style = get_sub_field('content_style');

if ($links): ?>
    <div class="<?php echo esc_attr($args['width']); ?> flex flex-wrap w-full">
        <?php foreach ($links as $link): ?>
            <div class="w-1/5">
                <?php
                $link_url = esc_url(get_permalink($link->ID));
                $link_title = esc_html(get_the_title($link->ID));
                $link_icon = get_field('icon', $link->ID);
                $link_excerpt = get_the_excerpt($link->ID);
                $link_image = get_the_post_thumbnail($link->ID, 'thumbnail');

                switch ($content_style) {
                    case 'link_only':
                        echo "<a href='{$link_url}'>{$link_title}</a>";
                        break;
                    case 'with_icon':
                        echo "<a class='with-icon' href='{$link_url}'>";
                        if ($link_icon) {
                            echo wp_get_attachment_image($link_icon, 'thumbnail');
                        }
                        echo "{$link_title}</a>";
                        break;
                    case 'with_image':
                        echo "<a class='with-image' href='{$link_url}'>{$link_image}{$link_title}</a>";
                        break;
                    case 'with_excerpt':
                        echo "<a class='with-excerpt' href='{$link_url}'>{$link_title}</a><p>{$link_excerpt}</p>";
                        break;
                    case 'with_image_excerpt':
                        echo "<a class='with-image-excerpt' href='{$link_url}'>{$link_image}{$link_title}</a><p>{$link_excerpt}</p>";
                        break;
                    case 'with_image_excerpt_icon':
                        echo "<a class='with-image-excerpt-icon' href='{$link_url}'>";
                        if ($link_icon) {
                            echo wp_get_attachment_image($link_icon, 'thumbnail');
                        }
                        echo "{$link_image}{$link_title}</a><p>{$link_excerpt}</p>";
                        break;
                    case 'image_only':
                        echo "<a class='image-only' href='{$link_url}'>{$link_image}</a>";
                        break;
                    case 'icon_only':
                        echo "<a class='icon-only' href='{$link_url}'>";
                        if ($link_icon) {
                            echo wp_get_attachment_image($link_icon, 'thumbnail');
                        }
                        echo "</a>";
                        break;
                    default:
                        echo "<a href='{$link_url}'>{$link_title}</a>";
                        break;
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
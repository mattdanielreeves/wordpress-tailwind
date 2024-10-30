<?php

/**
 * Template part for displaying the annoucement content
 *
 */


$announcement = get_sub_field('text');
$bg_color = get_sub_field('background_custom_colors');
$bg_color = $bg_color["global_color_picker"];
$link = get_sub_field('link');
$link_url = $link['url'] ?? '';
$link_title = $link['title'] ?? '';
$tag = $link_url ? 'a' : 'div';

?>
<style>
  #announcement-bar::before {
    background-color:
      <?php echo $bg_color; ?>
    ;
  }
</style>

<div id="announcement-bar"
  class="<?php echo esc_attr($args['width']); ?> relative before:absolute before:left-1/2 before:right-1/2 before:h-full before:-ml-half-screen before:-mr-half-screen order-first"
  style="background-color:<?php echo $bg_color; ?>"><<?php echo $tag; ?> href="<?php echo esc_url($link_url); ?>"
    class="flex relative text-white px-4 py-2"><div class=""><?php echo esc_html($announcement); ?></div></<?php echo $tag; ?>></div>
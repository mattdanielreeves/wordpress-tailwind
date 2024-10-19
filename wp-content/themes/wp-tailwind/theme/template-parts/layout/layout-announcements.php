<?php
/**
 * Template part for displaying the header components
 *
 */

 $announcement = get_sub_field('text', 'option');
 $link = get_sub_field('link', 'option');
 $link_url = $link['url'] ?? '';
 $link_title = $link['title'] ?? '';
 $tag = $link_url ? 'a' : 'div';
 ?>
 <div class="col-span-4">

     <<?php echo $tag; ?> href="<?php echo esc_url($link_url); ?>" class="flex text-white bg-blue-500 px-4 py-2">
         <?php echo esc_html($announcement); ?>
     </<?php echo $tag; ?>>
 </div>
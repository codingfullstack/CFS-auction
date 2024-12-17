<?php
function auction_admin_enqueue($hook)  {
    global $post_type;
    if (($hook === 'post-new.php' || $hook === 'post.php') && $post_type === 'auction'  ) {
        wp_enqueue_media(); 
        wp_enqueue_script('auction_admin');
    }
}
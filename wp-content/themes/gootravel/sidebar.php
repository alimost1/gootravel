<?php
/**
 * Sidebar Template
 * @package GooTravel
 */

if (!is_active_sidebar('tour-sidebar')) {
    return;
}
?>

<aside class="gt-sidebar">
    <?php dynamic_sidebar('tour-sidebar'); ?>
</aside>

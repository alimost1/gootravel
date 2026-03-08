<?php
/**
 * Main Index Template
 * @package GooTravel
 */

get_header(); ?>

<section class="gt-section">
    <div class="gt-container">
        <?php if (have_posts()) : ?>
            <div class="gt-activities-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'tour-card'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php the_posts_pagination(array(
                'prev_text' => '<i class="fas fa-arrow-left"></i>',
                'next_text' => '<i class="fas fa-arrow-right"></i>',
            )); ?>
        <?php else : ?>
            <p><?php _e('No content found.', 'gootravel'); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();

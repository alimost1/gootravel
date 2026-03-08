<?php
/**
 * Page Template
 * @package GooTravel
 */

get_header(); ?>

<section class="gt-section">
    <div class="gt-container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="gt-section-header">
                    <h1 class="gt-section-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="gt-page-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer();

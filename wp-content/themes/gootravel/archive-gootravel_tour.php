<?php
/**
 * Archive Tour Template
 * @package GooTravel
 */

get_header(); ?>

<!-- Tours Hero Section -->
<section class="gt-hero gt-tours-hero">
    <div class="gt-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=1920&q=80');"></div>
    <div class="gt-hero-overlay"></div>
    <div class="gt-container">
        <div class="gt-hero-content gt-tours-hero-content">
            <nav class="gt-breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-home"></i> Home</a>
                <span class="gt-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                <span class="gt-breadcrumb-current">Tours</span>
            </nav>
            <h1 class="gt-hero-title"><?php post_type_archive_title(); ?></h1>
            <p class="gt-hero-text">Explore our collection of amazing tours and activities around the world. Find your perfect adventure today.</p>
            <?php
            $tour_count = wp_count_posts('gootravel_tour');
            $total_tours = $tour_count ? $tour_count->publish : 0;
            ?>
            <div class="gt-tours-hero-stats">
                <div class="gt-tours-hero-stat">
                    <i class="fas fa-map-marked-alt"></i>
                    <span><?php echo $total_tours; ?> Tours Available</span>
                </div>
                <div class="gt-tours-hero-stat">
                    <i class="fas fa-star"></i>
                    <span>Top Rated Experiences</span>
                </div>
                <div class="gt-tours-hero-stat">
                    <i class="fas fa-shield-alt"></i>
                    <span>Free Cancellation</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gt-section">
    <div class="gt-container">
        
        <!-- Filter Tabs -->
        <div class="gt-filter-tabs">
            <button class="gt-filter-tab active" data-filter="all">All Tours</button>
            <?php
            $tour_types = get_terms(array('taxonomy' => 'tour_type', 'hide_empty' => false));
            if ($tour_types && !is_wp_error($tour_types)) :
                foreach ($tour_types as $type) :
            ?>
                <button class="gt-filter-tab" data-filter="<?php echo esc_attr($type->slug); ?>">
                    <?php echo esc_html($type->name); ?>
                </button>
            <?php endforeach; endif; ?>
        </div>
        
        <?php if (have_posts()) : ?>
            <div class="gt-activities-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'tour-card'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php the_posts_pagination(array(
                'prev_text' => '<i class="fas fa-arrow-left"></i> Previous',
                'next_text' => 'Next <i class="fas fa-arrow-right"></i>',
            )); ?>
        <?php else : ?>
            <p>No tours found. Please check back later!</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();

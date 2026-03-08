<?php
/**
 * Taxonomy Tour Type Template
 * @package GooTravel
 */

get_header(); 

// Get current term
$term = get_queried_object();
$title = $term->name;
$description = $term->description;
?>

<!-- Hero Section -->
<section class="gt-hero" style="min-height: 400px;">
    <div class="gt-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1920&auto=format&fit=crop'); background-color: var(--gt-dark);"></div>
    <div class="gt-hero-overlay"></div>
    <div class="gt-container">
        <div class="gt-hero-content">
            <h1 class="gt-hero-title"><?php echo esc_html($title); ?></h1>
            <?php if ($description) : ?>
                <p class="gt-hero-text"><?php echo esc_html($description); ?></p>
            <?php else : ?>
                <p class="gt-hero-text">Explore our best <?php echo esc_html(strtolower($title)); ?> packages.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="gt-section">
    <div class="gt-container">
        
        <?php if (have_posts()) : ?>
            <div class="gt-activities-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="gt-activity-card">
                        <div class="gt-activity-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('gootravel-card'); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="https://picsum.photos/400/300?random=<?php echo get_the_ID(); ?>" alt="<?php the_title_attribute(); ?>">
                                </a>
                            <?php endif; ?>
                            
                            <?php 
                            $price = get_post_meta(get_the_ID(), '_gootravel_price', true);
                            $sale_price = get_post_meta(get_the_ID(), '_gootravel_sale_price', true);
                            $display_price = $sale_price ? $sale_price : $price;
                            ?>
                            <span class="gt-activity-price">$ <?php echo esc_html($display_price); ?></span>
                            
                            <div class="gt-activity-meta">
                                <?php 
                                $duration = get_post_meta(get_the_ID(), '_gootravel_duration', true);
                                $locations = get_the_terms(get_the_ID(), 'tour_location');
                                $location_name = $locations ? $locations[0]->name : '';
                                ?>
                                <?php if ($duration) : ?>
                                    <span class="gt-activity-badge"><i class="far fa-clock"></i> <?php echo esc_html($duration); ?></span>
                                <?php endif; ?>
                                <?php if ($location_name) : ?>
                                    <span class="gt-activity-badge"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location_name); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="gt-activity-content">
                            <h3 class="gt-activity-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            
                            <?php 
                            $rating = get_post_meta(get_the_ID(), '_gootravel_rating', true);
                            ?>
                            <div class="gt-activity-rating">
                                <div class="gt-stars">
                                    <?php 
                                    if (function_exists('gootravel_display_stars')) {
                                        echo gootravel_display_stars($rating);
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="gt-activity-author">
                                <div class="gt-author-avatar">
                                    <img src="https://i.pravatar.cc/100?u=<?php echo get_the_author_meta('ID'); ?>" alt="">
                                </div>
                                <div>
                                    <div class="gt-author-name"><?php the_author(); ?></div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php the_posts_pagination(array(
                'prev_text' => '<i class="fas fa-arrow-left"></i> Previous',
                'next_text' => 'Next <i class="fas fa-arrow-right"></i>',
            )); ?>
        <?php else : ?>
            <p>No tours found in this category.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>

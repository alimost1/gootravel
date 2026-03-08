<?php
/**
 * Tour Card Template Part
 * @package GooTravel
 */

$price = gootravel_get_tour_price();
$sale_price = gootravel_get_tour_sale_price();
$duration = gootravel_get_tour_duration();
$rating = gootravel_get_tour_rating();
$guide_name = get_post_meta(get_the_ID(), '_gootravel_guide_name', true);
$guide_company = get_post_meta(get_the_ID(), '_gootravel_guide_company', true);

$display_price = $sale_price ? $sale_price : ($price ? $price : 80);
$locations = get_the_terms(get_the_ID(), 'tour_location');
$location_name = $locations && !is_wp_error($locations) ? $locations[0]->name : 'Location';
?>

<article class="gt-activity-card" id="post-<?php the_ID(); ?>">
    <div class="gt-activity-image">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('gootravel-card'); ?>
        <?php else : ?>
            <img src="https://picsum.photos/400/300?random=<?php echo get_the_ID(); ?>" alt="<?php the_title_attribute(); ?>">
        <?php endif; ?>
        
        <span class="gt-activity-price">$ <?php echo esc_html($display_price); ?></span>
        
        <div class="gt-activity-meta">
            <?php if ($duration) : ?>
                <span class="gt-activity-badge"><i class="far fa-clock"></i> <?php echo esc_html($duration); ?></span>
            <?php endif; ?>
            <span class="gt-activity-badge"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location_name); ?></span>
        </div>
    </div>
    
    <div class="gt-activity-content">
        <h3 class="gt-activity-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="gt-activity-rating">
            <?php if ($rating) : ?>
                <?php echo gootravel_display_stars($rating); ?>
            <?php else : ?>
                <div class="gt-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
            <?php endif; ?>
            <span class="gt-rating-count">(<?php echo get_comments_number(); ?> ratings)</span>
        </div>
        
        <div class="gt-activity-author">
            <div class="gt-author-avatar">
                <?php echo get_avatar(get_the_author_meta('ID'), 36); ?>
            </div>
            <div>
                <div class="gt-author-name"><?php echo $guide_name ? esc_html($guide_name) : get_the_author(); ?></div>
                <div class="gt-author-company"><?php echo $guide_company ? esc_html($guide_company) : 'Tour Guide'; ?></div>
            </div>
        </div>
    </div>
</article>

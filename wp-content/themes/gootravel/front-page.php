<?php
/**
 * Front Page Template
 * @package GooTravel
 */

get_header(); ?>

<!-- Hero Section with Video Background -->
<section class="gt-hero gt-hero-video">
    <div class="gt-hero-video-bg">
        <iframe 
            src="https://www.youtube.com/embed/IIaZMLMldyI?autoplay=1&mute=1&loop=1&playlist=IIaZMLMldyI&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen
            title="Marrakech Video Background">
        </iframe>
    </div>
    <div class="gt-hero-overlay"></div>
    <div class="gt-container">
        <div class="gt-hero-content">
            <h1 class="gt-hero-title">Discover the Best of <span>Marrakech</span></h1>
            <p class="gt-hero-text">Book amazing activities, desert excursions, and unforgettable experiences. Free cancellation • Pay on site • 7/7 support.</p>
            <div class="gt-hero-search-container">
                <form role="search" method="get" class="gt-search-form-pill" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="hidden" name="post_type" value="gootravel_tour">
                    
                    <div class="gt-search-pill-group">
                        <label for="search-location">Location</label>
                        <div class="gt-search-input-wrap">
                            <input type="search" id="search-location" class="gt-search-pill-input" placeholder="Where are you going?" value="<?php echo get_search_query(); ?>" name="s" />
                        </div>
                    </div>
                    
                    <div class="gt-search-pill-divider"></div>
                    
                    <div class="gt-search-pill-group">
                        <label for="search-date">Check in</label>
                        <div class="gt-search-input-wrap">
                            <input type="text" id="search-date" class="gt-search-pill-input" placeholder="Add dates" onfocus="(this.type='date')" onblur="(this.type='text')" name="tour_date">
                        </div>
                    </div>
                    
                    <div class="gt-search-pill-divider"></div>
                    
                    <div class="gt-search-pill-group">
                        <label for="search-guests">Guests</label>
                        <div class="gt-search-input-wrap">
                            <select id="search-guests" name="guests" class="gt-search-pill-select">
                                <option value="1">1 Guest</option>
                                <option value="2">2 Guests</option>
                                <option value="3">3 Guests</option>
                                <option value="4">4 Guests</option>
                                <option value="5">5+ Guests</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="gt-search-pill-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Browse By Category Section -->
<section class="gt-section gt-categories-section">
    <div class="gt-container">
        <div class="gt-section-header">
            <h2 class="gt-section-title">Browse By Category</h2>
        </div>
        
        <div class="gt-categories-grid">
            <?php
$categories = array(
        array('name' => 'City Tours', 'icon' => 'fas fa-city', 'link' => '#'),
        array('name' => 'Desert', 'icon' => 'fas fa-sun', 'link' => '#'),
        array('name' => 'Food & Drink', 'icon' => 'fas fa-utensils', 'link' => '#'),
        array('name' => 'Adventure', 'icon' => 'fas fa-mountain', 'link' => '#'),
        array('name' => 'Couples', 'icon' => 'fas fa-heart', 'link' => '#'),
        array('name' => 'Families', 'icon' => 'fas fa-users', 'link' => '#'),
);

foreach ($categories as $cat):
?>
                <a href="<?php echo $cat['link']; ?>" class="gt-category-card">
                    <div class="gt-category-icon">
                        <i class="<?php echo $cat['icon']; ?>"></i>
                    </div>
                    <h3 class="gt-category-name"><?php echo $cat['name']; ?></h3>
                </a>
            <?php
endforeach; ?>
        </div>
    </div>
</section>

<!-- Activities Section -->
<section class="gt-section gt-activities-section">
    <div class="gt-container">
        <div class="gt-section-header" style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <span class="gt-section-label">Activities</span>
                <h2 class="gt-section-title">Browse the most preferred<br>categories and activities.</h2>
            </div>
            <p class="gt-section-desc">ExecutionEveryday.com is a productivity and self-improvement platform dedicated to helping individuals achieve success through consistent daily execution. Focused on actionable strategies, the website provides valuable insights on productivity, habit building, goal setting, and personal development.</p>
        </div>
        
        <!-- Filter Tabs -->
        <div class="gt-filter-tabs">
            <button class="gt-filter-tab active" data-filter="all">All Activities</button>
            <button class="gt-filter-tab" data-filter="terrestres">Land Activities</button>
            <button class="gt-filter-tab" data-filter="airs">In The Air</button>
            <button class="gt-filter-tab" data-filter="excursion">Day Excursions</button>
            <button class="gt-filter-tab" data-filter="discovery">Desert Discovery</button>
        </div>
        
        <!-- Activities Grid -->
        <div class="gt-activities-grid">
            <?php
$tours = new WP_Query(array(
    'post_type' => 'gootravel_tour',
    'posts_per_page' => 8,
    'orderby' => 'date',
    'order' => 'DESC',
));

if ($tours->have_posts()):
    while ($tours->have_posts()):
        $tours->the_post();
        get_template_part('template-parts/content', 'tour-card');
    endwhile;
    wp_reset_postdata();
else:
    // Marrakech activities based on marrakechbestof.com
    $demo_tours = array(
            array('title' => 'Quad Biking in Palmeraie', 'price' => 35, 'location' => 'Marrakech', 'duration' => '2 hours', 'rating' => 4.8, 'reviews' => 156, 'guide' => 'Hassan', 'company' => 'Marrakech Best Of', 'type' => 'terrestres'),
            array('title' => 'Agafay Desert Sunset Dinner', 'price' => 45, 'location' => 'Agafay Desert', 'duration' => '5 hours', 'rating' => 4.9, 'reviews' => 203, 'guide' => 'Youssef', 'company' => 'Desert Tours', 'type' => 'discovery'),
            array('title' => 'Hot Air Balloon Sunrise', 'price' => 180, 'location' => 'Marrakech', 'duration' => '3 hours', 'rating' => 5.0, 'reviews' => 89, 'guide' => 'Omar', 'company' => 'Sky Adventures', 'type' => 'airs'),
            array('title' => 'Camel Ride in Palmeraie', 'price' => 25, 'location' => 'Palmeraie', 'duration' => '1.5 hours', 'rating' => 4.6, 'reviews' => 312, 'guide' => 'Mohamed', 'company' => 'Marrakech Best Of', 'type' => 'terrestres'),
            array('title' => 'Ouzoud Waterfalls Day Trip', 'price' => 25, 'location' => 'Cascades Ouzoud', 'duration' => 'Full Day', 'rating' => 4.7, 'reviews' => 178, 'guide' => 'Rachid', 'company' => 'Excursions Maroc', 'type' => 'excursion'),
            array('title' => 'Essaouira Day Excursion', 'price' => 20, 'location' => 'Essaouira', 'duration' => 'Full Day', 'rating' => 4.8, 'reviews' => 245, 'guide' => 'Karim', 'company' => 'Marrakech Best Of', 'type' => 'excursion'),
            array('title' => 'Atlas Mountains & Berber Villages', 'price' => 30, 'location' => 'Atlas Mountains', 'duration' => 'Full Day', 'rating' => 4.9, 'reviews' => 167, 'guide' => 'Ahmed', 'company' => 'Mountain Tours', 'type' => 'excursion'),
            array('title' => 'Agafay Desert Overnight Camp', 'price' => 85, 'location' => 'Agafay Desert', 'duration' => '2 Days', 'rating' => 4.9, 'reviews' => 134, 'guide' => 'Ibrahim', 'company' => 'Desert Camps', 'type' => 'discovery'),
    );
    foreach ($demo_tours as $i => $demo):
?>
                    <article class="gt-activity-card">
                        <div class="gt-activity-image">
                            <img src="https://picsum.photos/400/300?random=<?php echo $i; ?>" alt="<?php echo esc_attr($demo['title']); ?>">
                            <span class="gt-activity-price">$ <?php echo $demo['price']; ?></span>
                            <div class="gt-activity-meta">
                                <span class="gt-activity-badge"><i class="far fa-clock"></i> <?php echo $demo['duration']; ?></span>
                                <span class="gt-activity-badge"><i class="fas fa-map-marker-alt"></i> <?php echo $demo['location']; ?></span>
                            </div>
                        </div>
                        <div class="gt-activity-content">
                            <h3 class="gt-activity-title"><a href="#"><?php echo $demo['title']; ?></a></h3>
                            <div class="gt-activity-rating">
                                <div class="gt-stars">
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <i class="<?php echo $s <= $demo['rating'] ? 'fas' : 'far'; ?> fa-star"></i>
                                    <?php
        endfor; ?>
                                </div>
                                <span class="gt-rating-count">(<?php echo $demo['reviews']; ?> ratings)</span>
                            </div>
                            <div class="gt-activity-author">
                                <div class="gt-author-avatar">
                                    <img src="https://i.pravatar.cc/100?img=<?php echo $i + 10; ?>" alt="">
                                </div>
                                <div>
                                    <div class="gt-author-name"><?php echo $demo['guide']; ?></div>
                                    <div class="gt-author-company"><?php echo $demo['company']; ?></div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
    endforeach;
endif;
?>
        </div>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="<?php echo get_post_type_archive_link('gootravel_tour'); ?>" class="gt-btn gt-btn-primary">
                More Activities <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Locations Section -->
<section class="gt-section gt-locations-section">
    <div class="gt-container">
        <div class="gt-locations-header">
            <div>
                <span class="gt-section-label">Locations</span>
                <h2 class="gt-section-title">Wouldn't you like to be in the best locations<br>in the world?</h2>
            </div>
            <div class="gt-locations-nav">
                <button class="gt-nav-arrow gt-prev"><i class="fas fa-arrow-left"></i></button>
                <button class="gt-nav-arrow gt-next"><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
        
        <div class="gt-locations-grid">
            <?php
// Get locations from taxonomy
$locations = get_terms(array(
    'taxonomy' => 'tour_location',
    'hide_empty' => false,
    'number' => 8,
));

if (!empty($locations) && !is_wp_error($locations)):
    foreach ($locations as $idx => $location):
        $image_url = gootravel_get_location_image($location->term_id, 'gootravel-card-large');
        if (!$image_url) {
            $image_url = 'https://picsum.photos/300/400?random=' . (20 + $idx);
        }
        $tour_count = $location->count;
        $location_link = get_term_link($location);
?>
                <a href="<?php echo esc_url($location_link); ?>" class="gt-location-card">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($location->name); ?>">
                    <div class="gt-location-content">
                        <div class="gt-location-info">
                            <div>
                                <div class="gt-location-name"><?php echo esc_html($location->name); ?></div>
                                <div class="gt-location-from"><?php echo $tour_count; ?> Tours Available</div>
                            </div>
                            <div class="gt-location-price">
                                <div class="amount"><i class="fas fa-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
    endforeach;
else:
    // Fallback demo locations if no terms exist
    $demo_locations = array(
            array('name' => 'Marrakech', 'tours' => 12),
            array('name' => 'Agafay Desert', 'tours' => 8),
            array('name' => 'Essaouira', 'tours' => 6),
            array('name' => 'Atlas Mountains', 'tours' => 10),
    );
    foreach ($demo_locations as $idx => $loc):
?>
                <div class="gt-location-card">
                    <img src="https://picsum.photos/300/400?random=<?php echo 20 + $idx; ?>" alt="<?php echo esc_attr($loc['name']); ?>">
                    <div class="gt-location-content">
                        <div class="gt-location-info">
                            <div>
                                <div class="gt-location-name"><?php echo esc_html($loc['name']); ?></div>
                                <div class="gt-location-from"><?php echo $loc['tours']; ?> Tours Available</div>
                            </div>
                            <div class="gt-location-price">
                                <div class="amount"><i class="fas fa-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
    endforeach;
endif;
?>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="gt-section gt-testimonials">
    <div class="gt-container">
        <div class="gt-testimonials-header">
            <span class="gt-section-label">Testimonials</span>
            <h2 class="gt-section-title" style="opacity: 0.1; font-size: 4rem; position: absolute; left: 50%; transform: translateX(-50%);">Testimonials</h2>
        </div>
        
        <div class="gt-testimonials-grid">
            <?php
$testimonials = array(
        array('title' => 'Great Activity', 'role' => 'Manager'),
        array('title' => 'Friendly Team', 'role' => 'Manager'),
        array('title' => 'Fast and Safe', 'role' => 'Freelancer'),
);

foreach ($testimonials as $idx => $test):
?>
                <div class="gt-testimonial-card">
                    <div class="gt-testimonial-icon"><i class="fas fa-quote-left"></i></div>
                    <h4 class="gt-testimonial-title"><?php echo $test['title']; ?></h4>
                    <p class="gt-testimonial-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dui ut ornare lectus sit.</p>
                    <div class="gt-testimonial-author">
                        <div class="gt-testimonial-avatar">
                            <img src="https://i.pravatar.cc/100?img=<?php echo 30 + $idx; ?>" alt="">
                        </div>
                        <div>
                            <div class="gt-testimonial-name"><?php echo $test['title']; ?></div>
                            <div class="gt-testimonial-role"><?php echo $test['role']; ?></div>
                        </div>
                    </div>
                </div>
            <?php
endforeach; ?>
        </div>
        
        <div class="gt-testimonials-dots">
            <span class="gt-dot active"></span>
            <span class="gt-dot"></span>
            <span class="gt-dot"></span>
        </div>
    </div>
</section>

<?php get_footer();

<?php
/**
 * Single Tour Template
 * @package GooTravel
 */

get_header();

$price = gootravel_get_tour_price();
$sale_price = gootravel_get_tour_sale_price();
$duration = gootravel_get_tour_duration();
$rating = gootravel_get_tour_rating();
$display_price = $sale_price ? $sale_price : ($price ? $price : 80);
$original_price = $sale_price && $price ? $price : 90;

// Participant pricing from admin (fallback to defaults)
$senior_price_meta = get_post_meta(get_the_ID(), '_gootravel_senior_price', true);
$infant_price_meta = get_post_meta(get_the_ID(), '_gootravel_infant_price', true);
$senior_price = $senior_price_meta !== '' ? floatval($senior_price_meta) : round($display_price * 0.8, 2);
$infant_price = $infant_price_meta !== '' ? floatval($infant_price_meta) : 0;

$locations = get_the_terms(get_the_ID(), 'tour_location');
$location_name = $locations ? $locations[0]->name : 'Paris';
?>

<div class="gt-tour-hero-fullwidth">
    <?php if (has_post_thumbnail()) : ?>
        <div class="gt-tour-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'full'); ?>');"></div>
    <?php else : ?>
        <div class="gt-tour-bg" style="background-image: url('https://picsum.photos/1920/800?random=100');"></div>
    <?php endif; ?>
</div>

<section class="gt-section gt-single-tour">
    <div class="gt-container">
        
        <div class="gt-tour-layout">
            <!-- Main Content -->
            <div class="gt-tour-content">
                <h2>Tour Activity Details</h2>
                
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="gt-tour-description">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php if (!get_the_content()) : ?>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dui ut ornare lectus sit. Dictum varius duis at consectetur lorem. Nunc scelerisque viverra mauris in aliquam sem fringilla ut morbi. Amet mauris commodo quis imperdiet massa. Maecenas ultricies mi eget mauris pharetra et ultrices. Amet nulla facilisi morbi tempus iaculis. Sapien faucibus et molestie ac feugiat sed lectus vestibulum. Vel facilisis volutpat est velit egestas dui id. Ipsum dolor sit amet consectetur adipiscing.</p>
                    <?php endif; ?>
                <?php endwhile; endif; ?>
                
                <?php
                // Tour Gallery
                $gallery_ids = get_post_meta(get_the_ID(), '_gootravel_gallery', true);
                if ($gallery_ids) :
                    $ids = array_filter(array_map('intval', explode(',', $gallery_ids)));
                    if (!empty($ids)) :
                ?>
                <div class="gt-gallery-section">
                    <h2><i class="fas fa-images"></i> Tour Gallery</h2>
                    
                    <div class="gt-gallery-main" id="gt-gallery-main">
                        <?php
                        $first_url = wp_get_attachment_image_url($ids[0], 'large');
                        $first_full = wp_get_attachment_image_url($ids[0], 'full');
                        ?>
                        <img src="<?php echo esc_url($first_url); ?>" 
                             data-full="<?php echo esc_url($first_full); ?>" 
                             alt="<?php the_title_attribute(); ?>" 
                             id="gt-gallery-main-img">
                        <button class="gt-gallery-fullscreen" id="gt-gallery-fullscreen" title="View Full Screen">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                    
                    <div class="gt-gallery-thumbs" id="gt-gallery-thumbs">
                        <?php foreach ($ids as $index => $img_id) :
                            $thumb_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                            $medium_url = wp_get_attachment_image_url($img_id, 'large');
                            $full_url = wp_get_attachment_image_url($img_id, 'full');
                            if (!$thumb_url) continue;
                        ?>
                        <div class="gt-gallery-thumb<?php echo $index === 0 ? ' active' : ''; ?>" 
                             data-src="<?php echo esc_url($medium_url); ?>"
                             data-full="<?php echo esc_url($full_url); ?>">
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Lightbox -->
                <div class="gt-lightbox" id="gt-lightbox">
                    <button class="gt-lightbox-close" id="gt-lightbox-close"><i class="fas fa-times"></i></button>
                    <button class="gt-lightbox-prev" id="gt-lightbox-prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="gt-lightbox-next" id="gt-lightbox-next"><i class="fas fa-chevron-right"></i></button>
                    <div class="gt-lightbox-content">
                        <img src="" alt="" id="gt-lightbox-img">
                    </div>
                    <div class="gt-lightbox-counter" id="gt-lightbox-counter"></div>
                </div>
                <?php
                    endif;
                endif;
                ?>
            </div>
            
            <!-- Booking Sidebar -->
            <aside class="gt-tour-sidebar">
                <div class="gt-booking-widget">
                    <h3 class="gt-booking-title">Ticket Booking</h3>
                    
                    <div class="gt-booking-price">
                        <span class="gt-price-original">From: $<?php echo esc_html($original_price); ?></span>
                        <span class="gt-price-current">$ <?php echo esc_html($display_price); ?></span>
                    </div>
                    
                    <form id="gt-booking-form" class="gt-booking-form">
                        <input type="hidden" name="tour_id" value="<?php echo get_the_ID(); ?>">
                        <input type="hidden" name="price" value="<?php echo esc_attr($display_price); ?>">
                        
                        <div class="gt-form-group">
                            <label for="booking_name">Full Name *</label>
                            <input type="text" id="booking_name" name="name" required placeholder="Your name">
                        </div>
                        
                        <div class="gt-form-group">
                            <label for="booking_email">Email *</label>
                            <input type="email" id="booking_email" name="email" required placeholder="your@email.com">
                        </div>
                        
                        <div class="gt-form-group">
                            <label for="booking_phone">Phone</label>
                            <input type="tel" id="booking_phone" name="phone" placeholder="+1234567890">
                        </div>
                        
                        <div class="gt-form-group">
                            <label for="booking_date">Tour Date *</label>
                            <input type="date" id="booking_date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="gt-booking-label">Select Participants</div>
                        
                        <!-- Adults -->
                        <div class="gt-participant-row">
                            <div class="gt-participant-info">
                                <span class="gt-participant-type">Adults</span>
                                <span class="gt-participant-desc">Age 18+</span>
                            </div>
                            <div class="gt-participant-counter">
                                <button type="button" class="gt-counter-btn gt-minus" data-target="adults">−</button>
                                <span class="gt-counter-value" id="adults-count" data-price="<?php echo esc_attr($display_price); ?>">1</span>
                                <input type="hidden" name="adults" id="adults-input" value="1">
                                <button type="button" class="gt-counter-btn gt-plus" data-target="adults">+</button>
                            </div>
                        </div>
                        
                        <!-- Seniors -->
                        <div class="gt-participant-row">
                            <div class="gt-participant-info">
                                <span class="gt-participant-type">Seniors</span>
                                <span class="gt-participant-desc">60+ years</span>
                            </div>
                            <div class="gt-participant-counter">
                                <button type="button" class="gt-counter-btn gt-minus" data-target="seniors">−</button>
                                <span class="gt-counter-value" id="seniors-count" data-price="<?php echo esc_attr($senior_price); ?>">0</span>
                                <input type="hidden" name="seniors" id="seniors-input" value="0">
                                <button type="button" class="gt-counter-btn gt-plus" data-target="seniors">+</button>
                            </div>
                        </div>
                        
                        <!-- Infants -->
                        <div class="gt-participant-row">
                            <div class="gt-participant-info">
                                <span class="gt-participant-type">Infants</span>
                                <span class="gt-participant-desc">0-6 years</span>
                            </div>
                            <div class="gt-participant-counter">
                                <button type="button" class="gt-counter-btn gt-minus" data-target="infants">−</button>
                                <span class="gt-counter-value" id="infants-count" data-price="<?php echo esc_attr($infant_price); ?>">0</span>
                                <input type="hidden" name="infants" id="infants-input" value="0">
                                <button type="button" class="gt-counter-btn gt-plus" data-target="infants">+</button>
                            </div>
                        </div>
                        
                        <div class="gt-form-group">
                            <label for="booking_notes">Special Requests</label>
                            <textarea id="booking_notes" name="notes" rows="2" placeholder="Any special requirements?"></textarea>
                        </div>
                        
                        <div class="gt-booking-total">
                            <span>Total:</span>
                            <span class="gt-total-amount" id="booking-total">$<?php echo esc_html($display_price); ?></span>
                            <input type="hidden" name="total" id="total-input" value="<?php echo esc_attr($display_price); ?>">
                        </div>
                        
                        <button type="submit" class="gt-btn gt-btn-primary gt-book-btn">
                            <i class="fas fa-ticket-alt"></i> Book Now
                        </button>
                        
                        <div class="gt-booking-message" id="booking-message" style="display:none;"></div>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php get_footer();

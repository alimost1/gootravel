<?php
/**
 * Template Name: Contact Page
 * @package GooTravel
 */

get_header(); ?>

<!-- Hero Section -->
<section class="gt-hero" style="min-height: 400px;">
    <div class="gt-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1530789253388-582c481c54b0?q=80&w=1920&auto=format&fit=crop'); background-color: var(--gt-dark);"></div>
    <div class="gt-hero-overlay"></div>
    <div class="gt-container">
        <div class="gt-hero-content">
            <h1 class="gt-hero-title"><?php the_title(); ?></h1>
            <p class="gt-hero-text"><?php echo get_post_meta(get_the_ID(), 'gt_contact_subtitle', true) ?: 'Get in touch with us for your next adventure.'; ?></p>
        </div>
    </div>
</section>

<!-- Contact Content Section -->
<section class="gt-section">
    <div class="gt-container">
        <div class="gt-contact-layout">
            
            <!-- Contact Info Column -->
            <div class="gt-contact-info">
                <div class="gt-section-header">
                    <span class="gt-section-label">Contact Us</span>
                    <h2 class="gt-section-title">We'd love to hear from you</h2>
                    <p class="gt-section-desc">Have questions about our tours or need help planning your trip? Reach out to our team.</p>
                </div>

                <div class="gt-contact-cards">
                    <!-- Address -->
                    <div class="gt-contact-card">
                        <div class="gt-contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="gt-contact-details">
                            <h3>Visit Us</h3>
                            <p>123 Travel Street, Marrakech, 40000 Morocco</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="gt-contact-card">
                        <div class="gt-contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="gt-contact-details">
                            <h3>Call Us</h3>
                            <p><a href="tel:+1234567890">+212 660-065842</a></p>
                            <p class="gt-contact-sub">Mon-Fri: 9am - 6pm</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="gt-contact-card">
                        <div class="gt-contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="gt-contact-details">
                            <h3>Email Us</h3>
                            <p><a href="mailto:info@gootravel.com">info@gootravel.com</a></p>
                            <p class="gt-contact-sub">We reply within 24 hours</p>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="gt-contact-social">
                    <h3>Follow Us</h3>
                    <div class="gt-social-links">
                        <a href="#" class="gt-social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="gt-social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="gt-social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="gt-social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form Column -->
            <div class="gt-contact-form-wrapper">
                <div class="gt-contact-form-card">
                    <h3>Send us a Message</h3>
                    <div class="gt-contact-form-7-container">
                        <?php 
                        // Display the page content which should contain the Contact Form 7 shortcode
                        while (have_posts()) : the_post(); 
                            the_content(); 
                        endwhile; 
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Map Section -->
<section class="gt-map-section">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54280.69793498498!2d-8.0363!3d31.6295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8d96179e51%3A0x5950b6534f87adb8!2sMarrakech%2C%20Morocco!5e0!3m2!1sen!2s!4v1652882206775!5m2!1sen!2s" 
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>

<?php get_footer(); ?>

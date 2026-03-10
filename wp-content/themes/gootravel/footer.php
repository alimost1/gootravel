</main>

<footer class="gt-footer">
    <div class="gt-container">
        <div class="gt-footer-grid">
            <div class="gt-footer-brand">
                <span class="gt-logo-text">excursion <span>Every day</span></span>
                <p>Discover amazing tours and activities around the world.</p>
                <div class="gt-footer-social">
                    <a href="#" class="gt-social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="gt-social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="gt-social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="gt-footer-col">
                <h4 class="gt-footer-title">Quick Links</h4>
                <ul class="gt-footer-links">
                    <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                    <li><a href="<?php echo get_post_type_archive_link('gootravel_tour'); ?>">Tours</a></li>
                    <li><a href="#">Destinations</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="gt-footer-col">
                <h4 class="gt-footer-title">Tour Types</h4>
                <ul class="gt-footer-links">
                    <li><a href="#">Adventure Tours</a></li>
                    <li><a href="#">Guided Tours</a></li>
                    <li><a href="#">Sightseeing</a></li>
                </ul>
            </div>
            <div class="gt-footer-col">
                <h4 class="gt-footer-title">Contact</h4>
                <ul class="gt-footer-links">
                    <li>info@excursioneveryday.com</li>
                    <li>+212 660-065842</li>
                </ul>
            </div>
        </div>
        <div class="gt-footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Excursion Every day. Developed with Antigravity.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

/**
 * GooTravel Theme JavaScript
 * @package GooTravel
 */

(function () {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function () {
        initMobileMenu();
        initFilterTabs();
        initParticipantCounters();
        initLocationCarousel();
        initTestimonialDots();
        initBookingForm();
        initTourGallery();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const toggle = document.querySelector('.gt-mobile-toggle');
        const nav = document.querySelector('.gt-nav-menu');

        if (toggle && nav) {
            toggle.addEventListener('click', function () {
                nav.classList.toggle('active');
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-times');
                }
            });
        }
    }

    /**
     * Filter Tabs for Activities
     */
    function initFilterTabs() {
        const tabs = document.querySelectorAll('.gt-filter-tab');
        const cards = document.querySelectorAll('.gt-activity-card');

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                // Update active state
                tabs.forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');

                const filter = tab.dataset.filter;

                // Filter cards (for demo, show all)
                cards.forEach(function (card) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease';
                });
            });
        });
    }

    /**
     * Participant Counter (+/-)
     */
    function initParticipantCounters() {
        document.querySelectorAll('.gt-counter-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const target = btn.dataset.target;
                const countEl = document.getElementById(target + '-count');
                const inputEl = document.getElementById(target + '-input');

                if (!countEl) return;

                let value = parseInt(countEl.textContent) || 0;

                if (btn.classList.contains('gt-minus')) {
                    if (value > 0) value--;
                } else if (btn.classList.contains('gt-plus')) {
                    value++;
                }

                countEl.textContent = value;
                if (inputEl) inputEl.value = value;

                // Update total
                updateBookingTotal();
            });
        });
    }

    /**
     * Update Booking Total
     */
    function updateBookingTotal() {
        const adultsEl = document.getElementById('adults-count');
        const seniorsEl = document.getElementById('seniors-count');
        const infantsEl = document.getElementById('infants-count');
        const totalEl = document.getElementById('booking-total');
        const totalInput = document.getElementById('total-input');

        if (!adultsEl || !totalEl) return;

        const adults = parseInt(adultsEl.textContent) || 0;
        const seniors = parseInt(seniorsEl ? seniorsEl.textContent : 0) || 0;
        const infants = parseInt(infantsEl ? infantsEl.textContent : 0) || 0;

        const adultPrice = parseFloat(adultsEl.dataset.price) || 0;
        const seniorPrice = parseFloat(seniorsEl ? seniorsEl.dataset.price : 0) || 0;
        const infantPrice = parseFloat(infantsEl ? infantsEl.dataset.price : 0) || 0;

        const total = (adults * adultPrice) + (seniors * seniorPrice) + (infants * infantPrice);

        totalEl.textContent = '$' + total.toFixed(2);
        if (totalInput) totalInput.value = total.toFixed(2);
    }

    /**
     * Location Carousel Navigation
     */
    function initLocationCarousel() {
        const prevBtn = document.querySelector('.gt-locations-nav .gt-prev');
        const nextBtn = document.querySelector('.gt-locations-nav .gt-next');
        const grid = document.querySelector('.gt-locations-grid');

        if (prevBtn && nextBtn && grid) {
            let scrollPos = 0;
            const cardWidth = 300;

            nextBtn.addEventListener('click', function () {
                scrollPos += cardWidth;
                grid.scrollTo({ left: scrollPos, behavior: 'smooth' });
            });

            prevBtn.addEventListener('click', function () {
                scrollPos -= cardWidth;
                if (scrollPos < 0) scrollPos = 0;
                grid.scrollTo({ left: scrollPos, behavior: 'smooth' });
            });
        }
    }

    /**
     * Testimonial Dots
     */
    function initTestimonialDots() {
        const dots = document.querySelectorAll('.gt-testimonials-dots .gt-dot');

        dots.forEach(function (dot, index) {
            dot.addEventListener('click', function () {
                dots.forEach(function (d) { d.classList.remove('active'); });
                dot.classList.add('active');
            });
        });
    }

    /**
     * Booking Form Submission
     */
    function initBookingForm() {
        const form = document.getElementById('gt-booking-form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = form.querySelector('.gt-book-btn');
            const messageEl = document.getElementById('booking-message');
            const originalText = submitBtn.innerHTML;

            // Validate participants
            const adults = parseInt(document.getElementById('adults-input').value) || 0;
            const seniors = parseInt(document.getElementById('seniors-input').value) || 0;

            if (adults + seniors < 1) {
                showMessage(messageEl, 'Please add at least one adult or senior.', 'error');
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

            // Prepare form data
            const formData = new FormData(form);
            formData.append('action', 'gootravel_booking');
            formData.append('nonce', gootravel.nonce);

            // Submit via AJAX
            fetch(gootravel.ajaxurl, {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage(messageEl, data.data.message, 'success');

                        // Send booking details to WhatsApp automatically
                        const waPhone = '212641390881';
                        const tourName = document.querySelector('.gt-tour-header h1, .gt-tour-title, .entry-title')?.textContent?.trim() || 'Tour';
                        const custName = form.querySelector('[name="name"]')?.value || '';
                        const custEmail = form.querySelector('[name="email"]')?.value || '';
                        const custPhone = form.querySelector('[name="phone"]')?.value || '';
                        const bookDate = form.querySelector('[name="date"]')?.value || '';
                        const totalEl = document.getElementById('booking-total');
                        const totalAmount = totalEl ? totalEl.textContent.trim() : '';
                        const notesVal = form.querySelector('[name="notes"]')?.value || '';
                        const infants = parseInt(document.getElementById('infants-input')?.value) || 0;

                        let waMsg = '📋 *New Booking*\n';
                        waMsg += '──────────────\n';
                        waMsg += '🏖 *Tour:* ' + tourName + '\n';
                        waMsg += '👤 *Customer:* ' + custName + '\n';
                        waMsg += '📧 *Email:* ' + custEmail + '\n';
                        waMsg += '📞 *Phone:* ' + custPhone + '\n';
                        waMsg += '📅 *Date:* ' + bookDate + '\n';
                        waMsg += '👥 *Participants:*\n';
                        waMsg += '   Adults: ' + adults + '\n';
                        waMsg += '   Seniors: ' + seniors + '\n';
                        waMsg += '   Infants: ' + infants + '\n';
                        waMsg += '💰 *Total:* ' + totalAmount + '\n';
                        if (notesVal) {
                            waMsg += '📝 *Notes:* ' + notesVal + '\n';
                        }

                        window.open('https://wa.me/' + waPhone + '?text=' + encodeURIComponent(waMsg), '_blank');

                        form.reset();
                        // Reset counters
                        document.getElementById('adults-count').textContent = '1';
                        document.getElementById('adults-input').value = '1';
                        document.getElementById('seniors-count').textContent = '0';
                        document.getElementById('seniors-input').value = '0';
                        document.getElementById('infants-count').textContent = '0';
                        document.getElementById('infants-input').value = '0';
                        updateBookingTotal();
                    } else {
                        showMessage(messageEl, data.data.message, 'error');
                    }
                })
                .catch(error => {
                    showMessage(messageEl, 'An error occurred. Please try again.', 'error');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        });
    }

    /**
     * Tour Gallery — Thumbnails + Lightbox
     */
    function initTourGallery() {
        var thumbs = document.querySelectorAll('#gt-gallery-thumbs .gt-gallery-thumb');
        var mainImg = document.getElementById('gt-gallery-main-img');
        var fullscreenBtn = document.getElementById('gt-gallery-fullscreen');
        var lightbox = document.getElementById('gt-lightbox');
        var lightboxImg = document.getElementById('gt-lightbox-img');
        var lightboxClose = document.getElementById('gt-lightbox-close');
        var lightboxPrev = document.getElementById('gt-lightbox-prev');
        var lightboxNext = document.getElementById('gt-lightbox-next');
        var lightboxCounter = document.getElementById('gt-lightbox-counter');

        if (!thumbs.length || !mainImg) return;

        var currentIndex = 0;
        var galleryItems = [];

        thumbs.forEach(function (thumb, i) {
            galleryItems.push({
                src: thumb.dataset.src,
                full: thumb.dataset.full
            });

            thumb.addEventListener('click', function () {
                currentIndex = i;
                mainImg.src = thumb.dataset.src;
                mainImg.dataset.full = thumb.dataset.full;
                thumbs.forEach(function (t) { t.classList.remove('active'); });
                thumb.classList.add('active');
            });
        });

        // Fullscreen / lightbox
        function openLightbox(index) {
            if (!lightbox) return;
            currentIndex = index;
            lightboxImg.src = galleryItems[index].full;
            lightboxCounter.textContent = (index + 1) + ' / ' + galleryItems.length;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            if (!lightbox) return;
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        function showNext() {
            currentIndex = (currentIndex + 1) % galleryItems.length;
            lightboxImg.src = galleryItems[currentIndex].full;
            lightboxCounter.textContent = (currentIndex + 1) + ' / ' + galleryItems.length;
        }

        function showPrev() {
            currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
            lightboxImg.src = galleryItems[currentIndex].full;
            lightboxCounter.textContent = (currentIndex + 1) + ' / ' + galleryItems.length;
        }

        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function () {
                openLightbox(currentIndex);
            });
        }

        // Also open lightbox on main image click
        mainImg.addEventListener('click', function () {
            openLightbox(currentIndex);
        });

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxPrev) lightboxPrev.addEventListener('click', showPrev);
        if (lightboxNext) lightboxNext.addEventListener('click', showNext);

        // Close on backdrop click
        if (lightbox) {
            lightbox.addEventListener('click', function (e) {
                if (e.target === lightbox) closeLightbox();
            });
        }

        // Keyboard navigation
        document.addEventListener('keydown', function (e) {
            if (!lightbox || !lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') showNext();
            if (e.key === 'ArrowLeft') showPrev();
        });
    }

    /**
     * Show Message
     */
    function showMessage(el, message, type) {
        if (!el) return;
        el.style.display = 'block';
        el.textContent = message;
        el.className = 'gt-booking-message gt-message-' + type;

        if (type === 'success') {
            setTimeout(function () {
                el.style.display = 'none';
            }, 5000);
        }
    }

    // Fade In Animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gt-nav-menu.active {
            display: flex !important;
            flex-direction: column;
            position: absolute;
            top: 80px;
            left: 0;
            right: 0;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    `;
    document.head.appendChild(style);

})();

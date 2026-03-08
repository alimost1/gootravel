<?php
/**
 * GooTravel Theme Functions
 *
 * @package GooTravel
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('GOOTRAVEL_VERSION', '1.0.0');
define('GOOTRAVEL_DIR', get_template_directory());
define('GOOTRAVEL_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function gootravel_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('automatic-feed-links');
    add_theme_support('customize-selective-refresh-widgets');
    
    // Image sizes for tours
    add_image_size('gootravel-card', 400, 300, true);
    add_image_size('gootravel-card-large', 600, 450, true);
    add_image_size('gootravel-hero', 1920, 800, true);
    add_image_size('gootravel-gallery', 800, 600, true);
    
    // Register menus
    register_nav_menus(array(
        'primary'   => __('Primary Menu', 'gootravel'),
        'footer'    => __('Footer Menu', 'gootravel'),
    ));
}
add_action('after_setup_theme', 'gootravel_setup');

/**
 * Enqueue Scripts and Styles
 */
function gootravel_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'gootravel-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap',
        array(),
        null
    );
    
    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );
    
    // Theme Stylesheet
    wp_enqueue_style(
        'gootravel-style',
        get_stylesheet_uri(),
        array('gootravel-fonts', 'font-awesome'),
        GOOTRAVEL_VERSION
    );
    
    // Theme JavaScript
    wp_enqueue_script(
        'gootravel-main',
        GOOTRAVEL_URI . '/assets/js/main.js',
        array(),
        GOOTRAVEL_VERSION,
        true
    );
    
    // Localize script for AJAX
    wp_localize_script('gootravel-main', 'gootravel', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('gootravel_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'gootravel_scripts', 20);

/**
 * Register Custom Post Type: Tour
 */
function gootravel_register_post_types() {
    $labels = array(
        'name'                  => __('Tours', 'gootravel'),
        'singular_name'         => __('Tour', 'gootravel'),
        'menu_name'             => __('Tours', 'gootravel'),
        'add_new'               => __('Add New Tour', 'gootravel'),
        'add_new_item'          => __('Add New Tour', 'gootravel'),
        'edit_item'             => __('Edit Tour', 'gootravel'),
        'new_item'              => __('New Tour', 'gootravel'),
        'view_item'             => __('View Tour', 'gootravel'),
        'search_items'          => __('Search Tours', 'gootravel'),
        'not_found'             => __('No tours found', 'gootravel'),
        'not_found_in_trash'    => __('No tours found in trash', 'gootravel'),
        'all_items'             => __('All Tours', 'gootravel'),
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'tours'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-palmtree',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );
    
    register_post_type('gootravel_tour', $args);
}
add_action('init', 'gootravel_register_post_types');

/**
 * Register Taxonomies
 */
function gootravel_register_taxonomies() {
    // Tour Location
    register_taxonomy('tour_location', 'gootravel_tour', array(
        'labels' => array(
            'name'          => __('Locations', 'gootravel'),
            'singular_name' => __('Location', 'gootravel'),
            'add_new_item'  => __('Add New Location', 'gootravel'),
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'location'),
    ));
    
    // Tour Type
    register_taxonomy('tour_type', 'gootravel_tour', array(
        'labels' => array(
            'name'          => __('Tour Types', 'gootravel'),
            'singular_name' => __('Tour Type', 'gootravel'),
            'add_new_item'  => __('Add New Tour Type', 'gootravel'),
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'tour-type'),
    ));
    
    // Duration
    register_taxonomy('tour_duration', 'gootravel_tour', array(
        'labels' => array(
            'name'          => __('Durations', 'gootravel'),
            'singular_name' => __('Duration', 'gootravel'),
        ),
        'public'            => true,
        'hierarchical'      => false,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'duration'),
    ));
}
add_action('init', 'gootravel_register_taxonomies');

/**
 * Register Widget Areas
 */
function gootravel_widgets_init() {
    register_sidebar(array(
        'name'          => __('Tour Sidebar', 'gootravel'),
        'id'            => 'tour-sidebar',
        'description'   => __('Widgets in this area will be shown on single tour pages.', 'gootravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'gootravel'),
        'id'            => 'footer-1',
        'description'   => __('First footer column.', 'gootravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="gt-footer-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Column 2', 'gootravel'),
        'id'            => 'footer-2',
        'description'   => __('Second footer column.', 'gootravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="gt-footer-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Column 3', 'gootravel'),
        'id'            => 'footer-3',
        'description'   => __('Third footer column.', 'gootravel'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="gt-footer-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'gootravel_widgets_init');

/**
 * Tour Meta Box
 */
function gootravel_add_tour_meta_boxes() {
    add_meta_box(
        'gootravel_tour_details',
        __('Tour Details', 'gootravel'),
        'gootravel_tour_meta_box_callback',
        'gootravel_tour',
        'normal',
        'high'
    );
    add_meta_box(
        'gootravel_tour_gallery',
        __('Tour Gallery', 'gootravel'),
        'gootravel_tour_gallery_callback',
        'gootravel_tour',
        'normal',
        'default'
    );
}

function gootravel_tour_gallery_callback($post) {
    $gallery_ids = get_post_meta($post->ID, '_gootravel_gallery', true);
    ?>
    <div class="gootravel-gallery-wrap">
        <input type="hidden" id="gootravel_gallery" name="gootravel_gallery" value="<?php echo esc_attr($gallery_ids); ?>">
        <div id="gootravel-gallery-thumbs" class="gootravel-gallery-thumbs">
            <?php
            if ($gallery_ids) {
                $ids = explode(',', $gallery_ids);
                foreach ($ids as $id) {
                    $id = intval(trim($id));
                    if (!$id) continue;
                    $thumb = wp_get_attachment_image_url($id, 'thumbnail');
                    if ($thumb) {
                        echo '<div class="gootravel-gallery-thumb" data-id="' . $id . '">';
                        echo '<img src="' . esc_url($thumb) . '" alt="">';
                        echo '<button type="button" class="gootravel-gallery-remove">&times;</button>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
        <button type="button" class="button button-primary gootravel-gallery-add">
            <span class="dashicons dashicons-images-alt2" style="vertical-align:middle;margin-right:4px;"></span>
            <?php _e('Add Gallery Images', 'gootravel'); ?>
        </button>
        <p class="description"><?php _e('Click to add images. Drag to reorder. Click &times; to remove.', 'gootravel'); ?></p>
    </div>
    <style>
        .gootravel-gallery-thumbs { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:12px; }
        .gootravel-gallery-thumb { position:relative; width:120px; height:120px; border:2px solid #ddd; border-radius:6px; overflow:hidden; cursor:move; }
        .gootravel-gallery-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
        .gootravel-gallery-remove { position:absolute; top:2px; right:2px; background:rgba(0,0,0,0.7); color:#fff; border:none; border-radius:50%; width:24px; height:24px; cursor:pointer; font-size:16px; line-height:22px; text-align:center; padding:0; }
        .gootravel-gallery-remove:hover { background:#d63638; }
        .gootravel-gallery-thumb.ui-sortable-helper { box-shadow:0 4px 12px rgba(0,0,0,0.3); }
        .gootravel-gallery-thumb.ui-sortable-placeholder { border:2px dashed #2271b1; background:#f0f6fc; visibility:visible !important; }
    </style>
    <?php
}
add_action('add_meta_boxes', 'gootravel_add_tour_meta_boxes');

function gootravel_tour_meta_box_callback($post) {
    wp_nonce_field('gootravel_tour_meta', 'gootravel_tour_nonce');
    
    $price = get_post_meta($post->ID, '_gootravel_price', true);
    $sale_price = get_post_meta($post->ID, '_gootravel_sale_price', true);
    $senior_price = get_post_meta($post->ID, '_gootravel_senior_price', true);
    $infant_price = get_post_meta($post->ID, '_gootravel_infant_price', true);
    $duration = get_post_meta($post->ID, '_gootravel_duration', true);
    $max_guests = get_post_meta($post->ID, '_gootravel_max_guests', true);
    $rating = get_post_meta($post->ID, '_gootravel_rating', true);
    $guide_name = get_post_meta($post->ID, '_gootravel_guide_name', true);
    $guide_company = get_post_meta($post->ID, '_gootravel_guide_company', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="gootravel_price"><?php _e('Adult Price ($)', 'gootravel'); ?></label></th>
            <td><input type="number" id="gootravel_price" name="gootravel_price" value="<?php echo esc_attr($price); ?>" step="0.01"><p class="description"><?php _e('Price per adult (18+)', 'gootravel'); ?></p></td>
        </tr>
        <tr>
            <th><label for="gootravel_sale_price"><?php _e('Sale Price ($)', 'gootravel'); ?></label></th>
            <td><input type="number" id="gootravel_sale_price" name="gootravel_sale_price" value="<?php echo esc_attr($sale_price); ?>" step="0.01"><p class="description"><?php _e('If set, this replaces the adult price on display', 'gootravel'); ?></p></td>
        </tr>
        <tr>
            <th><label for="gootravel_senior_price"><?php _e('Senior Price ($)', 'gootravel'); ?></label></th>
            <td><input type="number" id="gootravel_senior_price" name="gootravel_senior_price" value="<?php echo esc_attr($senior_price); ?>" step="0.01"><p class="description"><?php _e('Price per senior (60+). Leave empty to use 80% of adult price.', 'gootravel'); ?></p></td>
        </tr>
        <tr>
            <th><label for="gootravel_infant_price"><?php _e('Infant Price ($)', 'gootravel'); ?></label></th>
            <td><input type="number" id="gootravel_infant_price" name="gootravel_infant_price" value="<?php echo esc_attr($infant_price); ?>" step="0.01"><p class="description"><?php _e('Price per infant (0-6). Leave empty for free.', 'gootravel'); ?></p></td>
        </tr>
        <tr>
            <th><label for="gootravel_duration"><?php _e('Duration (hours)', 'gootravel'); ?></label></th>
            <td><input type="text" id="gootravel_duration" name="gootravel_duration" value="<?php echo esc_attr($duration); ?>" placeholder="e.g., 3 hours"></td>
        </tr>
        <tr>
            <th><label for="gootravel_max_guests"><?php _e('Max Guests', 'gootravel'); ?></label></th>
            <td><input type="number" id="gootravel_max_guests" name="gootravel_max_guests" value="<?php echo esc_attr($max_guests); ?>"></td>
        </tr>
        <tr>
            <th><label for="gootravel_rating"><?php _e('Rating (1-5)', 'gootravel'); ?></label></th>
            <td><input type="number" id="gootravel_rating" name="gootravel_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="5" step="0.1"></td>
        </tr>
        <tr>
            <th><label for="gootravel_guide_name"><?php _e('Guide Name', 'gootravel'); ?></label></th>
            <td><input type="text" id="gootravel_guide_name" name="gootravel_guide_name" value="<?php echo esc_attr($guide_name); ?>"></td>
        </tr>
        <tr>
            <th><label for="gootravel_guide_company"><?php _e('Guide Company', 'gootravel'); ?></label></th>
            <td><input type="text" id="gootravel_guide_company" name="gootravel_guide_company" value="<?php echo esc_attr($guide_company); ?>"></td>
        </tr>
    </table>
    <?php
}

function gootravel_save_tour_meta($post_id) {
    if (!isset($_POST['gootravel_tour_nonce']) || !wp_verify_nonce($_POST['gootravel_tour_nonce'], 'gootravel_tour_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'gootravel_price'        => '_gootravel_price',
        'gootravel_sale_price'   => '_gootravel_sale_price',
        'gootravel_senior_price' => '_gootravel_senior_price',
        'gootravel_infant_price' => '_gootravel_infant_price',
        'gootravel_duration'     => '_gootravel_duration',
        'gootravel_max_guests'   => '_gootravel_max_guests',
        'gootravel_rating'       => '_gootravel_rating',
        'gootravel_guide_name'   => '_gootravel_guide_name',
        'gootravel_guide_company'=> '_gootravel_guide_company',
    );
    
    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Save gallery
    if (isset($_POST['gootravel_gallery'])) {
        $gallery = sanitize_text_field($_POST['gootravel_gallery']);
        update_post_meta($post_id, '_gootravel_gallery', $gallery);
    }
}
add_action('save_post_gootravel_tour', 'gootravel_save_tour_meta');

/**
 * Helper Functions
 */
function gootravel_get_tour_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_gootravel_price', true);
}

function gootravel_get_tour_sale_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_gootravel_sale_price', true);
}

function gootravel_get_tour_duration($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_gootravel_duration', true);
}

function gootravel_get_tour_rating($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_gootravel_rating', true);
}

function gootravel_display_stars($rating) {
    $output = '<div class="gt-stars">';
    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5;
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $full_stars) {
            $output .= '<i class="fas fa-star"></i>';
        } elseif ($half_star && $i == $full_stars + 1) {
            $output .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $output .= '<i class="far fa-star"></i>';
        }
    }
    
    $output .= '</div>';
    return $output;
}

/**
 * Flush rewrite rules on theme activation
 */
function gootravel_rewrite_flush() {
    gootravel_register_post_types();
    gootravel_register_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'gootravel_rewrite_flush');

/**
 * Location Taxonomy Image Upload
 */

// Add image field to Add Location form
function gootravel_location_add_image_field() {
    ?>
    <div class="form-field term-image-wrap">
        <label for="location_image"><?php _e('Location Image', 'gootravel'); ?></label>
        <div id="location-image-wrapper"></div>
        <input type="hidden" name="location_image" id="location_image" value="">
        <button type="button" class="button gootravel-upload-image"><?php _e('Upload Image', 'gootravel'); ?></button>
        <button type="button" class="button gootravel-remove-image" style="display:none;"><?php _e('Remove Image', 'gootravel'); ?></button>
        <p class="description"><?php _e('Upload an image for this location.', 'gootravel'); ?></p>
    </div>
    <?php
}
add_action('tour_location_add_form_fields', 'gootravel_location_add_image_field');

// Add image field to Edit Location form
function gootravel_location_edit_image_field($term) {
    $image_id = get_term_meta($term->term_id, 'location_image', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
    ?>
    <tr class="form-field term-image-wrap">
        <th scope="row"><label for="location_image"><?php _e('Location Image', 'gootravel'); ?></label></th>
        <td>
            <div id="location-image-wrapper">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 150px; height: auto; margin-bottom: 10px; display: block;">
                <?php endif; ?>
            </div>
            <input type="hidden" name="location_image" id="location_image" value="<?php echo esc_attr($image_id); ?>">
            <button type="button" class="button gootravel-upload-image"><?php _e('Upload Image', 'gootravel'); ?></button>
            <button type="button" class="button gootravel-remove-image" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php _e('Remove Image', 'gootravel'); ?></button>
            <p class="description"><?php _e('Upload an image for this location.', 'gootravel'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('tour_location_edit_form_fields', 'gootravel_location_edit_image_field');

// Save location image
function gootravel_save_location_image($term_id) {
    if (isset($_POST['location_image'])) {
        update_term_meta($term_id, 'location_image', absint($_POST['location_image']));
    }
}
add_action('created_tour_location', 'gootravel_save_location_image');
add_action('edited_tour_location', 'gootravel_save_location_image');

// Enqueue media uploader scripts for taxonomy pages
function gootravel_admin_scripts($hook) {
    // Location taxonomy pages
    if ($hook === 'edit-tags.php' || $hook === 'term.php') {
        $screen = get_current_screen();
        if ($screen && $screen->taxonomy === 'tour_location') {
            wp_enqueue_media();
            wp_enqueue_script(
                'gootravel-admin',
                GOOTRAVEL_URI . '/assets/js/admin.js',
                array('jquery'),
                GOOTRAVEL_VERSION,
                true
            );
        }
    }
    
    // Tour edit screen — gallery uploader
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        $screen = get_current_screen();
        if ($screen && $screen->post_type === 'gootravel_tour') {
            wp_enqueue_media();
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script(
                'gootravel-admin',
                GOOTRAVEL_URI . '/assets/js/admin.js',
                array('jquery', 'jquery-ui-sortable'),
                GOOTRAVEL_VERSION,
                true
            );
        }
    }
}
add_action('admin_enqueue_scripts', 'gootravel_admin_scripts');

// Add image column to location list
function gootravel_location_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'name') {
            $new_columns['image'] = __('Image', 'gootravel');
        }
    }
    return $new_columns;
}
add_filter('manage_edit-tour_location_columns', 'gootravel_location_columns');

// Display image in column
function gootravel_location_column_content($content, $column_name, $term_id) {
    if ($column_name === 'image') {
        $image_id = get_term_meta($term_id, 'location_image', true);
        if ($image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            $content = '<img src="' . esc_url($image_url) . '" style="max-width: 50px; height: auto;">';
        } else {
            $content = '—';
        }
    }
    return $content;
}
add_filter('manage_tour_location_custom_column', 'gootravel_location_column_content', 10, 3);

// Helper function to get location image
function gootravel_get_location_image($term_id, $size = 'gootravel-card') {
    $image_id = get_term_meta($term_id, 'location_image', true);
    if ($image_id) {
        return wp_get_attachment_image_url($image_id, $size);
    }
    return false;
}

/**
 * =========================================================================
 * BOOKING SYSTEM
 * =========================================================================
 */

// Register Booking Post Type
function gootravel_register_booking_post_type() {
    $labels = array(
        'name'               => __('Bookings', 'gootravel'),
        'singular_name'      => __('Booking', 'gootravel'),
        'menu_name'          => __('Bookings', 'gootravel'),
        'all_items'          => __('All Bookings', 'gootravel'),
        'view_item'          => __('View Booking', 'gootravel'),
        'edit_item'          => __('Edit Booking', 'gootravel'),
        'search_items'       => __('Search Bookings', 'gootravel'),
        'not_found'          => __('No bookings found', 'gootravel'),
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'            => array('title'),
        'capabilities'        => array(
            'create_posts' => false,
        ),
        'map_meta_cap'        => true,
    );
    
    register_post_type('gootravel_booking', $args);
}
add_action('init', 'gootravel_register_booking_post_type');

// Add custom columns to Bookings list
function gootravel_booking_columns($columns) {
    $new_columns = array(
        'cb'           => $columns['cb'],
        'title'        => __('Booking ID', 'gootravel'),
        'tour'         => __('Tour', 'gootravel'),
        'customer'     => __('Customer', 'gootravel'),
        'date'         => __('Tour Date', 'gootravel'),
        'participants' => __('Participants', 'gootravel'),
        'total'        => __('Total', 'gootravel'),
        'status'       => __('Status', 'gootravel'),
        'booking_date' => __('Booked On', 'gootravel'),
    );
    return $new_columns;
}
add_filter('manage_gootravel_booking_posts_columns', 'gootravel_booking_columns');

// Display custom column content
function gootravel_booking_column_content($column, $post_id) {
    switch ($column) {
        case 'tour':
            $tour_id = get_post_meta($post_id, '_booking_tour_id', true);
            if ($tour_id) {
                echo '<a href="' . get_edit_post_link($tour_id) . '">' . get_the_title($tour_id) . '</a>';
            }
            break;
        case 'customer':
            $name = get_post_meta($post_id, '_booking_name', true);
            $email = get_post_meta($post_id, '_booking_email', true);
            echo esc_html($name) . '<br><small>' . esc_html($email) . '</small>';
            break;
        case 'date':
            echo esc_html(get_post_meta($post_id, '_booking_date', true));
            break;
        case 'participants':
            $adults = get_post_meta($post_id, '_booking_adults', true);
            $seniors = get_post_meta($post_id, '_booking_seniors', true);
            $infants = get_post_meta($post_id, '_booking_infants', true);
            echo 'Adults: ' . intval($adults) . '<br>';
            echo 'Seniors: ' . intval($seniors) . '<br>';
            echo 'Infants: ' . intval($infants);
            break;
        case 'total':
            echo '$' . esc_html(get_post_meta($post_id, '_booking_total', true));
            break;
        case 'status':
            $status = get_post_meta($post_id, '_booking_status', true) ?: 'pending';
            $colors = array(
                'pending'   => '#f0ad4e',
                'confirmed' => '#5cb85c',
                'cancelled' => '#d9534f',
                'completed' => '#0275d8',
            );
            $color = isset($colors[$status]) ? $colors[$status] : '#999';
            echo '<span style="background:' . $color . ';color:#fff;padding:4px 8px;border-radius:4px;font-size:12px;">' . ucfirst($status) . '</span>';
            break;
        case 'booking_date':
            echo get_the_date('M j, Y g:i A', $post_id);
            break;
    }
}
add_action('manage_gootravel_booking_posts_custom_column', 'gootravel_booking_column_content', 10, 2);

// Make columns sortable
function gootravel_booking_sortable_columns($columns) {
    $columns['date'] = 'date';
    $columns['status'] = 'status';
    $columns['total'] = 'total';
    return $columns;
}
add_filter('manage_edit-gootravel_booking_sortable_columns', 'gootravel_booking_sortable_columns');

// Add meta box for booking details
function gootravel_booking_meta_boxes() {
    add_meta_box(
        'gootravel_booking_details',
        __('Booking Details', 'gootravel'),
        'gootravel_booking_details_callback',
        'gootravel_booking',
        'normal',
        'high'
    );
    add_meta_box(
        'gootravel_booking_status',
        __('Booking Status', 'gootravel'),
        'gootravel_booking_status_callback',
        'gootravel_booking',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'gootravel_booking_meta_boxes');

function gootravel_booking_details_callback($post) {
    $tour_id = get_post_meta($post->ID, '_booking_tour_id', true);
    $name = get_post_meta($post->ID, '_booking_name', true);
    $email = get_post_meta($post->ID, '_booking_email', true);
    $phone = get_post_meta($post->ID, '_booking_phone', true);
    $date = get_post_meta($post->ID, '_booking_date', true);
    $adults = get_post_meta($post->ID, '_booking_adults', true);
    $seniors = get_post_meta($post->ID, '_booking_seniors', true);
    $infants = get_post_meta($post->ID, '_booking_infants', true);
    $total = get_post_meta($post->ID, '_booking_total', true);
    $notes = get_post_meta($post->ID, '_booking_notes', true);
    ?>
    <table class="form-table">
        <tr>
            <th><?php _e('Tour', 'gootravel'); ?></th>
            <td><a href="<?php echo get_permalink($tour_id); ?>" target="_blank"><?php echo get_the_title($tour_id); ?></a></td>
        </tr>
        <tr>
            <th><?php _e('Customer Name', 'gootravel'); ?></th>
            <td><?php echo esc_html($name); ?></td>
        </tr>
        <tr>
            <th><?php _e('Email', 'gootravel'); ?></th>
            <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
        </tr>
        <tr>
            <th><?php _e('Phone', 'gootravel'); ?></th>
            <td><?php echo esc_html($phone); ?></td>
        </tr>
        <tr>
            <th><?php _e('Tour Date', 'gootravel'); ?></th>
            <td><?php echo esc_html($date); ?></td>
        </tr>
        <tr>
            <th><?php _e('Participants', 'gootravel'); ?></th>
            <td>
                Adults: <?php echo intval($adults); ?><br>
                Seniors: <?php echo intval($seniors); ?><br>
                Infants: <?php echo intval($infants); ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Total Amount', 'gootravel'); ?></th>
            <td><strong>$<?php echo esc_html($total); ?></strong></td>
        </tr>
        <?php if ($notes) : ?>
        <tr>
            <th><?php _e('Notes', 'gootravel'); ?></th>
            <td><?php echo esc_html($notes); ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <?php
    // WhatsApp Send Button
    $wa_phone = '212641390881';
    $wa_message = "📋 *Booking #" . $post->ID . "*%0A";
    $wa_message .= "──────────────%0A";
    $wa_message .= "🏖 *Tour:* " . rawurlencode(get_the_title($tour_id)) . "%0A";
    $wa_message .= "👤 *Customer:* " . rawurlencode($name) . "%0A";
    $wa_message .= "📧 *Email:* " . rawurlencode($email) . "%0A";
    $wa_message .= "📞 *Phone:* " . rawurlencode($phone) . "%0A";
    $wa_message .= "📅 *Date:* " . rawurlencode($date) . "%0A";
    $wa_message .= "👥 *Participants:* Adults: " . intval($adults) . ", Seniors: " . intval($seniors) . ", Infants: " . intval($infants) . "%0A";
    $wa_message .= "💰 *Total:* $" . esc_attr($total) . "%0A";
    if ($notes) {
        $wa_message .= "📝 *Notes:* " . rawurlencode($notes) . "%0A";
    }
    $wa_message .= "──────────────%0A";
    $wa_message .= "✅ *Status:* " . ucfirst(get_post_meta($post->ID, '_booking_status', true) ?: 'pending');
    $wa_url = 'https://wa.me/' . $wa_phone . '?text=' . $wa_message;
    ?>
    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" 
           style="display: inline-flex; align-items: center; gap: 8px; background: #25D366; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            <?php _e('Send to WhatsApp', 'gootravel'); ?>
        </a>
    </div>
    <?php
}

function gootravel_booking_status_callback($post) {
    wp_nonce_field('gootravel_booking_status', 'gootravel_booking_status_nonce');
    $status = get_post_meta($post->ID, '_booking_status', true) ?: 'pending';
    ?>
    <p>
        <label for="booking_status"><?php _e('Status:', 'gootravel'); ?></label>
        <select name="booking_status" id="booking_status" style="width:100%;">
            <option value="pending" <?php selected($status, 'pending'); ?>><?php _e('Pending', 'gootravel'); ?></option>
            <option value="confirmed" <?php selected($status, 'confirmed'); ?>><?php _e('Confirmed', 'gootravel'); ?></option>
            <option value="cancelled" <?php selected($status, 'cancelled'); ?>><?php _e('Cancelled', 'gootravel'); ?></option>
            <option value="completed" <?php selected($status, 'completed'); ?>><?php _e('Completed', 'gootravel'); ?></option>
        </select>
    </p>
    <?php
}

// Save booking status
function gootravel_save_booking_status($post_id) {
    if (!isset($_POST['gootravel_booking_status_nonce']) || 
        !wp_verify_nonce($_POST['gootravel_booking_status_nonce'], 'gootravel_booking_status')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['booking_status'])) {
        update_post_meta($post_id, '_booking_status', sanitize_text_field($_POST['booking_status']));
    }
}
add_action('save_post_gootravel_booking', 'gootravel_save_booking_status');

// AJAX Handler for booking submission
function gootravel_process_booking() {
    check_ajax_referer('gootravel_nonce', 'nonce');
    
    $tour_id = intval($_POST['tour_id']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date = sanitize_text_field($_POST['date']);
    $adults = intval($_POST['adults']);
    $seniors = intval($_POST['seniors']);
    $infants = intval($_POST['infants']);
    $total = floatval($_POST['total']);
    $notes = sanitize_textarea_field($_POST['notes']);
    
    // Validation
    if (!$tour_id || !$name || !$email || !$date) {
        wp_send_json_error(array('message' => __('Please fill in all required fields.', 'gootravel')));
    }
    
    if ($adults + $seniors <= 0) {
        wp_send_json_error(array('message' => __('Please add at least one participant.', 'gootravel')));
    }
    
    // Create booking
    $booking_id = wp_insert_post(array(
        'post_type'   => 'gootravel_booking',
        'post_title'  => 'Booking #' . time(),
        'post_status' => 'publish',
    ));
    
    if ($booking_id) {
        update_post_meta($booking_id, '_booking_tour_id', $tour_id);
        update_post_meta($booking_id, '_booking_name', $name);
        update_post_meta($booking_id, '_booking_email', $email);
        update_post_meta($booking_id, '_booking_phone', $phone);
        update_post_meta($booking_id, '_booking_date', $date);
        update_post_meta($booking_id, '_booking_adults', $adults);
        update_post_meta($booking_id, '_booking_seniors', $seniors);
        update_post_meta($booking_id, '_booking_infants', $infants);
        update_post_meta($booking_id, '_booking_total', $total);
        update_post_meta($booking_id, '_booking_notes', $notes);
        update_post_meta($booking_id, '_booking_status', 'pending');
        
        // Send email notification
        $admin_email = get_option('admin_email');
        $tour_title = get_the_title($tour_id);
        $subject = sprintf(__('New Booking: %s', 'gootravel'), $tour_title);
        $message = sprintf(
            __("New booking received!\n\nTour: %s\nCustomer: %s\nEmail: %s\nPhone: %s\nDate: %s\nAdults: %d\nSeniors: %d\nInfants: %d\nTotal: $%s\n\nView booking: %s", 'gootravel'),
            $tour_title, $name, $email, $phone, $date, $adults, $seniors, $infants, $total,
            admin_url('post.php?post=' . $booking_id . '&action=edit')
        );
        wp_mail($admin_email, $subject, $message);
        
        // Send WhatsApp notification
        gootravel_send_whatsapp_notification(array(
            'booking_id' => $booking_id,
            'tour_title' => $tour_title,
            'name'       => $name,
            'email'      => $email,
            'phone'      => $phone,
            'date'       => $date,
            'adults'     => $adults,
            'seniors'    => $seniors,
            'infants'    => $infants,
            'total'      => $total,
            'notes'      => $notes,
        ));
        
        wp_send_json_success(array(
            'message' => __('Booking submitted successfully! We will contact you shortly.', 'gootravel'),
            'booking_id' => $booking_id,
        ));
    } else {
        wp_send_json_error(array('message' => __('Error creating booking. Please try again.', 'gootravel')));
    }
}
add_action('wp_ajax_gootravel_booking', 'gootravel_process_booking');
add_action('wp_ajax_nopriv_gootravel_booking', 'gootravel_process_booking');

// Add booking count to admin menu
function gootravel_pending_bookings_count() {
    global $menu;
    $count = wp_count_posts('gootravel_booking');
    $pending = isset($count->publish) ? $count->publish : 0;
    
    foreach ($menu as $key => $value) {
        if (isset($value[2]) && $value[2] === 'edit.php?post_type=gootravel_booking') {
            $menu[$key][0] .= ' <span class="awaiting-mod"><span class="pending-count">' . $pending . '</span></span>';
            break;
        }
    }
}
add_action('admin_menu', 'gootravel_pending_bookings_count', 999);

/**
 * =========================================================================
 * WHATSAPP NOTIFICATION
 * =========================================================================
 */

/**
 * Send booking details to WhatsApp via CallMeBot API
 * 
 * To activate: 
 * 1. Add +34 644 71 58 96 to your contacts
 * 2. Send "I allow callmebot to send me messages" from +212641390881
 * 3. Save the API key in Settings > General > WhatsApp API Key
 *
 * @param array $data Booking data array
 */
function gootravel_send_whatsapp_notification($data) {
    $phone = '212641390881';
    $apikey = get_option('gootravel_whatsapp_apikey', '');
    
    // If no API key is set, log and skip
    if (empty($apikey)) {
        error_log('GooTravel WhatsApp: No API key configured. Set it in Settings > General.');
        return false;
    }
    
    // Build the message
    $msg  = "📋 *New Booking #" . $data['booking_id'] . "*\n";
    $msg .= "──────────────\n";
    $msg .= "🏖 *Tour:* " . $data['tour_title'] . "\n";
    $msg .= "👤 *Customer:* " . $data['name'] . "\n";
    $msg .= "📧 *Email:* " . $data['email'] . "\n";
    $msg .= "📞 *Phone:* " . $data['phone'] . "\n";
    $msg .= "📅 *Date:* " . $data['date'] . "\n";
    $msg .= "👥 *Participants:*\n";
    $msg .= "   Adults: " . $data['adults'] . "\n";
    $msg .= "   Seniors: " . $data['seniors'] . "\n";
    $msg .= "   Infants: " . $data['infants'] . "\n";
    $msg .= "💰 *Total:* $" . $data['total'] . "\n";
    if (!empty($data['notes'])) {
        $msg .= "📝 *Notes:* " . $data['notes'] . "\n";
    }
    $msg .= "──────────────\n";
    $msg .= "🔗 " . admin_url('post.php?post=' . $data['booking_id'] . '&action=edit');
    
    // Send via CallMeBot API
    $url = 'https://api.callmebot.com/whatsapp.php?' . http_build_query(array(
        'phone'  => $phone,
        'text'   => $msg,
        'apikey' => $apikey,
    ));
    
    $response = wp_remote_get($url, array(
        'timeout' => 30,
        'sslverify' => false,
    ));
    
    if (is_wp_error($response)) {
        error_log('GooTravel WhatsApp Error: ' . $response->get_error_message());
        return false;
    }
    
    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        error_log('GooTravel WhatsApp Error: HTTP ' . $code);
        return false;
    }
    
    return true;
}

/**
 * Add WhatsApp API Key field to Settings > General
 */
function gootravel_whatsapp_settings_field() {
    add_settings_field(
        'gootravel_whatsapp_apikey',
        __('WhatsApp API Key (CallMeBot)', 'gootravel'),
        'gootravel_whatsapp_apikey_callback',
        'general',
        'default'
    );
    register_setting('general', 'gootravel_whatsapp_apikey', 'sanitize_text_field');
}
add_action('admin_init', 'gootravel_whatsapp_settings_field');

function gootravel_whatsapp_apikey_callback() {
    $value = get_option('gootravel_whatsapp_apikey', '');
    echo '<input type="text" name="gootravel_whatsapp_apikey" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description">' . __('Enter your CallMeBot API key to enable automatic WhatsApp notifications for new bookings to +212641390881.', 'gootravel') . '</p>';
}

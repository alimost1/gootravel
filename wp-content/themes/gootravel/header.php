<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="gt-header">
    <div class="gt-container">
        <div class="gt-header-inner">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="gt-logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <span class="gt-logo-text">Goo<span>Travel</span></span>
                <?php endif; ?>
            </a>
            
            <!-- Navigation -->
            <nav class="gt-nav">
                <?php if (has_nav_menu('primary')) : ?>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'gt-nav-menu',
                        'container'      => false,
                        'depth'          => 2,
                    ));
                    ?>
                <?php else : ?>
                    <ul class="gt-nav-menu">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'gootravel'); ?></a></li>
                        <li><a href="<?php echo esc_url(get_post_type_archive_link('gootravel_tour')); ?>"><?php _e('Tours', 'gootravel'); ?></a></li>
                        <li><a href="#"><?php _e('Destinations', 'gootravel'); ?></a></li>
                        <li><a href="#"><?php _e('About', 'gootravel'); ?></a></li>
                        <li><a href="#"><?php _e('Contact', 'gootravel'); ?></a></li>
                    </ul>
                <?php endif; ?>
                
                <div class="gt-nav-actions">
                    <a href="#" class="gt-btn gt-btn-outline"><?php _e('Login', 'gootravel'); ?></a>
                    <a href="#" class="gt-btn gt-btn-primary"><?php _e('Sign Up', 'gootravel'); ?></a>
                </div>
            </nav>
            
            <!-- Mobile Menu Toggle -->
            <button class="gt-mobile-toggle" aria-label="<?php _e('Toggle Menu', 'gootravel'); ?>">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<main id="main" class="gt-main">

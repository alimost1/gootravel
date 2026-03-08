<?php
/**
 * Production WordPress Configuration
 * Reads all sensitive values from environment variables.
 * This file is committed to GitHub and used by Docker/Coolify.
 * 
 * Set these environment variables in Coolify's dashboard.
 */

// ** Database settings ** //
define( 'DB_NAME',     getenv('DB_NAME')     ?: 'wordpress' );
define( 'DB_USER',     getenv('DB_USER')     ?: 'wordpress' );
define( 'DB_PASSWORD', getenv('DB_PASSWORD') ?: '' );
define( 'DB_HOST',     getenv('DB_HOST')     ?: 'db' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

// ** Authentication Unique Keys and Salts ** //
// Set these in Coolify environment variables for security.
// Generate new ones at: https://api.wordpress.org/secret-key/1.1/salt/
define( 'AUTH_KEY',         getenv('AUTH_KEY')         ?: 'change-me-in-coolify' );
define( 'SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY')  ?: 'change-me-in-coolify' );
define( 'LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY')    ?: 'change-me-in-coolify' );
define( 'NONCE_KEY',        getenv('NONCE_KEY')        ?: 'change-me-in-coolify' );
define( 'AUTH_SALT',        getenv('AUTH_SALT')        ?: 'change-me-in-coolify' );
define( 'SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT') ?: 'change-me-in-coolify' );
define( 'LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT')   ?: 'change-me-in-coolify' );
define( 'NONCE_SALT',       getenv('NONCE_SALT')       ?: 'change-me-in-coolify' );

// ** Table prefix ** //
$table_prefix = getenv('DB_TABLE_PREFIX') ?: 'wp_';

// ** WordPress URLs ** //
define( 'WP_HOME',    getenv('WP_HOME')    ?: 'http://localhost' );
define( 'WP_SITEURL', getenv('WP_SITEURL') ?: 'http://localhost' );

// ** WordPress content directory ** //
define( 'WP_CONTENT_DIR', dirname(__FILE__) . '/wp-content' );
define( 'WP_CONTENT_URL', getenv('WP_HOME') . '/wp-content' );

// ** Uploads: use a persistent Docker volume path ** //
define( 'UPLOADS', 'wp-content/uploads' );

// ** HTTPS / SSL (Coolify handles SSL termination via reverse proxy) ** //
if ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

// ** Debug mode (disable in production) ** //
define( 'WP_DEBUG',         getenv('WP_DEBUG') === 'true' );
define( 'WP_DEBUG_LOG',     false );
define( 'WP_DEBUG_DISPLAY', false );

// ** Memory limit ** //
define( 'WP_MEMORY_LIMIT', '256M' );

// ** Disable file editing from admin dashboard (security) ** //
define( 'DISALLOW_FILE_EDIT', true );

// ** Environment type ** //
define( 'WP_ENVIRONMENT_TYPE', 'production' );

/* That's all, stop editing! Happy publishing. */

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';

<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'WP_HOME', 'http://localhost:10003/' );
define( 'WP_SITEURL', 'http://localhost:10003/' );

/** ENABLE DEBUGGING */
@ini_set(‘display_errors’,0);
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);
define('SAVEQUERIES', true);

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ERpiLUUjHmgSCuE8z5rJEqW6L9/j2pYvC3eISocitxTs7UMwUvJRshGv7UlJ0TB0gH/y1cxLY9pq0RORNMWSGw==');
define('SECURE_AUTH_KEY',  'TcZwakt0GVEhvW5JjndBF94+tnhfeAoWLEwAgREHXt3S8DCRDCY4xfI4KZBjha0fkO/d/ZwTxD9Av9KH2TDe7g==');
define('LOGGED_IN_KEY',    'W+V45Rk50LaIC5/4zSthaSJqP6gYiRth7+Q/Falp/J+qAq2GI+5/FRCfT8cr31o9pmlJYCOweld9nHabL9EAzg==');
define('NONCE_KEY',        'hHWAAk6xpKza1QXbXZ7SZLVV9Zu+rqGsXbxQF+mdwnFkMx9bGTb225djH7ibA/gvXx5H2fj/NNnqiYbYGRwszg==');
define('AUTH_SALT',        'lXhs4P3I9sxGREcEeaSCBfnGAh1MhVQp/M8ISAkphDFECyBEW6/hPGfkiFlcdRFXfQrEScSV1BvDhWrUs/2EWA==');
define('SECURE_AUTH_SALT', '9SnAEJ4nxxZubnDxozbGxp58U1vju5v70iz3tn2ZbvdDdt98P6/rxxOLQBmh7UCz9cg+xPldDSnp2ySS6VGIAA==');
define('LOGGED_IN_SALT',   'oQp1SCRaACXwOE5MBJx8iTziCGgHb5HGX98ESZJNZUpbsFXLwwC3Cj5bVi/ahdEz2ptf7mChWDv2AS/xRRctFQ==');
define('NONCE_SALT',       'fh00Yxe49mHdjusJkuePQ4v2GkucnIPlPR+4iLdaxPgAf23TCWR0MjDCHVkU4rQ6EJ50i0ltHl8A0kUK0ocMxg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

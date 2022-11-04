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

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'BB6NfspzWzPlCraK/NzTBZ4jQVYqa8jbetQ4+EzTJn36jzLeog15rlRme2eC056/Hym79/7yfgjKZV43AfyR2w==');
define('SECURE_AUTH_KEY',  'RoE6MeY/Xjafh7aTB+pGozCh6CR4aL3aFDJ1ADkInx9AmIzhyQehUbYmjN3n0oTPcDbqM7CyWB63f0YFzu8JlQ==');
define('LOGGED_IN_KEY',    'EzBJwgUkkmD/iGGJ2HknkbezB2ev9rGVTf49uqiqvKw3vQIg8+cv7SB8uHWbUmpxtJoaHfXvDjLXhrbWs3EW+Q==');
define('NONCE_KEY',        'UlW6OiqwzaSLV4Vv3h4vjPBOqdaImC+4TOFNuI6Aug0mfuB8hyYU+bSuzrQOauT2J9fbEjsGougw3Vq6jn+yhg==');
define('AUTH_SALT',        'b5Cdpzjug5warI0iVGO2yJ3u5mcm1cBUs3QspDqNnAepuWtnn2L3x/zA3ahrx2pMQFT/OK/4OWhBt8/FWeKYvA==');
define('SECURE_AUTH_SALT', 'vRGVNTNh72ZAOtbJGd7bpMXi5PCXzhJKVScN3/A/lvRO8pYFRP2VVqQJVDiug8YOCDT7W6Ol3ofe006G6aDZeA==');
define('LOGGED_IN_SALT',   'TnfdOVy6PTg/xkU7AIzxErBGTs29tyW8Xxhq5h4UUtUec51vdZD893jqUG5203+0qfqcfXUwvd0toN0wRvHRXg==');
define('NONCE_SALT',       'kVexGkO9jWnKzbsp7QHtiHFykNPPW92GXtnmB/EsNV9L5okGxb1mCEq8Gvka+X9cJ2r7HtH/W0B2QT8YaAOlUA==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/*
// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
*/

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


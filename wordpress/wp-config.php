<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bizbook365' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ly+GLz MOp!`.;&3]T8+S%C^>#FTS{%8twTXE8~y}A]{&)-R:{#h_C$>87>>m2wK' );
define( 'SECURE_AUTH_KEY',  'G#+(,S-lp:gG@ZuxA{BYKO#Bk+{_+,g!^eCdr8R5+OiQn=dh(6~iOZ}bT>&jqex8' );
define( 'LOGGED_IN_KEY',    'M_1x0epv}O`OUOE&X`y2~?9-y]M3?oxJgLMg<U_4y_tB_>}S;EInLYdUVQ)nU^d9' );
define( 'NONCE_KEY',        '^HBA;N.U4|]l~*?7I%Sg8|xivsPc=yZa,)v!Iy)Cqo81MFMuK^-j}A#I`LM>SMg:' );
define( 'AUTH_SALT',        ';u05.jIJak&0#+u+:bI.gr}u,+g4`.$WASyL]RG@TXZ|at($z+oHDN)Vg1D(&k#E' );
define( 'SECURE_AUTH_SALT', '`XJjVrWJ}vHwuF<]{dcc[SO,U}CC~AB4;8.;}uo8D?ge$W2`P9J27fysMNR~7aaH' );
define( 'LOGGED_IN_SALT',   '^XEG3w:LH_>A2E]^)y<i:.(ozm!3DPQ=f=$5,P1/1@S4!<c#o]%G-*f44.TDq35I' );
define( 'NONCE_SALT',       'Z/p=bRs?_4O;TI^ Z<%xN0|Zlko{;-JwE[PpvL7**M`QU1PL`S[byN;6J>J8syQ ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'adn';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('WP_HOME','http://localhost/MyShopbizbook365/wordpress');
define('WP_SITEURL','http://localhost/MyShopbizbook365/wordpress');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

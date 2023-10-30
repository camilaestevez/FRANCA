<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'franca' );

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
define( 'AUTH_KEY',         'N^sAUg6fZz GsMuj-y&A)5~(&L-VWB<]aY?l;D.WGIi*#V:f2:,J6[[JLu:>Ia|C' );
define( 'SECURE_AUTH_KEY',  'ffz-*G=g1@Mf3n}@yi[tRbo}N(O[GJEj6?6IYZpN9>`Ak<$+pmk#VWx7FpfaUV&&' );
define( 'LOGGED_IN_KEY',    'X^^^UBzSAwS2H](GdXi>*S!>5cR:7nV]P?VUf){<3.?3$ ;C#@)@JdFfZy r0[>T' );
define( 'NONCE_KEY',        'jHdULjZ[lzB_j}U)knH,U9;%b~PiEX?zK!*wNzTKzMv3aMChmcPcqzs:INp<^+;g' );
define( 'AUTH_SALT',        '~NO/xg)Z(?O-rg8(Fo..rDN-i}pE/wU4bagDXw31+L8;}lk_BN);sE=<2<4-xrzR' );
define( 'SECURE_AUTH_SALT', ')4k@a:FWKQ=`}S*+3RiRpL9w#bep`%f~16{{V[m>? oM}:LVqBbIlx}{{Zg?`k.|' );
define( 'LOGGED_IN_SALT',   '7OYqnvN,-mM[j4/]4LrDhia,.Bog3<-MuLb]*rw?V xb$u+i~s?QCt f3Tw6VBPC' );
define( 'NONCE_SALT',       '/Sd!hUbZeGR{gFko)vwecKFd#@Jxseko:iGshfTXr_LEyJTwp<HY-!}@FOODvV.K' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

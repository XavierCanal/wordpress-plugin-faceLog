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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'patata2' );

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
define( 'AUTH_KEY',         'jvT9*dp-$mmNL*wn8ZB%FhdU@!1x#`8tQZ%} 9%5)wh{#uP%%B{HnOGIoNg*:_lc' );
define( 'SECURE_AUTH_KEY',  'w6`31+>]=&^_%-kMU%YIL[Y2fO,@j07$zIt<>R!M&O*Nt}i[?(yM{MTWNK$;2<Y0' );
define( 'LOGGED_IN_KEY',    ':QIJ`|Q=ltkc:@d9Qm!`1X?CGEB4QQit{8A>s6b)yIJn1`mD/$[;OHnE-9xU2&AU' );
define( 'NONCE_KEY',        'Zb5M4}MIWY@}nq~3$X}<!u5}E-nRF:9*v)yv}BsZiplwiJdF3.m(fh4zlJYjq)bv' );
define( 'AUTH_SALT',        'Mn}A$UPx:7d4R{,a4vW1;SpJ#mNk,MswOsPJ;ey50*#y,sTrpj5Q8e/kU0zt34b*' );
define( 'SECURE_AUTH_SALT', 'oo5>lP+6DK|}75=GO1a@g6@D0l^B%8|:pb.%2<3(W,;]yL~Fd6`*4Vc[OqdU@U#:' );
define( 'LOGGED_IN_SALT',   '>LRJDJf0jF;(:hR(Bw-aJOnhAu16DyYXsS&j8BQ09*VHHjj^c_6$H(Kq7:[abLm(' );
define( 'NONCE_SALT',       '(/T0Q@33<z1n&7!7zn^3>am[]!H=x1(F_i}4KU7*{PP~t>1 qFrQ~SUoNGT,X!SU' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define( 'WP_MEMORY_LIMIT', '1064M' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

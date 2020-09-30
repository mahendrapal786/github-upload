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
define( 'DB_NAME', 'questam' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'vGh_TMT4[yw+U583OUF^rWdyPhg^jOctHI>7}C24Syd``C.8.Bk3!i<L :coeB*@' );
define( 'SECURE_AUTH_KEY',  'LBTEg?f[%&N_Ko)SoA^IlzAh:QxNI<w&RCM}tw?)6wxe+]#b*19a9B1Q8#,Ac)C[' );
define( 'LOGGED_IN_KEY',    'F>hx$|W*8:f>3cENq.:ld;Ac}CC?6$elbND U;a_1V!Y$Dh|R-M~VU%v7bA3%tZl' );
define( 'NONCE_KEY',        '&xASl.l|RL!IL(g>vE[KYHpB`AOAnAGmLsl/4Ew p*&i`zJA Sv(Q}cT|NE|Y9P^' );
define( 'AUTH_SALT',        ']mvZo(Lo`I-U>XEn>FEt9.!1V|Z#TqBaDHW>TVO1Gi1^#6MZZ61c^[Ap*v$!s#@h' );
define( 'SECURE_AUTH_SALT', 'of15#;$,/zTd_db(AT,`P}s-_Gp:|j/*~Z9cUpx,x1E7E5lz8}wF?<hg[DqpD)0a' );
define( 'LOGGED_IN_SALT',   '$$l RN<kn$x$/5a}g~5!3iX.)PFK3/=G:+@ARjHS!VhmDfd<Q!CVb%qCw52>W?Q]' );
define( 'NONCE_SALT',       '1` hscPLTQWJX&-i7VtOSj<]1TvWcyM.e)l,7.ffVj >`)f>HpB7Zy*3bLC2hxN@' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

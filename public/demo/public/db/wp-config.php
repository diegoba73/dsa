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
define( 'DB_NAME', 'db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Di360@23' );

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
define( 'AUTH_KEY',         'vGBa:wP2eb[W7Wr.!ZI9t-jT*^hjyb^o>tD_8z5U]lGgv?9{8h2ljvYY.>}To@QG' );
define( 'SECURE_AUTH_KEY',  '4xn/ <jp1$)>ql3D4=~<wI/9DrctW?,PwLTLMQDAPa]U^K7DTTx%ezNL!Y-Kl`UW' );
define( 'LOGGED_IN_KEY',    '8LU=RNyU] z`z<p-a}6b7{T6 ^<SDby;#2RV{1PO:#HFyWFep[hN_7fN1HUt3W/5' );
define( 'NONCE_KEY',        'fG]cyzv]It8JoAbwQ2qUN^?3TcywR[*4-Yl6G3K=oB)fPFz;828J6=%w{qOtx}.*' );
define( 'AUTH_SALT',        '}{np+2^; `q+ U8$tT^U}]k7<EaRJ(=7)MIxSX!]NPD8*PA*L?oO:JO8#d+Z9,`4' );
define( 'SECURE_AUTH_SALT', '0e,|Pp;jGKL2IKzLb(0Tfy/zc~_n)*%CA}|H7p^B[gwz- At:^6rk;=JXgW$k4E,' );
define( 'LOGGED_IN_SALT',   'hw9O:B0^qm8Q[jB4w)lRD%Z%.Wp2&_K~*Gohl$Sl1ez;wwxXS$p}?levtqE],?4q' );
define( 'NONCE_SALT',       'TT|rBHSom GH_skL;Up,D9nIe0PWk(yCJJt+w+wBORa?VgcTSRy*il//S_2,fvBg' );

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

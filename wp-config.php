<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'newgaga666');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '6)?F@k|,b6p3q_[1#m|@@E0V2}3a:8FqYxNHRWP2*HbO~^9V-,cn8rH73z]82@3)');
define('SECURE_AUTH_KEY',  '8a39-eF&kNvWUF}d[;iRSR$#fKbPF:|Nv@Ww[DVEt.d7gTL:Ni-ieUS|Noq^A]-b');
define('LOGGED_IN_KEY',    ';,rpKnK<{MB8IO]di?%t8YqZh@>~}Oq}4?,X:wxO=dH>,%E7xoa43[m5lwK#.=Br');
define('NONCE_KEY',        '5TL];Ha1A<C|ngP`;Z7_8+)A~MccbiGG/Hi^{dLgYdPZkqwE5x,B[2DU_qj*4cS2');
define('AUTH_SALT',        '2*|^|kkh`@orGLpZU?Wzl[x/WbSg[gSQo4y,v-Dx-^ DmJNPDx1o)@B::ak[CjSZ');
define('SECURE_AUTH_SALT', 'ap-b>#|5ol +t)H!A)mq#m{7:f7]zP:-UqIX._CkYc+Vct=!)q|)9fd*@C;HB_#2');
define('LOGGED_IN_SALT',   ',63}O8+IE2~%j#{uLY>+=upy.Q.:akB:x9bhPQX{w|3a;BIM-.&m;ra4>m+AMhy_');
define('NONCE_SALT',       'H[hZ|W^q*=?=ap.$,Oy0V1L+D$<I?Uot{Q-1lK!_I&gF+Eh:(eiT$N,zUEWJ{9-r');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

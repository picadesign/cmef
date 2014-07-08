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
define('DB_NAME', 'cmef_wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'zYi2zpozpRck[vS,T#|4LdyoQEjz$r{CR y<*u_lpm:Y2mzik`5pulc!?iNJSy=J');
define('SECURE_AUTH_KEY',  '6:$pCrs{[1n~35l|%]0w>+TnE5`<m%!Us-Q8o7TCU5h|>>n3;g&n,i^k=EUrq(mG');
define('LOGGED_IN_KEY',    '1`0P!h_ps.rT*p-|K=M2xT}&|+lw&t[52AQ3mF_pqz>ciT7JjAp-:q8{N|p5pR|c');
define('NONCE_KEY',        '|53b~!vq)VRqa0:>SBLx gA]-FW,ANI<??5jH2]Z;{r+9+[QVW87HDIysoF4m-Ed');
define('AUTH_SALT',        '~HW/NsZK<g)x^&o,qMl*}^.NYQZdB:v2P!+j|bq[gBH3CXW}+[!jR$;#?TBg]r$$');
define('SECURE_AUTH_SALT', '<Cc;mD@H9?=jlx{zCWGGG]!Y>u.;BkJVT`iuFG@$?G{*[ellD1jyjp>k?-`++A%^');
define('LOGGED_IN_SALT',   'J=tx|J0(UVbq;}(ldVBt8jWrl=#8new6+Yrd<t?=hR|<v.y:yQ`V@CMy]bY=V|Nv');
define('NONCE_SALT',       '<zgU* VQgy*Mn~O9!m50s/hO;zN%kHpL3 R#wp9.JmU6L%@G0E^ N[?nzyz0tF2?');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cmef_wp_';

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

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
define('DB_NAME', $_ENV['DB_NAME']);

/** MySQL database username */
define('DB_USER', $_ENV['DB_USER']);

/** MySQL database password */
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

/** MySQL hostname */
define('DB_HOST', $_ENV['DB_HOST']);

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
define('AUTH_KEY',         'nx_KN`F@D*.j%pxxcLg3:m;|5UhU@FHzTOChCt+-nlVED(C|u9wgud{a-mzLnpT3');
define('SECURE_AUTH_KEY',  'RYnlvVlHU)e,,O51PA6n4JoX,sb17)38Q?k{~nbjPB+h)0:aHA}VeN@#K+{t]PyN');
define('LOGGED_IN_KEY',    'DqFQ)Xts*T#7y,eVq$M]T=lWao,|.`oy[@-,! *o_ vMchBy& 4P]H`Z/9&4GJC3');
define('NONCE_KEY',        'JS^^V0[]S!8%FoPb?RDC|WOqYmf)zTU^=LgpG}eux^8oe@Gy9+A.i]+u|47N`RkF');
define('AUTH_SALT',        '&:(Hj>[Q<=+A-#0+lI9<r)8#7yI/4z|q1i6T?pO{697*`|6H<a3=wq5=YZjqdj,$');
define('SECURE_AUTH_SALT', '-%V@8wp}34S>M^dfpZix?89mV?&(3oG;kBs(hO[tmDy{];|0VCKQn>l}ABl7 hRL');
define('LOGGED_IN_SALT',   '{gB<XqH@YxMeJdF1nob]o73}|2|<3@I>_tp74|qI;MU,K68<6RaME+l|g3hq=~]0');
define('NONCE_SALT',       'WAv8HuDU=dVzHauC?fPM([~`^@~BAN7kTMu6}^7w;)^=ZFA5.sU78eW>2e?{=>_&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_jlord';

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

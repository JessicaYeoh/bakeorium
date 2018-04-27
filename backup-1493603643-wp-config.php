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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'essicaye_wp_r0i7' );

/** MySQL database username */
define( 'DB_USER', 'essicaye_wp_r0i7' );

/** MySQL database password */
define( 'DB_PASSWORD', '53CDFAEsw7mt4k9h6e0d1x8b2' );

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
define('AUTH_KEY',         '!x<lS|.mF7<(u] M|6NUy!=V502k6-zoZKn~F_Eip4f[aGD$G3&Er$Wz,4:@Q$j3');
define('SECURE_AUTH_KEY',  '?t_:o<@]iKY(-N^n!b)6E5Ez*Q)*}+Aw-@Rflgl~)hNq]@X6Bc *._R4]4lGz%Y8');
define('LOGGED_IN_KEY',    '2=g-?/D[yj@vj[6Rqa.+jInw3j?_D$w/iNjEr bY@tY+ki Q,eb||k|Jv!*|R*aB');
define('NONCE_KEY',        '&[ilW~NAK /FPb$Iq_`e[~RRnKYIY]#A=YKp+-9@7ON{8E/yFc^YCtTO%xw.OQO9');
define('AUTH_SALT',        'Pf$w&*n}lg}|3eic9`ju(GQhC6e]i9cyn|<8r^KkHG+jUw*lXQE_hj{K-`(S-*e;');
define('SECURE_AUTH_SALT', '|c*f+- XD^r-gpUZKpS,_8quz+HH-<TH54K[ e5{$~3/Ev?7,7+KbizAx0/t]9)V');
define('LOGGED_IN_SALT',   'o2a@OI_t}$zQ_fj0MYZ-$S#Z>--K!0(CZop*<l,,a)`(eW$D>[= EVF_e:I+q!XH');
define('NONCE_SALT',       ':KeZn3w/bIeu!>Sugw<<!mt&f:J/&V,ZZWXwdPB/%N._:HS&S{laMMj+o247KSBd');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_r0i7b4u5_';


define( 'AUTOSAVE_INTERVAL',    300   );
define( 'WP_POST_REVISIONS',    5     );
define( 'EMPTY_TRASH_DAYS',     7     );
define( 'WP_AUTO_UPDATE_CORE',  true  );
define( 'WP_CRON_LOCK_TIMEOUT', 120   );


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

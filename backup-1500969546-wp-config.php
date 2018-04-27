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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'essicaye_ss_dbname04c');

/** MySQL database username */
define('DB_USER', 'essicaye_ss_d04c');

/** MySQL database password */
define('DB_PASSWORD', '4uT2261T1YaZ');

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
define('AUTH_KEY', 'oIZnppe(]fdHp+<URuGXJS_PKqi{_/U_Ke=D_!*^@l(_MLHJGFmGlLMAVA<lgOK<WFXXIxs_/}?*nW[G=}AUsXk}Re*qEz|x<VDQ/)o+yL!s$>!pjsIhQlyfss;kxQxe');
define('SECURE_AUTH_KEY', 'UPq@vr)jMsmjQ?dERWF}L/%JgIEb[JPfM%BcT]%oj*K=[KQo*-S{PFYa-VBc-@$ztD@g(LHJogrTajDgom^HA|RKtBaA+(pCBpFsB)u_vV|z-ZVP>]|cahRQqd*Fkyj]');
define('LOGGED_IN_KEY', '{/M/QdlHu>@}[M?cEk!UBW_JY{;AZ!Fh[T>Ts);KhM]P(-p>Hha[H<e|OcRC+=$tOI^/?Pg$%$=|idR(sWYaxz|A*%Eo/yqd}DB]U_)j&evzsX=waRMm<^wa/CW;Uz{s');
define('NONCE_KEY', 'QWAY@WX&b+e<qmeEYg[G}wq<^&?|wcY?|Svk)o{>_$||f!jHD&REX|PQTzYi>-?FQoD-ZegspcFpt$_^MG?=&xHwS$?xAS]TT{bwAZsFskG=<zhZ>Z*e{a*xU*N!SZbS');
define('AUTH_SALT', 'h_)*_;rHausJnV_@->u@e*xWSlFex^D=[%}^CiM}Wa_hU<+sLM^RhWis>$YQmS)IB=y<rv$;He@++IZe^)uYWSS*EjhghG?Vul=A^DGj@%q[DIf$QT^jPRg)j<-LdnuV');
define('SECURE_AUTH_SALT', '?fhucm{?CGWn!xzVI%mUS_]FtTK)!QwhsJ=]wgA&{kI_<+swNr/qwW%kwnlaZEa>e/W*(v+ZHhKl>REnMbfjW+ZA%hxij;L%Ln_;SK|+&_N|g%XNWCbmvWKMOe[PfZJh');
define('LOGGED_IN_SALT', 'fJdUm/aT<Ki&!{oJZSqQGazRb>cJ@T)ga*}O*$Dd_OA!LLwBA!=|PKs)s$Em&Rb(FkbE?PAPtXnqvhl|cfV=c|)=e$DR*klk-|yNF&yMm|Idmzb}egl>^fsGW?Qg>RgD');
define('NONCE_SALT', 'zrt]zufJ?)Jr>kM{ezwo%?dc>enX=J/wZmeqQZA|RAKuC+pQI_a;)?$?|yV)KbcpNok!yR{<bZbt;fgFQ|dBoDOwhFJ/EJ-_drTlD(lVd)CnM_}M+CHyn&k)Fn^obECX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_xrvv_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

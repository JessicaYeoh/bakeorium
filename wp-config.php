<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'mywebsite');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY', 'R(!Cfvp)qdMt+Tvi&+eSCw&-YF;KQW>=r^C<R)]qbyY+!z$@rq%ablu&e|jK(yXTsCu@tiAI{<JJ^Faf$&bH/QDiS=c/oTSA&u>BnoX(gB&zNaVai&N*R_mtjet-cMMP');
define('SECURE_AUTH_KEY', '^ajfKBcr/BNb|j=FR-oE^sAVh$xx<xuBYZ!>a!TM?hIjdp+NW(%S}Y{=_usapKI;!q]D}uPK=fwxtRW*FSs=f_|gU?p_BP*x<lZNnekjzTdM>b-RFP}R$$q]hPvAAbZU');
define('LOGGED_IN_KEY', 'bc@{j(c/If&v}!ni-DR_jblLB^wrEN+F&YkHkh>QnsgY!n+JnBJiWtp}Kj+IR=U]{PBiG[Ayzbk?]Zwtpbadu%IwYZWQawrCgLdwz{n!CiYFU@Wabs&ktGaiwk>dA)wB');
define('NONCE_KEY', 'xe?zmOI@v$h$wfYrU->P]F=zBqgFCcbX<+q^-@tOQdme?]pj)cF]d+U^TB?+ey+ofQK-WlS_Q+pqFbvC^f;PsnYShSx?Vzyc$UCV)io=^]]W!wGlh*jSQRp{CIpaUA-$');
define('AUTH_SALT', 'VlHF+vX&gL^j^QYuhYdIh+nY=ar$%|vA$O%aaD^MczkbyaJ;jkXuJXp?efVABiyPLmwvir]rtcGu()aao&EfsZLW(QqHMeCF>x^F*SqG-fPPesj(!^ot]I+fseOpFXBT');
define('SECURE_AUTH_SALT', 't[>V+Mp;IVxQUay+P/s$}X&+mOhx<dIgIJqnWAb^CrM>x+_SRs!$=FzjLyn+sh+Y]|PESO&ouw=/wdeq%qKYt@FIlGX]g_OOSKV{zx^b$maSfDO[gs_?)n}?(qbeBbwL');
define('LOGGED_IN_SALT', 'ILgq_l|MxVkjHC;[&]$mB&wDkY%cWJ)dJ/k!kqpdUJV]}@@%SnKqgWp?d}>(C$)LHQPtQ|tFRj(hAYx=nKuEc%t|^?|DwIJd<A[$k];LSaZ)b<gDHAx+DJ^VYU!MZ{$!');
define('NONCE_SALT', 'Qz=;okrqQ<x;gWzF<;(NGfj>}?k{EcaIVggw}Cdd$Yjg{N}vJFgHzHQz!AYszD-f@[hkHP@_sGEiBUi*|MW!JdfQjcxy]+egI^OlXo/^eZZ[X&Q+{D>{UuHxY|}[psP;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_tlii_';

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

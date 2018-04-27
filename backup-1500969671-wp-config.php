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
define('DB_NAME', 'essicaye_ss_dbname620');

/** MySQL database username */
define('DB_USER', 'essicaye_ss_d620');

/** MySQL database password */
define('DB_PASSWORD', 'JcSYUjBwa6Ni');

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
define('AUTH_KEY', 'tbfdt%CQZT_!K}pgjWb}DwNiniFy_@Bi=$YVU|(uB@x[jYhN]wqlx/]IA(P{P}HjK=HmnAy=n=EtD]Op<+SOVt?@ZPnS@cnKe{iZzUPhsA/F!xU<NXQw&C_H&e_nHDGi');
define('SECURE_AUTH_KEY', '/ipHpqIOyheaDAHE^^)J>WYXP!YuxWkMf)DMNq(&Y*rg^y_U}LwrO+(id!o!Oytm_Nc/{>c_kU_;pKssp-|eSeO;cSYUajQ/xaH]zE!yRv<rCjV+(/y>)S-$Zfuqmdrn');
define('LOGGED_IN_KEY', '*^SC^h|W<fxsPqOqgw&D^^Vm%tzXa*BfVGcArr|hIEfKjG-*MTJ}Y<C_u^(lgYcaf<%i-b*-RUb(eWcUor=H%Si=Z_QRCbuZdBLgR/WYthB>NlT(Ovm^=rxFWwSFlI+@');
define('NONCE_KEY', 'r&_B!-go;sQ@!rWfq/Gmh=EKPJ@C@]pidpDf_rjY[F!-nr&eNIEpbIxZTt@?xIf>hZcOKA|q/h]OJ^Hg%B!/RwoFIMG[SNUk&*SO=DCPLTifL|yai(Zz-hOZe*uX{W<|');
define('AUTH_SALT', 'r{k{QzlqQ)ZHcq!+(vpG/Abvb%qm_lcb!DEC+/Tf]upVEI[{VduhdfSbKb})R(^nem/;{uwdgcnDilwg|i%of<T_u/|sIB@wcP-FT*=QdI;hfq|Hm;pv?{tuiDg)w(DN');
define('SECURE_AUTH_SALT', 'caPbJ)q?n<mad$;aoUMb%o[}Ssk<Qn);[]Yr<[tDp_A;<=w*evrpoLNBnAZbj!]g)kY?PIPduaVwRfuRAugd|-cq}?uPW@[?@-sfNw|-^|GRD=|;yRD!Ejznn>_jfLKS');
define('LOGGED_IN_SALT', '+M}wbFj?$!qMkaT{LO;BGaNJddN|o{tt{okYQnY$=_vcGaBhP%vWNdupCrU|B{HUR<@=C}IdGoZ%JPCVFc[eMRpB_<MXbfGB;s]n![s{*[iZf@(=i/]cLeuhFK+|JEV_');
define('NONCE_SALT', 'tRa$]x>dB}}k]dz-mTT+GYJtTOjV)}L_btbputtQM=|e[zUG;RndGjD(RnJlQG;oqJ*cW&TeLtoyX*ZC<@k}<AQM*rINBNnWFmdkKIiTuM|l//;pnh{Wr@O/>ae))XFL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_muls_';

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

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
define('DB_NAME', 'essicaye_ss_dbnameea4');

/** MySQL database username */
define('DB_USER', 'essicaye_ss_dea4');

/** MySQL database password */
define('DB_PASSWORD', 'rcwIuBj5D7mh');

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
define('AUTH_KEY', '-d}rdF[h?mDghdTafFC>TNsJj=a>|S(dq%w?{za/qDp^eB|M_Nj_SINp_)FK{*QqCO<n&fHsCRg_sF&s!]_?x/EOk|!hoSnc@f!YuqJ{)>S{SG<jxUcw=jofsSbp(i@P');
define('SECURE_AUTH_KEY', 'gycfc?MLF&yL^KTmFZ<!S_k}Y](X)BxTS;FYuq-ooe]IU%xqvA]|TbmD-/E||<{Nku/{SN_AXp_bQl}b-YAAze@F<K+UV+UU<WEGR(_-Tyvsl?Kcr+}!EjVeao)<T[*s');
define('LOGGED_IN_KEY', 'X%)D@Ab%>odN)sDp(U%Q+@v(xER-/)!}d&Zs|g{x@Nm@fG&l]h{fu?ga%((|>d/GuH^BuyJiyBGgOvfT^FNTd%wmJ[G>OdWYoTe?HwsQELvY>(LjC=tHB>njO>{Gexet');
define('NONCE_KEY', '-$hiM_ZxICeA_yrNZVsfc<Mn-=-DYR]ErvSW+ad?yLWmdyENykmAuTti?bs[In+Se)McsHr-sdVXwus{>|+cGrh}r[_=<U^&GgwgyRWy*d|/Lc[Ns[>sGvrwJZ@&%y};');
define('AUTH_SALT', ')-Je^{YDsONr^Rr<//*&@]R&fF)a*<$d$wm]sZ|@ySPOD%?zrhw}cOmix;Ihuptrb*|bzl^Tqmq[b@e@!$G}JJKd$i]p?BZ||&P>)Hj}ki|UEIK$Q}WjwHoZ_XWsPM$!');
define('SECURE_AUTH_SALT', 'Y)w>i(WLlXFZ=e^^V<K^kK)@}G>-e})IxPYnrBvDbPlzs$(mkUui]?bk?TeIaf/j-R-!;@sSq+[*;?tEy&!P[;IcPR!uDeSq?TOwtBx+<TaGG]!TaPj]f<g=L@Ohq$Nd');
define('LOGGED_IN_SALT', '[BO[^l<MAMbu*EjX)j&IE${kmNL^=twyCXM$EVTGZ)GGH!Flkt^pAvJ$Ct?JVUohDDMLbp!_^VOFKBt&Rd&czDwXTwdQe!mmY<YYWy=kMa%DLA{JVW%_-i[+JPcDnE)y');
define('NONCE_SALT', '}bTG@C+(!fNsvBH@]}NC;zeC|@f+[[XT[/zBO@xMp{=ug(GU!D>W]la[nkZjYpYB*ro-A>CXa+zELJmFT*u%xWK+MW/vcoEK*^bjxoyRnFLeHZfFqqpE)LeQDOP$B;Up');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_pmju_';

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

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
define( 'DB_NAME', 'stream2' );

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
define( 'AUTH_KEY',         ' @POE/-2TXFZ^T! RI1+Ho[L]Oynv*NXJ6TB0O*Rf``r^t`A&jcH5buh!6-v_$CH' );
define( 'SECURE_AUTH_KEY',  'i5!hyr/cp4CSzl^Cxc)A<m%67Je7eot/yGv/No}E6(B_^!H-W-.fLd}1V+P$zXy)' );
define( 'LOGGED_IN_KEY',    '>L9XJ?mvQy[l}q%!hj|R!Vmtir[BAH@d-f4?vC!2k(0J,o2&=S)8Z<Oq2(&zXDsx' );
define( 'NONCE_KEY',        'oQrj]q{XMHF=RrR4@>[MT1=(yIyrfpKsg<%>)C3[=vy^@g}/Mu0~Ehkrx2DO-d/&' );
define( 'AUTH_SALT',        'Uh7dR(.&6L0JOtN2kp5VE|tqUp[MbD(fE{?]DKGjI9e7fH6uHU=+=I{z+$L(dgJm' );
define( 'SECURE_AUTH_SALT', 'jhiy?8@Ny;^wrA5$`d`#dPY3U)u%G6tZl Vm+{Px7AUf,6qCoT?^7Jndhgc:uUS<' );
define( 'LOGGED_IN_SALT',   '[u|VE#KILPf9 v:n306WE<q.8yd=s->*TL>w(B/!7q9_.eBSDnUJ}!seK/T]-dU5' );
define( 'NONCE_SALT',       'mfhs$,4A/+OdV)H_g<?^h-)wD{eBvy4k^K9I|ejH[&<-eXn]zXWbrkbSE[13w2<k' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

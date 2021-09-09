<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'dixeed' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'FQT^]!>|{7pvcA w3[9G+hcWb(ZFAB[6mvN>Ah|Ozp7^bz)2EPsVgk(E@cQ ^Anb' );
define( 'SECURE_AUTH_KEY',  ')Z2=w1>^Z~gg6@V[$>^L@J~!-[@Dvre~So$*H+J7dpd9s@,qWbwwn:QO]Rr~xGIW' );
define( 'LOGGED_IN_KEY',    '.0hf]Kv(p*clp*N6f,$LU![#c+JVamvKa:&+o$;W*s$Cx%`]NZyR_~p~_1~|Fjjb' );
define( 'NONCE_KEY',        '26|BIBp]j%/&$Lnm(a0O<Ufg ??~Qkm xi[|6Z<:[^TZ}.|<)/)8-w4/L&(4awm=' );
define( 'AUTH_SALT',        'Qwk&+v FwqTGvZ:Yz)|%_:CCcW]P62%y_b!B?R(MzAz4&,Hya#3;7}2$`9-h5t!i' );
define( 'SECURE_AUTH_SALT', 'O@NhaqR#+nFVm:g^o1>txrT[|v3G~I^D/i4#bC8t-bg%0^}McJWYys0boC`%J#p-' );
define( 'LOGGED_IN_SALT',   '<%mIo`rd]burlGkc$ecUP`&ye[ARZWF#B{x*%.B.aE[!#X>cAx-{ZZf-x~FO>@#a' );
define( 'NONCE_SALT',       ']S=Mnj(C3M0upnzwBa(6Qs+![EMFsZR#@K^)U_JHN2(_tiF-3unOm>4H(mVC<}_L' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'dx_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );

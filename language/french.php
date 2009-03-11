<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2008-12-27 22:10:24 +0100 (Sa, 27 Dez 2008) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 3531 $
 * 
 * $Id: english.php 3531 2008-12-27 21:10:24Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$lang['ENCODING'] = 'iso-8859-1';
$lang['XML_LANG'] = 'fr';

$plang = array_merge($plang, array(
  'latestposts'                 => 'Derniers messages du forum',
  'portal_latestposts_nomodule' => 'Pas de module sélectionné. Vérifiez les paramètres !',
  'portal_latestposts_invmodule'=> 'Mauvais module de forum.',
  'pk_latestposts_bbmodule'     => 'Module du forum.',
  'pk_latestposts_amount'       => 'Afficher les x derniers messages.',
  'pk_latestposts_newdb'        => 'Le forum est sur une BDD différente.',
  'pk_latestposts_dbname'       => 'Base de données.',
  'pk_latestposts_dbuser'       => 'Utilisateur',
  'pk_latestposts_dbpassword'   => 'Mot de passe',
  'pk_latestposts_dbhost'       => 'Serveur',
  'pk_latestposts_dbprefix'     => 'Préfixe',
  'pk_latestposts_url'          => 'URL du forum',
  'pk_latestposts_noentries'    => 'Pas de messages disponibles.',
  'pk_latestposts_connerror'    => 'Erreur de connexion.',
  'pk_latestposts_lastpost'     => 'Dernier message',
  'pk_latestposts_starter'      => 'Début',
  'pk_latestposts_posts'        => 'Réponses',
  'pk_latestposts_title'        => 'Titre',
  'pk_latestposts_trimtitle'    => 'Tronquer les titres longs après x lettres.',
  'pk_latestposts_trimtitle_h'  => 'Uniquement pour le module placé à droite ou à gauche.',
  'pk_latestposts_privateforums'=> 'ID des forums privés, séparés par un point-virgule',
  'pk_latestposts_privforums_h' => 'Les forums privés ne sont pas affichés dans la liste des derniers messages.',
  'pk_latestposts_plus2old'     => 'Version Plus périmée. 0.6.2.0 stable ou supérieure requise.',
  'pk_latestposts_newwindow'    => 'Ouvrir les liens dans une nouvelle fenêtre ?',
  'pk_latestposts_blackwhite'   => 'Listes noires ou blanches',
  'pk_latestposts_blackwhite_h' => 'Rejette les ID de forum insérés (liste noire) ou les accepte (liste blanche)',
));
?>

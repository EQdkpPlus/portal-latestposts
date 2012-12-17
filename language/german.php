<?php
 /*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2010-07-11 16:25:04 +0200 (So, 11. Jul 2010) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2006-2010 EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 8345 $
 * 
 * $Id: german.php 8345 2010-07-11 14:25:04Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$plang = array_merge($plang, array(
  'latestposts'                 => 'Neuste Beiträge',
  'portal_latestposts_nomodule' => 'Kein Forenmodul gewählt. Bitte Moduleinstellungen prüfen!',
  'portal_latestposts_invmodule'=> 'Ungültiges Forenmodul',
  'pk_latestposts_bbmodule'     => 'Forenmodul',
  'pk_latestposts_amount'       => 'Zeige neuste x Einträge',
  'pk_latestposts_newdb'        => 'BB in anderer Datenbank',
  'pk_latestposts_dbname'       => 'Datenbank',
  'pk_latestposts_dbuser'       => 'Benutzer',
  'pk_latestposts_dbpassword'   => 'Passwort',
  'pk_latestposts_dbhost'       => 'Host',
  'pk_latestposts_dbprefix'     => 'Prefix',
  'pk_latestposts_url'          => 'URL zum Forum',
  'pk_latestposts_noentries'    => 'Keine Einträge vorhanden',
  'pk_latestposts_connerror'    => 'Fehler in der Verbindung',
  'pk_latestposts_lastpost'     => 'Letzter Eintrag',
  'pk_latestposts_starter'      => 'Starter',
  'pk_latestposts_posts'        => 'Antworten',
  'pk_latestposts_title'        => 'Titel',
  'pk_latestposts_trimtitle'    => 'Lange Thementitel nach x Buchstaben beschneiden',
  'pk_latestposts_trimtitle_h'  => 'Gilt nur für die Anzeige Rechts/Links',
  'pk_latestposts_privateforums'=> 'ID der privaten Foren, getrennt durch Semikolon',
  'pk_latestposts_privforums_h' => 'Private Foren werden nicht in den neusten Einträgen gelistet',
  'pk_latestposts_plus2old'     => 'Plus Version zu alt. 0.6.2.0 Stable oder höher benötigt',
  'pk_latestposts_newwindow'    => 'Öffne Links zu Beiträgen in neuem Fenster?',
  'pk_latestposts_blackwhite'   => 'Black - oder Whitelists',
  'pk_latestposts_blackwhite_h' => 'Eingegebene ForenIDs zulassen (Whitelist) oder Abweisen (Blacklist)',
));
?>
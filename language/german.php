<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date$
 * -----------------------------------------------------------------------
 * @author      $Author$
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev$
 * 
 * $Id$
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
  'pk_latestposts_bbpath'       => 'Pfad zum Forum',
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
));
?>

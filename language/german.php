<?php
/*	Project:	EQdkp-Plus
 *	Package:	Last posts Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2016 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'latestposts'						=> 'Neuste Beiträge',
	'latestposts_name'					=> 'Letzte Forums-Beiträge',
	'latestposts_desc'					=> 'Zeigt die neuesten Beiträge aus deinem Forum an',
	'portal_latestposts_nomodule'		=> 'Kein Forenmodul gewählt. Bitte Moduleinstellungen prüfen!',
	'portal_latestposts_invmodule'		=> 'Ungültiges Forenmodul',
	'portal_latestposts_noselectedboards' => 'Es wurden keine Foren zur Anzeige ausgewählt.',
	'latestposts_f_bbmodule'			=> 'Forenmodul',
	'latestposts_f_dbmode'				=> 'Wähle den Verbindungsmodus zur Datenbank',
	'latestposts_f_help_dbmode'			=> 'Die Datenbankverbindunsdaten werden nur bei der Einstellung "Andere Datenbank als EQDKP" benötigt',
	'latestposts_dbmode_same'			=> 'Forum in selben DB wie das EQDKP',
	'latestposts_dbmode_new'			=> 'Forum in anderen DB als das EQDKP',
	'latestposts_dbmode_bridge'			=> 'Verwende die Verbindung der Bridge',
	'latestposts_dbmode_none'			=> 'Keine',
	'latestposts_f_dbname'				=> 'Datenbank',
	'latestposts_f_dbuser'				=> 'Benutzer',
	'latestposts_f_dbpassword'			=> 'Passwort',
	'latestposts_f_dbhost'				=> 'Host',
	'latestposts_f_dbprefix'			=> 'Prefix',
	'latestposts_f_url'					=> 'URL zum Forum',
	'latestposts_f_amount'				=> 'Zeige neuste x Einträge',
	'latestposts_f_trimtitle'			=> 'Lange Thementitel nach x Buchstaben beschneiden',
	'latestposts_f_help_trimtitle'		=> 'Gilt nur für die Anzeige Rechts/Links',
	'latestposts_f_linktype'			=> 'Wie sollen die Links zu Beiträgen geöffnet werden?',
	'latestposts_f_blackwhitelist'		=> 'Black - oder Whitelists',
	'latestposts_f_help_blackwhitelist'	=> 'Eingegebene ForenIDs zulassen (Whitelist) oder Abweisen (Blacklist)',
	'latestposts_f_privateforums'		=> 'Black-/Whitelist für Benutzergruppe: ',
	'latestposts_f_help_privateforums'	=> 'Trage hier die IDs der Foren für die angezeigt Benutzergruppe ein, durch Kommas getrennt',
	'latestposts_f_help_privateforums2' => 'Wähle die Foren für die angezeigte Benutzergruppe aus, auf die die Black-/Whitelist angewendet werden soll',
	'latestposts_noentries'				=> 'Keine Einträge vorhanden',
	'latestposts_connerror'				=> 'Fehler in der Verbindung',
	'latestposts_lastpost'				=> 'Letzter Beitrag',
	'latestposts_starter'				=> 'Starter',
	'latestposts_posts'					=> 'Beiträge',
	'latestposts_title'					=> 'Thema',
	'latestposts_forum'					=> 'Forum',
	
	'latestposts_display_normal'		=> 'Normal',
	'latestposts_display_accordion'		=> 'Akkordion',
	'latestposts_f_showcontent'			=> 'Vorschau des Posts anzeigen',
	'latestposts_f_style'				=> 'Darstellung',
);
?>
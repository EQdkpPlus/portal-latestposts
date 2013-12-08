<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-12-01 00:20:24 +0100 (Sa, 01. Dez 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12525 $
 * 
 * $Id: english.php 12525 2012-11-30 23:20:24Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'latestposts'						=> 'Latest Forum Posts',
	'latestposts_name'					=> 'Latest Forum Posts',
	'latestposts_desc'					=> 'Show the recent posts of your bulletin board',
	'portal_latestposts_nomodule'		=> 'No board module selected. Please go to module settings and configure this module.!',
	'portal_latestposts_invmodule'		=> 'Wrong BB Module',
	'portal_latestposts_noselectedboards' => 'No forums have been selected to be displayed.',
	'latestposts_f_bbmodule'			=> 'Forum Module',
	'latestposts_f_dbmode'				=> 'Select the database connection mode',
	'latestposts_f_help_dbmode'			=> 'The Database connection information is only required if you select "Another DB than EQDKP"',
	'latestposts_dbmode_same'			=> 'Forum is in the same db as EQDKP',
	'latestposts_dbmode_new'			=> 'Forum is in another db as EQDKP',
	'latestposts_dbmode_bridge'			=> 'Use connection settings of bridge',
	'latestposts_f_dbname'				=> 'Database',
	'latestposts_f_dbuser'				=> 'User',
	'latestposts_f_dbpassword'			=> 'Password',
	'latestposts_f_dbhost'				=> 'Host',
	'latestposts_f_dbprefix'			=> 'Prefix',
	'latestposts_f_url'					=> 'URL to the Board',
	'latestposts_f_amount'				=> 'Show last x Entries',
	'latestposts_f_trimtitle'			=> 'Trim long topic titles after x chars',
	'latestposts_f_help_trimtitle'		=> 'Only when in left/right Module block',
	'latestposts_f_linktype'			=> 'How should the topic links be opened? ',
	'latestposts_f_blackwhitelist'		=> 'Black - or Whitelists',
	'latestposts_f_help_blackwhitelist'	=> 'Reject the inserted Forum IDs (blacklisting) or accept them (whitelisting)',
	'latestposts_f_privateforums'		=> 'Black-/Whitelist for Usergroup: ',
	'latestposts_f_help_privateforums'	=> 'Insert here the forum IDs used by Black-/Whitelist, seperated by commas',
	'latestposts_f_help_privateforums2'	=> 'Select the forums for the shown usergroup used by Black-/Whitelist',
	'latestposts_noentries'				=> 'No entries available',
	'latestposts_connerror'				=> 'Connection Error',
	'latestposts_lastpost'				=> 'Last Answer',
	'latestposts_starter'				=> 'Starter',
	'latestposts_posts'					=> 'Replies',
	'latestposts_title'					=> 'Topic',
	'latestposts_forum'					=> 'Board',
);
?>
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
  'latestposts'                 => 'Latest Forum Posts',
  'portal_latestposts_nomodule' => 'No Module Selected. See the Module Settings!',
  'portal_latestposts_invmodule'=> 'Wrong BB Module',
  'pk_latestposts_bbmodule'     => 'Forum Module',
  'pk_latestposts_amount'       => 'Show last x Entries',
  'pk_latestposts_newdb'        => 'BB in different Database',
  'pk_latestposts_dbname'       => 'Database',
  'pk_latestposts_dbuser'       => 'User',
  'pk_latestposts_dbpassword'   => 'Password',
  'pk_latestposts_dbhost'       => 'Host',
  'pk_latestposts_dbprefix'     => 'Prefix',
  'pk_latestposts_bbpath'       => 'Path to the Forum',
  'pk_latestposts_noentries'    => 'No entries available',
  'pk_latestposts_connerror'    => 'Connetction Error',
  'pk_latestposts_lastpost'     => 'Last Entry',
  'pk_latestposts_starter'      => 'Starter',
  'pk_latestposts_posts'        => 'Replies',
  'pk_latestposts_title'        => 'Title',
  'pk_latestposts_trimtitle'    => 'trim long topic titles after x chars',
  'pk_latestposts_trimtitle_h'  => 'Only when in left/right Module block',
  'pk_latestposts_privateforums'=> 'ID of the private forums, seperated by semicolon',
  'pk_latestposts_privforums_h' => 'Private Forums will not be listed in the latest posts.',
  'pk_latestposts_plus2old'     => 'Plus Version too old. 0.6.2.0 Stable or higher required',
  'pk_latestposts_newwindow'    => 'Open Topic Links in New window?',
  'pk_latestposts_blackwhite'   => 'Black - or Whitelists',
  'pk_latestposts_blackwhite_h' => 'Reject the inserted Forum IDs (blacklisting) or accept them (whitelisting)',
));
?>

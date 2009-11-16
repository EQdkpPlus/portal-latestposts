<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2009-03-14 16:05:08 +0100 (Sa, 14 Mrz 2009) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 4210 $
 * 
 * $Id: ipb2.php 4210 2009-03-14 15:05:08Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$defprefix      = ($conf_plus['pk_latestposts_dbprefix']);
$table_topics   = $defprefix. "forum_t";
$table_members  = $defprefix. "user";

// Build the db query
$myBBquery  = "SELECT t.thread_id as bb_topic_id, t.thread_name as bb_topic_title, 
              t.thread_forum_id as bb_forum_id, t.thread_datestamp as bb_posttime, t.thread_total_replies as bb_replies, 
              t.thread_user as bb_poster_id, m.user_name as bb_username
              FROM ".$table_topics." t, ".$table_members." m
              WHERE t.thread_lastuser = m.user_id ";
if(is_array($privateforums)){
  $myBBquery .= " AND t.thread_forum_id ".$black_or_white."(". implode(', ', $privateforums).") ";
}
$myBBquery .= "ORDER BY t.thread_lastpost DESC LIMIT ".$topicnumber;

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  return 'e107_plugins/forum/forum_viewtopic.php?'.$row['bb_topic_id'];
  }

?>

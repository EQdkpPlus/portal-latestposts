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
 * $Id: e107.php 8345 2010-07-11 14:25:04Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$defprefix      = trim($conf_plus['pk_latestposts_dbprefix']);
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
$myBBquery .= "ORDER BY t.thread_lastpost DESC LIMIT ".trim($topicnumber);

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  return 'e107_plugins/forum/forum_viewtopic.php?'.$row['bb_topic_id'];
  }

?>
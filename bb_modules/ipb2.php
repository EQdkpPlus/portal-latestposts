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
 * $Id: ipb2.php 8345 2010-07-11 14:25:04Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$defprefix      = ($conf_plus['pk_latestposts_dbprefix']) ? trim($conf_plus['pk_latestposts_dbprefix']) : 'ipb_';
$table_topics   = $defprefix. "topics";
$table_members  = $defprefix. "members";

// Build the db query
$myBBquery  = "SELECT t.tid as bb_topic_id, t.title as bb_topic_title, 
              t.forum_id as bb_forum_id, t.last_post as bb_posttime, t.posts as bb_replies, 
              t.last_poster_id as bb_poster_id, m.name as bb_username
              FROM ".$table_topics." t, ".$table_members." m
              WHERE t.last_poster_id = m.id ";
if(is_array($privateforums)){
  $myBBquery .= " AND t.forum_id ".$black_or_white."(". implode(', ', $privateforums).") ";
}
$myBBquery .= "ORDER BY t.last_post DESC LIMIT ".trim($topicnumber);

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  if($mode=='member'){
    return '/index.php?showuser='.$row['bb_poster_id'];
  }else{
    return '/index.php?showtopic='.$row['bb_topic_id'].'&view=getlastpost';
  }
}
?>
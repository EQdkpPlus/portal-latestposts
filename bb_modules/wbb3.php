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
 * @copyright   2006-2010 EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$defprefix      = ($conf_plus['pk_latestposts_dbprefix']) ? trim($conf_plus['pk_latestposts_dbprefix']) : 'wbb1_1_';
$table_threads  = $defprefix. "thread";
$table_posts    = $defprefix. "post";

// Build the db query
$myBBquery  = "SELECT t.threadID as bb_topic_id, t.topic as bb_topic_title, 
              p.postID as bb_last_post, t.lastPostTime as bb_posttime, 
              t.replies as bb_replies, t.lastPosterID as bb_user_id, 
              t.lastPoster as bb_username
              FROM ".$table_threads." t, ".$table_posts." p
              WHERE t.threadID = p.threadid";
if(is_array($privateforums)){
  $myBBquery .= " AND t.boardID ".$black_or_white."(". implode(', ', $privateforums).")";
}
$myBBquery .= " AND p.time = t.lastPostTime 
              ORDER BY t.lastPostTime DESC LIMIT ".trim($topicnumber);

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  if($mode=='member'){
    return 'index.php?page=User&userID='.$row['bb_user_id'];
  }else{
    return 'index.php?page=Thread&threadID='.$row['bb_topic_id'].'&action=firstNew';
  }
}
?>
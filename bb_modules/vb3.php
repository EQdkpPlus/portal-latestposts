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
 * $Id: vb3.php 8345 2010-07-11 14:25:04Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$table_threads  = trim($conf_plus['pk_latestposts_dbprefix']). "thread";
$table_posts    = trim($conf_plus['pk_latestposts_dbprefix']). "post";
$table_users    = trim($conf_plus['pk_latestposts_dbprefix']). "user";

// Build the db query
$myBBquery  = "SELECT t.threadid as bb_topic_id, t.title as bb_topic_title, 
              t.lastpostid as bb_last_post, t.forumid as bb_forum_id, 
              t.lastpost as bb_posttime, t.replycount as bb_replies,
              u.userid as bb_user_id, u.username as bb_username
              FROM ".$table_threads." t, ".$table_posts." p, ".$table_users." u
              WHERE t.threadid = p.threadid
              AND t.open = '1' AND ";
if(is_array($privateforums)){
  $myBBquery .= "t.forumid ".$black_or_white."(". implode(', ', $privateforums).") AND ";
}
$myBBquery .= "p.postid = t.lastpostid AND
              p.userid = u.userid
              ORDER BY t.lastpost DESC LIMIT ".trim($topicnumber);

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  if($mode=='member'){
    return '/member.php?u='.$row['bb_user_id'];
  }else{
    return '/showthread.php?p='.$row['bb_last_post'].'#post'.$row['bb_last_post'];
  }
}
?>
<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2008-12-16 17:33:02 +0100 (Di, 16 Dez 2008) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 3396 $
 * 
 * $Id: phpbb3.php 3396 2008-12-16 16:33:02Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$table_threads  = $conf_plus['pk_latestposts_dbprefix']. "thread";
$table_posts    = $conf_plus['pk_latestposts_dbprefix']. "post";
$table_users    = $conf_plus['pk_latestposts_dbprefix']. "user";

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
              ORDER BY t.lastpost DESC LIMIT ".$topicnumber;

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

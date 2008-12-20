<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
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

// Define the tables & configuration options
$table_topics = $conf_plus['pk_latestposts_dbprefix']. "topics";
$table_members = $conf_plus['pk_latestposts_dbprefix']. "members";
$topicnumber = ($conf_plus['pk_latestposts_amount']) ? $conf_plus['pk_latestposts_amount'] : 5;

// Build the db query
$myBBquery  = "SELECT t.tid as bb_topic_id, t.title as bb_topic_title, 
              t.forum_id as bb_forum_id, t.last_post as bb_posttime, t.posts as bb_replies, 
              t.last_poster_id as bb_poster_id, m.name as bb_username
              FROM ".$table_topics." t, ".$table_members." m
              WHERE t.last_poster_id = m.id ";
if(is_array($privateforums)){
  $myBBquery .= "t.forum_id ".$black_or_white."(". implode(', ', $privateforums).") AND ";
}
$myBBquery .= "ORDER BY t.last_post DESC LIMIT ".$topicnumber;

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  if($mode=='member'){
    return $conf_plus['pk_latestposts_bbpath'].'/index.php?showuser='.$row['bb_poster_id'];
  }else{
    return $conf_plus['pk_latestposts_bbpath'].'/index.php?showtopic='.$row['bb_topic_id'].'&view=getlastpost';
  }
}
?>

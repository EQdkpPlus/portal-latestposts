<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2008-12-02 13:38:01 +0100 (Di, 02 Dez 2008) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 3294 $
 * 
 * $Id: module.php 3294 2008-12-02 12:38:01Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$table_messages = $conf_plus['pk_latestposts_dbprefix']. "messages";
$table_topics   = $conf_plus['pk_latestposts_dbprefix']. "topics";
$topicnumber = ($conf_plus['pk_latestposts_amount']) ? $conf_plus['pk_latestposts_amount'] : 5;

// Build the db query
$myBBquery  = "SELECT ms.ID_TOPIC as bb_topic_id, ms.subject as bb_topic_title, 
              ms.ID_MSG as bb_message_id, ms.posterTime as bb_posttime, t.numReplies as bb_replies, 
              ms.ID_MEMBER as bb_poster_id, ms.posterName as bb_username
              FROM ".$table_messages." ms, ".$table_topics." t
              WHERE ms.ID_MSG = t.ID_LAST_MSG
              ORDER BY ms.posterTime DESC LIMIT ".$topicnumber;

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  if($mode=='member'){
    return $conf_plus['pk_latestposts_bbpath'].'/index.php?action=profile;u='.$row['bb_poster_id'];
  }else{
    return $conf_plus['pk_latestposts_bbpath'].'/index.php?topic='.$row['bb_topic_id'].'.msg'.$row['bb_message_id'].';topicseen#new';
  }
}
?>

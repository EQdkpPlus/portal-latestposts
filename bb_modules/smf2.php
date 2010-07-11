<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		    http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2010-06-30 18:14:02 +0200 (Mi, 30 Jun 2010) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 8264 $
 * 
 * $Id: smf.php 8264 2010-06-30 16:14:02Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

// Define the tables & configuration options
$table_messages = trim($conf_plus['pk_latestposts_dbprefix']). "messages";
$table_topics   = trim($conf_plus['pk_latestposts_dbprefix']). "topics";

// Build the db query
$myBBquery  = "SELECT ms.ID_TOPIC as bb_topic_id, ms.subject as bb_topic_title, 
              ms.ID_MSG as bb_message_id, ms.poster_time as bb_posttime, t.num_replies as bb_replies, 
              ms.ID_MEMBER as bb_poster_id, ms.poster_name as bb_username
              FROM ".$table_messages." ms, ".$table_topics." t
              WHERE ms.ID_MSG = t.ID_LAST_MSG ";
if(is_array($privateforums)){
  $myBBquery .= " AND t.ID_BOARD ".$black_or_white."(". implode(', ', $privateforums).") ";
}
$myBBquery .= "ORDER BY ms.poster_time DESC LIMIT ".trim($topicnumber);

// Link
function bbLinkGeneration($mode, $row){
  global $conf_plus;
  if($mode=='member'){
    return '/index.php?action=profile;u='.$row['bb_poster_id'];
  }else{
    return '/index.php?topic='.$row['bb_topic_id'].'.msg'.$row['bb_message_id'].';topicseen#new';
  }
}
?>
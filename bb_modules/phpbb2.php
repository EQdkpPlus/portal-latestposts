<?php
/*	Project:	EQdkp-Plus
 *	Package:	Last posts Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2016 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
class latestpostsmodule_phpbb3 {
	
	public function getBBQuery($arrPrivateforums, $black_or_white, $topicnumber) {
		// Build the db query
		$myBBquery	= "SELECT t.topic_title as bb_topic_title, 
						t.topic_last_post_id as bb_post_id, t.topic_replies as bb_replies,
						p.poster_id as bb_poster_id, p.post_time as bb_posttime, 
						u.user_id as bb_user_id, u.username as bb_username
						FROM __topics t, __forums f, __posts p, __users u
						WHERE t.topic_id = p.topic_id AND
						f.forum_id = t.forum_id AND
						t.topic_status <> 2 AND ";
		if(is_array($arrPrivateforums) && !empty($arrPrivateforums)){
			$myBBquery .= "t.forum_id ".$black_or_white."(". implode(', ', $arrPrivateforums).") AND ";
		}
		$myBBquery	.= "p.post_id = t.topic_last_post_id AND
						p.poster_id = u.user_id
						ORDER BY p.post_id DESC LIMIT ".trim($topicnumber);
		return $myBBquery;
	}	
	
	public function getBBLink($mode, $row, $strBoardURL){
		if($mode=='member'){
			return $strBoardURL.'profile.php?mode=viewprofile&u='.$row['bb_user_id'];
		}else{
			return $strBoardURL.'viewtopic.php?p='.$row['bb_post_id'].'#'.$row['bb_post_id'];
		}
	}
}
?>
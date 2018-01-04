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
class latestpostsmodule_vb4 {

	public function getBBQuery($arrPrivateforums, $black_or_white, $topicnumber) {
		// Build the db query
		$myBBquery  = "SELECT t.threadid as bb_topic_id, t.title as bb_topic_title, 
						t.lastpostid as bb_post_id, t.forumid as bb_forum_id, 
						t.lastpost as bb_posttime, t.replycount as bb_replies,
						u.userid as bb_user_id, u.username as bb_username
						FROM __thread t, __post p, __user u
						WHERE t.threadid = p.threadid
						AND t.open = '1' AND ";
		if(is_array($arrPrivateforums) && !empty($arrPrivateforums)){
			$myBBquery .= "t.forumid ".$black_or_white."(". implode(', ', $arrPrivateforums).") AND ";
		}
		$myBBquery	.= "p.postid = t.lastpostid AND
						p.userid = u.userid
						ORDER BY t.lastpost DESC LIMIT ".trim($topicnumber);
						
		return $myBBquery;
	}
	
	public function getBBForumQuery(){
		$myBBforumQuery = "SELECT forumid as id, title as name FROM __forum";	
		return $myBBforumQuery;
	}
	
	
	public function getBBLink($mode, $row, $strBoardURL){
		if($mode=='member'){
			return $strBoardURL.'member.php?u='.$row['bb_user_id'];
		}else{
			return $strBoardURL.'showthread.php?p='.$row['bb_post_id'].'#post'.$row['bb_post_id'];
		}
	}
}
?>
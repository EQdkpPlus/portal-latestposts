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
class latestpostsmodule_ipb3 {

	public function getBBQuery($arrPrivateforums, $black_or_white, $topicnumber) {
		$myBBquery	= "SELECT t.tid as bb_topic_id, t.title as bb_topic_title, 
			t.forum_id as bb_forum_id, t.last_post as bb_posttime, t.posts as bb_replies, 
			t.last_poster_id as bb_poster_id, m.name as bb_username
			FROM __topics t, __members m
			WHERE t.last_poster_id = m.member_id ";
		if(is_array($arrPrivateforums) && !empty($arrPrivateforums)){
			$myBBquery .= " AND t.forum_id ".$black_or_white."(". implode(', ', $arrPrivateforums).") ";
		}
		$myBBquery	.= "ORDER BY t.last_post DESC LIMIT ".trim($topicnumber);
						
		return $myBBquery;
	}
	
	public function getBBForumQuery(){
		$myBBforumQuery = "SELECT id as id, name as name FROM __forums ORDER BY position ASC";
		return $myBBforumQuery;
	}
	
	public function getBBLink($mode, $row, $strBoardURL){
		if($mode == 'member'){
			return $strBoardURL."index.php?/user/".$row['bb_poster_id']."-".$row['bb_poster_id']."/";
		} else {
			return $strBoardURL."index.php?/topic/".$row['bb_topic_id']."-".$row['bb_topic_id']."/?view=getlastpost";
		}
	}
}
?>
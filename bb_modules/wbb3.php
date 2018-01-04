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
class latestpostsmodule_wbb3 {

	public function getBBQuery($arrPrivateforums, $black_or_white, $topicnumber) {
			// Build the db query
			$myBBquery	= "SELECT t.threadID as bb_topic_id, t.topic as bb_topic_title, 
							p.postID as bb_post_id, t.lastPostTime as bb_posttime, 
							t.replies as bb_replies, t.lastPosterID as bb_user_id, 
							t.lastPoster as bb_username, b.title as bb_forum_name,
							p.message as bb_content
							FROM __thread t, __post p, __board b
							WHERE t.threadID = p.threadid";
			if(is_array($arrPrivateforums) && !empty($arrPrivateforums)){
				$myBBquery .= " AND t.boardID ".$black_or_white."(". implode(', ', $arrPrivateforums).")";
			}
			$myBBquery	.= " AND p.time = t.lastPostTime AND b.boardID = t.boardID 
							ORDER BY t.lastPostTime DESC LIMIT ".trim($topicnumber);
						
		return $myBBquery;
	}
	
	public function getBBForumQuery(){
		$myBBforumQuery = "SELECT boardID as id, title as name FROM __board";	
		return $myBBforumQuery;
	}
	
	
	public function getBBLink($mode, $row, $strBoardURL){
		if($mode=='member'){
			return $strBoardURL.'index.php?page=User&userID='.$row['bb_user_id'];
		}else{
			return $strBoardURL.'index.php?page=Thread&threadID='.$row['bb_topic_id'].'&action=firstNew';
		}
	}
}
?>
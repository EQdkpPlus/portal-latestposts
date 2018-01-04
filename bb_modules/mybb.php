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
class latestpostsmodule_mybb {
	
	public function getBBQuery($arrPrivateforums, $black_or_white, $topicnumber) {
			// Build the db query
			$myBBquery	= "SELECT t.tid as bb_topic_id, t.subject as bb_topic_title, 
							p.pid as bb_post_id, t.lastpost as bb_posttime, 
							t.replies as bb_replies, t.lastposteruid as bb_user_id, 
							t.lastposter as bb_username,
							p.message as bb_content
							FROM __threads t, __posts p
							WHERE t.tid = p.tid";
			if(is_array($arrPrivateforums) && !empty($arrPrivateforums)){
				$myBBquery .= " AND t.fid ".$black_or_white."(". implode(', ', $arrPrivateforums).")";
			}
			$myBBquery	.= " AND p.dateline = t.lastpost
							ORDER BY t.lastpost DESC LIMIT ".trim($topicnumber);
						
		return $myBBquery;
	}
	
	public function getBBForumQuery(){
		$myBBforumQuery = "SELECT fid as id, name as name FROM __forums WHERE type = 'f' ORDER BY pid ASC";	
		return $myBBforumQuery;
	}
	
	
	public function getBBLink($mode, $row, $strBoardURL){
		if($mode=='member'){
			return $strBoardURL.'member.php?action=profile&uid='.$row['bb_user_id'];
		}else{
			return $strBoardURL.'showthread.php?tid='.$row['bb_topic_id'].'&pid='.$row['bb_post_id'].'#pid'.$row['bb_post_id'];
		}
	}
}
?>
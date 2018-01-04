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
class latestpostsmodule_smf {
	
	public function getBBQuery($arrPrivateforums, $black_or_white, $topicnumber) {
		// Build the db query
		$myBBquery	= "SELECT ms.ID_TOPIC as bb_topic_id, ms.subject as bb_topic_title, 
						ms.ID_MSG as bb_post_id, ms.posterTime as bb_posttime, t.numReplies as bb_replies, 
						ms.ID_MEMBER as bb_poster_id, ms.posterName as bb_username
						FROM __messages ms, __topics t
						WHERE ms.ID_MSG = t.ID_LAST_MSG ";
		if(is_array($arrPrivateforums) && !empty($arrPrivateforums)){
			$myBBquery .= " AND t.ID_BOARD ".$black_or_white."(". implode(', ', $arrPrivateforums).") ";
		}
		$myBBquery .= "ORDER BY ms.posterTime DESC LIMIT ".trim($topicnumber);
								
		return $myBBquery;
	}
	
	public function getBBLink($mode, $row, $strBoardURL){
		if($mode=='member'){
			return $strBoardURL.'index.php?action=profile;u='.$row['bb_poster_id'];
		}else{
			return $strBoardURL.'index.php?topic='.$row['bb_topic_id'].'.msg'.$row['bb_post_id'].';topicseen#new';
		}
	}
}
?>
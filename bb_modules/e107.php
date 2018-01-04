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
class latestpostsmodule_e107 {

	public function getBBQuery($arrPrivateforums, $black_or_white, $topicnumber) {
			// Build the db query
			$myBBquery	= "SELECT t.thread_id as bb_topic_id, t.thread_name as bb_topic_title, 
				t.thread_forum_id as bb_forum_id, t.thread_datestamp as bb_posttime, t.thread_total_replies as bb_replies, 
				t.thread_user as bb_poster_id, m.user_name as bb_username
				FROM __forum_t t, __user m
				WHERE t.thread_lastuser = m.user_id ";
				if(is_array($arrPrivateforums) && !empty($arrPrivateforums)){
					$myBBquery .= " AND t.thread_forum_id ".$black_or_white."(". implode(', ', $arrPrivateforums).") ";
				}
				$myBBquery .= "ORDER BY t.thread_lastpost DESC LIMIT ".trim($topicnumber);
						
		return $myBBquery;
	}
	
	public function getBBLink($mode, $row, $strBoardURL){
		return $strBoardURL.'e107_plugins/forum/forum_viewtopic.php?'.$row['bb_topic_id'];
	}
}
?>
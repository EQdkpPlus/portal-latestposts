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
class latestpostsmodule_discord {

	public function getBBPosts($arrPrivateforums, $black_or_white, $topicnumber, $showcontent, $strBoardURL){
		$arrForums = $this->getBBForums($strBoardURL);
		$arrData = array();
		
		if(strpos($strBoardURL, ':') !== false){
			list($guildid, $token) = explode(':', $strBoardURL);
			$token = str_replace("/", "", $token);
		} else {
			$arrDiscordConfig = register('config')->get_config('discord');
			$guildid = $arrDiscordConfig['guild_id'];
			$token = $arrDiscordConfig['bot_token'];
		}

		foreach($arrForums as $forumID => $forumName){
			if($black_or_white == 'IN'){
				//WL
				if(is_array($arrPrivateforums) && !empty($arrPrivateforums) && !in_array($forumID, $arrPrivateforums)) continue;
			} else {
				//BL
				if(is_array($arrPrivateforums) && !empty($arrPrivateforums) && in_array($forumID, $arrPrivateforums)) continue;
			}

			$result = register('urlfetcher')->fetch('https://discordapp.com/api/channels/'.$forumID, array('Authorization: Bot '.$token));
			if($result){
				$arrJSON = json_decode($result, true);
					
				$strLastMessage = $arrJSON['last_message_id'];

				$result = register('urlfetcher')->fetch('https://discordapp.com/api/channels/'.$forumID.'/messages/'.$strLastMessage, array('Authorization: Bot '.$token));
				if($result){
					$arrJSON = json_decode($result, true);

					$arrData[] = array(
							'content' 	=> ($showcontent !== false && $showcontent) ? $arrJSON['content'] : '',
							'member_link'	=> 'https://discordapp.com/channels/@me/'.$arrJSON['author']['id'],
							'topic_link'	=> 'https://discordapp.com/channels/'.$guildid.'/'.$forumID,
							'topic_title'	=> '#'.$forumName,
							'forum_name'	=> '',
							'replies'	=> '&infin;',
							'posttime'	=> $arrJSON['timestamp'],
							'username'	=> $arrJSON['author']['username'],
							'post_id'	=> $strLastMessage,
							'topic_id'	=> $forumID,
							'forum_id'	=> 0,
					);
				}
			}
		}

		//Cache data
		register('pdc')->put('portal.module.latestposts.u'.register('user')->id,$arrData,300,false,true);

		return $arrData;
	}


	public function getBBForums($strBoardURL){
		$arrOut = array();

		if(strpos($strBoardURL, ':') !== false){
			list($guildid, $token) = explode(':', $strBoardURL);
			$token = str_replace("/", "", $token);
		} else {
			$arrDiscordConfig = register('config')->get_config('discord');
			$guildid = $arrDiscordConfig['guild_id'];
			$token = $arrDiscordConfig['bot_token'];
		}

		$result = register('urlfetcher')->fetch('https://discordapp.com/api/guilds/'.$guildid.'/channels', array('Authorization: Bot '.$token));
		if($result){
			$arrJSON = json_decode($result, true);
				
			foreach($arrJSON as $val){
				if($val['type'] == 'text'){
					$arrOut[$val['id']] = 	$val['name'];
				}
			}
		}

		return $arrOut;
	}


	public function getBBLink($mode, $row, $strBoardURL){
		if($mode=='member'){
			return $strBoardURL.'index.php?user/'.$row['bb_user_id'].'-'.$row['bb_username'].'/';
		}else{
			return $strBoardURL.'index.php?thread/'.$row['bb_topic_id'].'/&action=firstNew';
		}
	}
	
	public function getBBQuery(){
		
	}
}
?>
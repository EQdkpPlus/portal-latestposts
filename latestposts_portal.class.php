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

class latestposts_portal extends portal_generic {

	protected static $path		= 'latestposts';
	protected static $data		= array(
			'name'			=> 'Latest Forum Posts',
			'version'		=> '3.3.1',
			'author'		=> 'GodMod',
			'icon'			=> 'fa-group',
			'contact'		=> EQDKP_PROJECT_URL,
			'description'	=> 'View the latest Forum posts.',
			'exchangeMod'	=> array('latestposts'),
			'reload_on_vis'	=> true,
			'lang_prefix'	=> 'latestposts_',
			'multiple'		=> true,
	);
	protected static $positions = array('middle', 'left1', 'left2', 'right', 'bottom');
	protected static $multiple = true;
	
	protected $hooks = array(
			array('wrapper', 'latestposts_wrapper_hook')
	);

	protected static $apiLevel = 20;

	public function get_settings($state){
		$settings	= array(
				'bbmodule'	=> array(
						'type'		=> 'dropdown',
						'class'		=> 'js_reload',
						'options'	=> array(
								'phpbb3'	=> 'phpBB3',
								'phpbb31'	=> 'phpBB3.1',
								'phpbb2'	=> 'phpBB2',
								'ipb2'		=> 'IPB 2.x',
								'ipb3'		=> 'IPB 3.x',
								'ipb4'		=> 'IPB 4.x',
								'smf'		=> 'SMF 1.x',
								'smf2'		=> 'SMF 2.x',
								'vb3'		=> 'vBulletin 3',
								'vb4'		=> 'vBulletin 4',
								'wbb3'		=> 'WBB 3',
								'wbb4'		=> 'WBB 4',
								'wbb4_1'	=> 'WBB 4.1',
								'wbb5'		=> 'WBB 5',
								'e107'		=> 'e107',
								'mybb'		=> 'MyBB',
								'discord'	=> 'Discord',
						),
				),
				'dbprefix'	=> array(
						'type'		=> 'text',
						'size'		=> '30',
						'class'		=> 'js_reload',
				),
				'dbmode'	=> array(
						'type'		=> 'dropdown',
						'class'		=> 'js_reload',
						'tolang'	=> true,
						'options'	=> array(
								'same'		=> 'latestposts_dbmode_same',
								'new'		=> 'latestposts_dbmode_new',
								'bridge'	=> 'latestposts_dbmode_bridge',
								'none'		=> 'latestposts_dbmode_none',
						),
						'dependency'=> array('new' => array('dbhost', 'dbname', 'dbuser', 'dbpassword')),
				),
				'dbhost'	=> array(
						'type'		=> 'text',
						'size'		=> '30',
						'encrypt'	=> true,
				),
				'dbname'	=> array(
						'type'		=> 'text',
						'size'		=> '30',
						'encrypt'	=> true,
				),
				'dbuser'	=> array(
						'type'		=> 'text',
						'size'		=> '30',
						'encrypt'	=> true,
				),
				'dbpassword'	=> array(
						'type'		=> 'password',
						'size'		=> '30',
						'pattern'	=> '',
						'encrypt'	=> true,
						'class'		=> 'js_reload',
						'set_value' => true,
				),
				'url'	=> array(
						'type'		=> 'text',
						'size'		=> '30',
				),
				'trimtitle'	=> array(
						'type'		=> 'spinner',
				),
				'amount'	=> array(
						'type'		=> 'spinner',
				),
				'linktype'	=> array(
						'type'		=> 'dropdown',
						'tolang'	=> true,
						'options'	=> array(
								'0'	=> 'pk_set_link_type_self',
								'1'	=> 'pk_set_link_type_link',
								'2'	=> 'pk_set_link_type_iframe',
								'4'	=> 'pk_set_link_type_D_iframe_womenues',
						),
				),
				'blackwhitelist'	=> array(
						'type'	=> 'dropdown',
						'options'	=> array(
								'black'		=> 'Blacklist',
								'white'		=> 'Whitelist',
						)
				),
				'showcontent' => array(
						'type' 		=> 'radio',
						'default'	=> 1,
				),
				'style'	=> array(
						'type'		=> 'dropdown',
						'tolang'	=> true,
						'options'	=> array(
								'normal'	=> 'latestposts_display_normal',
								'accordion'	=> 'latestposts_display_accordion',
						),
				),
		);

		// kill the bridge option if its disabled
		if((int)$this->config->get('cmsbridge_active') != 1){
			unset($settings['dbmode']['options']['bridge']);
		}
		
		$mydb = false;

		//Try a database connection
		if((int)$this->config->get('cmsbridge_active') == 1 && $this->config('dbmode') == 'bridge'){
			//Bridge Connection
			$mydb		= $this->bridge->bridgedb;
			//change prefix
			if (strlen(trim($this->config('dbprefix')))) $mydb->setPrefix(trim($this->config('dbprefix')));
		} elseif($this->config('dbmode') == 'new'){
			//Another Database
			try {
				$mydb = dbal::factory(array('dbtype' => registry::get_const('dbtype'), 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));
				$mydb->connect($this->encrypt->decrypt($this->config('dbhost')), $this->encrypt->decrypt($this->config('dbname')), $this->encrypt->decrypt($this->config('dbuser')), $this->encrypt->decrypt($this->config('dbpassword')));
			} catch(DBALException $e){
				$mydb = false;
			}
		}elseif($this->config('dbmode') != 'none'){
			//Same Database
			try {
				$mydb = dbal::factory(array('dbtype' => registry::get_const('dbtype'), 'open'=>true, 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));
			} catch(DBALException $e){
				$mydb = false;
			}
		}

		// get a list of all subforums
		if (($mydb && $mydb !== null && is_object($mydb)) || $this->config('dbmode') == 'none'){
			$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config('bbmodule').'.php';
			if(is_file($bbModule)){
				include_once($bbModule);
				$classname = 'latestpostsmodule_'.$this->config('bbmodule');
				$module = new $classname();

				if ($module && method_exists($module, 'getBBForums')){
					$arrOptions = $module->getBBForums($this->config('url'));
				} elseif ($module && method_exists($module, 'getBBForumQuery')){
					$objQuery = $mydb->query($module->getBBForumQuery());
					if ($objQuery){
						$arrOptions = array();
						while($row = $objQuery->fetchAssoc()){
							$arrOptions[intval($row['id'])] = $row['name'];
						}
					}
				}
			}
			
			//reset prefix
			if ($this->config('dbmode') == 'bridge') $mydb->resetPrefix();
		} else {
			if($state == 'fetch_new') $this->core->message('Datebase connection failed. Please check your settings.', $this->user->lang('error'), 'error');
		}

		$visibility = $this->config('visibility');
		if (is_array($visibility)) {
			foreach ($visibility as $key => $value){
				$dir_lang = $this->user->lang('latestposts_f_privateforums').(((int)$value == 0) ? $this->user->lang('cl_all') : $this->pdh->get('user_groups', 'name', array($value)));
				if (isset($arrOptions)){
					$settings['privateforums_'.$value]	= array(
							'dir_lang'	=> $dir_lang,
							'type'		=> 'multiselect',
							'help'		=> 'latestposts_f_help_privateforums2',
							'options'	=> $arrOptions,
					);
				} else {
					$settings['privateforums_'.$value]	= array(
							'dir_lang'	=> $dir_lang,
							'type'		=> 'text',
							'size'		=> '30',
							'help'		=> 'latestposts_f_help_privateforums',
					);
				}
			}
		}

		return $settings;
	}


	public function output() {
		$arrData = $this->pdc->get('portal.module.latestposts.'.$this->id.'.u'.$this->user->id,false,true);
		$myTarget	= ($this->config('linktype') == '1') ? '_blank' : '';

		if(!$arrData){
			// do the link-thing..
				
			$strBoardURL = $this->config('url');
			$mydb = false;
				
			if (substr($this->config('url'), -1) != "/"){
				$strBoardURL .= '/';
			}

			//Try a database connection
			if($this->config->get('cmsbridge_active') == 1 && $this->config('dbmode') == 'bridge'){
				//Bridge Connection
				$mydb		= $this->bridge->bridgedb;
				//change prefix
				if (strlen(trim($this->config('dbprefix')))) $mydb->setPrefix(trim($this->config('dbprefix')));
			} elseif($this->config('dbmode') == 'new'){
				//Another Database
				try {
					$mydb = dbal::factory(array('dbtype' => registry::get_const('dbtype'), 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));
					$mydb->connect($this->encrypt->decrypt($this->config('dbhost')), $this->encrypt->decrypt($this->config('dbname')), $this->encrypt->decrypt($this->config('dbuser')), $this->encrypt->decrypt($this->config('dbpassword')));
				} catch(DBALException $e){
					$mydb = false;
				}
			}elseif($this->config('dbmode') != 'none'){
				//Same Database
				try {
					$mydb = dbal::factory(array('dbtype' => registry::get_const('dbtype'), 'open'=>true, 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));
				} catch(DBALException $e){
					$mydb = false;
				}
			}
				
			if (!$mydb && $this->config('dbmode') != 'none'){
				return $this->user->lang('latestposts_connerror');
			}

			// Set some Variables we're using in the BB Modules..
			$topicnumber	= ($this->config('amount')) ? $this->config('amount') : 5;
			$black_or_white	= ($this->config('blackwhitelist') == 'white') ? 'IN' : 'NOT IN';

			// include the BB Module File...
			$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config('bbmodule').'.php';
			if(is_file($bbModule)){
				include_once($bbModule);
				$classname = 'latestpostsmodule_'.$this->config('bbmodule');
				$module = new $classname();

				if(!$module || !method_exists($module, 'getBBQuery')){
					return $this->user->lang('portal_latestposts_invmodule');
				}

			}else{
				return $this->user->lang('portal_latestposts_nomodule');
			}
				
			// Create Array of allowed/disallowed forums
			$arrUserMemberships = $this->pdh->get('user_groups_users', 'memberships', array($this->user->id));
			array_push($arrUserMemberships, 0);
			$arrForums = array();
			$visibilityGrps = $this->config('visibility');

			foreach ($arrUserMemberships as $groupid) {
				//only load forums for which actual settings are set

				if(!in_array($groupid, $visibilityGrps)) {
					continue;
				}

				$strForums = $this->config('privateforums_'.$groupid);
				if (method_exists($module, 'getBBForumQuery')){
					if(is_array($strForums)) $arrForums = array_merge($arrForums, $strForums);
				} else {
					//comma seperated IDs
					$arrTmpForums = ($this->config('privateforums_'.$groupid)) ? explode(",", $this->config('privateforums_'.$groupid)) : '';
					if(is_array($arrTmpForums)){
						foreach($arrTmpForums as $forumid){
							if(trim($forumid) != ''){
								$arrForums[] = trim($forumid);
							}
						}
					}
				}
			}

			$arrForums = array_unique($arrForums);
				
			// if there are no forums selected and its whitelist
			if (count($arrForums) == 0 && $black_or_white == 'IN') return $this->user->lang('portal_latestposts_noselectedboards');

			if(method_exists($module, 'getBBPosts')){
				$arrData = $module->getBBPosts($arrForums, $black_or_white, $topicnumber, $this->config('showcontent'), $strBoardURL);
			} else {
					
				$strQuery = $module->getBBQuery($arrForums, $black_or_white, $topicnumber);
				$objQuery = $mydb->query($strQuery);
				$arrData = array();
				if ($objQuery){
					$sucess = true;
					$blnForumName = false;

					$arrResult = $objQuery->fetchAllAssoc();
					if (count($arrResult)){
						foreach($arrResult as $row){
							//Get Content
							$strContent = "";
							if(isset($row['bb_content'])){
								$strContent = $row['bb_content'];
							}elseif(method_exists($module, 'getBBPostContent')){
								$strContentQuery = $module->getBBPostContent($row);
								$objContentQuery = $mydb->query($strContentQuery);
								if($objContentQuery){
									$arrResult = $objContentQuery->fetchAssoc();
									$strContent = $arrResult['bb_content'];
								}
							}
								
							//Sanitize Content
							$strContent = strip_tags($strContent);
							$strContent = $this->remove_bbcode($strContent);
							$strContent = cut_text($strContent, 300, true);
								
							$blnAddSID = ($this->user->id > 0) ? true : false;
							$strMemberlinkWrapper = $this->routing->build('external', $row['bb_username'].'-'.$row['bb_user_id'], 'User', $blnAddSID);
							$strTopiclinkWrapper = $this->routing->build('external', $row['bb_topic_title'].'-'.$row['bb_post_id'].'-'.$row['bb_topic_id'], 'Topic', $blnAddSID);
							
							$member_link	= (in_array($this->config('linktype'), range(0,1))) ? $module->getBBLink('member', $row, $strBoardURL) : $strMemberlinkWrapper;
							$topic_link		= (in_array($this->config('linktype'), range(0,1))) ? $module->getBBLink('topic', $row, $strBoardURL) : $strTopiclinkWrapper;


							$arrData[] = array(
									'content' 		=> ($this->config('showcontent') !== false && $this->config('showcontent')) ? $strContent : '',
									'member_link'	=> $member_link,
									'topic_link'	=> $topic_link,
									'topic_title'	=> $row['bb_topic_title'],
									'forum_name'	=> $row['bb_forum_name'],
									'replies'		=> ($row['bb_replies']) ? $row['bb_replies'] : 0,
									'posttime'		=> $row['bb_posttime'],
									'username'		=> $row['bb_username'],
									'post_id'		=> $row['bb_post_id'],
									'topic_id'		=> $row['bb_topic_id'],
									'forum_id'		=> $row['bb_forum_id'],
							);
						}
					}

					//Cache the data
					if (isset($sucess)) {
						$this->pdc->put('portal.module.latestposts.'.$this->id.'.u'.$this->user->id,$arrData,300,false,true);
					}

				} else {
					$myOut = "An error occured. Please check your settings.";
					return $myOut;
				}
					
				//reset prefix
				if($this->config('dbmode') == 'bridge'){
					$mydb->resetPrefix();
				}
			}
		} //Now we should have data

		// Wide Content
		$myOut = "";
		$blnForumName = false;
		if($this->wide_content){
			if(count($arrData)){
				foreach($arrData as $row){
					$strTarget = ($myTarget != "") ? " target='".$myTarget."'" : "";
					$strTooltip = ($row['content'] != "") ?  " class='coretip' data-coretip='".$row['content']."'" : '';
						
					$myOut .= "<tr valign='top'>
										<td>
											<a href='".htmlentities($row['topic_link'])."'".$strTarget.$strTooltip.">".$row['topic_title']."</a>
										</td>";

					if (isset($row['forum_name']) && $row['forum_name'] != "") {
						$myOut .= "<td>".$row['forum_name']."</td>";
						$blnForumName = true;
					}
					$myOut .= "</td>
									<td align='center'>".$row['replies']."</td>
									<td><a href='".htmlentities($row['topic_link'])."'".$strTarget.">".$this->time->createTimeTag($row['posttime'], $this->time->user_date($row['posttime'], true))."</a>,
									<a href='".htmlentities($row['member_link'])."'".$strTarget."><i class=\"fa fa-user\"></i> ".$row['username']."</a> <a href='".htmlentities($row['topic_link'])."'".$strTarget."></a>
									<a href='".htmlentities($row['topic_link'])."'".$strTarget."><i class=\"fa fa-chevron-right\"></i></a>
									</td>
								</tr>";
						
					$arrOut[$row['topic_title'].", ".$this->time->createTimeTag($row['posttime'], $this->time->user_date($row['posttime'], true))] = "<a href='".$row['topic_link']."' target='".$myTarget."'>".$row['content']."</a>
<br /><a href='".$row['member_link']."'".$strTarget."><i class='fa fa-user'></i> ".sanitize($row['username'])."</a>, <i class='fa fa-comments'></i>".$row['replies']."
							";
				}
			} else {
				$myOut .= "<tr valign='top'>
								<td colspan='3'>".$this->user->lang('latestposts_noentries')."</td>
							</tr>";
			}
				

			$myOut = "<table class='table fullwidth colorswitch'>
					<tr>
						<th width='50%'>".$this->user->lang('latestposts_title')."</th>
						".(($blnForumName) ? '<th class="nowrap" width="10%">'.$this->user->lang('latestposts_forum').'</th>' : '')."
						<th width='10%'>".$this->user->lang('latestposts_posts')."</th>
						<th width='20%'>".$this->user->lang('latestposts_lastpost')."</th>
					</tr>".$myOut;

			$myOut .= "</table>";
			$sucess = true;
				
			if($this->config('style') == 'accordion'){
				$myOut = '<div style="white-space:normal;">'.$this->jquery->accordion('accordion_'.$this->id, $arrOut).'</div>';
			}
				
		} else {
			$myTitleLength = ($this->config('trimtitle')) ? $this->config('trimtitle') : 40;
			if(count($arrData)){
				$myOut = "<table class='table fullwidth colorswitch'>";

				foreach($arrData as $row){
					$short_title = cut_text($row['topic_title'], $myTitleLength, true);
						
					$strTarget = ($myTarget != "") ? " target='".$myTarget."'" : "";
					$strTooltip = ($row['content'] != "") ?  " class='coretip' data-coretip='".$row['content']."'" : '';
						
					$myOut .= "<tr valign='top'>
							<td>
								<a href='".$row['topic_link']."'".$strTarget.$strTooltip.">".$short_title."</a> (<i class='fa fa-comments'></i>".$row['replies'].")<br/>
								".$this->time->createTimeTag($row['posttime'], $this->time->user_date($row['posttime'], true)).", <a href='".$row['member_link']."'".$strTarget."><i class='fa fa-user'></i>".sanitize($row['username'])."</a>
							</td>
						</tr>";
						
					$arrOut[$short_title] = $this->time->createTimeTag($row['posttime'], $this->time->user_date($row['posttime'], true))."<br /><a href='".$row['topic_link']."'".$strTarget.">".$row['content']."</a>
<br /><a href='".$row['member_link']."'".$strTarget."><i class='fa fa-user'></i>".sanitize($row['username'])."</a>, <i class='fa fa-comments'></i>".$row['replies']."
							";
				}

				$myOut .= "</table>";
				$sucess = true;
			} else {
				$myOut = $this->user->lang('latestposts_noentries');
			}
				
			if($this->config('style') == 'accordion'){
				$myOut = '<div style="white-space:normal;">'.$this->jquery->accordion('accordion_'.$this->id, $arrOut).'</div>';
			}

		}

		return $myOut;
	}

	function remove_bbcode($string)
	{
		$pattern = '|[[\/\!]*?[^\[\]]*?]|si';
		$replace = '';
		return preg_replace($pattern, $replace, $string);
	}
}
?>

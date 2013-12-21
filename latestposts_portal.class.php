<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-11-27 21:12:43 +0100 (Di, 27. Nov 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12511 $
 *
 * $Id: latestposts_portal.class.php 12511 2012-11-27 20:12:43Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class latestposts_portal extends portal_generic {

	protected static $path		= 'latestposts';
	protected static $data		= array(
		'name'			=> 'Latest Forum Posts',
		'version'		=> '3.0.0',
		'author'		=> 'WalleniuM',
		'icon'			=> 'fa-group',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'View the latest Forum posts.',
		'exchangeMod'	=> array('latestposts'),
		'reload_on_vis'	=> true,
		'lang_prefix'	=> 'latestposts_'
	);
	protected static $positions = array('middle', 'left1', 'left2', 'right', 'bottom');
	
	protected $hooks = array(
		array('wrapper', 'latestposts_wrapper_hook')
	);	
	
	public function get_settings($state){
		$settings	= array(
			'bbmodule'	=> array(
				'type'		=> 'dropdown',
				'class'		=> 'js_reload',
				'options'	=> array(
					'phpbb3'	=> 'phpBB3',
					'phpbb2'	=> 'phpBB2',
					'ipb2'		=> 'IPB 2.x',
					'smf'		=> 'SMF 1.x',
					'smf2'		=> 'SMF 2.x',
					'vb3'		=> 'vBulletin 3',
					'vb4'		=> 'vBulletin 4',
					'wbb3'		=> 'WBB 3',
					'wbb4'		=> 'WBB 4',
					'e107'		=> 'e107',
					'mybb'		=> 'MyBB',
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
				'encrypt'	=> true,
				'class'		=> 'js_reload',
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
		);
	
		// kill the bridge option if its disabled
		if((int)$this->config->get('cmsbridge_active') != 1){
			unset($settings['dbmode']['options']['bridge']);
		}
		
		//Try a database connection
		if($this->config('cmsbridge_active') == 1 && $this->config('dbmode') == 'bridge'){
			//Bridge Connection
			$mydb		= $this->bridge->db;
			//change prefix
			if (strlen(trim($this->config('dbprefix')))) $mydb->setPrefix(trim($this->config('dbprefix')));
		} elseif($this->config('dbmode') == 'new'){
			//Another Database
			try {
				$mydb = dbal::factory(array('dbtype' => 'mysqli', 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));
				$mydb->connect($this->encrypt->decrypt($this->config('dbhost')), $this->encrypt->decrypt($this->config('dbname')), $this->encrypt->decrypt($this->config('dbuser')), $this->encrypt->decrypt($this->config('dbpassword')));
			} catch(DBALException $e){
				$mydb = false;
			}
		}else{
			//Same Database
			try {
				$mydb = dbal::factory(array('dbtype' => 'mysqli', 'open'=>true, 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));			
			} catch(DBALException $e){
				$mydb = false;
			}
		}
		
		// get a list of all subforums
		if ($mydb){
			$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config('bbmodule').'.php';
			if(is_file($bbModule)){
				include_once($bbModule);
				$classname = 'latestpostsmodule_'.$this->config('bbmodule');
				$module = new $classname();
				
				if ($module && method_exists($module, 'getBBForumQuery')){
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
		}
		
		$visibility = $this->config('visibility');
		if (is_array($visibility)) {
			foreach ($visibility as $key => $value){
				$dir_lang = $this->user->lang('latestposts_f_privateforums').(((int)$value == 0) ? $this->user->lang('cl_all') : $this->pdh->get('user_groups', 'name', array($value)));
				if (isset($arrOptions)){
					$settings['privateforums_'.$value]	= array(
						'dir_lang'	=> $dir_lang,
						'type'		=> 'jq_multiselect',
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
		$myOut = $this->pdc->get('portal.module.latestposts.u'.$this->user->id,false,true);

		if(!$myOut){
			// do the link-thing..
			$myTarget	= ($this->config('linktype') == '1') ? '_blank' : '';
			$strBoardURL = $this->config('url');
			
			if (substr($this->config('url'), -1) != "/"){
				$strBoardURL .= '/';
			}

			//Try a database connection
			if($this->config->get('cmsbridge_active') == 1 && $this->config('dbmode') == 'bridge'){
				//Bridge Connection
				$mydb		= $this->bridge->db;
				//change prefix
				if (strlen(trim($this->config('dbprefix')))) $mydb->setPrefix(trim($this->config('dbprefix')));
			} elseif($this->config('dbmode') == 'new'){
				//Another Database
				try {
					$mydb = dbal::factory(array('dbtype' => 'mysqli', 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));
					$mydb->connect($this->encrypt->decrypt($this->config('dbhost')), $this->encrypt->decrypt($this->config('dbname')), $this->encrypt->decrypt($this->config('dbuser')), $this->encrypt->decrypt($this->config('dbpassword')));
				} catch(DBALException $e){
					$mydb = false;
				}
			}else{
				//Same Database
				try {
					$mydb = dbal::factory(array('dbtype' => 'mysqli', 'open'=>true, 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config('dbprefix'))));			
				} catch(DBALException $e){
					$mydb = false;
				}
			}
			
			if (!$mydb){
				return $this->user->lang('connerror');
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
				if(!in_array($groupid, $visibilityGrps)) continue;
				
				$strForums = $this->config('privateforums_'.$groupid);
				if (method_exists($module, 'getBBForumQuery')){
					//serialized IDs
					$arrTmpForums = @unserialize($strForums);
					if (is_array($arrTmpForums)){
						foreach ($arrTmpForums as $forumid){
							$arrForums[] = $forumid;
						}
					}
				} else {
					//comma seperated IDs
					$arrTmpForums = ($this->config('privateforums')) ? explode(",", $this->config('privateforums')) : '';
					if(is_array($arrTmpForums)){
						foreach($arrTmpForums as $forumid){
							if(trim($forumid) != ''){
								$arrForums[] = trim($forumid);
							}
						}
					}
				}
			}		
			
			// if there are no forums selected and its whitelist
			if (count($arrForums) == 0 && $black_or_white == 'IN') return $this->user->lang('portal_latestposts_noselectedboards');
			
			$strQuery = $module->getBBQuery($arrForums, $black_or_white, $topicnumber);
			
			// Wide Content
			if($this->wide_content){
				$objQuery = $mydb->query($strQuery);
				if ($objQuery){
					$sucess = true;
					$blnForumName = false;
					
					$arrResult = $objQuery->fetchAllAssoc();
					if (count($arrResult)){
						foreach($arrResult as $row){
							$strMemberlinkWrapper = $this->routing->build('external', $row['bb_username'].'-'.$row['bb_user_id'], 'User');
							$strTopiclinkWrapper = $this->routing->build('external', $row['bb_topic_title'].'-'.$row['bb_topic_id'], 'Topic');
						
							$member_link	= (in_array($this->config('linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('member', $row) : $strMemberlinkWrapper;
							$topic_link		= (in_array($this->config('linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('topic', $row) : $strTopiclinkWrapper;
	
							$myOut .= "<tr valign='top'>
										<td>
											<a href='".htmlentities($topic_link)."' target='".$myTarget."'>".$row['bb_topic_title']."</a>											
										</td>";
							if (isset($row['bb_forum_name'])) {
								$myOut .= "<td>".$row['bb_forum_name']."</td>";
								$blnForumName = true;
							}		
							$myOut .= "</td>
										<td align='center'>".$row['bb_replies']."</td>
										<td><a href='".htmlentities($topic_link)."' target='".$myTarget."'>".$this->time->user_date($row['bb_posttime'], true)."</a>, 
										<a href='".htmlentities($member_link)."' target='".$myTarget."'>".$row['bb_username']."</a> <a href='".htmlentities($topic_link)."' target='".$myTarget."'></a>
										<a href='".htmlentities($topic_link)."' target='".$myTarget."'><i class=\"fa fa-chevron-right\"></i></a>
										</td>
									</tr>";		
						}
						
					} else {
						$myOut .= "<tr valign='top'>
									<td colspan='3'>".$this->user->lang('noentries')."</td>
								</tr>";
					}					
					
					$myOut = "<table cellpadding='3' cellspacing='2' width='100%' class='table colorswitch'>
							<tr>
								<th width='50%'>".$this->user->lang('title')."</th>
								".(($blnForumName) ? '<th class="nowrap" width="10%">'.$this->user->lang('forum').'</th>' : '')."
								<th width='10%'>".$this->user->lang('posts')."</th>
								<th width='20%'>".$this->user->lang('lastpost')."</th>
							</tr>".$myOut;
				
					$myOut .= "</table>";
				} else {
					$myOut = "An error occured.";
				}					
			} else {
				// Sidebar Output				
				$objQuery = $mydb->query($strQuery);
				if($objQuery){
					$myOut = "<table cellpadding='3' cellspacing='2' width='100%' class='colorswitch'>";
					$arrResult = $objQuery->fetchAllAssoc();
					if (count($arrResult)){
						$sucess = true;
						$myTitleLength = ($this->config('trimtitle')) ? $this->config('trimtitle') : 40;
						
						foreach($arrResult as $row){
							if (strlen($row['bb_topic_title']) > $myTitleLength){
								$short_title = substr($row['bb_topic_title'], 0, $myTitleLength)."...";
							}else{
								$short_title = $row['bb_topic_title'];
							}
							$strMemberlinkWrapper = $this->routing->build('external', $row['bb_username'].'-'.$row['bb_user_id'], 'User');
							$strTopiclinkWrapper = $this->routing->build('external', $row['bb_topic_title'].'-'.$row['bb_topic_id'], 'Topic');
							
							$member_link	= (in_array($this->config('linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('member', $row) : $strMemberlinkWrapper;
							$topic_link		= (in_array($this->config('linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('topic', $row) : $strTopiclinkWrapper;
							$myOut .= "<tr valign='top'>
									<td>
										<a href='".$topic_link."' target='".$myTarget."'>".$short_title."</a> (".$row['bb_replies'].")<br/>
										".$this->time->user_date($row['bb_posttime'], true).", <a href='".$member_link."' target='".$myTarget."'>".sanitize($row['bb_username'])."</a>
									</td>
								</tr>";
						}
						$myOut .= "</table>";
						$sucess = true;
						
					} else {
						$myOut = $this->user->lang('noentries');					
					}
					
				}
			}
			
			//reset prefix
			if($this->config('dbmode') == 'bridge'){
				$mydb->resetPrefix();
			}
			
			if (isset($sucess)) {
				$this->pdc->put('portal.module.latestposts.u'.$this->user->id,$myOut,300,false,true);
			}
		}
		return $myOut;
	}
}
?>
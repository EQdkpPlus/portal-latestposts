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
	public static function __shortcuts() {
		$shortcuts = array('user', 'core', 'time', 'db', 'pdc', 'config', 'bridge', 'crypt'=>'encrypt', 'pdh', 'routing', 'db2');
		return array_merge(parent::$shortcuts, $shortcuts);
	}

	protected $path		= 'latestposts';
	protected $data		= array(
		'name'			=> 'Latest Forum Posts',
		'version'		=> '2.0.5',
		'author'		=> 'WalleniuM',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'See the latest Forum Posts',
	);
	protected $positions = array('middle', 'left1', 'left2', 'right', 'bottom');
	
	protected $install	= array(
	);
	
	protected $exchangeModules = array(
		'latestposts',
	);
	
	protected $hooks = array(
		array('wrapper', 'latestposts_wrapper_hook')
	);

	public $LoadSettingsOnchangeVisibility = true;
	
	
	public function get_settings($state){
		$settings	= array(
		'pk_latestposts_bbmodule'	=> array(
			'name'		=> 'pk_latestposts_bbmodule',
			'language'	=> 'pk_latestposts_bbmodule',
			'property'	=> 'dropdown',
			'help'		=> '',
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
			'javascript'=> 'onchange="load_settings()"',
		),
		'pk_latestposts_dbprefix'	=> array(
			'name'		=> 'pk_latestposts_dbprefix',
			'language'	=> 'pk_latestposts_dbprefix',
			'property'	=> 'text',
			'size'		=> '30',
			'help'		=> '',
			'javascript'=> 'onchange="load_settings()"',
		),
		'pk_latestposts_dbmode'	=> array(
			'name'		=> 'pk_latestposts_dbmode',
			'help'		=> 'pk_latestposts_dbmode_h',
			'language'	=> 'pk_latestposts_dbmode',
			'property'	=> 'dropdown',
			'javascript'=> 'onchange="load_settings()"',
			'help'		=> '',
			'options'	=> array(
				'same'		=> 'pk_latestposts_dbmode_same',
				'new'		=> 'pk_latestposts_dbmode_new',
				'bridge'	=> 'pk_latestposts_dbmode_bridge',
			)
		),
		'pk_latestposts_dbhost'	=> array(
			'name'		=> 'pk_latestposts_dbhost',
			'language'	=> 'pk_latestposts_dbhost',
			'property'	=> 'text',
			'size'		=> '30',
			'help'		=> '',
			'encrypt'	=> true,
			'dependency'=> array('pk_latestposts_dbmode', 'new'),
			'javascript'=> 'onchange="load_settings()"',
		),
		'pk_latestposts_dbname'	=> array(
			'name'		=> 'pk_latestposts_dbname',
			'language'	=> 'pk_latestposts_dbname',
			'property'	=> 'text',
			'size'		=> '30',
			'help'		=> '',
			'encrypt'	=> true,
			'dependency'=> array('pk_latestposts_dbmode', 'new'),
			'javascript'=> 'onchange="load_settings()"',
		),
		'pk_latestposts_dbuser'	=> array(
			'name'		=> 'pk_latestposts_dbuser',
			'language'	=> 'pk_latestposts_dbuser',
			'property'	=> 'text',
			'size'		=> '30',
			'help'		=> '',
			'encrypt'	=> true,
			'dependency'=> array('pk_latestposts_dbmode', 'new'),
			'javascript'=> 'onchange="load_settings()"',
		),
		'pk_latestposts_dbpassword'	=> array(
			'name'		=> 'pk_latestposts_dbpassword',
			'language'	=> 'pk_latestposts_dbpassword',
			'property'	=> 'password',
			'size'		=> '30',
			'help'		=> '',
			'encrypt'	=> true,
			'dependency'=> array('pk_latestposts_dbmode', 'new'),
			'javascript'=> 'onchange="load_settings()"',
		),
		'pk_latestposts_url'	=> array(
			'name'		=> 'pk_latestposts_url',
			'language'	=> 'pk_latestposts_url',
			'property'	=> 'text',
			'size'		=> '30',
			'help'		=> '',
		),
		'pk_latestposts_trimtitle'	=> array(
			'name'		=> 'pk_latestposts_trimtitle',
			'language'	=> 'pk_latestposts_trimtitle',
			'property'	=> 'text',
			'size'		=> '6',
			'help'		=> 'pk_latestposts_trimtitle_h',
		),
		'pk_latestposts_amount'	=> array(
			'name'		=> 'pk_latestposts_amount',
			'language'	=> 'pk_latestposts_amount',
			'property'	=> 'text',
			'size'		=> '6',
			'help'		=> '',
		),
		'pk_latestposts_linktype'	=> array(
			'name'		=> 'pk_latestposts_linktype',
			'language'	=> 'pk_latestposts_linktype',
			'property'	=> 'dropdown',
			'options'	=> array(
				'0'				=> 'pk_set_link_type_self',
				'1'				=> 'pk_set_link_type_link',
				'2'				=> 'pk_set_link_type_iframe',
				'4'				=> 'pk_set_link_type_D_iframe_womenues',
			),
			'help'		=> '',
		),
		'pk_latestposts_blackwhitelist'	=> array(
			'name'		=> 'pk_latestposts_blackwhitelist',
			'language'	=> 'pk_latestposts_blackwhite',
			'property'	=> 'dropdown',
			'help'		=> 'pk_latestposts_blackwhite_h',
			'options'	=> array(
				'black'		=> 'Blacklist',
				'white'		=> 'Whitelist',
			)
		),		
	);
	
		// kill the bridge option if its disabled
		if((int)$this->config->get('cmsbridge_active') != 1){
			unset($settings['pk_latestposts_dbmode']['options']['bridge']);
		}
		
		//Try a database connection
		if($this->config->get('cmsbridge_active') == 1 && $this->config->get('pk_latestposts_dbmode') == 'bridge'){
			//Bridge Connection
			$mydb		= $this->bridge->db;
			//change prefix
			if (strlen(trim($this->config->get('pk_latestposts_dbprefix')))) $mydb->setPrefix(trim($this->config->get('pk_latestposts_dbprefix')));
		} elseif($this->config->get('pk_latestposts_dbmode') == 'new'){
			//Another Database
			try {
				$mydb = idbal::factory(array('dbtype' => 'mysqli', 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config->get('pk_latestposts_dbprefix'))));
				$mydb->connect($this->crypt->decrypt($this->config->get('pk_latestposts_dbhost')), $this->crypt->decrypt($this->config->get('pk_latestposts_dbname')), $this->crypt->decrypt($this->config->get('pk_latestposts_dbuser')), $this->crypt->decrypt($this->config->get('pk_latestposts_dbpassword')));
			} catch(iDBALException $e){
				$mydb = false;
			}
		}else{
			//Same Database
			try {
				$mydb = idbal::factory(array('dbtype' => 'mysqli', 'open'=>true, 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config->get('pk_latestposts_dbprefix'))));			
			} catch(iDBALException $e){
				$mydb = false;
			}
		}
		
		if ($mydb){
			$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config->get('pk_latestposts_bbmodule').'.php';
			if(is_file($bbModule)){
				include_once($bbModule);
				$classname = 'latestpostsmodule_'.$this->config->get('pk_latestposts_bbmodule');
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
			if ($this->config->get('pk_latestposts_dbmode') == 'bridge') $mydb->resetPrefix();
		}
		
		if (is_array($this->pdh->get('portal', 'visibility', array($this->id)))){
			foreach ($this->pdh->get('portal', 'visibility', array($this->id)) as $key => $value){
				if (isset($arrOptions)){
					$settings['pk_latestposts_privateforums_'.$value]	= array(
						'name'		=> 'pk_latestposts_privateforums_'.$value,
						'language'	=> $this->user->lang('pk_latestposts_privateforums').(((int)$value ==0 ) ? $this->user->lang('cl_all') : $this->pdh->get('user_groups', 'name', array($value))),
						'property'	=> 'jq_multiselect',
						'help'		=> 'pk_latestposts_privateforums_dd_help',
						'options'	=> $arrOptions,
					);
				} else {
					$settings['pk_latestposts_privateforums_'.$value]	= array(
						'name'		=> 'pk_latestposts_privateforums_'.$value,
						'language'	=> $this->user->lang('pk_latestposts_privateforums').(((int)$value ==0 ) ? $this->user->lang('cl_all') : $this->pdh->get('user_groups', 'name', array($value))),
						'property'	=> 'text',
						'size'		=> '30',
						'help'		=> 'pk_latestposts_privateforums_help',
					);
				}
			}
		}
		
		return $settings;
	}
	
	
	public function output() {
		$myOut = $this->pdc->get('portal.modul.latestposts.u'.$this->user->id,false,true);

		if(!$myOut){
			// do the link-thing..
			$myTarget	= ($this->config->get('pk_latestposts_linktype') == '1') ? '_blank' : '';
			$strBoardURL = $this->config->get('pk_latestposts_url');
			
			if (substr($this->config->get('pk_latestposts_url'), -1) != "/"){
				$strBoardURL .= '/';
			}

			//Try a database connection
			if($this->config->get('cmsbridge_active') == 1 && $this->config->get('pk_latestposts_dbmode') == 'bridge'){
				//Bridge Connection
				$mydb		= $this->bridge->db;
				//change prefix
				if (strlen(trim($this->config->get('pk_latestposts_dbprefix')))) $mydb->setPrefix(trim($this->config->get('pk_latestposts_dbprefix')));
			} elseif($this->config->get('pk_latestposts_dbmode') == 'new'){
				//Another Database
				try {
					$mydb = idbal::factory(array('dbtype' => 'mysqli', 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config->get('pk_latestposts_dbprefix'))));
					$mydb->connect($this->crypt->decrypt($this->config->get('pk_latestposts_dbhost')), $this->crypt->decrypt($this->config->get('pk_latestposts_dbname')), $this->crypt->decrypt($this->config->get('pk_latestposts_dbuser')), $this->crypt->decrypt($this->config->get('pk_latestposts_dbpassword')));
				} catch(iDBALException $e){
					$mydb = false;
				}
			}else{
				//Same Database
				try {
					$mydb = idbal::factory(array('dbtype' => 'mysqli', 'open'=>true, 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config->get('pk_latestposts_dbprefix'))));			
				} catch(iDBALException $e){
					$mydb = false;
				}
			}
			
			if (!$mydb){
				return $this->user->lang('pk_latestposts_connerror');
			}

			// Set some Variables we're using in the BB Modules..
			$topicnumber	= ($this->config->get('pk_latestposts_amount')) ? $this->config->get('pk_latestposts_amount') : 5;
			$black_or_white	= ($this->config->get('pk_latestposts_blackwhitelist') == 'white') ? 'IN' : 'NOT IN';

			// include the BB Module File...
			$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config->get('pk_latestposts_bbmodule').'.php';
			if(is_file($bbModule)){
				include_once($bbModule);
				$classname = 'latestpostsmodule_'.$this->config->get('pk_latestposts_bbmodule');
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
			$visibilityGrps = $this->pdh->get('portal', 'visibility', array($this->id));
			foreach ($arrUserMemberships as $groupid) {
				//only load forums for which actual settings are set
				if(!in_array($groupid, $visibilityGrps)) continue;
				
				$strForums = $this->config->get('pk_latestposts_privateforums_'.$groupid);
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
					$arrTmpForums = ($this->config->get('pk_latestposts_privateforums')) ? explode(",", $this->config->get('pk_latestposts_privateforums')) : '';
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
						
							$member_link	= (in_array($this->config->get('pk_latestposts_linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('member', $row) : $strMemberlinkWrapper;
							$topic_link		= (in_array($this->config->get('pk_latestposts_linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('topic', $row) : $strTopiclinkWrapper;
	
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
										<a href='".htmlentities($topic_link)."' target='".$myTarget."'><i class=\"icon-chevron-right\"></i></a>
										</td>
									</tr>";		
						}
						
					} else {
						$myOut .= "<tr valign='top'>
									<td colspan='3'>".$this->user->lang('pk_latestposts_noentries')."</td>
								</tr>";
					}					
					
					$myOut = "<table cellpadding='3' cellspacing='2' width='100%' class='table colorswitch'>
							<tr>
								<th width='50%'>".$this->user->lang('pk_latestposts_title')."</th>
								".(($blnForumName) ? '<th class="nowrap" width="10%">'.$this->user->lang('pk_latestposts_forum').'</th>' : '')."
								<th width='10%'>".$this->user->lang('pk_latestposts_posts')."</th>
								<th width='20%'>".$this->user->lang('pk_latestposts_lastpost')."</th>
							</tr>".$myOut;
				
					$myOut .= "</table>";
				} else {
					$myOut = "An error occured.";
				}					
			} else {
				// Sidebar Output
				$myOut = "<table cellpadding='3' cellspacing='2' width='100%' class='colorswitch'>";
				
				$objQuery = $mydb->query($strQuery);
				if($objQuery){
					$arrResult = $objQuery->fetchAllAssoc();
					if (count($arrResult)){
						$sucess = true;
						$myTitleLength = ($this->config->get('pk_latestposts_trimtitle')) ? $this->config->get('pk_latestposts_trimtitle') : 40;
						
						foreach($arrResult as $row){
							if (strlen($row['bb_topic_title']) > $myTitleLength){
								$short_title = substr($row['bb_topic_title'], 0, $myTitleLength)."...";
							}else{
								$short_title = $row['bb_topic_title'];
							}
							$strMemberlinkWrapper = $this->routing->build('external', $row['bb_username'].'-'.$row['bb_user_id'], 'User');
							$strTopiclinkWrapper = $this->routing->build('external', $row['bb_topic_title'].'-'.$row['bb_topic_id'], 'Topic');
							
							$member_link	= (in_array($this->config->get('pk_latestposts_linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('member', $row) : $strMemberlinkWrapper;
							$topic_link		= (in_array($this->config->get('pk_latestposts_linktype'), range(0,1))) ? $strBoardURL.$module->getBBLink('topic', $row) : $strTopiclinkWrapper;
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
						$myOut = $this->user->lang('pk_latestposts_noentries');					
					}
					
				}
			}
			
			if($this->config->get('pk_latestposts_dbmode') == 'bridge'){
				//reset prefix
				$mydb->resetPrefix();
			}
			
			if (isset($sucess)) {
				$this->pdc->put('portal.modul.latestposts.u'.$this->user->id,$myOut,300,false,true);
			}
		}
		return $myOut;
	}

	public function reset() {
		$this->pdc->del_prefix('portal.modul.latestposts');
	}
}
?>
<?php
/*	Project:	EQdkp-Plus
 *	Package:	Last posts Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
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

if (!defined('EQDKP_INC')){
	die('Do not access this file directly.');
}

if (!class_exists('exchange_latestposts')){
	class exchange_latestposts extends gen_class{
		public static $shortcuts = array('pex'=>'plus_exchange', 'crypt'=>'encrypt');
		public $options		= array();
		
		private $module_id = 0;
		
		public function __construct($module_id) {
			$this->module_id = $module_id;
		}

		public function get_latestposts($params, $body){
			$intNumber = (intval($params['get']['number']) > 0) ?  intval($params['get']['number']) : 10;
		
			$myOut = $this->pdc->get('portal.module.latestposts.exchange.'.$intNumber.'.u'.$this->user->id,false,true);
				if(!$myOut){
					
				//Try a database connection
				if($this->config->get('cmsbridge_active') == 1 && $this->config->get('dbmode', 'pmod_'.$this->module_id) == 'bridge'){
					//Bridge Connection
					$mydb		= $this->bridge->bridgedb;
					//change prefix
					if (strlen(trim($this->config->get('dbprefix', 'pmod_'.$this->module_id)))) $mydb->setPrefix(trim($this->config->get('dbprefix', 'pmod_'.$this->module_id)));
				} elseif($this->config->get('dbmode', 'pmod_'.$this->module_id) == 'new'){
					//Another Database
					try {
						$mydb = dbal::factory(array(
							'dbtype' => registry::get_const('dbtype'),
							'debug_prefix' => 'latestposts_',
							'table_prefix' => trim($this->config->get('dbprefix', 'pmod_'.$this->module_id))
						));
						$mydb->connect($this->crypt->decrypt(
							$this->config->get('dbhost', 'pmod_'.$this->module_id)),
							$this->crypt->decrypt($this->config->get('dbname', 'pmod_'.$this->module_id)),
							$this->crypt->decrypt($this->config->get('dbuser', 'pmod_'.$this->module_id)),
							$this->crypt->decrypt($this->config->get('dbpassword', 'pmod_'.$this->module_id))
						);
					} catch(DBALException $e){
						$mydb = false;
					}
				}else{
					//Same Database
					try {
						$mydb = dbal::factory(array('dbtype' => registry::get_const('dbtype'), 'open'=>true, 'debug_prefix' => 'latestposts_', 'table_prefix' => trim($this->config->get('dbprefix', 'pmod_'.$this->module_id))));
					} catch(DBALException $e){
						$mydb = false;
					}
				}	

				
				if ($mydb){
					$black_or_white	= ($this->config->get('blackwhitelist', 'pmod_'.$this->module_id) == 'white') ? 'IN' : 'NOT IN';
					
					// include the BB Module File...
					$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config->get('bbmodule', 'pmod_'.$this->module_id).'.php';
					if(is_file($bbModule)){
						include_once($bbModule);
						$classname = 'latestpostsmodule_'.$this->config->get('bbmodule', 'pmod_'.$this->module_id);
						$module = new $classname();
							
						if(!$module || !method_exists($module, 'getBBQuery')){
							return $this->pex->error('boardmodule not available');
						}
					
					} else {
						return $this->pex->error('no boardmodule selected');
					}
					
					// Create Array of allowed/disallowed forums
					$arrUserMemberships = $this->pdh->get('user_groups_users', 'memberships', array($this->user->id));
					array_push($arrUserMemberships, 0);
					$arrForums = array();
					foreach ($arrUserMemberships as $groupid){
						$strForums = $this->config->get('privateforums_'.$groupid, 'pmod_'.$this->module_id);
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
							$arrTmpForums = ($this->config->get('privateforums', 'pmod_'.$this->module_id)) ? explode(",", $this->config->get('privateforums', 'pmod_'.$this->module_id)) : '';
							if(is_array($arrTmpForums)){
								foreach($arrTmpForums as $forumid){
									if(trim($forumid) != ''){
										$arrForums[] = trim($forumid);
									}
								}
							}
						}
					}
					
					$strQuery = $module->getBBQuery($arrForums, $black_or_white, $intNumber);
					$myOut['forum_url'] = htmlentities($this->config->get('url', 'pmod_'.$this->module_id));
					
					$strBoardURL = $this->config->get('url', 'pmod_'.$this->module_id);
					if (substr($strBoardURL, -1) != "/"){
						$strBoardURL .= '/';
					}
					
					$myOut['posts'] = array();
					$sucess = false;
					
					$objQuery = $mydb->query($strQuery);
					if ($objQuery && $objQuery->numRows){
						$sucess = true;
						while($row = $objQuery->fetchAssoc()){
							$myOut['posts'][] = array(
									'member_link' => htmlentities($strBoardURL.$module->getBBLink('member', $row)),
									'topic_link' => htmlentities($strBoardURL.$module->getBBLink('topic', $row)),
									'topic_title' => $row['bb_topic_title'],
									'topic_replies' => intval($row['bb_replies']),
									'topic_lastpost_date' => $this->time->date('Y-m-d H:i', $row['bb_posttime']),
									'topic_lastpost_timestamp' => $row['bb_posttime'],
									'topic_lastpost_username' => $row['bb_username'],
							);
						}
						
					} else {
						$myOut['posts'] = array();						
					}
					
					if ($sucess) {
						$this->pdc->put('portal.module.latestposts.exchange.'.$intNumber.'.u'.$this->user->id,$myOut,300,false,true);
					}
					
					
				} else return $this->pex->error('connection error');

			}
			return $myOut;
		}
	}
}
?>
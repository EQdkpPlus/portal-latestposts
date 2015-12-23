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

if (!class_exists('latestposts_wrapper_hook')){
	class latestposts_wrapper_hook extends gen_class {
		private $module_id = 0;

		public function __construct($module_id) {
			$this->module_id = $module_id;
		}
		
		public function wrapper_hook($arrParams){
			if ($arrParams['id'] != 'topic' && $arrParams['id'] != 'user' ) return false;
			
			// include the BB Module File...
			$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config->get('bbmodule', 'pmod_'.$this->module_id).'.php';
			if(is_file($bbModule)){
				include_once($bbModule);
				$classname = 'latestpostsmodule_'.$this->config->get('bbmodule', 'pmod_'.$this->module_id);
				$module = new $classname();
				
				if(!$module || !method_exists($module, 'getBBQuery')){
					return false;
				}

			} else {
				return false;
			}
			
			$arrPath = array_filter(explode('-', $arrParams['link']));
			$arrPath = array_reverse($arrPath);
			$strBoardURL = $this->config->get('url', 'pmod_'.$this->module_id);
			
			if (substr($this->config->get('url', 'pmod_'.$this->module_id), -1) != "/"){
				$strBoardURL .= '/';
			}
			
			if($arrParams['id'] == 'topic'){
				$row = array(
					'bb_topic_id'	=> $arrPath[0],
					'bb_post_id'	=> $arrPath[1],
				);
				
				$strUrl = $strBoardURL.$module->getBBLink('topic', $row);
				
				$out = array(
					'url'		=> $strUrl,
					'title'		=> $this->user->lang('forum'),
					'window'	=> (int)$this->config->get('linktype', 'pmod_'.$this->module_id),
					'height'	=> '4024',
				);
				
				return array('id'=>'topic', 'data'=> $out);
			
			} else {
				$row = array(
					'bb_user_id' => $arrPath[0]
				);
				
				$strUrl = $strBoardURL.$module->getBBLink('member', $row);
				
				$out = array(
					'url'		=> $strUrl,
					'title'		=> $this->user->lang('forum'),
					'window'	=> (int)$this->config->get('linktype', 'pmod_'.$this->module_id),
					'height'	=> '4024',
				);
				
				return array('id'=>'user', 'data'=> $out);
			}
		}
	}
}
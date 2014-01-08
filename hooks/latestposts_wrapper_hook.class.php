<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2009
 * Date:		$Date: 2012-11-11 19:07:23 +0100 (So, 11. Nov 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12435 $
 *
 * $Id: latestposts_wrapper_hook.class.php 12435 2012-11-11 18:07:23Z wallenium $
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
					'bb_topic_id' => $arrPath[0],
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
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
	class latestposts_wrapper_hook extends gen_class{
		public static $shortcuts = array('user', 'config');
		
		
		public function wrapper_hook($arrParams){
			if ($arrParams['id'] != 'Topic' && $arrParams['id'] != 'User' ) return false;
			
			// include the BB Module File...
			$bbModule = $this->root_path . 'portal/latestposts/bb_modules/'.$this->config->get('pk_latestposts_bbmodule').'.php';
			if(is_file($bbModule)){
				include_once($bbModule);
				$classname = 'latestpostsmodule_'.$this->config->get('pk_latestposts_bbmodule');
				$module = new $classname();
				
				if(!$module || !method_exists($module, 'getBBQuery')){
					return false;
				}

			} else {
				return false;
			}
			
			$arrPath = array_filter(explode('-', $arrParams['link']));
			$arrPath = array_reverse($arrPath);
			$strBoardURL = $this->config->get('pk_latestposts_url');
			
			if (substr($this->config->get('pk_latestposts_url'), -1) != "/"){
				$strBoardURL .= '/';
			}
			
			if($arrParams['id'] == 'Topic'){
				$row = array(
					'bb_topic_id' => $arrPath[0]
				);
				
				$strUrl = $strBoardURL.$module->getBBLink('topic', $row);
				
				$out = array(
					'url'		=> $strUrl,
					'title'		=> $this->user->lang('forum'),
					'window'	=> (int)$this->config->get('pk_latestposts_linktype'),
					'height'	=> '4024',
				);
				
				return array('id'=>'Topic', 'data'=> $out);
			
			} else {
				$row = array(
					'bb_user_id' => $arrPath[0]
				);
				
				$strUrl = $strBoardURL.$module->getBBLink('member', $row);
				
				$out = array(
					'url'		=> $strUrl,
					'title'		=> $this->user->lang('forum'),
					'window'	=> (int)$this->config->get('pk_latestposts_linktype'),
					'height'	=> '4024',
				);
				
				return array('id'=>'User', 'data'=> $out);
			}
		}
	}
}

if(version_compare(PHP_VERSION, '5.3.0', '<')) {
	registry::add_const('short_latestposts_wrapper_hook', latestposts_wrapper_hook::$shortcuts);
}
<?php
 /*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date$
 * -----------------------------------------------------------------------
 * @author      $Author$
 * @copyright   2006-2010 EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$portal_module['latestposts'] = array(
			'name'			    => 'Latest Forum Posts',
			'path'			    => 'latestposts',
			'version'		    => '1.2.0',
			'author'			=> 'WalleniuM',
			'contact'		    => 'http://www.eqdkp-plus.com',
			'description'		=> 'See the latest Forum Posts',
			'positions'			=> array('left1', 'left2', 'right', 'middle'),
			'install'			=> array(
			                            'autoenable'        => '0',
			                            'defaultposition'   => 'middle',
			                            'defaultnumber'     => '1',
			                            'visibility'        => '0',
			                            'collapsable'       => '1',
                                  ),
    );

$portal_settings['latestposts'] = array(
  'pk_latestposts_amount'     => array(
        'name'      => 'pk_latestposts_amount',
        'language'  => 'pk_latestposts_amount',
        'property'  => 'text',
        'size'      => '6',
        'help'      => '',
      ),
  'pk_latestposts_newwindow'     => array(
        'name'      => 'pk_latestposts_newwindow',
        'language'  => 'pk_latestposts_newwindow',
        'property'  => 'checkbox',
        'size'      => '30',
        'help'      => '',
      ),
  'pk_latestposts_blackwhitelist'     => array(
        'name'      => 'pk_latestposts_blackwhitelist',
        'language'  => 'pk_latestposts_blackwhite',
        'property'  => 'dropdown',
        'help'      => 'pk_latestposts_blackwhite_h',
        'options'   => array(
                          'black'    => 'Blacklist',
                          'white'    => 'Whitelist',
                        )
      ),
  'pk_latestposts_privateforums'     => array(
        'name'      => 'pk_latestposts_privateforums',
        'language'  => 'pk_latestposts_privateforums',
        'property'  => 'text',
        'size'      => '30',
        'help'      => 'pk_latestposts_privforums_h',
      ),
  'pk_latestposts_bbmodule'     => array(
        'name'      => 'pk_latestposts_bbmodule',
        'language'  => 'pk_latestposts_bbmodule',
        'property'  => 'dropdown',
        'help'      => '',
        'options'   => array(
                          'phpbb3.php'	=> 'phpBB3',
                          'phpbb2.php'	=> 'phpBB2',
                          'ipb2.php'	=> 'IPB 2.x',
                          'smf.php'		=> 'SMF 1.x',
                          'smf2.php'	=> 'SMF 2.x',
                          'vb3.php'		=> 'vBulletin 3',
                          'wbb3.php'	=> 'WBB 3',
                          'e107.php'	=> 'e107',
                        )
      ),
  'pk_latestposts_url'     => array(
        'name'      => 'pk_latestposts_url',
        'language'  => 'pk_latestposts_url',
        'property'  => 'text',
        'size'      => '30',
        'help'      => '',
      ),
    'pk_latestposts_dbprefix'     => array(
        'name'      => 'pk_latestposts_dbprefix',
        'language'  => 'pk_latestposts_dbprefix',
        'property'  => 'text',
        'size'      => '30',
        'help'      => '',
      ),
    'pk_latestposts_trimtitle'     => array(
        'name'      => 'pk_latestposts_trimtitle',
        'language'  => 'pk_latestposts_trimtitle',
        'property'  => 'text',
        'size'      => '6',
        'help'      => 'pk_latestposts_trimtitle_h',
      ),
   'pk_latestposts_newdb'     => array(
        'name'      => 'pk_latestposts_newdb',
        'language'  => 'pk_latestposts_newdb',
        'property'  => 'checkbox',
        'size'      => '30',
        'help'      => '',
      ),
      
   'pk_latestposts_dbhost'     => array(
        'name'      => 'pk_latestposts_dbhost',
        'language'  => 'pk_latestposts_dbhost',
        'property'  => 'text',
        'size'      => '30',
        'help'      => '',
      ),
   'pk_latestposts_dbname'     => array(
        'name'      => 'pk_latestposts_dbname',
        'language'  => 'pk_latestposts_dbname',
        'property'  => 'text',
        'size'      => '30',
        'help'      => '',
      ),
   'pk_latestposts_dbuser'     => array(
        'name'      => 'pk_latestposts_dbuser',
        'language'  => 'pk_latestposts_dbuser',
        'property'  => 'text',
        'size'      => '30',
        'help'      => '',
      ),
   'pk_latestposts_dbpassword'     => array(
        'name'      => 'pk_latestposts_dbpassword',
        'language'  => 'pk_latestposts_dbpassword',
        'property'  => 'text',
        'size'      => '30',
        'help'      => '',
      ),
);

if(!function_exists(latestposts_module))
{
  function latestposts_module()
  {
  	global $eqdkp, $user, $db, $plang, $conf_plus, $wherevalue, $eqdkp_root_path;
    global $dbhost, $dbname, $dbuser, $dbpass, $sql_db, $pdc;
    
  	$myOut = $pdc->get('portal.modul.latestposts',false,true);
  	if (!$myOut) 
  	{
	    // This Module requires EQDKP PLUS 0.6.2.x
	    if(EQDKPPLUS_VERSION < '0.6.2.1'){
	      return $plang['pk_latestposts_plus2old'];
	    }
	    // Where should we open the links?
	    $myTarget   = ($conf_plus['pk_latestposts_newwindow'] == '1') ? '_blank' : '_self';
	    $myWrapper  = ($conf_plus['pk_latestposts_newwindow'] == '1') ? $conf_plus['pk_latestposts_url'].'/' : $eqdkp_root_path.'wrapper.php?id=lp&f='.rawurlencode($conf_plus['pk_latestposts_url'].'/');
	    
	  	// Initiate the new Database Connection if needed
	  	if($conf_plus['pk_latestposts_newdb'] != 1){
	      $mydb = $db;
	    }else{
	      $mydb = new $sql_db();
	      $mydb->sql_connect($conf_plus['pk_latestposts_dbhost'], $conf_plus['pk_latestposts_dbname'], $conf_plus['pk_latestposts_dbuser'], $conf_plus['pk_latestposts_dbpassword'], false);
	    }
	  	
	  	// Set some Variables we're using in the BB Modules..
	  	$topicnumber    = ($conf_plus['pk_latestposts_amount']) ? $conf_plus['pk_latestposts_amount'] : 5;
	    $black_or_white = ($conf_plus['pk_latestposts_blackwhitelist'] == 'white') ? 'IN' : 'NOT IN';
	  	
	  	//Filter the Filters.. :D
	  	$privateforums_tmp  = ($conf_plus['pk_latestposts_privateforums']) ? explode(";", $conf_plus['pk_latestposts_privateforums']) : '';
	    if(is_array($privateforums_tmp)){
	      $privateforums = array();
	      foreach($privateforums_tmp as $mynumbertofilter){
	        if(trim($mynumbertofilter) != ''){
	          $privateforums[] = trim($mynumbertofilter);
	        }
	      }
	    }
	  	
	  	// include the BB Module File...
	  	$bbModule = $eqdkp_root_path . 'portal/latestposts/bb_modules/'.$conf_plus['pk_latestposts_bbmodule'];
	  	if(is_file($bbModule)){
	      include($bbModule);
	      if(!$myBBquery){
	        return $plang['portal_latestposts_invmodule'];
	      }
	    }else{
	      return $plang['portal_latestposts_nomodule'];
	    }
	    
	    // Middle Output
	    if($wherevalue == 'middle')
	    {
	      $myOut = "<table cellpadding='3' cellSpacing='2' width='100%'>
	                <tr>
	                  <th width='60%'>".$plang['pk_latestposts_title']."</th>
	                  <th width='10%'>".$plang['pk_latestposts_posts']."</th>
	                  <th width='30%' colspan='2'>".$plang['pk_latestposts_lastpost']."</th>
	                </tr>";
	      if($bb_result = $mydb->query($myBBquery))
	      {
	      	$sucess = true;
	        while($row = $mydb->fetch_record($bb_result))
	        {
	          $member_link  = ($conf_plus['pk_latestposts_newwindow'] == '1') ? $myWrapper.bbLinkGeneration('member', $row) : $myWrapper.rawurlencode(bbLinkGeneration('member', $row));
	          $topic_link   = ($conf_plus['pk_latestposts_newwindow'] == '1') ? $myWrapper.bbLinkGeneration('topic', $row) : $myWrapper.rawurlencode(bbLinkGeneration('topic', $row));
	          $myOut .= "<tr valign='top' class='".$eqdkp->switch_row_class()."''>
	                      <td>
	                        <a href='".$topic_link."' target='".$myTarget."'>".$row['bb_topic_title']."</a>
	                      </td>
	                      <td align='center'>".$row['bb_replies']."</td>
	                      <td>".date('d.m.Y, H:i', $row['bb_posttime'])."</td>
	                      <td><a href='".$member_link."' target='".$myTarget."'>".$row['bb_username']."</a> <a href='".$topic_link."' target='_blank'><img src='".$eqdkp_root_path."portal/latestposts/images/icon_topic_latest.gif' /></a></td>
	                    </tr>";
	        }
	      }else{
	        $myOut .= "<tr valign='top'>
	                      <td colspan='3'>".$plang['pk_latestposts_noentries']."</td
	                    </tr>";
	      }
	      $myOut .= "</table>";
	    }else
	    {
	      // Sidebar Output
	      $myOut = "<table cellpadding='3' cellSpacing='2' width='100%'>";
	      if($bb_result = $mydb->query($myBBquery))
	      {
	      	$sucess = true;	      	
	        $myTitleLength = ($conf_plus['pk_latestposts_trimtitle']) ? $conf_plus['pk_latestposts_trimtitle'] : 40;
	        while($row = $mydb->fetch_record($bb_result))
	        {
	          if (strlen($row['bb_topic_title']) > $myTitleLength){
	            $short_title = substr($row['bb_topic_title'], 0, $myTitleLength)."...";
	          }else{
	            $short_title = $row['bb_topic_title'];
	          }
	          $member_link  = ($conf_plus['pk_latestposts_newwindow'] == '1') ? $myWrapper.bbLinkGeneration('member', $row) : $myWrapper.rawurlencode(bbLinkGeneration('member', $row));
	          $topic_link   = ($conf_plus['pk_latestposts_newwindow'] == '1') ? $myWrapper.bbLinkGeneration('topic', $row) : $myWrapper.rawurlencode(bbLinkGeneration('topic', $row));
	          $myOut .= "<tr valign='top' class='".$eqdkp->switch_row_class()."''>
	                      <td>
	                        <a href='".$topic_link."' target='".$myTarget."'>".$short_title."</a> (".$row['bb_replies'].")<br/>
	                        ".date('d.m.y, H:i', $row['bb_posttime']).", <a href='".$member_link."' target='".$myTarget."'>".$row['bb_username']."</a>
	                      </td>
	                    </tr>";
	        }
	      }
	      $myOut .= "</table>";
	    }
	    $mydb->free_result($bb_result);
	    if($conf_plus['pk_latestposts_newdb'] == 1){ $mydb->close_db(); }
	    
	    if ($sucess) {
	    	$pdc->put('portal.modul.latestposts',$myOut,300,false,true);
	    }
	    
  	}    
    
    return $myOut;
  }
}
?>
<?php
 /*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2010-07-11 16:25:04 +0200 (So, 11. Jul 2010) $
 * -----------------------------------------------------------------------
 * @author      $Author: wallenium $
 * @copyright   2006-2010 EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 8345 $
 * 
 * $Id: korean.php 8345 2010-07-11 14:25:04Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$plang = array_merge($plang, array(
  'latestposts'                 => '최근 포럼 포스트',
  'portal_latestposts_nomodule' => '모듈이 선택되지 않았습니다. 모듈 설정을 확인하세요!',
  'portal_latestposts_invmodule'=> '잘못된 BB 모듈',
  'pk_latestposts_bbmodule'     => '포럼 모듈',
  'pk_latestposts_amount'       => '최근 x 개의 엔트리를 보입니다.',
  'pk_latestposts_newdb'        => '다른 데이터베이스 내 BB ',
  'pk_latestposts_dbname'       => '데이터베이스',
  'pk_latestposts_dbuser'       => '사용자',
  'pk_latestposts_dbpassword'   => '패스워드',
  'pk_latestposts_dbhost'       => '호스트',
  'pk_latestposts_dbprefix'     => '접두사',
  'pk_latestposts_url'          => '게시판 URL',
  'pk_latestposts_noentries'    => '보여질 내용이 없습니다.',
  'pk_latestposts_connerror'    => '연결 오류',
  'pk_latestposts_lastpost'     => '최근 게시물',
  'pk_latestposts_starter'      => '게시자',
  'pk_latestposts_posts'        => '답글',
  'pk_latestposts_title'        => '제목',
  'pk_latestposts_trimtitle'    => 'x 자를 넘는 긴 제목을 줄입니다.',
  'pk_latestposts_trimtitle_h'  => '왼쪽과 오른쪽 모듈 블럭에 위치할 때만 작동합니다.',
  'pk_latestposts_privateforums'=> '사설 포럼의 ID, 세미콜론으로 구분.',
  'pk_latestposts_privforums_h' => '사설 포럼은 최근 포스트에서 보여지지 않습니다.',
  'pk_latestposts_plus2old'     => 'EQdkp Plus 버전이 너무 오래되었습니다. 0.6.2.0 이상 버전이 필요합니다.',
  'pk_latestposts_newwindow'    => '새 창에서 열까요?',
  'pk_latestposts_blackwhite'   => '차단 - 허용리스트',
  'pk_latestposts_blackwhite_h' => '거절할 포럼 ID 나 허용할 ID 를 입력하세요',
));
?>
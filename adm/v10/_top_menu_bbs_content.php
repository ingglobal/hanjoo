<?php
if (!defined('_GNUBOARD_')) exit;
// 카테고리 관리 상단 공통 탭 링크들입니다.

// 최고관리자인 경우만
if($member['mb_level']>=9) {
    // $sub_title_list = ' <a href="'.G5_BBS_URL.'/board.php?bo_table=setting1" class="btn_top_menu '.$active_term_list.'">환경설정게시판</a>
    // ';
}

${'active_'.$bo_table} = ' btn_top_menu_active';
$g5['container_sub_title'] = '
<h2 id="container_sub_title">
    <a href="./board.php?bo_table=001" class="btn_top_menu '.$active_001.'">회사소개</a>
    <a href="./board.php?bo_table=002" class="btn_top_menu '.$active_002.'">사업소개</a>
	'.$sub_title_list.'
</h2>
';
?>

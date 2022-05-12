<?php
if (!defined('_GNUBOARD_')) exit;
// 카테고리 관리 상단 공통 탭 링크들입니다.

// 최고관리자인 경우만
if($member['mb_level']>=9) {
    // $sub_title_list = ' <a href="'.G5_BBS_URL.'/board.php?bo_table=setting1" class="btn_top_menu '.$active_term_list.'">환경설정게시판</a>
    // ';
}

${'active_'.$g5['file_name']} = ' btn_top_menu_active';
$g5['container_sub_title'] = '
<h2 id="container_sub_title">
    <a href="./cast_shot_sub_list.php" class="btn_top_menu '.$active_cast_shot_sub_list.'">주조공정(SUB)</a>
    <a href="./cast_temperature_list.php" class="btn_top_menu '.$active_cast_temperature_list.'">주조공정(SUB)-T</a>
	'.$sub_title_list.'
</h2>
';
?>

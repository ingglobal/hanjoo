<?php
if (!defined('_GNUBOARD_')) exit;
// 카테고리 관리 상단 공통 탭 링크들입니다.

${'active_'.$g5['file_name']} = ' btn_top_menu_active';

// 최고관리자인 경우만
if($member['mb_manager_yn']) {
    $sub_title_list = ' <a href="./config_form.php" class="btn_top_menu '.$active_config_form.'">솔루션설정</a>
    ';
}

$g5['container_sub_title'] = '
<h2 id="container_sub_title">
    '.$sub_title_list.'
    <a href="./term_list.php" class="btn_top_menu '.$active_term_list.'">분류설정</a>
    <a href="./stat_user_log.php" class="btn_top_menu '.$active_stat_user_log.'">사용자로그통계</a>
</h2>
';
?>

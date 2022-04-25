<?php
$sub_menu = "950300";
include_once('./_common.php');

if ($w == 'u' || $w == 'd')
    check_demo();

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

$gme_idx = isset($_POST['gme_idx']) ? (int) $_POST['gme_idx'] : 0;
$gme_subject = isset($_POST['gme_subject']) ? strip_tags(clean_xss_attributes($_POST['gme_subject'])) : '';
$gme_content = isset($_POST['gme_content']) ? $_POST['gme_content'] : '';

$gme_content = ($_POST['gme_type']=='hp') ? $_POST['gme_hp_content'] : $_POST['gme_content'];

if ($w == '')
{
    $sql = " insert {$g5['group_message_table']}
                set gme_subject = '{$gme_subject}',
                     gme_type = '{$gme_type}',
                     gme_content = '{$gme_content}',
                     gme_reg_dt = '".G5_TIME_YMDHIS."',
                     gme_ip = '{$_SERVER['REMOTE_ADDR']}'
    ";
    sql_query($sql);
}
else if ($w == 'u')
{
    $sql = " update {$g5['group_message_table']}
                set gme_subject = '{$gme_subject}',
                     gme_type = '{$gme_type}',
                     gme_content = '{$gme_content}',
                     gme_reg_dt = '".G5_TIME_YMDHIS."',
                     gme_ip = '{$_SERVER['REMOTE_ADDR']}'
                where gme_idx = '{$gme_idx}'
    ";
    sql_query($sql);
}
else if ($w == 'd')
{
	// $sql = " delete from {$g5['group_message_table']} where gme_idx = '{$gme_idx}' ";
	$sql = " UPDATE FROM {$g5['group_message_table']} SET gme_status = 'trash' WHERE gme_idx = '{$gme_idx}' ";
    sql_query($sql);
}

goto_url('./group_message_list.php');
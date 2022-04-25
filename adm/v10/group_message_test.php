<?php
$sub_menu = "950300";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');
check_demo();

$g5['title'] = '메시지 테스트';

$name = get_text($member['mb_name']);
$nick = $member['mb_nick'];
$mb_id = $member['mb_id'];
$mb_name = $member['mb_name'];
$mb_hp = $member['mb_hp'];
$email = $member['mb_email'];
$gme_idx = isset($_REQUEST['gme_idx']) ? (int) $_REQUEST['gme_idx'] : 0;

$sql = "select gme_subject, gme_content, gme_type from {$g5['group_message_table']} where gme_idx = '{$gme_idx}' ";
$msg = sql_fetch($sql);

// 제목 및 내용 치환
$patterns = array('/{이름}/','/{닉네임}/','/{회원아이디}/','/{이메일}/');
$replacements = array($name,$nick,$mb_id,$email);

$subject = $msg['gme_subject'];
$subject = preg_replace($patterns, $replacements, $subject);

$content = $msg['gme_content'];
$content = preg_replace($patterns, $replacements, $content);



if($msg['gme_type']=='email') {

    if (!$config['cf_email_use'])
        alert('환경설정에서 \'메일발송 사용\'에 체크하셔야 메일을 발송할 수 있습니다.');
    
    include_once(G5_LIB_PATH.'/mailer.lib.php');

    // content 정보 추가
    $mb_md5 = md5($member['mb_id'].$member['mb_email'].$member['mb_datetime']);
    $content = $content . '<p>더 이상 정보 수신을 원치 않으시면 [<a href="'
                .G5_BBS_URL.'/email_stop.php?mb_id='.$mb_id.'&amp;mb_md5='.$mb_md5.'" target="_blank">수신거부</a>] 해 주십시오.</p>';

    mailer($config['cf_title'], $email, $email, $subject, $content, 1);
    
    alert($nick.'('.$email.')님께 테스트 메일을 발송하였습니다. 확인하여 주십시오.');
    
}
else if($msg['gme_type']=='hp') {
    
    // 뿌리오 발송
    $ar['mb_id'] = $member['mb_id'];
    $ar['to_number'] = $mb_hp;
    $ar['subject'] = $subject;
    $ar['content'] = $content;
    ppurio_send($ar);
    unset($ar);

    alert($mb_name.'('.$mb_hp.')님께 메시지를 발송하였습니다. 확인하여 주십시오.');
    
}


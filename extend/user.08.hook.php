<?php
if (!defined('_GNUBOARD_')) exit;

// common 후킹
add_event('common_header','u_common_header',10);
function u_common_header(){
    global $board,$board_skin_path,$board_skin_url;

    // 관리자단 게시판 스킨 설정
    $fr_adm = preg_match("/\/adm\/v10/",$_SERVER['HTTP_REFERER']);
    if (defined('G5_IS_ADMIN') || $fr_adm) {
        // 관리자 스킨
        $unser = unserialize(stripslashes($board['bo_7']));
        // print_r3($unser);
        if( is_array($unser) ) {
            foreach ($unser as $k1=>$v1) {
                // print_r3($k1.'/'.$v1);
                $board[$k1] = htmlspecialchars($v1, ENT_QUOTES | ENT_NOQUOTES); // " 와 ' 를 html code 로 변환
            }    
        }
        // print_r3($board);
        // 모바일은 없음
        if($board['set_skin_adm']) {
            $board_skin_path    = get_skin_path('board', 'theme/'.$board['set_skin_adm']);
            $board_skin_url     = get_skin_url('board', 'theme/'.$board['set_skin_adm']);
        }
    }    
}

// Modify for converting PC mode automatically when mobile logout. It should be stayed in Mobile mode.
add_event('member_logout','u_member_logout',10);
function u_member_logout(){
    if(G5_IS_MOBILE) {
        goto_url(G5_URL.'?device=mobile');
    }
}

// 로그인 페이지로 오면 메인으로 다시 돌려보내기
add_event('member_login_tail','u_member_login_tail',10);
function u_member_login_tail(){
    global $g5;
    if($g5['file_name']=='login') {
        goto_url(G5_URL);
    }
}


add_event('member_login_check','u_member_login_check',10);
function u_member_login_check(){
    global $g5, $mb;

    // for a manager without mb_4, then assign default_com_idx
    if($mb['mb_level']>=6 && !$mb['mb_4']) {
        $com_idx = $g5['setting']['set_com_idx'];
    }
    // for normal member 
    else {
        $com_idx = $mb['mb_4'];
    }
    
    $c_sql = sql_fetch(" SELECT com_kosmolog_key FROM {$g5['company_table']} WHERE com_idx = '$com_idx' ");
    $com_kosmolog_key = $c_sql['com_kosmolog_key'];
    set_session('ss_com_idx', $com_idx);
    set_session('ss_com_kosmolog_key',$com_kosmolog_key);

    // 로그인 기록을 남겨요.
    $tmp_sql = " INSERT INTO {$g5['login_table']} SET
             lo_ip = '".G5_SERVER_TIME."'
             , mb_id = '{$mb['mb_id']}'
             , lo_datetime = '".G5_TIME_YMDHIS."'
             , lo_location = '".$mb['mb_name']."'
             , lo_url = '".$_SERVER['REMOTE_ADDR']."'
    ";
    sql_query($tmp_sql, FALSE);

    //kosmo에 사용현황 log 전송 함수(extend/suer.02.function.php에 정의)
	// send_kosmo_log();
}

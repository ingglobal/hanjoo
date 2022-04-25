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

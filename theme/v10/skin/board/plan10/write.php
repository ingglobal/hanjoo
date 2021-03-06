<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$file_count = (int)$board['bo_upload_count'];

// 설비 정보 추출
$mms = get_table_meta('mms','mms_idx',$write['wr_2']);
$com = get_table_meta('company','com_idx',$mms['com_idx']);
//print_r3($mms);
if(!$mms['mms_idx']) {
    $write['mms_info'] = '선택된 설비가 없습니다. 설비를 선택하세요.';
}
// print_r2($mms);

if ($w == '') {
    $write['mms_idx'] = 0;
    $write['wr_3'] = G5_TIME_YMD;
    $write['wr_4'] = 10;
    $write['wr_5'] = 'every';
    $write['wr_6'] = 9;
    $write['wr_10'] = $board['set_default_status'];

} else if ($w == 'u') {

    $file = get_file($bo_table, $wr_id);
    if($file_count < $file['count'])
        $file_count = $file['count'];
    
} else if ($w == 'r') {


}
// print_r2($write);
// print_r2( json_decode($write['wr_7']) );

// towhom_info variable
$wr_7s = json_decode($write['wr_7'], true);
if(is_array($wr_7s)) {
    foreach($wr_7s as $k1 => $v1) {
        // echo $k1.'<br>';
        // print_r2($v1);
        for($i=0;$i<sizeof($v1);$i++) {
            $towhom_li[$i][$k1] = $v1[$i];
        }
    }
}
// print_r2($towhom_li);


// 삭제 링크
$delete_href = 'javascript:';
// 로그인중이고 자신의 글이라면 또는 관리자라면 비밀번호를 묻지 않고 바로 수정, 삭제 가능
if ($is_admin) {
    set_session('ss_delete_token', $token = uniqid(time()));
    $delete_href = $board_skin_url.'/delete.user.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
}

?>
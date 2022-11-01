<?php
// 크롬 요소검사 열고 확인하면 되겠습니다. 
// print_r2 안 쓰고 print_r로 확인하는 게 좋습니다.
header('Content-Type: application/json; charset=UTF-8');
include_once('./_common.php');

// print_r($_REQUEST);exit;
//echo $_REQUEST['shf_type'][0];
$rawBody = file_get_contents("php://input"); // 본문을 불러옴
$getData = array(json_decode($rawBody,true)); // 데이터를 변수에 넣고
// print_r($getData);
// exit;

// 토큰 비교
if(!check_token1($getData[0]['token'])) {
	$result_arr = array("code"=>499,"message"=>"token error");
}
else if(is_array($getData[0])) {
    $arr = $getData[0];
    // print_r2($arr);exit;

    $qr_time = get_qr_time($arr['qrcode']);
    // $cast_time = get_cast_time('825442610','3289922');
    // echo $cast_time.' -------- <br>';
    // if($g5['setting']['set_dicast_test_yn']) {
    //     $cast_time = date("Y-m-d H:i:s", strtotime($qr_time)-3600*2);   // 주조코드가 2시간 전에 입력된 걸로 보고 설정
    //     $arr['cast_code'] = get_time2castcode($cast_time); // ex) 2022-01-31 11:32:00 > 2A31B32
    // }
    // else {
        $cast_time = get_castcode2time($arr['cast_code']); // ex) 2A31B32 > 2022-01-31 11:32:00
    // }
    // echo $time_cast.' -------- <br>';
    $mms_idx = substr($arr['cast_code'],0,1) + 57; // 58(17호기)....61(20호기)


    $ar['qrcode'] = $arr['qrcode'];
    $ar['cast_code'] = $arr['cast_code'];
    $ar['mms_idx'] = $mms_idx;
    $ar['event_time'] = $cast_time;
    $ar['qrc_grade'] = $arr['grade'];
    $ar['qrc_result'] = $arr['result'];
    // print_r2($ar);
    qr_cast_code_update($ar);
    unset($ar);

    $result_arr['code'] = 200;
    $result_arr['message'] = "Inserted OK!";

}
else {
	$result_arr = array("code"=>599,"message"=>"error");
}

//exit;
//echo json_encode($arr);
echo json_encode( array('meta'=>$result_arr) );
?>
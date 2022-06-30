<?php
// http://hanjoo.epcs.co.kr/user/json/measure.php?token=1099de5drf09&mms_idx=58&st_date=2022-06-30&st_time=13:33:14&en_date=2022-06-30&en_time=14:33:14&dta_type=1&dta_no=2
header("Content-Type: text/plain; charset=utf-8");
include_once('./_common.php');
if(isset($_SERVER['HTTP_ORIGIN'])){
	header("Access-Control-Allow-Origin:{$_SERVER['HTTP_ORIGIN']}");
	header("Access-Control-Allow-Credentials:true");
	header("Access-Control-Max-Age:86400"); //cache for 1 day
}

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
	if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods:GET,POST,OPTIONS");
	if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	exit(0);
}

if(!$_REQUEST['token']){
//	$list = array('');
}
else if($_REQUEST['mms_idx']){

    // 토큰 비교
    if(!check_token1($_REQUEST['token'])) {
        $list = array("code"=>499,"message"=>"token error");
        echo json_encode( array($list) );
		exit;
    }

    $where = array();
    // $where[] = " (1) ";   // 디폴트 검색조건

    if($dta_type) {
        $where[] =  " dta_type = '".$dta_type."' ";
    }
    if($dta_no) {
        $where[] =  " dta_no = '".$dta_no."' ";
    }
    // 날짜 조건
    $start = $st_date.' '.$st_time;
    $end = $en_date.' '.$en_time;
    $where[] =  " dta_dt >= '".$start."' AND dta_dt <= '".$end."' ";
    
    // 최종 WHERE 생성
    if ($where) {
        $sql_search = ' WHERE '.implode(' AND ', $where);
    }


 
 	// 측정 추출
    $sql = "SELECT * FROM g5_1_data_measure_".$mms_idx."
            {$sql_search}
            ORDER BY dta_dt ASC
    ";
    // echo $sql.'<br>';
    // exit;
    $stmt = sql_query_ps($sql,1);
	$list = array();
    for ($i=0; $row=$stmt->fetch(PDO::FETCH_ASSOC); $i++) {
        $row['no'] = $i;
        $row['timestamp'] = strtotime($row['dta_dt']);
        // 좌표에 표현할 value
        $dta1[$i]['x'] = $row['timestamp']*1000;
        $dta1[$i]['y'] = (float)$row['dta_value'];
        $dta1[$i]['dta_1'] = (int)$row['dta_1'];
        $dta1[$i]['dta_2'] = (int)$row['dta_2'];
        $dta1[$i]['dta_3'] = (int)$row['dta_3'];
        $dta1[$i]['yraw'] = ($dta1[$i]['y']) ?: 0;
        $dta1[$i]['yamp'] = 1;
        $dta1[$i]['ymove'] = 0;
        // 좌표 list array
        $list[$i] = $dta1[$i];
    }
    //print_r2($dta1);

    // in case of no data.
    if(!$list[0]) {
        $dta1[0]['x'] = G5_SERVER_TIME*1000;
        $dta1[0]['y'] = 0;
        $dta1[0]['dta_1'] = null;
        $dta1[0]['dta_2'] = null;
        $dta1[0]['dta_3'] = null;
        $dta1[0]['yraw'] = 0;
        $dta1[0]['yamp'] = 1;
        $dta1[0]['ymove'] = 0;
        $list[0] = $dta1[0];
    }

}

echo json_encode( $list );
?>
<?php
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

//-- 디폴트 상태 (실패) --//
$response = new stdClass();
$response->result=false;

// 각 설비별로 최신값 추출
if(is_array($g5['set_dicast_mms_idxs_array'])) {
	foreach($g5['set_dicast_mms_idxs_array'] as $k1=>$v1) {

		// the latest datetime for dta_type = 13
		$sql = " SELECT dta_dt FROM g5_1_data_measure_".$v1." WHERE dta_type = 13 ORDER BY dta_dt LIMIT 1 ";
		$one = sql_fetch_pg($sql,1);

		// the latest values with the dta_type of 13
		$sql = "SELECT dta_type,dta_no,dta_value FROM g5_1_data_measure_".$v1."
				WHERE dta_dt = '".$one['dta_dt']."' AND dta_type = 13
		";
		// echo $sql.'<br>';
		$rs = sql_query_pg($sql,1);
		for($j=0;$row=sql_fetch_array_pg($rs);$j++) {
			// print_r2($row);
			$row['mms_idx'] = $v1;
			$response->rows[] = $row;
		}
	}
}
// print_r2($response->rows);

$response->result = true;
$response->msg = "데이타를 성공적으로 가지고 왔습니다.";

$response->sql = $sql;

echo json_encode($response);
exit;
?>
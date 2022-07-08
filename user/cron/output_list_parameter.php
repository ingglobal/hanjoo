<?php
include_once('./_common.php');

$demo = 1;  // 데모모드 = 1

$g5['title'] = 'Optimum parameters tracing';
include_once('./_head.sub.php');

//-- 화면 표시
$countgap = ($demo||$db_id) ? 10 : 20;    // 몇건씩 보낼지 설정
$maxscreen = ($demo||$db_id) ? 30 : 100;  // 몇건씩 화면에 보여줄건지?/
$sleepsec = 500;     // 천분의 몇초간 쉴지 설정 (1sec=1000)

$table2 = 'g5_1_xray_inspection';
$fields2 = sql_field_names($table2);
// print_r2($fields2);

// default date.
$ymd = $ymd ?: date("Y-m-d");

// NEXT YMD Default
if($ym) {
    // 다음달
    $sql = " SELECT DATE_ADD('".$ym."-01' , INTERVAL -1 MONTH) AS ym FROM dual ";
    $dat = sql_fetch($sql,1);
    $ym_next = substr($dat['ym'],0,7);
    // echo $ym.'<br>';
    // echo $ym_next.'<br>';
    // exit;
}
else if($ymd) {
    // 다음일
    $sql = " SELECT DATE_ADD('".$ymd."' , INTERVAL -1 DAY) AS ymd FROM dual ";
    $dat = sql_fetch($sql,1);
    $ymd_next = substr($dat['ymd'],0,10);
    // echo $ymd.'<br>';
    // echo $ymd_next.'<br>';
    // exit;
}

// if db_id exists.
if($db_id) {
    $search1 = " WHERE xry_idx = '".$db_id."' ";
}
// 한달씩
else if($ym) {
    // $search1 = " WHERE EVENT_TIME LIKE '".$ym."' ";
    $search1 = " WHERE start_time >= '".$ym."-01 00:00:00' AND start_time <= '".$ym."-31 23:59:59' ";     
}
// 하루씩
else if($ymd) {
    // $search1 = " WHERE EVENT_TIME LIKE '".$ymd."%' ";
    $search1 = " WHERE start_time >= '".$ymd." 00:00:00' AND start_time <= '".$ymd." 23:59:59' ";     
    // $search1 = " WHERE CAMP_NO IN ('C0175987','C0175987') ";    // 특정레코드
}
else {
    // 데이터의 마지막 일시 ------
    $sql = " SELECT start_time FROM {$table2} ORDER BY xry_idx DESC LIMIT 1 ";
    $dat = sql_fetch($sql,1);
    $ymdhis = $dat['start_time'];

    $search1 = " WHERE start_time > '".$ymdhis."' AND END_TIME != '' ";
    $latest = 1;
}


$sql = "SELECT *
        FROM {$table2}
        {$search1}
        ORDER BY start_time DESC
";
// echo $sql.'<br>';
// exit;
$result = sql_query_pg($sql,1);
?>

<span style='font-size:9pt;'>
	<p><?=($ym)?$ym:$ymd?> 추적시작 ...<p><font color=crimson><b>[끝]</b></font> 이라는 단어가 나오기 전에는 중간에 중지하지 마세요.<p>
</span>
<span id="cont"></span>


<?php
include_once ('./_tail.sub.php');

// 추적 최대 날짜
$set_parameter_max_day = $g5['setting']['set_parameter_max_day'] ? $g5['setting']['set_parameter_max_day'] : 30;

// 등급합계
$set_ok_sum = $g5['setting']['set_ok_sum'] ? $g5['setting']['set_ok_sum'] : 18;

// 양품 그룹핑 수
$set_parameter_group_count = $g5['setting']['set_parameter_group_count'] ? $g5['setting']['set_parameter_group_count'] : 100;
$set_parameter_idx = (int)$set_parameter_group_count/2; // 가장 가운데 있는 값

// 레드존(7, 10, 11 포인트): 무조건 1등급이어야 OK
// 옐로우존(1,2,3,4,5,6,8,14,15,16,17,18 포인트): 1,2등급이면 OK
// 그린존(9,12,13 포인트): 1,2,3등급이면 OK


flush();
ob_flush();
ob_end_flush();

$xry_list = array();
$cnt=$oks=0;
// 정보 입력
for ($i=0; $row=sql_fetch_array_pg($result); $i++) {
	$cnt++;
    // print_r2($row);
    if($demo) {
        if($i >= 10) {break;}
    }

    // table2 변수 추출 $arr
    for($j=0;$j<sizeof($fields2);$j++) {
        // echo $fields2[$j].'<br>';
        // 공백제거 & 따옴표 처리
        $arr[$fields2[$j]] = addslashes(trim($row[$fields2[$j]]));
        // 천단위 제거
        if(preg_match("/_price$/",$fields2[$j]))
            $arr[$fields2[$j]] = preg_replace("/,/","",$arr[$fields2[$j]]);
    }
    // print_r2($arr);

    // table2 입력을 위한 변수배열 일괄 생성 ---------
    // 변수 설정
    for($j=1;$j<19;$j++) {
        $position_sum[$i] += $arr['position_'.$j];
        $positions[$i] .= $arr['position_'.$j].' ';
    }

    // 각 등급의 합계가 18이상이면 reset 후 다시 처음부터 카운팅
    echo $position_sum[$i] .'<'. ($set_ok_sum-1) .'||'. $position_sum[$i] .'>='. $set_ok_sum.'<br>';
    if( $position_sum[$i] < ($set_ok_sum-1) || $position_sum[$i] >= $set_ok_sum ) {
        $oks = 0;
        $xry_list = array();
        echo "<script> document.all.cont.innerHTML += '".$cnt."번째에서 등급미달 (".$arr['production_id'].", ".$arr['qrcode'].")<br>'; </script>\n";
        echo "<script> document.all.cont.innerHTML += '&nbsp;ㄴ&nbsp;".$positions[$i]." -> 추적정보 리셋<br>'; </script>\n";
        sleep(2);   // 2초
        continue;
    }
    $oks++;
    $xry_list[] = $arr['xry_idx'];

    // 기준 그룹핑 숫자 이상이 되면 $xry_list[]배열에서 중간값 확보
    if($oks >= $set_parameter_group_count) {
        $sql = "SELECT * FROM {$table2} WHERE xry_idx = '".$xry_list[$set_parameter_idx]."' ";
        // echo $sql.'<br>';
        $one = sql_fetch_pg($sql,1);
        print_r2($one);
        echo "<script> document.all.cont.innerHTML += '최적 파라메타 추출 성공<br>'; </script>\n";
        echo "<script> document.all.cont.innerHTML += '(".$arr['production_id'].", ".$arr['qrcode'].")<br>'; </script>\n";
        $latest = 1;
    }


    echo "<script> document.all.cont.innerHTML += ' . '; </script>\n";

    flush();
    @ob_flush();
    @ob_end_flush();
    usleep($sleepsec);

	// 보기 쉽게 묶음 단위로 구분 (단락으로 구분해서 보임)
	if ($cnt % $countgap == 0)
		echo "<script> document.all.cont.innerHTML += '<br>'; </script>\n";

	// 화면 정리! 부하를 줄임 (화면 싹 지움)
	if ($cnt % $maxscreen == 0)
		echo "<script> document.all.cont.innerHTML = ''; </script>\n";

}

// Terminate in case of db_id found.
if($db_id) {
?>
    <script>
    	document.all.cont.innerHTML += "<br><br>총 <?php echo number_format($cnt) ?>건 완료<br><font color=crimson><b>[끝]</b></font>";
    </script>
    <?php
}
// 월간 처리
else {
    if($ym_next > date("Y-m", G5_SERVER_TIME - 86400*$set_parameter_max_day) 
        || $ymd_next > date("Y-m-d", G5_SERVER_TIME - 86400*$set_parameter_max_day)
        || $demo || $latest) {
        echo $ym_next.'<br>';
        echo $ymd_next.'<br>';
        echo $demo.'<br>';
        echo $laest.'<br>';
    ?>
    <script>
        document.all.cont.innerHTML += "<br><br><?=($ym)?$ym:$ymd?> 완료<br><font color=crimson><b>[끝]</b></font>";
    </script>
    <?php
    }
    // 다음 페이지가 있는 경우는 3초 후 이동
    else {
    ?>
    <script>
        document.all.cont.innerHTML += "<br><br><?=($ym)?$ym:$ymd?> 완료 <br><font color=crimson><b>5초후</b></font> 다음 페이지로 이동합니다.";
        setTimeout(function(){
            self.location='?ym=<?=$ym_next?>&ymd=<?=$ymd_next?>';
        },5000);
    </script>
    <?php
    }
}
?>

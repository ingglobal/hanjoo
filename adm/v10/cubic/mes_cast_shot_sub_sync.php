<?php
$sub_menu = "960150";
include_once('./_common.php');

$demo = 0;  // 데모모드 = 1

$g5['title'] = '캠페인 동기화';
include_once('./_head.sub.php');
include_once('./_head.cubic.php');

//-- 화면 표시
$countgap = ($demo||$db_id) ? 10 : 20;    // 몇건씩 보낼지 설정
$maxscreen = ($demo||$db_id) ? 30 : 100;  // 몇건씩 화면에 보여줄건지?/
$sleepsec = 20;     // 천분의 몇초간 쉴지 설정 (1sec=1000)

$table1 = 'MES_CAST_SHOT_SUB';

$table2 = 'g5_1_mes_cast_shot_sub';
$fields2 = sql_field_names($table2);

// 하루씩 끊어서 입력, Default first YYYY-MM of first record for no $ym
if(!$ymd) {
    $sql = " SELECT EVENT_TIME FROM {$table1} ORDER BY EVENT_TIME LIMIT 1 ";
    $dat = sql_fetch($sql,1);
    // print_r2($dat);
    $ym = substr($dat['EVENT_TIME'],0,7);
}

// 다음날
$sql = " SELECT DATE_ADD('".$ymd."' , INTERVAL +1 DAY) AS ymd FROM dual ";
$dat = sql_fetch($sql,1);
$ymd_next = substr($dat['ymd'],0,10);
// echo $ymd.'<br>';
// echo $ymd_next.'<br>';
// exit;


// if db_id exists.
if($db_id) {
    $search1 = " WHERE SHOT_ID = '".$db_id."' ";
}
// 하루
else {
    $search1 = " WHERE EVENT_TIME >= '".$ymd." 00:00:00' AND EVENT_TIME <= '".$ymd." 23:59:59' ";
    // $search1 = " WHERE CAMP_NO IN ('C0175987','C0175987') ";    // 특정레코드
}

$sql = "SELECT *
        FROM {$table1} AS cam
        {$search1}
        ORDER BY EVENT_TIME
";
// echo $sql.'<br>';
// exit;
$result = $connect_db_pdo->query($sql);
?>

<span style='font-size:9pt;'>
	<p><?=($db_id)?$db_id:$ym?> 입력시작 ...<p><font color=crimson><b>[끝]</b></font> 이라는 단어가 나오기 전에는 중간에 중지하지 마세요.<p>
</span>
<span id="cont"></span>


<?php
include_once ('./_tail.sub.php');


$status_array = array("00"=>"pending"
    ,"01"=>"pending"
    ,"02"=>"ok"
    ,"10"=>"ok"
    ,"20"=>"pending"
);


flush();
ob_flush();
ob_end_flush();

$cnt=0;
// 캠페인 정보 입력
for ($i=0; $row=$result->fetch(PDO::FETCH_ASSOC); $i++) {
	$cnt++;
    // print_r2($row);
    if($demo) {
        if($i >= 2) {break;}
    }

    // table2 변수 추출 $arr
    for($j=0;$j<sizeof($fields2);$j++) {
        // 공백제거 & 따옴표 처리
        $arr[$fields2[$j]] = addslashes(trim($row[strtoupper($fields2[$j])]));
        // 천단위 제거
        if(preg_match("/_price$/",$fields2[$j]))
            $arr[$fields2[$j]] = preg_replace("/,/","",$arr[$fields2[$j]]);
    }

    // table2 입력을 위한 table1 변수 치환
    // $row['EVENT_TIME'] = substr($arr['EVENT_TIME'],0,19);
    // print_r2($arr);

    // table2 입력을 위한 변수배열 일괄 생성 ---------
    // 건너뛸 변수들 설정
    $skips = array('mcs_idx');
    for($j=0;$j<sizeof($fields2);$j++) {
        if(in_array($fields2[$j],$skips)) {continue;}
        $arr[$fields2[$j]] = ($fields21[$fields2[$j]]) ? $arr[$fields21[$fields2[$j]]] : $arr[$fields2[$j]];
        $sql_commons[$i][] = " ".strtolower($fields2[$j])." = '".$arr[$fields2[$j]]."' ";
    }

    // table2 입력을 위한 변수 재선언 (or 생성)
    // $sql_commons[$i][] = " trm_idx_department = '".$mb2['mb_2']."' ";

    // 최종 변수 생성
    $sql_text[$i] = (is_array($sql_commons[$i])) ? implode(",",$sql_commons[$i]) : '';


    // Record update
    $sql3 = "   SELECT mcs_idx FROM {$table2}
                WHERE shot_id = '".$arr['SHOT_ID']."' AND event_time = '".$arr['EVENT_TIME']."'
    ";
    //echo $sql3.'<br>';
    $row3 = sql_fetch($sql3,1);
    // 정보 업데이트
    if($row3['mcs_idx']) {
		$sql = "UPDATE {$table2} SET
					$sql_text[$i]
				WHERE mcs_idx = '".$row3['mcs_idx']."'
		";
		if(!$demo) {sql_query($sql,1);}
	    else {echo $sql.'<br><br>';}
    }
    // 정보 입력
    else{
		$sql = "INSERT INTO {$table2} SET
					$sql_text[$i]
		";
		if(!$demo) {sql_query($sql,1);}
	    else {echo $sql.'<br><br>';}
    }


    echo "<script> document.all.cont.innerHTML += '".$cnt.". ".$arr['shot_id']." (".$arr['event_time'].") 완료<br>'; </script>\n";

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
// 마지막 페이지인 경우는 종료
else {
    if($ymd_next > date("Y-m-d")||$demo) {
    ?>
    <script>
        document.all.cont.innerHTML += "<br><br><?=$ym?> 완료<br><font color=crimson><b>[끝]</b></font>";
    </script>
    <?php
    }
    // 다음 페이지가 있는 경우는 3초 후 이동
    else {
    ?>
    <script>
        document.all.cont.innerHTML += "<br><br><?=$ymd?> 완료 <br><font color=crimson><b>2초후</b></font> 다음 페이지로 이동합니다.";
        setTimeout(function(){
            self.location='?ymd=<?=$ymd_next?>';
        },2000);
    </script>
    <?php
    }
}

include_once ('./_tail.cubic.php');
?>

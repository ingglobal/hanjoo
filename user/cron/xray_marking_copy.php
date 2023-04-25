<?php
// 크론 실행을 위해서는 사용자단에 파일이 존재해야 함
// sudo vi /etc/crontab
// sudo systemctl restart cron
// */2 * * * * * root wget -O - -q -t 1 http://hanjoo.epcs.co.kr/user/cron/xray_marking_copy.php (2분 주기)
// */5 * * * * root wget -O - -q -t 1 http://hanjoo.epcs.co.kr/user/cron/xray_marking_copy.php (5분 주기)
// * * * * * * root wget -O - -q -t 1 http://hanjoo.epcs.co.kr/user/cron/xray_marking_copy.php (1분 주기)
// [root@web-37 user]# wget -O - -q -t 1 http://hanjoo.epcs.co.kr/user/cron/xray_marking_copy.php

include_once('./_common.php');

$demo = 0;  // 데모모드 = 1

$g5['title'] = '마킹정보저장';
include_once('./_head.sub.php');

//-- 화면 표시
$countgap = ($demo||$db_id) ? 10 : 20;    // 몇건씩 보낼지 설정
$maxscreen = ($demo||$db_id) ? 30 : 100;  // 몇건씩 화면에 보여줄건지?/
$sleepsec = 200;     // 천분의 몇초간 쉴지 설정 (1sec=1000)


$table1 = 'g5_1_marking';
$fields1 = sql_field_names($table1);

// 데이터의 마지막 일시 ------
$sql = " SELECT mrk_reg_dt FROM {$table1} ORDER BY mrk_idx DESC LIMIT 1 ";
$mrk = sql_fetch($sql,1);
if($mrk['mrk_reg_dt']) {
    // 설비별 마지막 값 초기화 (이전값과 비교해서 카운팅을 해야 함)
    $sql = " SELECT * FROM g5_5_meta WHERE mta_db_table = 'pgsql/measure' AND mta_key = 'dta_idx_last_marking' ";
    // echo $sql.'<br>';
    // exit;
    $rs = sql_query($sql,1);
    for($i=0;$row=sql_fetch_array($rs);$i++) {
        // print_r2($row);
        $prev[$row['mta_db_id']] = $row['mta_value'];
        if($row['mta_value']) {
            ${'sql_query_'.$row['mta_db_id']} = " AND dta_dt > '".$row['mta_value']."' ORDER BY dta_dt ";
        }
        else {
            ${'sql_query_'.$row['mta_db_id']} = " ORDER BY dta_dt DESC LIMIT 1 ";
        }
    }
    // $sql_query = " AND dta_dt > '".$mrk['mrk_reg_dt']."' ORDER BY dta_dt LIMIT 1000 ";

    // print_r2($prev);
}
else {
    // 각 테이블당 10개씩만
    $sql_query_58 = $sql_query_59 = $sql_query_60 = $sql_query_61 = " ORDER BY dta_dt DESC LIMIT 1 ";
}

$sql = "SELECT * 
        FROM (
          (
              SELECT 58 AS mms_idx, dta_idx, dta_dt, dta_value FROM g5_1_data_measure_58
              WHERE dta_type = 13 AND dta_no = 25 {$sql_query_58}
          )
          UNION ALL
          (
              SELECT 59 AS mms_idx, dta_idx, dta_dt, dta_value FROM g5_1_data_measure_59
              WHERE dta_type = 13 AND dta_no = 25 {$sql_query_59}
          )
          UNION ALL
          (
              SELECT 60 AS mms_idx, dta_idx, dta_dt, dta_value FROM g5_1_data_measure_60
              WHERE dta_type = 13 AND dta_no = 25 {$sql_query_60}
          )
          UNION ALL
          (
              SELECT 61 AS mms_idx, dta_idx, dta_dt, dta_value FROM g5_1_data_measure_61
              WHERE dta_type = 13 AND dta_no = 25 {$sql_query_61}
          )
        ) AS db1
        ORDER BY dta_dt
";
// echo $sql.'<br>';
// exit;
$rs = sql_query_pg($sql,1);
?>

<span style='font-size:9pt;'>
	<p><?=($db_id)?$db_id:$ym?> 입력시작 ...<p><font color=crimson><b>[끝]</b></font> 이라는 단어가 나오기 전에는 중간에 중지하지 마세요.<p>
</span>
<span id="cont"></span>

<?php
include_once ('./_tail.sub.php');


flush();
ob_flush();
ob_end_flush();

$cnt=0;
// 정보 입력
for($i=0;$row=sql_fetch_array_pg($rs);$i++) {
    // print_r2($row);
    // echo $i.'<br>';
	$cnt++;
    if($demo) {
        if($cnt >= 10) {break;}
    }

    // 이전값 디폴트값이 없으면 최초 등록을 위해서 -1값 강제 생성
    $prev[$row['mms_idx']] = $prev[$row['mms_idx']] ?: $row['dta_value']-1;

    // 현재값
    $now[$row['mms_idx']] = $row['dta_value'];
    // print_r2($now);

    // insert from table (이전값과 다른 경우만 입력)
    if($now[$row['mms_idx']] && $prev[$row['mms_idx']] && $now[$row['mms_idx']] != $prev[$row['mms_idx']]) {
        if($demo) {
            echo $now[$row['mms_idx']] .">". $prev[$row['mms_idx']].BR;
        }
        // counter = 현재값 - 이전값
        $row['mrk_count'] = $now[$row['mms_idx']] - $prev[$row['mms_idx']];
        // 30000 이상에서 다시 초기화되는 부분이 있어서 추가
        $row['mrk_count'] = (abs($row['mrk_count'])>10) ? 1 : $row['mrk_count'];

        // 존재 여부 체크
        $sql = " SELECT mrk_idx, mrk_value FROM {$table1} WHERE mms_idx = '".$row['mms_idx']."' ORDER BY mrk_idx DESC LIMIT 1 ";
        // echo $sql.BR;
        $one = sql_fetch($sql,1);
        if($one['mrk_value']!=$now[$row['mms_idx']]) {
            $sql = "INSERT INTO {$table1} SET
                        mms_idx = '".$row['mms_idx']."'
                        , dta_idx = '".$row['dta_idx']."'
                        , mrk_value = '".$row['dta_value']."'
                        , mrk_count = '".$row['mrk_count']."'
                        , mrk_reg_dt = '".$row['dta_dt']."'
            ";
            if(!$demo) {sql_query($sql,1);}
            else {echo $sql.'<br><br>';}
        }
    }

    // 이전값과 비교하기 위해서 배열 저장
    $prev[$row['mms_idx']] = $row['dta_value'];
    // print_r2($prev);

    // 다음 cron 실행 시 쿼리 속도를 위해서 마지막 번호 저장
    $dta_idx[$row['mms_idx']] = $row['dta_dt'];


    echo "<script> document.all.cont.innerHTML += '".$cnt.". ".$row['mms_idx']." (".$row['dta_dt'].") ".$row['dta_value']." 완료<br>'; </script>\n";

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

// meta 에 마지막 번호 저장!
// echo $g5['setting']['set_cast_no_value'];
// print_r2($g5['set_cast_no_value']);
// print_r2($dta_idx);
if(is_array($g5['set_cast_no_value'])) {
    foreach($g5['set_cast_no_value'] as $k1=>$v1) {
        // echo $k1.'/'.$v1.BR;
        if($dta_idx[$v1]) {
            // 메타 정보 입력
            $ar['mta_db_table'] = 'pgsql/measure';
            $ar['mta_db_id'] = $v1;
            $ar['mta_key'] = 'dta_idx_last_marking';
            $ar['mta_value'] = $dta_idx[$v1];
            $ar['mta_title'] = $k1;
            meta_update($ar);
            unset($ar);
        }
    }
}


?>
<script>
	document.all.cont.innerHTML += "<br><br>총 <?php echo number_format($cnt) ?>건 완료<br><font color=crimson><b>[끝]</b></font>";
</script>

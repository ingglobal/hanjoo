<?php
$sub_menu = "960150";
include_once('./_common.php');

$demo = 0;  // 데모모드 = 1

$g5['title'] = '복제';
include_once('./_head.sub.php');

//-- 화면 표시
$countgap = ($demo||$db_id) ? 10 : 20;    // 몇건씩 보낼지 설정
$maxscreen = ($demo||$db_id) ? 30 : 100;  // 몇건씩 화면에 보여줄건지?/
$sleepsec = 200;     // 천분의 몇초간 쉴지 설정 (1sec=1000)



$table1 = 'g5_1_mes_cast_shot_sub';
$fields1 = sql_field_names($table1);

// 하루씩 끊어서 입력, Default first YYYY-MM of first record for no $ym
if(!$ymd) {
    $sql = " SELECT event_time, DATE_ADD(event_time , INTERVAL +7 DAY) AS ymd FROM {$table1} ORDER BY event_time LIMIT 1 ";
    $dat = sql_fetch($sql,1);
    // print_r2($dat);
    $ymd = substr($dat['ymd'],0,10);
}
$st_timestamp = strtotime($ymd);
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
// 캠페인 정보 입력
for ($i=$st_timestamp; $i<time(); $i+=86400) {
	$cnt++;
    // echo $i.'<br>';
    if($demo) {
        if($cnt >= 15) {break;}
    }

    // today & last week date
    $current[$i] = date("Y-m-d",$i); // today
    $last_timestamp[$i] = strtotime($current[$i]." -7 day");
    $last[$i] = date("Y-m-d",$last_timestamp[$i]); // last week date
    // echo $current[$i].'<br>';
    // echo $last[$i].'<br>';

    // Copy from date of one week ago.
	$sql = "INSERT INTO {$table1}(shot_id, event_time, hold_temp, upper_heat,lower_heat,upper_1_temp,upper_2_temp,upper_3_temp,upper_4_temp,upper_5_temp,upper_6_temp,lower_1_temp,lower_2_temp,lower_3_temp)
            SELECT shot_id, CONCAT('".$current[$i]."',' ',SUBSTRING(event_time,12)) AS event_time, hold_temp, upper_heat,lower_heat
                ,upper_1_temp,upper_2_temp,upper_3_temp,upper_4_temp,upper_5_temp,upper_6_temp,lower_1_temp
                ,lower_2_temp,lower_3_temp
            FROM g5_1_mes_cast_shot_sub WHERE event_time LIKE '".$last[$i]."%'
	";
	if(!$demo) {sql_query($sql,1);}
    else {echo $sql.'<br><br>';}

    echo "<script> document.all.cont.innerHTML += '".$cnt.". ".$current[$i]." (from ".$last[$i].") 완료<br>'; </script>\n";

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
?>
<script>
	document.all.cont.innerHTML += "<br><br>총 <?php echo number_format($cnt) ?>건 완료<br><font color=crimson><b>[끝]</b></font>";
</script>

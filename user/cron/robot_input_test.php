<?php
// 크론 실행을 위해서는 사용자단에 파일이 존재해야 함
// sudo vi /etc/crontab
// sudo systemctl restart cron
// 0/1 * * * * root wget -O - -q -t 1 http://hanjoo.epcs.co.kr/user/cron/robot_input_test.php (매초당)
// [root@web-37 user]# wget -O - -q -t 1 http://hanjoo.epcs.co.kr/user/cron/robot_input_test.php
include_once('./_common.php');

$demo = 0;  // 데모모드 = 1

$g5['title'] = '로봇테스트 자료 입력';
include_once('./_head.sub.php');
?>

<span style='font-size:9pt;'>
	<p><?=($ym)?$ym:$ymd?> 입력시작 ...</p>
</span>
<span id="cont"></span>

<?php
include_once ('./_tail.sub.php');

for($i=1;$i<7;$i++) {
    ${'tq1'.$i} = rand(100,200);
    ${'et1'.$i} = rand(10,60);
    ${'tq2'.$i} = rand(100,200);
    ${'et2'.$i} = rand(10,60);
}

// 1번 로봇 입력
$sql = "INSERT INTO g5_1_robot_test (time, robot_no, tq1, tq2, tq3, tq4, tq5, tq6, et1, et2, et3, et4, et5, et6)
        VALUES ('".G5_TIME_YMDHIS."','1','".$tq11."','".$tq12."','".$tq13."','".$tq14."','".$tq15."','".$tq16."','".$et11."','".$et12."','".$et13."','".$et14."','".$et15."','".$et16."')
        RETURNING id
";
// echo $sql.'<br>';
if(!$demo) {sql_query_pg($sql,1);}
else {echo $sql.'<br><br>';}

// 2번 로봇 입력
$sql = "INSERT INTO g5_1_robot_test (time, robot_no, tq1, tq2, tq3, tq4, tq5, tq6, et1, et2, et3, et4, et5, et6)
        VALUES ('".G5_TIME_YMDHIS."','2','".$tq21."','".$tq22."','".$tq23."','".$tq24."','".$tq25."','".$tq26."','".$et21."','".$et22."','".$et23."','".$et24."','".$et25."','".$et26."')
        RETURNING id
";
// echo $sql.'<br>';
if(!$demo) {sql_query_pg($sql,1);}
else {echo $sql.'<br><br>';}

?>
<script>
    document.all.cont.innerHTML += "완료";
</script>

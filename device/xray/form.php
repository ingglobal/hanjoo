<?php
// URL: http://test.hanjoo.epcs.co.kr/device/xray/form.php
include_once('./_common.php');
// 인스타 로그인후 인스타쪽 피드 배열을 받아서 올스타에 업데이트하는 폼을 임시로 구현한 페이지입니다.
// 실제로는 member_log.php가 크롤링 서버에서 정보를 받아서 저장합니다.
// 파일명이 실제로는 member_feed_log.php가 더 적합할 수도..

$grade_arr = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
$grade = $grade_arr[rand(0,sizeof($grade_arr)-1)];
$result = ($grade<6) ? 'OK':'NG';


// $com_idx_array = array(9999,67,66,65,64,10000);
$com_idx_array = array($_SESSION['ss_com_idx']);
$group_array = array('mea','mea');
// get random qrcode aomon the ones in 1 day.
$sql = "SELECT * FROM g5_1_xray_inspection
		WHERE end_time > DATE_ADD(now(), INTERVAL -6 HOUR)
		ORDER BY RAND() LIMIT 1
";
$one = sql_fetch($sql,1);
if($one['qrcode']) {
	$qrcode = $one['qrcode'];
}
else {
	$qrcode_array = array('22I14DRRH00540203','22I14DRRH00610258','22I14DRRH00600257');
	$qrcode = $qrcode_array[rand(0,sizeof($qrcode_array)-1)];
}

$qr_time = get_qr_time($qrcode);
$cast_time = date("Y-m-d H:i:s", strtotime($qr_time)-3600*2);   // 주조코드가 30시간 전에 입력된 걸로 보고 설정
$time_cast = get_time2castcode($cast_time); // ex) 2022-01-31 11:32:00 > 2A31B32


$code = '1L30K45';
echo get_castcode2time($code).'<br>';
$code = '4A03L00';
echo get_castcode2time($code).'<br>';

?>
<style>
    #hd_login_msg {display:none;}
    button {background:#37a7ff;padding:10px 20px;font-size:1.5em;border-radius:4px;}
</style>

<form id="form01" action="./form2.php">

<h1>주조코드 입력</h1>
<ul style="border:solid 5px #ddd;padding:15px 30px;">
	<li>주조코드: 주조기에서 고온레이저로 마킹한 코드입니다. (IGGGlobal)</li>
	<li>QRcode: 탕구절단 공정 근처에서 레이저로 마킹한 코드입니다. (큐빅)</li>
</ul>
Token(암호코드)
<table>
	<tr><td>토큰값</td><td><input type="text" name="token" value="1099de5drf09"></td></tr>
</table>

<hr>
입력 항목
<table>
	<tr><td>QRcode</td><td><input type="text" name="qrcode" value="<?=$qrcode?>"></td></tr>
	<tr><td>주조코드</td><td><input type="text" name="cast_code" value="<?=$time_cast?>"></td></tr>
	<tr><td>등급</td><td><input type="text" name="grade" value="<?=$grade?>"></td></tr>
	<tr><td>판정</td><td><input type="text" name="result" value="<?=$result?>"></td></tr>
</table>

<hr>
<button type="submit">확인</button>
</form>

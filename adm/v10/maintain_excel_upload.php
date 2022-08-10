<?php
$sub_menu = "930120";
include_once('./_common.php');

if( auth_check($auth[$sub_menu],"w",1) ) {
    alert('메뉴 접근 권한이 없습니다.');
}

$demo = 0;  // 데모모드 = 1

// 업데이트 함수
if(!function_exists('func_db_update')){
function func_db_update($arr) {
    global $g5,$demo;

    // 주민등록번호 있으면
    if($arr['mb_jumin']) {
        $arr['mb_jumin'] = get_mb_jumin($arr['mb_jumin'],'set');
    }
    // 상태값
    $arr['mb_status'] = 'ing';
    if(in_array($arr['mb_next_visit_date'],array("완료"))) {
        $arr['mb_status'] = 'ok';
    }
    if(in_array($arr['mb_next_visit_date'],array("종료","x","중도포기"))) {
        $arr['mb_status'] = 'quit';
    }

    // VIP 정보 입력
    $sql_common = " com_idx = '".$arr['com_idx']."'
                    , mb_id = '".$arr['mb_id']."'
                    , mb_id_saler = '".$arr['mb_id_saler']."'
                    , mb_name_saler = '".$arr['mb_name_saler']."'
                    , mb_id_manager = 'jaoo1008_'
                    , mb_id_camera = '21sts'
                    , ct_id = '".$od['ct_id']."'
                    , vip_price = '".preg_replace("/,/","",$arr['mb_price'])."'
                    , vip_type = '".$arr['mb_type']."'
                    , vip_name = '".$arr['mb_name']."'
                    , vip_jumin = '".$arr['mb_jumin']."'
                    , vip_hp = '".$arr['mb_hp']."'
                    , vip_email = '".$arr['mb_email']."'
                    , vip_height = '".$arr['mb_height']."'
                    , vip_weight = '".$arr['mb_weight']."'
                    , vip_obesity = '".$arr['mb_obesity']."'
                    , vip_fixture_size = '".$arr['mb_fixture_size']."'
                    , vip_shoes = '".$arr['mb_shoes']."'
                    , vip_foot_size = '".$arr['mb_foot_size']."'
                    , vip_agree_dt = '".$arr['mb_agree_date']." 09:00:00'
                    , vip_memo = '".$arr['mb_memo']."'
                    , vip_status = '".$arr['mb_status']."'
    ";
    $sql = "SELECT *
            FROM {$g5['maintain_table']}
            WHERE mb_id = '".$arr['mb_id']."'
                AND SUBSTRING(vip_agree_dt,1,10) = '".$arr['mb_agree_date']."'
                AND mb_name_saler = '".$arr['mb_name_saler']."'
    ";
    $row = sql_fetch($sql,1);
    // 삭제 우선 처리
    if($arr['mb_status']=='삭제') {
        if($row['vip_idx']) {
            $sql = "DELETE FROM {$g5['maintain_table']} WHERE vip_idx = '".$row['vip_idx']."' ";
            if(!$demo) {sql_query($sql,1);}
            else {print_r3($sql);}
        }
    }
    else {
        // 없으면 등록
        if(!$row['vip_idx']) {
            $sql = " INSERT INTO {$g5['maintain_table']} SET
                        {$sql_common}
                        , vip_reg_dt = '".G5_TIME_YMDHIS."'
            ";
            if(!$demo) {sql_query($sql,1);}
            $row['vip_idx'] = sql_insert_id();
        }
        // 있으면 수정
        else {
            $sql = "UPDATE {$g5['maintain_table']} SET
                        {$sql_common}
                        , vip_update_dt = '".G5_TIME_YMDHIS."'
                    WHERE vip_idx = '".$row['vip_idx']."'
            ";
            if(!$demo) {sql_query($sql,1);}
        }
        if($demo) {print_r3($sql);}
        // print_r3($sql);

    }
 
    return $row['vip_idx'];
}
}

require_once G5_LIB_PATH.'/PhpSpreadsheet/vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$upload_file_name = $_FILES['file_excel']['name'];
$file_type= pathinfo($upload_file_name, PATHINFO_EXTENSION);
if ($file_type =='xls') {
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();	
}
elseif ($file_type =='xlsx') {
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
}
else {
	echo '처리할 수 있는 엑셀 파일이 아닙니다';
	exit;
}

$upload_file=$_FILES['file_excel']['tmp_name'];
// $reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load($upload_file);	
$sheetCount = $spreadsheet->getSheetCount();
for ($i = 0; $i < $sheetCount; $i++) {
    $sheet = $spreadsheet->getSheet($i);
    $sheetData = $sheet->toArray(null, true, true, true);
    // echo $i.' ------------- <br>';
    // print_r2($sheetData);
    $allData[$i] = $sheetData;
}
// print_r3($allData[0]);
// echo sizeof($allData);
// exit;




$g5['title'] = '엑셀 업로드';
//include_once('./_top_menu_applicant.php');
include_once('./_head.php');
//echo $g5['container_sub_title'];
?>
<div class="" style="padding:10px;">
	<span>
		작업 시작~~ <font color=crimson><b>[끝]</b></font> 이라는 단어가 나오기 전 중간에 중지하지 마세요.
	</span><br><br>
	<span id="cont"></span>
</div>
<?php
include_once ('./_tail.php');
?>

<?php
$countgap = 10; // 몇건씩 보낼지 설정
$sleepsec = 200;  // 백만분의 몇초간 쉴지 설정
$maxscreen = 200; // 몇건씩 화면에 보여줄건지?

flush();
ob_flush();

// print_r3($allData);
$idx = 0;
$mb_id_arr = array();

// 첫번째 시트
for($i=0;$i<=sizeof($allData[0]);$i++) {
    // print_r3($allData[0][$i]);
	if($demo) {
        if($i>4) {break;}
    }

    // 초기화
    unset($arr);
    unset($list);
    // 한 라인씩 $list 숫자 배열로 변경!!
    if(is_array($allData[0][$i])) {
        foreach($allData[0][$i] as $k1=>$v1) {
            // print_r3($k1.'='.$v1);
            $list[] = trim($v1);
        }
    }
    // print_r3($list);
    $arr['machine_no'] = $list[0];
    $arr['machine_name'] = $list[1];
    $arr['mnt_date'] = $list[2];
    $arr['mnt_reason'] = $list[3];    // 사유
    $arr['mnt_content'] = $list[4];
    $arr['mnt_part'] = $list[5];
    $arr['mnt_name'] = $list[6];
    $arr['mnt_start_dt'] = $list[7];
    $arr['mnt_end_dt'] = $list[8];
    $arr['mnt_minutes'] = $list[9];
    $arr['mnt_company'] = $list[10];
    // print_r3($arr);

    // 조건에 맞는 해당 라인만 추출
    if( preg_match("/[-0-9A-Z]/",$arr['machine_no'])
        && preg_match("/[가-힝]/",$arr['machine_name'])
        && preg_match("/[-0-9]/",$arr['mnt_date']) )
    {
        // print_r3($arr);

        // 데이터 입력&수정&삭제
        $db_idx = func_db_update($arr);

        $idx++;
    }
    else {continue;}


    // 메시지 보임
    if($arr['mb_name']) {
        echo "<script> document.all.cont.innerHTML += '".$idx
                .". ".$arr['mb_name']." [".$arr['mb_name_saler']."]: ".$arr['mb_hp']
                ." ----------->> 완료<br>'; </script>\n";
    }


    flush();
    ob_flush();
    ob_end_flush();
    usleep($sleepsec);
    
    // 보기 쉽게 묶음 단위로 구분 (단락으로 구분해서 보임)
    if ($i % $countgap == 0)
        echo "<script> document.all.cont.innerHTML += '<br>'; </script>\n";
    
    // 화면 정리! 부하를 줄임 (화면 싹 지움)
    if ($i % $maxscreen == 0)
        echo "<script> document.all.cont.innerHTML = ''; </script>\n";

}
// 두번째 시트
for($i=0;$i<=sizeof($allData[1]);$i++) {
    // print_r3($allData[1][$i]);
}
//................





// 관리자 디버깅 메시지
if( is_array($g5['debug_msg']) ) {
    for($i=0;$i<sizeof($g5['debug_msg']);$i++) {
        echo '<div class="debug_msg">'.$g5['debug_msg'][$i].'</div>';
    }
?>
    <script>
    $(function(){
        $("#container").prepend( $('.debug_msg') );
    });
    </script>
<?php
}
?>


<script>
	document.all.cont.innerHTML += "<br><br>총 <?php echo number_format($idx) ?>건 완료<br><br><font color=crimson><b>[끝]</b></font>";
</script>
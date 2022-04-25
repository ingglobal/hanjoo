<?php
$sub_menu = "950100";
include_once('./_common.php');

if( auth_check($auth[$sub_menu],"w",1) ) {
    alert('메뉴 접근 권한이 없습니다.');
}

$demo = 0;  // 데모모드 = 1

// 업데이트 함수
if(!function_exists('func_db_update')){
function func_db_update($arr) {
    global $g5,$demo;
    
    // 성별
    $arr['apc_gender_key'] = array_search($arr['apc_gender'],$g5['set_mb_gender_value']);
    // 희망직종
    $arr['apc_category_idx'] = array_search($arr['apc_category'],$g5['category_name']);
    // 재직상태
    $arr['apc_work_status_key'] = array_search($arr['apc_work_status'],$g5['set_work_status_value']);

    $sql_common = " apc_name = '".addslashes($arr['apc_name'])."'
                    , apc_birth = '".$arr['apc_birth']."'
                    , apc_email = '".$arr['apc_email']."'
                    , apc_addr1 = '".$arr['apc_addr1']."'
                    , apc_hp = '".$arr['apc_hp']."'
                    , trm_idx_category = '".$arr['apc_category_idx']."'
    ";
    
    
    $sql = "SELECT *
            FROM {$g5['applicant_table']}
            WHERE apc_name = '".$arr['apc_name']."'
                AND apc_hp = '".$arr['apc_hp']."'
                AND trm_idx_category = '".$arr['apc_category_idx']."'
    ";
    $row = sql_fetch($sql,1);
    // 삭제 우선 처리
    if($arr['apc_status']=='삭제') {
        if($row['apc_idx']) {
            $sql = "DELETE FROM {$g5['applicant_table']} WHERE apc_idx = '".$row['apc_idx']."' ";
            if(!$demo) {sql_query($sql,1);}
            else {print_r3($sql);}
        }
    }
    else {
        // 없으면 등록
        if(!$row['apc_idx']) {
            $sql = " INSERT INTO {$g5['applicant_table']} SET
                        {$sql_common}
                        , apc_status = 'ok'
                        , apc_reg_dt = '".G5_TIME_YMDHIS."'
            ";
            if(!$demo) {sql_query($sql,1);}
            $row['apc_idx'] = sql_insert_id();
        }
        // 있으면 수정
        else {
            $sql = "UPDATE {$g5['applicant_table']} SET
                        {$sql_common}
                        , apc_update_dt = '".G5_TIME_YMDHIS."'
                    WHERE apc_idx = '".$row['apc_idx']."'
            ";
            if(!$demo) {sql_query($sql,1);}
        }
        if($demo) {print_r3($sql);}
        // print_r3($sql);
    }
 
    return $row['apc_idx'];
}
}


// ref: https://github.com/PHPOffice/PHPExcel
require_once G5_LIB_PATH."/PHPExcel-1.8/Classes/PHPExcel.php"; // PHPExcel.php을 불러옴.
$objPHPExcel = new PHPExcel();
require_once G5_LIB_PATH."/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php"; // IOFactory.php을 불러옴.
$filename = $_FILES['file_excel']['tmp_name'];
PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
$filename = iconv("UTF-8", "EUC-KR", $filename);
try {
    // 업로드한 PHP 파일을 읽어온다.
	$objPHPExcel = PHPExcel_IOFactory::load($filename);
	$sheetsCount = $objPHPExcel -> getSheetCount();

	// 시트Sheet별로 읽기
    $allData = array();
	for($i = 0; $i < $sheetsCount; $i++) {

        if($demo) {
            if($i>4) {break;}
        }
        $objPHPExcel -> setActiveSheetIndex($i);
        $sheet = $objPHPExcel -> getActiveSheet();
        $highestRow = $sheet -> getHighestRow();          // 마지막 행
        $highestColumn = $sheet -> getHighestColumn();    // 마지막 컬럼
        
        // 한줄씩 읽기
        for($row = 1; $row <= $highestRow; $row++) {
            // $rowData가 한줄의 데이터를 셀별로 배열처리 된다.
            $rowData = $sheet -> rangeToArray("A" . $row . ":" . $highestColumn . $row, NULL, TRUE, FALSE);
            // $rowData에 들어가는 값은 계속 초기화 되기때문에 값을 담을 새로운 배열을 선언하고 담는다.

//            print_r3( date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1])) );
            $rowData[0][6] = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1]));    // 1968.7.13 날짜 표현이 이상하게 되어서 재선언
//            print_r3($rowData[0]);

            $allData[$i][$row] = $rowData[0];
        }
	}
} catch(exception $e) {
	echo $e;
}
// print_r3($allData);
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
$sleepsec = 20000;  // 백만분의 몇초간 쉴지 설정
$maxscreen = 50; // 몇건씩 화면에 보여줄건지?

flush();
ob_flush();

// print_r3($allData);
$idx = 0;
for($i=0;$i<=sizeof($allData[0]);$i++) {
    // print_r3($allData[0][$i]);

	if($demo) {
        if($i>4) {break;}
    }

    // 초기화
    unset($arr);

    // 조건에 맞는 해당 라인만 추출
    if( preg_match("/[가-힝]/",$allData[0][$i][0])
            && preg_match("/[-0-9]/",$allData[0][$i][5]) ) {
//        print_r3($allData[0][$i]);
        $arr['apc_name'] = $allData[0][$i][0];
        $arr['apc_addr1'] = $allData[0][$i][2];
        $arr['apc_category'] = trim($allData[0][$i][3]);
        $arr['apc_email'] = $allData[0][$i][4];
        $arr['apc_hp'] = $allData[0][$i][5];
        $arr['apc_birth'] = $allData[0][$i][6];
        $idx++;
    }
    else
        continue;
//    print_r3($arr);
    
    
    // 데이터 입력&수정&삭제
    $db_idx = func_db_update($arr);

    

    // 메시지 보임
    if($arr['apc_name']) {
        echo "<script> document.all.cont.innerHTML += '".$idx
                .". ".$arr['apc_name']."(".$arr['apc_birth']."): ".$arr['apc_hp']
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
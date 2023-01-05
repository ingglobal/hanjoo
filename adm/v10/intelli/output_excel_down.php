<?php
$sub_menu = "920130";
include_once('./_common.php');

if($member['mb_level']<4) {
    alert('메뉴에 접근 권한이 없습니다.');
}

function column_char($i) { return chr( 65 + $i ); }

// 변수 설정, 필드 구조 및 prefix 추출
$table_name = 'xray_inspection';
$g5_table_name = $g5[$table_name.'_table'];
$fields = sql_field_names($g5_table_name);
$pre = substr($fields[0],0,strpos($fields[0],'_'));
$fname = preg_replace("/_list/","",$g5['file_name']); // _list을 제외한 파일명
//$qstr .= '&mms_idx='.$mms_idx; // 추가로 확장해서 넘겨야 할 변수들


$sql_common = " FROM {$g5_table_name} AS ".$pre." "; 

$where = array();
$where[] = " 1=1 ";   // 디폴트 검색조건

if ($stx) {
    switch ($sfl) {
		case ( $sfl == $pre.'_id' || $sfl == $pre.'_idx' ) :
            $where[] = " ({$sfl} = '{$stx}') ";
            break;
		case ($sfl == $pre.'_hp') :
            $where[] = " ({$sfl} LIKE '%{$stx}%') ";
            break;
       default :
            $where[] = " {$sfl} = '{$stx}' ";
            break;
    }
}

// 기간 검색
if ($st_date) {
    if ($st_time) {
        $where[] = " start_time >= '".$st_date.' '.$st_time."' ";
    }
    else {
        $where[] = " start_time >= '".$st_date.' 00:00:00'."' ";
    }
}
else {
    $where[] = " start_time >= '".date("Y-m-01 00:00:00",G5_SERVER_TIME)."' ";
}
if ($en_date) {
    if ($en_time) {
        $where[] = " start_time <= '".$en_date.' '.$en_time."' ";
    }
    else {
        $where[] = " start_time <= '".$en_date.' 23:59:59'."' ";
    }
}

// 최종 WHERE 생성
if ($where)
    $sql_search = ' WHERE '.implode(' AND ', $where);


if (!$sst) {
    $sst = "start_time";
    $sod = "DESC";
}
$sql_order = " ORDER BY {$sst} {$sod} ";

if(sizeof($where)<=1) {
    $sql = " SELECT row_estimate AS cnt FROM hypertable_approximate_row_count('g5_1_xray_inspection') ";
}
else {
    $sql = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
}
$row = sql_fetch_pg($sql,1);
$total_count = $row['cnt'];
if (!$total_count)
    alert("출력할 내역이 없습니다.");

$sql = "SELECT *
        {$sql_common} {$sql_search} {$sql_order}
";
// echo $sql.'<br>';
// exit;
$result = sql_query_pg($sql,1);


// 각 항목 설정
$headers = array('Idx','작업일','주야간','시작','종료','QRCode','주조코드','주조기','주조시각','생산품ID','설비ID','설비번호','품질','결과');
$widths  = array(10,      10,    10,    20,   20,      20,      10,    10,     15,      10,     10,      10,   30,    5);
$header_bgcolor = 'FFABCDEF';
$last_char = column_char(count($headers) - 1);

// 엑셀 데이타 출력
include_once(G5_LIB_PATH.'/PHPExcel.php');


// 두번째 줄부터 실제 데이터 입력
for ($i=0; $row=sql_fetch_array_pg($result); $i++) {
    // 주조코드
    $sql2 = " SELECT * FROM g5_1_qr_cast_code WHERE qrcode = '".$row['qrcode']."' ";
    // echo $sql2.'<br>';
    $row['cast'] = sql_fetch($sql2,1);
    // print_r3($row['cast']);
    // 주조시각
    $row['cast']['event_time_yn'] = (preg_match("/^[0-9][A-Z][0-9]{2}[A-Z][0-9]{2}$/",$row['cast']['cast_code'])) ? 1 : 0;
    $row['cast']['event_dt'] = $row['cast']['event_time_yn'] ? substr($row['cast']['event_time'],5,11) : '';
    $row['cast']['mms_no'] = $row['cast']['event_time_yn'] ? substr($row['cast']['cast_code'],0,1) : 1;
    $row['cast']['cast_code'] = $row['cast']['event_time_yn'] ? $row['cast']['cast_code'] : '';
    $row['cast']['mms_name'] = $row['cast']['event_time_yn'] ? $g5['mms'][$g5['set_cast_code_no_value'][$row['cast']['mms_no']]]['mms_name'] : '';

    // 검사포인트
    for($j=1;$j<19;$j++) {
        $row['points'] .= $row['position_'.$j].' ';
    }

    $rows[] = array($row['xry_idx']
                  , $row['work_date']
                  , $row['work_shift']
                  , substr($row['start_time'],0,19)
                  , substr($row['end_time'],0,19)
                  , $row['qrcode']
                  , $row['cast']['cast_code']
                  , $row['cast']['mms_name']
                  , $row['cast']['event_dt']
                  , $row['production_id']
                  , $row['machine_id']
                  , $row['machine_no']
                  , $row['points']
                  , $row['result']
              );
}
// print_r2($headers);
// print_r2($widths);
// print_r2($rows);
// exit;


$data = array_merge(array($headers), $rows);

$excel = new PHPExcel();
$excel->setActiveSheetIndex(0)->getStyle( "A1:${last_char}1" )->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($header_bgcolor);
$excel->setActiveSheetIndex(0)->getStyle( "A:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
foreach($widths as $i => $w) $excel->setActiveSheetIndex(0)->getColumnDimension( column_char($i) )->setWidth($w);
$excel->getActiveSheet()->fromArray($data,NULL,'A1');

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"xray-".date("ymdHi", time()).".xls\"");
header("Cache-Control: max-age=0");

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
$writer->save('php://output');

?>
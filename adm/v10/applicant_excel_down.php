<?php
$sub_menu = "950100";
include_once('./_common.php');

if(auth_check($auth[$sub_menu],"d",1)) {
    alert('메뉴에 접근 권한이 없습니다.');
}

function column_char($i) { return chr( 65 + $i ); }

// 변수 설정, 필드 구조 및 prefix 추출
$table_name = 'applicant';
$g5_table_name = $g5[$table_name.'_table'];
$fields = sql_field_names($g5_table_name);
$pre = substr($fields[0],0,strpos($fields[0],'_'));


$sql_common = " FROM {$g5_table_name} AS ".$pre."
					LEFT JOIN {$g5['recruit_table']} AS rct ON rct.rct_idx = apc.rct_idx
";
// $sql_common = " FROM {$g5_table_name} AS ".$pre;

$where = array();
//$where[] = " (1) ";   // 디폴트 검색조건
$where[] = " ".$pre."_status NOT IN ('delete', 'trash') ";

if ($stx) {
    switch ($sfl) {
		case ( $sfl == $pre.'_id' || $sfl == $pre.'_idx' ) :
            $where[] = " ({$sfl} = '{$stx}') ";
            break;
		case ($sfl == $pre.'_hp') :
            $where[] = " REGEXP_REPLACE(mb_hp,'-','') LIKE '".preg_replace("/-/","",$stx)."' ";
            break;
        default :
            $where[] = " ({$sfl} LIKE '%{$stx}%') ";
            break;
    }
}

// 업직종
if(is_array($ser_category)) {
	foreach($ser_category as $k1=>$v1) {
        $cat_idx[] = $v1;
	}
    $where[] = " trm_idx_category IN (".implode(",",$cat_idx).") ";
}

// 지역
if(is_array($ser_area)) {
	foreach($ser_area as $k1=>$v1) {
//        echo $k1.'/'.$v1.'<br>';
        $sql1 = " SELECT apc_idx FROM {$g5['applicant_table']} WHERE apc_addr1 LIKE '%".$v1."%' ";
//        echo $sql1.'<br>';
        $rs1 = sql_query($sql1,1);
        for($k=0;$row1=sql_fetch_array($rs1);$k++) {
            $addr_apc_idx[] = $row1['apc_idx'];            
        }
	}
//    print_r2(array_unique($addr_apc_idx));
    if($addr_apc_idx[0])
        $where[] = " apc_idx IN (".implode(",",array_unique($addr_apc_idx)).") ";
    else
        $where[] = " (0) ";
}


// 경력
if ($ser_st_apc_work_year) {
    $where[] = " apc_work_year >= '".$ser_st_apc_work_year."' ";
}
if ($ser_en_apc_work_year) {
    $where[] = " apc_work_year <= '".$ser_en_apc_work_year."' ";
}

// 나이
if ($ser_st_age) {
    $sql1 = " SELECT YEAR( DATE_ADD(now() , INTERVAL -".($ser_st_age-1)." YEAR)) AS year ";
    $syear = sql_fetch($sql1,1);
//    print_r2($syear);
    if($syear['year'])
        $where[] = " apc_birth <= '".$syear['year']."-12-31' ";
}
if ($ser_en_age) {
    $sql1 = " SELECT YEAR( DATE_ADD(now() , INTERVAL -".($ser_en_age-1)." YEAR)) AS year ";
    $eyear = sql_fetch($sql1,1);
//    print_r2($eyear);
    if($eyear['year'])
        $where[] = " apc_birth >= '".$eyear['year']."-01-01' ";
}

// 남여
if ($ser_gender) {
    if(in_array($ser_gender,array('M','F')))
        $where[] = " apc_gender = '".$ser_gender."' ";
}

// 연봉
if($ser_st_pay) {
    $sql1 = "   SELECT apc_idx FROM {$g5['career_table']} WHERE crr_pay >= '".$ser_st_pay."' ";
//     echo $sql1.'<br>';
    $rs1 = sql_query($sql1,1);
    for($k=0;$row1=sql_fetch_array($rs1);$k++) {
        $st_pay_apc_idx[] = $row1['apc_idx'];            
    }
//    print_r2(array_unique($st_pay_apc_idx));
    if($st_pay_apc_idx[0])
        $where[] = " apc_idx IN (".implode(",",array_unique($st_pay_apc_idx)).") ";
    else
        $where[] = " (0) ";
}
if($ser_en_pay) {
    $sql1 = "   SELECT apc_idx FROM {$g5['career_table']} WHERE crr_pay <= '".$ser_en_pay."' ";
//     echo $sql1.'<br>';
    $rs1 = sql_query($sql1,1);
    for($k=0;$row1=sql_fetch_array($rs1);$k++) {
        $en_pay_apc_idx[] = $row1['apc_idx'];            
    }
//    print_r2(array_unique($en_pay_apc_idx));
    if($en_pay_apc_idx[0])
        $where[] =  " apc_idx IN (".implode(",",array_unique($en_pay_apc_idx)).") ";
    else
        $where[] = " (0) ";
}


// 학력
if(is_array($ser_school_type)) {
	foreach($ser_school_type as $k1=>$v1) {
        // 고등학교인경우
        if($v1=='highschool') {
            $sql_shl_type1 = " AND shl_type1 = '".$v1."' ";
        }
        // 대학교인 경우는 shl_type2 까지 고려해야 함
        else {
            $sql_shl_type1 = " AND shl_type1 = 'university' ";
            $sql_shl_type2 = " AND shl_type2 = '".$v1."' ";            
        }
        
        $sql1 = "   SELECT apc_idx FROM {$g5['school_table']}
                    WHERE shl_yearmonth != ''
                        AND shl_title != ''
                        {$sql_shl_type1}
                        {$sql_shl_type2}
        ";
//         echo $sql1.'<br>';
        $rs1 = sql_query($sql1,1);
        for($k=0;$row1=sql_fetch_array($rs1);$k++) {
            $sch_apc_idx[] = $row1['apc_idx'];            
        }
	}
//    print_r2(array_unique($sch_apc_idx));
    if($sch_apc_idx[0])
        $where[] = " apc_idx IN (".implode(",",array_unique($sch_apc_idx)).") ";
    else
        $where[] = " (0) ";
}

// 장애 (yes, no인 경우만)
if($ser_disability) {
    if(in_array($ser_disability,array('yes','no'))) {
        $sql1 = "   SELECT apc_idx FROM {$g5['additional_table']} WHERE add_type = 'disability' AND add_value = '".$ser_disability."' ";
        $rs1 = sql_query($sql1,1);
        for($k=0;$row1=sql_fetch_array($rs1);$k++) {
            $disability_apc_idx[] = $row1['apc_idx'];            
        }
    //    print_r2(array_unique($disability_apc_idx));
        if($disability_apc_idx[0])
            $where[] = " apc_idx IN (".implode(",",array_unique($disability_apc_idx)).") ";
    }
}

// 어학능력
if($ser_score) {
    $sql1 = "   SELECT apc_idx FROM {$g5['school_table']}
                WHERE shl_type1 = 'language'
                    AND shl_type2 = '".$lang_type2."'
                    AND shl_type2 = '".$lang_type2."'
                    AND shl_score >= '".$ser_score."'
    ";
//     echo $sql1.'<br>';
    $rs1 = sql_query($sql1,1);
    for($k=0;$row1=sql_fetch_array($rs1);$k++) {
        $lang_apc_idx[] = $row1['apc_idx'];            
    }
//    print_r2(array_unique($lang_apc_idx));
    if($lang_apc_idx[0])
        $where[] = " apc_idx IN (".implode(",",array_unique($lang_apc_idx)).") ";
    else
        $where[] = " (0) ";
}

// 자격/교육
if($ser_certificate) {
    $sql1 = "   SELECT apc_idx FROM {$g5['school_table']}
                WHERE shl_type1 = 'certificate'
                    AND shl_title LIKE '%".$ser_certificate."%'
    ";
//     echo $sql1.'<br>';
    $rs1 = sql_query($sql1,1);
    for($k=0;$row1=sql_fetch_array($rs1);$k++) {
        $certificate_apc_idx[] = $row1['apc_idx'];            
    }
//    print_r2(array_unique($certificate_apc_idx));
    if($certificate_apc_idx[0])
        $where[] = " apc_idx IN (".implode(",",array_unique($certificate_apc_idx)).") ";
    else
        $where[] = " (0) ";
}

// 재직상태
if($ser_work_status) {
    $where[] = " apc_work_status = '".$ser_work_status."' ";
}

// 관리상태
if($ser_apc_status) {
    $where[] = " apc_status = '".$ser_apc_status."' ";
}


// 채용공고
if ($ser_rct_idx) {
	$where[] = " apc.rct_idx = '".$ser_rct_idx."' ";
}

// 담당자
if ($ser_mb_id) {
	$where[] = " mb_id = '".$ser_mb_id."' ";
}

// 최종 WHERE 생성
if ($where)
    $sql_search = ' WHERE '.implode(' AND ', $where);


if (!$sst) {
    $sst = $pre."_idx";
    $sod = "ASC";
}
$sql_order = " ORDER BY {$sst} {$sod} ";


$sql = " SELECT *
		{$sql_common}
		{$sql_search}
        {$sql_order}
";
//echo $sql;
$result = sql_query($sql,1);

// 전체 게시물 수
$sql = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
if (!$total_count)
    alert("출력할 내역이 없습니다.");


// 각 항목 설정
$headers = array('이름','성별','이메일','생년월일','전화','휴대폰','우편번호','주소1','주소2','경력연수','희망직종','재직상태','관리상태','등록일','채용공고');
$widths  = array(10,   7,   30,     15,     15,   15,     10,      20,     20,   10,     20,      10,       20,    60);
$header_bgcolor = 'FFABCDEF';
$last_char = column_char(count($headers) - 1);

// 엑셀 데이타 출력
include_once(G5_LIB_PATH.'/PHPExcel.php');


// 두번째 줄부터 실제 데이터 입력
for($i=1; $row=sql_fetch_array($result); $i++) {
    // 우편번호
    $row['apc_zip'] = $row['apc_zip1'].$row['apc_zip2'];
    // 성별
    $row['apc_gender_text'] = $g5['set_mb_gender_value'][$row['apc_gender']];
    // 희망직종
    $row['apc_category_text'] = $g5['category_name'][$row['trm_idx_category']];
    // 재직상태
    $row['apc_work_status_text'] = $g5['set_work_status_value'][$row['apc_work_status']];
    // 상태
    $row['apc_status_text'] = $g5['set_apc_status_value'][$row['apc_status']];
    
    $rows[] = array($row['apc_name']
                  , $row['apc_gender_text']
                  , $row['apc_email']
                  , $row['apc_birth']
                  , $row['apc_tel']
                  , $row['apc_hp']
                  , $row['apc_zip']
                  , $row['apc_addr1']
                  , $row['apc_addr2']
                  , $row['apc_work_year']
                  , $row['apc_category_text']
                  , $row['apc_work_status_text']
                  , $row['apc_status_text']
                  , $row['apc_reg_dt']
                  , $row['rct_subject']
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
header("Content-Disposition: attachment; filename=\"applicant-".date("ymdHi", time()).".xls\"");
header("Cache-Control: max-age=0");

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
$writer->save('php://output');

?>
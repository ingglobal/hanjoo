<?php
$sub_menu = "950100";
include_once('./_common.php');

auth_check($auth[$sub_menu],'w');

// 변수 설정, 필드 구조 및 prefix 추출
$table_name = 'applicant';
$g5_table_name = $g5[$table_name.'_table'];
$fields = sql_field_names($g5_table_name);
$pre = substr($fields[0],0,strpos($fields[0],'_'));
$fname = preg_replace("/_form/","",$g5['file_name']); // _form을 제외한 파일명
$qstr .= '&st_date='.$st_date.'&en_date='.$en_date; // 추가로 확장해서 넘겨야 할 변수들

$g5['title'] = '지원자정보 보기';
include_once ('./_head.sub.php');

${$pre} = get_table_meta($table_name, $pre.'_idx', ${$pre."_idx"});
$rct = get_table_meta('recruit', 'rct_idx', ${$pre}['rct_idx']);
//print_r2($rct);

if (!${$pre}[$pre.'_idx'])
    alert('존재하지 않는 자료입니다.');

// 희망직종
//print_r3($g5['category_up_idxs'][$apc['trm_idx_category']]);
$apc['cats'] = explode(',', preg_replace("/\s+/", "", $g5['category_up_idxs'][$apc['trm_idx_category']]));
//    print_r3($apc['cats']);
$apc['apc_category1'] = $apc['cats'][0] ?: '';
$apc['apc_category2'] = $apc['cats'][1] ?: '';

// 관련 파일 추출
$sql = "SELECT * FROM {$g5['file_table']} 
        WHERE fle_db_table = '".$table_name."' AND fle_db_id = '".${$pre.'_idx'}."' ORDER BY fle_sort, fle_reg_dt DESC ";
$rs = sql_query($sql,1);
//echo $sql;
for($i=0;$row=sql_fetch_array($rs);$i++) {
//    echo $row['fle_name_orig'].'<br>';
    ${$pre}[$row['fle_type']][$row['fle_sort']]['file'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
        '<span>&nbsp;&nbsp;'.$row['fle_name_orig'].'&nbsp;&nbsp;</span><a href="../..'.$row['fle_path'].'/'.$row['fle_name_orig'].'" download>파일다운로드</a>'
        .'&nbsp;&nbsp;<input type="checkbox" name="'.$row['fle_type'].'_del['.$row['fle_sort'].']" value="1"> <span>삭제</span>'
        :'';
    ${$pre}[$row['fle_type']][$row['fle_sort']]['down'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
        '<a href="../..'.$row['fle_path'].'/'.$row['fle_name_orig'].'" download>파일다운로드</a>'
        :'';
    ${$pre}[$row['fle_type']][$row['fle_sort']]['name'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
        $row['fle_name_orig'] : '' ;
    ${$pre}[$row['fle_type']][$row['fle_sort']]['fle_name'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
        $row['fle_name'] : '' ;
    ${$pre}[$row['fle_type']][$row['fle_sort']]['fle_path'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
        $row['fle_path'] : '' ;
    ${$pre}[$row['fle_type']][$row['fle_sort']]['exists'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
        1 : 0 ;
}
//print_r2($apc['applicant_attach']);
//exit;


// 대표이미지
$fle_type3 = "applicant_list";
if(${$pre}[$fle_type3][0]['fle_name']) {
    ${$pre}[$fle_type3][0]['thumbnail'] = thumbnail(${$pre}[$fle_type3][0]['fle_name'], 
                    G5_PATH.${$pre}[$fle_type3][0]['fle_path'], G5_PATH.${$pre}[$fle_type3][0]['fle_path'],
                    120, 120, 
                    false, true, 'center', true, $um_value='85/3.4/15'
    );	// is_create, is_crop, crop_mode
    ${$pre}[$fle_type3][0]['thumbnail_img'] = '<img src="'.G5_URL.${$pre}[$fle_type3][0]['fle_path'].'/'.${$pre}[$fle_type3][0]['thumbnail'].'">';
    // 원본으로 출력하기로 변경
    ${$pre}[$fle_type3][0]['thumbnail_img'] = '<img src="'.G5_URL.${$pre}[$fle_type3][0]['fle_path'].'/'.${$pre}[$fle_type3][0]['fle_name'].'" style="height:120px;">';
}
else {
    ${$pre}[$fle_type3][0]['thumbnail'] = 'default.png';
    ${$pre}[$fle_type3][0]['fle_path'] = '/data/'.$fle_type3;
    ${$pre}[$fle_type3][0]['thumbnail_img'] = '<img src="'.G5_URL.${$pre}[$fle_type3][0]['fle_path'].'/'.${$pre}[$fle_type3][0]['thumbnail'].'">';
}
//print_r2($apc);

// 학력/자격/교육/어학
$sql = " SELECT * FROM {$g5['school_table']} WHERE apc_idx = '".${$pre."_idx"}."' ORDER BY shl_idx ";
$rs = sql_query($sql,1);
//echo $sql.'<br>';
for($x=0;$row=sql_fetch_array($rs);$x++) {
//       print_r2($row);
    $row['shl_yearmonth_arr'] = explode("-",$row['shl_yearmonth']);
    $row['shl_year'] = $row['shl_yearmonth_arr'][0];
    $row['shl_month'] = $row['shl_yearmonth_arr'][1];
    unset($row['shl_yearmonth_arr']);
    $shl[$row['shl_type1']][] = $row;
}
//print_r2($shl);
// 학력 대표 내용
if($shl['university'][0]['shl_title']) {
    $shl['university'][0]['shl_type2_text'] = ($shl['university'][0]['shl_type2']) ?
                                            ' '.$g5['set_school_type_value'][$shl['university'][0]['shl_type2']]
                                            : '';
    $apc['shl_last_record'] = $shl['university'][0]['shl_type2_text'].' '.$g5['set_shl_graduate_type_value'][$shl['university'][0]['shl_graduate_type']];
}
else if($shl['highschool'][0]['shl_title']) {
    $apc['shl_last_record'] = '고등학교 '.$g5['set_shl_graduate_type_value'][$shl['highschool'][0]['shl_graduate_type']];
}

// 자격/교육/어학
if($shl['certificate'][0]['shl_title']) {
    $apc['shl_etc_record'][] = $shl['certificate'][0]['shl_title'].' ..';
}
if($shl['language'][0]['shl_content']) {
    $apc['shl_etc_record'][] = $g5['set_exam_'.$shl['language'][0]['shl_type2'].'_value'][$shl['language'][0]['shl_content']].' '.$shl['language'][0]['shl_score'].' ..';
}


// 추가사항
$sql = " SELECT * FROM {$g5['additional_table']} WHERE apc_idx = '".${$pre."_idx"}."' ORDER BY add_idx ";
$rs = sql_query($sql,1);
//    echo $sql.'<br>';
for($x=0;$row=sql_fetch_array($rs);$x++) {
//       print_r2($row);
    $row['add_start_ym_arr'] = explode("-",$row['add_start_ym']);
    $row['add_start_year'] = $row['add_start_ym_arr'][0];
    $row['add_start_month'] = $row['add_start_ym_arr'][1];
    $row['add_end_ym_arr'] = explode("-",$row['add_end_ym']);
    $row['add_end_year'] = $row['add_end_ym_arr'][0];
    $row['add_end_month'] = $row['add_end_ym_arr'][1];
    unset($row['add_start_ym_arr']);
    unset($row['add_end_ym_arr']);
    $add[$row['add_type']][] = $row;
}
//print_r3($add);
        
    
// 경력
$sql = " SELECT * FROM {$g5['career_table']} WHERE apc_idx = '".${$pre."_idx"}."' ORDER BY crr_idx ";
$rs = sql_query($sql,1);
//    echo $sql.'<br>';
for($x=0;$row=sql_fetch_array($rs);$x++) {
//       print_r2($row);
    $row['crr_start_ym_arr'] = explode("-",$row['crr_start_ym']);
    $row['crr_start_year'] = $row['crr_start_ym_arr'][0];
    $row['crr_start_month'] = $row['crr_start_ym_arr'][1];
    $row['crr_end_ym_arr'] = explode("-",$row['crr_end_ym']);
    $row['crr_end_year'] = $row['crr_end_ym_arr'][0];
    $row['crr_end_month'] = $row['crr_end_ym_arr'][1];
    unset($row['crr_start_ym_arr']);
    unset($row['crr_end_ym_arr']);
    $row['cats'] = explode(',', preg_replace("/\s+/", "", $g5['category_up_idxs'][$row['trm_idx_category']]));
    $row['crr_category1'] = $row['cats'][0] ?: '';
    $row['crr_category2'] = $row['cats'][1] ?: '';
    unset($row['cats']);
    $crr[] = $row;
    
    // 경력 연수 계산
    if($row['crr_end_ym']!='-' && $row['crr_start_ym']!='-' && $row['crr_end_ym']>=$row['crr_start_ym']) {
        $sql = " SELECT TIMESTAMPDIFF(MONTH, '".$row['crr_start_ym']."-01', '".$row['crr_end_ym']."-01') AS m ";
//        echo $sql.'<br>';
        $ym = sql_fetch($sql,1);
//        echo ($ym['m']+1).'개월<br>';
        $mtotal += ($ym['m']+1);
    }
}
// 경력 연수 계산
$y = sprintf('%d', $mtotal/12);
$m = $mtotal%12;
$work_year = round($mtotal/12,2);
//echo $mtotal.' 총개월<br>';
//echo $y.'년<br>';
//echo $m.'개월<br>';
//echo $work_year.'<br>';
$crr_total = $mtotal ? $y.'년 '.$m.'개월' : '';





// Include the main TCPDF library (search for installation path).
require_once('./tcpdf_include.php');

class MYPDF extends TCPDF {

    // Page footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont(PDF_FONT_NAME_MAIN, ' ', 8);
        $this->SetFooterMargin(15);

        $this->Cell(0, 0, 'www.dreampeople.kr' , 0, false, 'L');
        // Page number
        $this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, true, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('James');
$pdf->SetTitle($apc['apc_name'].' 이력서');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, contract, document, guide');

// remove default header/footer
$pdf->setPrintHeader(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-20);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(G5_PLUGIN_PATH.'/tcpdf/examples/lang/eng.php')) {
	require_once(G5_PLUGIN_PATH.'/tcpdf/examples/lang/eng.php');
	$pdf->setLanguageArray($l);
}

$space10 = '<img src="'.G5_THEME_IMG_URL.'/dot.png" style="width:10px;">';
$space30 = '<img src="'.G5_THEME_IMG_URL.'/dot.png" style="width:30px;">';
$space50 = '<img src="'.G5_THEME_IMG_URL.'/dot.png" style="width:50px;">';
$space100 = '<img src="'.G5_THEME_IMG_URL.'/dot.png" style="width:100px;">';
// ---------------------------------------------------------

// add a page
$pdf->AddPage();


// 생년월일 있는 경우만 표현
if($apc['apc_birth']) {
    $apc['apc_birth_text'] = '<span>'.substr($apc['apc_birth'],0,4).'년</span>';
}
// 나이
if($apc['apc_birth']) {
    $apc['apc_age'] = '<span>'.((substr(G5_TIME_YMD,0,4) - substr($apc['apc_birth'],0,4))+1).'세</span>';
}
// 성별
if($apc['apc_gender']) {
    $apc['apc_gender_text'] = '<span>'.$g5['set_mb_gender_value'][$apc['apc_gender']].'</span>';
}
// 재직상태
if($apc['apc_work_status']) {
    $apc['apc_work_status_text'] = '<span>'.$g5['set_work_status_value'][$apc['apc_work_status']].'</span>';
}


$div_style1 = 'style="line-height:10px;vertical-align:middle;"';

// 휴대폰
if($apc['apc_hp']) {
//    $apc['apc_hp_text'] = '<div '.$div_style1.'><img src="'.G5_THEME_IMG_URL.'/v10/icon_phone.png"> '.$apc['apc_hp'].'</div>';
    $apc['apc_hp_text'] = '<tr>
                                <td style="width:35px;text-align:center;"><img src="'.G5_THEME_IMG_URL.'/v10/icon_phone.png"></td>
                                <td style="width:60%;line-height:17px;">'.$apc['apc_hp'].'</td>
                            </tr>';
}
// 이메일
if($apc['apc_email']) {
//    $apc['apc_email_text'] = '<div '.$div_style1.'>'.$apc['apc_email'].'</div>';
    $apc['apc_email_text'] = '<tr>
                                <td style="width:35px;text-align:center;"><img src="'.G5_THEME_IMG_URL.'/v10/icon_envelope.png"></td>
                                <td style="width:60%;line-height:17px;">'.$apc['apc_email'].'</td>
                            </tr>';
}
// 전화번호
if($apc['apc_tel']) {
    $apc['apc_tel_text'] = '<div '.$div_style1.'>'.$apc['apc_tel'].'</div>';
}
// 주소
if($apc['apc_addr1']) {
    $apc['apc_zip'] = $apc['apc_zip1'].$apc['apc_zip2'];
//    $apc['apc_addr_text'] = '<div '.$div_style1.'>'.$apc['apc_zip'].' '.$apc['apc_addr1'].' '.$apc['apc_addr2'].'</div>';
    $apc['apc_addr_text'] = '<tr>
                                <td style="width:35px;text-align:center;"><img src="'.G5_THEME_IMG_URL.'/v10/icon_user.png"></td>
                                <td style="width:400px;line-height:17px;">'.$apc['apc_zip'].' '.$apc['apc_addr1'].' '.$apc['apc_addr2'].'</td>
                            </tr>';
}

// 로고이미지
$logo_image = '<img src="'.G5_THEME_IMG_URL.'/logo.png">';

// HTML content
$html = '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td style="width:50%;font-size:2.5em;font-weight:bold;line-height:70px;">입사지원서</td>
    <td style="width:50%;text-align:right;">'.$logo_image.'</td>
</tr>
<tr><td colspan="3" style="background-color:#444;line-height:-35px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png"></td></tr>
<tr><td colspan="3" style="background-color:#fff;line-height:-15px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png"></td></tr>
</table>
';

$html .= '
<table boarder="0" cellpadding="5" cellspacing="1" style="background-color:#fff;width:100%;">
<tr>
    <td style="height:120px;width:120px;">'.$apc['applicant_list'][0]['thumbnail_img'].'</td>
    <td>
        <table boarder="0" cellpadding="0" cellspacing="0" style="">
        <tr>
            <td style="font-size:1.5em;font-weight:bold;line-height:40px;">
                '.$apc['apc_name'].'
                '.$apc['apc_birth_text'].'
                '.$apc['apc_age'].'
                '.$apc['apc_gender_text'].'
            </td>
        </tr>
        </table>
        <table boarder="0" cellpadding="0" cellspacing="1" style="width:100%;">
            '.$apc['apc_hp_text'].'
            '.$apc['apc_email_text'].'
            '.$apc['apc_addr_text'].'
        </table>
    </td>
</tr>
</table>
';

// 기본 요약 정보
$html .= '
<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;text-align:center;border:solid 1px #aaa;">
<tr>
    <td style="width:25%;background-color:#fff;">
        <strong style="line-height:10px;">최종학력</strong>
        <p>'.$apc['shl_last_record'].'</p>
    </td>
    <td style="width:25%;background-color:#fff;">
        <strong>총 경력</strong>
        <p>'.$crr_total.'</p>
    </td>
    <td style="width:25%;background-color:#fff;">
        <strong>희망 업직종</strong>
        <p>'.$g5['category_up_names'][$apc['trm_idx_category']].'</p>
    </td>
    <td style="width:25%;background-color:#fff;">
        <strong>자격/교육/어학</strong>
        <p>'.implode("<br>",$apc['shl_etc_record']).'</p>
    </td>
</tr>
</table>
<br><br><br>
';


// 학력 ----------------------
$idx = 0;
// 고등학교
for($j=0;$j<sizeof($shl['highschool']);$j++) {
//    print_r2($shl['highschool'][$j]);
    // 없으면 건너뜀
    if(!$shl['highschool'][$j]['shl_title']) {continue;}
    $idx++;
    $school .= '<tr>
                <td style="background-color:#fff;">'.$shl['highschool'][$j]['shl_yearmonth'].'</td>
                <td style="background-color:#fff;">'.$g5['set_shl_graduate_type_value'][$shl['highschool'][$j]['shl_graduate_type']].'</td>
                <td style="background-color:#fff;">'.$shl['highschool'][$j]['shl_title'].'</td>
                <td style="background-color:#fff;">'.$shl['highschool'][$j]['shl_content'].'</td>
            </tr>
    ';
}
// 대학교
for($j=0;$j<sizeof($shl['university']);$j++) {
//                    print_r2($shl['university'][$j]);
    // 없으면 건너뜀
    if(!$shl['university'][$j]['shl_title']) {continue;}
    $idx++;
    // 대학교구분 표현은 2가지 경우에서만 표현함:  대학(2.3)학년 or 대학원
    $shl['university'][$j]['shl_type2_text'] = ($shl['university'][$j]['shl_type2'] && $shl['university'][$j]['shl_type2']!='university') ? 
                                            ' ('.$g5['set_school_type_value'][$shl['university'][$j]['shl_type2']].')'
                                            : '';

    $school .= '<tr>
                <td style="background-color:#fff;">'.$shl['university'][$j]['shl_yearmonth'].'</td>
                <td style="background-color:#fff;">'.$g5['set_shl_graduate_type_value'][$shl['university'][$j]['shl_graduate_type']].'</td>
                <td style="background-color:#fff;">'.$shl['university'][$j]['shl_title'].'</td>
                <td style="background-color:#fff;">'.$shl['university'][$j]['shl_content'].$shl['university'][$j]['shl_type2_text'].'</td>
            </tr>
    ';
}
if($idx==0) {
    $school = '  <tr><td colspan="4" style="background-color:#fff;">정보가 없습니다.</td></tr>';
}

$html .= '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td><span style="font-size:xx-large;font-weight:bold;">학력</span>&nbsp;&nbsp; 최종학력: '.$apc['shl_last_record'].'</td>
</tr>
<tr><td style="background-color:#aaa;line-height:-44px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png" style="width:1px;height:1px;"></td></tr>
</table>

<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="width:15%;font-weight:bold;">졸업년월</td>
    <td style="width:15%;font-weight:bold;">구분</td>
    <td style="width:30%;font-weight:bold;">학교명</td>
    <td style="width:40%;font-weight:bold;">전공</td>
</tr>
'.$school.'
</table>
<br><br><br>
';


// 경력 --------------------------
$idx = 0;
for($j=0;$j<sizeof($crr);$j++) {
//                    print_r2($crr[$j]);
    // 없으면 건너뜀
    if(!$crr[$j]['crr_company']) {continue;}
    $idx++;

    // 업종/직종
    $crr[$j]['job_category'] = $g5['category_up_names'][$crr[$j]['trm_idx_category']];

    $career .= '<tr>
                <td rowspan="2"  style="background-color:#fff;">'.$crr[$j]['crr_start_ym'].'~'.$crr[$j]['crr_end_ym'].'</td>
                <td style="background-color:#fff;">'.$crr[$j]['crr_company'].'</td>
                <td style="background-color:#fff;">'.$crr[$j]['job_category'].'</td>
                <td style="background-color:#fff;">'.$crr[$j]['crr_pay'].'만원</td>
            </tr>                    
            <tr>
                <td colspan="3" style="background-color:#fff;">
                    <span style="font-weight:bold">담당업무:</span>
                    '.$crr[$j]['crr_job'].'
                    <br>
                    <span style="font-weight:bold">퇴사사유:</span>
                    '.$crr[$j]['crr_quit_why'].'
                </td>
            </tr>                    
    ';
}
if($idx==0) {
    $career = '  <tr><td colspan="4" style="background-color:#fff;">정보가 없습니다.</td></tr>';
}

$html .= '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td><span style="font-size:xx-large;font-weight:bold;">경력</span>&nbsp;&nbsp; 총: '.$crr_total.'</td>
</tr>
<tr><td style="background-color:#aaa;line-height:-44px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png" style="width:1px;height:1px;"></td></tr>
</table>

<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="width:20%;font-weight:bold;">근무기간</td>
    <td style="width:30%;font-weight:bold;">회사명</td>
    <td style="width:30%;font-weight:bold;">업종/직종</td>
    <td style="width:20%;font-weight:bold;">연봉</td>
</tr>
'.$career.'
</table>
<br><br><br>
';

// 추가사항 --------------------------
if($add['disability'][0]['add_value']) {
    $apc['apc_disability'] = $g5['set_additional_disability_value'][$add['disability'][0]['add_value']];    
}
if($add['patriot'][0]['add_value']) {
    $apc['apc_patriot'] = $g5['set_additional_patriot_value'][$add['disability'][0]['add_value']];
}
if($add['military'][0]['add_value']) {
    $apc['apc_military'] = $g5['set_additional_military_value'][$add['military'][0]['add_value']];
}
if($add['militaryterm'][0]['add_start_ym']>'0000-00-00') {
    $apc['militaryterm'] = $add['militaryterm'][0]['add_start_ym'].'~'.$add['militaryterm'][0]['add_end_ym'];
}

$html .= '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td><span style="font-size:xx-large;font-weight:bold;">추가사항</span></td>
</tr>
<tr><td style="background-color:#aaa;line-height:-44px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png" style="width:1px;height:1px;"></td></tr>
</table>

<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="width:20%;font-weight:bold;">장애여부</td>
    <td style="width:30%;font-weight:bold;">보훈대상</td>
    <td style="width:30%;font-weight:bold;">병역사항</td>
    <td style="width:20%;font-weight:bold;">군 복무기간</td>
</tr>
<tr>
    <td style="background-color:#fff;">'.$apc['apc_disability'].'</td>
    <td style="background-color:#fff;">'.$apc['apc_patriot'].'</td>
    <td style="background-color:#fff;">'.$apc['apc_military'].'</td>
    <td style="background-color:#fff;">'.$apc['militaryterm'].'</td>
</tr>                    
</table>
<br><br><br>
';


// 자격및교육 --------------------------
$idx = 0;
for($j=0;$j<sizeof($shl['certificate']);$j++) {
//                    print_r2($shl['certificate'][$j]);
    // 없으면 건너뜀
    if(!$shl['certificate'][$j]['shl_title']) {continue;}
    $idx++;

    $certificate .= '<tr>
                <td style="background-color:#fff;">'.$shl['certificate'][$j]['shl_yearmonth'].'</td>
                <td style="background-color:#fff;">'.$shl['certificate'][$j]['shl_title'].'</td>
            </tr>
    ';
}
if($idx==0) {
    $certificate = '  <tr><td colspan="2" style="background-color:#fff;">정보가 없습니다.</td></tr>';
}

$html .= '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td><span style="font-size:xx-large;font-weight:bold;">자격및교육</span></td>
</tr>
<tr><td style="background-color:#aaa;line-height:-44px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png" style="width:1px;height:1px;"></td></tr>
</table>

<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="width:20%;font-weight:bold;">취득/수료일</td>
    <td style="width:80%;font-weight:bold;">자격교육내용</td>
</tr>
'.$certificate.'
</table>
<br><br><br>
';


// 어학능력 --------------------------
$idx = 0;
for($j=0;$j<sizeof($shl['language']);$j++) {
//                    print_r2($shl['language'][$j]);
    // 없으면 건너뜀
    if(!$shl['language'][$j]['shl_content']) {continue;}
    $idx++;

    $language .= '<tr>
                <td style="background-color:#fff;">'.$shl['language'][$j]['shl_yearmonth'].'</td>
                <td style="background-color:#fff;">'.$g5['set_language_value'][$shl['language'][$j]['shl_type2']].'</td>
                <td style="background-color:#fff;">'.$g5['set_exam_'.$shl['language'][$j]['shl_type2'].'_value'][$shl['language'][$j]['shl_content']].'</td>
                <td style="background-color:#fff;">'.$shl['language'][$j]['shl_score'].'</td>
            </tr>                    
    ';
}
if($idx==0) {
    $language = '  <tr><td colspan="4" style="background-color:#fff;">정보가 없습니다.</td></tr>';
}

$html .= '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td><span style="font-size:xx-large;font-weight:bold;">어학능력</span></td>
</tr>
<tr><td style="background-color:#aaa;line-height:-44px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png" style="width:1px;height:1px;"></td></tr>
</table>

<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="width:15%;font-weight:bold;">취득일</td>
    <td style="width:35%;font-weight:bold;">언어</td>
    <td style="width:35%;font-weight:bold;">시험명</td>
    <td style="width:15%;font-weight:bold;">점수</td>
</tr>
'.$language.'
</table>
<br><br><br>
';


// 첨부문서 --------------------------
$idx = 0;
for($j=0;$j<3;$j++) {
    print_r2($apc['applicant_attach'][$j]);
    // 없으면 건너뜀
    if(!$apc['applicant_attach'][$j]['fle_name']) {continue;}
    $idx++;

    $attach .= '<tr>
                <td style="background-color:#fff;">'.$apc['applicant_attach'][$j]['name'].'</td>
                <td style="background-color:#fff;">다운로드</td>
            </tr>                    
    ';
//    echo $apc['applicant_attach'][$j]['name'];
}
if($idx==0) {
    $attach = '  <tr><td colspan="2" style="background-color:#fff;">정보가 없습니다.</td></tr>';
}
//exit;

$html .= '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td><span style="font-size:xx-large;font-weight:bold;">첨부문서</span></td>
</tr>
<tr><td style="background-color:#aaa;line-height:-44px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png" style="width:1px;height:1px;"></td></tr>
</table>

<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="width:85%;font-weight:bold;">파일명</td>
    <td style="width:15%;font-weight:bold;">다운로드</td>
</tr>
'.$attach.'
</table>
<br><br><br>
';
//exit;


// 자기소개서 --------------------------
$html .= '
<table boarder="0" cellpadding="5" cellspacing="0" style="background-color:#fff;width:100%;">
<tr>
    <td><span style="font-size:xx-large;font-weight:bold;">자기소개서</span></td>
</tr>
<tr><td style="background-color:#aaa;line-height:-44px;"><img src="https://people0702.cafe24.com/theme/v10/img/dot.png" style="width:1px;height:1px;"></td></tr>
</table>

<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="background-color:#fff;">'.conv_content($apc['apc_profile'],2).'</td>
</tr>                    
</table>
<br><br><br>
';

// 경고문장 --------------------------
$html .= '
<table boarder="0" cellpadding="10" cellspacing="1" style="background-color:#ddd;width:100%;">
<tr>
    <td style="background-color:#f2f2f2;text-align:center;">'.conv_content($g5['setting']['set_pdf_warning'],2).'</td>
</tr>                    
</table>
<br><br><br>
<div style="text-align:center;">'.$logo_image.'</div>
<br><br><br>
';



// output the HTML content
$pdf->SetFont('nanumgothic', '', 9);
$pdf->writeHTML($html, true, false, true, false, '');


// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


//Close and output PDF document
ob_end_clean();
//$pdf->Output($apc['apc_name'].'_이력서.pdf', 'I');
//$pdf->Output(G5_DATA_PATH.'/resume/'.$apc['apc_idx'].'.pdf', 'F');
$pdf->Output(G5_DATA_PATH.'/resume/'.$apc['apc_name'].'_이력서.pdf', 'F');   //<<<<<<<<<<<<
//$pdf->Output($apc['apc_name'].'_이력서.pdf','D');
//$pdf->Output(iconv("UTF-8","EUC-KR",'이력서').'.pdf','D');
//$pdf->Output(iconv("UTF-8","EUC-KR",'이력서').'.pdf','I');

//============================================================+
// END OF FILE
//============================================================+

goto_url('../../data/resume/'.$apc['apc_name'].'_이력서.pdf');
?>
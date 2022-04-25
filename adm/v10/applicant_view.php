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
    ${$pre}[$row['fle_type']][$row['fle_sort']]['file'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
        '<span>&nbsp;&nbsp;'.$row['fle_name_orig'].'&nbsp;&nbsp;</span><a href="../..'.$row['fle_path'].'/'.$row['fle_name_orig'].'" download>파일다운로드</a>'
        .'&nbsp;&nbsp;<input type="checkbox" name="'.$row['fle_type'].'_del['.$row['fle_sort'].']" value="1"> <span>삭제</span>'
        :'';
    ${$pre}[$row['fle_type']][$row['fle_sort']]['down'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
		 '<a href="'.G5_USER_ADMIN_URL.'/lib/download.php?file_fullpath='.urlencode(G5_PATH.$row['fle_path'].'/'.$row['fle_name']).'&file_name_orig='.$row['fle_name_orig'].'">파일다운로드</a>'
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
//print_r2(${$pre}['applicant_list']);


// 대표이미지
$fle_type3 = "applicant_list";
if(${$pre}[$fle_type3][0]['fle_name']) {
    ${$pre}[$fle_type3][0]['thumbnail'] = thumbnail(${$pre}[$fle_type3][0]['fle_name'], 
                    G5_PATH.${$pre}[$fle_type3][0]['fle_path'], G5_PATH.${$pre}[$fle_type3][0]['fle_path'],
                    120, 120, 
                    false, false, 'center', true, $um_value='85/3.4/15'
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


// 나이
if($apc['apc_birth']) {
    $apc['apc_age'] = ((substr(G5_TIME_YMD,0,4) - substr($apc['apc_birth'],0,4))+1).'세';
}
// 남여
if($apc['apc_gender']) {
    $apc['apc_gender_text'] = $g5['set_mb_gender_value'][$apc['apc_gender']];
}
// 재직상태
if($apc['apc_work_status']) {
    $apc['apc_work_status_text'] = $g5['set_work_status_value'][$apc['apc_work_status']];
}
// 우편번호
$apc['apc_zip'] = $apc['apc_zip1'].$apc['apc_zip2'];


//print_r2($apc);
?>
<div id="anc_basic" class="tbl_frm01 tbl_wrap">

    <div class="title">입사지원서</div>

    <div class="photo_info">
        <div class="photo">
            <?=${$pre}['applicant_list'][0]['thumbnail_img']?>
        </div>
        <div class="info">
            <div class="name_related">
                <span class="title_name"><?=$apc['apc_name']?></span>
                <span class="title_birth" style="<?=(!$apc['apc_birth'])?'none':''?>;"><?=substr($apc['apc_birth'],0,4)?>년</span>
                <span class="title_age" style="<?=(!$apc['apc_age'])?'none':''?>;"><?=$apc['apc_age']?></span>
                <span class="title_gender" style="<?=(!$apc['apc_gender'])?'none':''?>;"><?=$apc['apc_gender_text']?></span>
            </div>
            <div style="<?=(!$apc['apc_hp'])?'none':''?>;"><img src="<?=G5_THEME_IMG_URL?>/v10/icon_phone.png"> <?=$apc['apc_hp']?></div>
            <div style="<?=(!$apc['apc_email'])?'none':''?>;"><img src="<?=G5_THEME_IMG_URL?>/v10/icon_envelope.png"> <?=$apc['apc_email']?></div>
            <div style="<?=(!$apc['apc_addr1'])?'none':''?>;"><img src="<?=G5_THEME_IMG_URL?>/v10/icon_user.png"> (<?=$apc['apc_zip']?>) <?=$apc['apc_addr1']?> <?=$apc['apc_addr2']?></div>
        </div>
    </div>

    <!-- 요약부분 -->
    <div class="info_brief">
        <ul>
            <li>
                <strong>최종학력</strong>
                <p class="txt"><?=$apc['shl_last_record']?></p>
            </li>
            <li>
                <strong>총 경력</strong>
                <p class="txt"><?=$crr_total?></p>
            </li>
            <li>
                <strong>희망 업직종</strong>
                <p class="txt"><?=$g5['category_up_names'][$apc['trm_idx_category']]?></p>
            </li>
            <li>
                <strong>자격/교육/어학</strong>
                <p class="txt"><?=implode("<br>",$apc['shl_etc_record'])?></p>
            </li>
        </ul>        
    </div>    

    <!-- 학력 -->
    <div class="info_table">
        <div class="div_title">
            학력 <span class="span_shl_last_record">최종학력: <?=$apc['shl_last_record']?></span>
        </div>
        <table class="data_table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:15%;">졸업년월</th>
                    <th style="width:15%;">구분</th>
                    <th style="">학교명</th>
                    <th style="width:">전공</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                print_r2($shl);
                $idx = 0;
                // 고등학교
                for($j=0;$j<sizeof($shl['highschool']);$j++) {
//                    print_r2($shl['highschool'][$j]);
                    // 없으면 건너뜀
                    if(!$shl['highschool'][$j]['shl_title']) {continue;}
                    $idx++;
                    
                    echo '  <tr>
                                <td>'.$shl['highschool'][$j]['shl_yearmonth'].'</td>
                                <td>'.$g5['set_shl_graduate_type_value'][$shl['highschool'][$j]['shl_graduate_type']].'</td>
                                <td>'.$shl['highschool'][$j]['shl_title'].'</td>
                                <td>'.$shl['highschool'][$j]['shl_content'].'</td>
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
                    
                    echo '  <tr>
                                <td>'.$shl['university'][$j]['shl_yearmonth'].'</td>
                                <td>'.$g5['set_shl_graduate_type_value'][$shl['university'][$j]['shl_graduate_type']].'</td>
                                <td>'.$shl['university'][$j]['shl_title'].'</td>
                                <td>'.$shl['university'][$j]['shl_content'].$shl['university'][$j]['shl_type2_text'].'</td>
                            </tr>                    
                    ';
                }
                if($idx==0) {
                    echo '  <tr><td colspan="4">정보가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>    

    <!-- 경력 -->
    <div class="info_table">
        <div class="div_title">
            경력 <span class="span_shl_last_record">총 <?=$crr_total?></span>
        </div>
        <table class="data_table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:20%;">근무기간</th>
                    <th style="width:">회사명</th>
                    <th style="width:25%;">업종/직종</th>
                    <th style="width:20%;">연봉</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                print_r2($crr);
                $idx = 0;
                for($j=0;$j<sizeof($crr);$j++) {
//                    print_r2($crr[$j]);
                    // 없으면 건너뜀
                    if(!$crr[$j]['crr_company']) {continue;}
                    $idx++;
                    
                    // 업종/직종
                    $crr[$j]['job_category'] = $g5['category_up_names'][$crr[$j]['trm_idx_category']];
                        
                    echo '  <tr>
                                <td rowspan="2" class="td_crr_period">'.$crr[$j]['crr_start_ym'].'~'.$crr[$j]['crr_end_ym'].'</td>
                                <td>'.$crr[$j]['crr_company'].'</td>
                                <td>'.$crr[$j]['job_category'].'</td>
                                <td>'.$crr[$j]['crr_pay'].'만원</td>
                            </tr>                    
                            <tr>
                                <td colspan="3" class="job_quit_why">
                                    <span class="span_crr_job">담당업무</span>
                                    '.$crr[$j]['crr_job'].'
                                    <br>
                                    <span class="span_crr_quit_why">퇴사사유</span>
                                    '.$crr[$j]['crr_quit_why'].'
                                </td>
                            </tr>                    
                    ';
                }
                if($idx==0) {
                    echo '  <tr><td colspan="10">정보가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>    

    <!-- 추가사항 -->
    <div class="info_table">
        <div class="div_title">
            추가사항
        </div>
        <table class="data_table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:25%;">장애여부</th>
                    <th style="width:25%;">보훈대상</th>
                    <th style="width:25%;">병역사항</th>
                    <th style="width:25%;">군 복무기간</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=($add['disability'][0]['add_value'])?$g5['set_additional_disability_value'][$add['disability'][0]['add_value']]:''?></td>
                    <td><?=($add['patriot'][0]['add_value'])?$g5['set_additional_patriot_value'][$add['disability'][0]['add_value']]:''?></td>
                    <td><?=($add['military'][0]['add_value'])?$g5['set_additional_military_value'][$add['military'][0]['add_value']]:''?></td>
                    <td><?=($add['militaryterm'][0]['add_start_ym']>'0000-00-00')?$add['militaryterm'][0]['add_start_ym'].'~'.$add['militaryterm'][0]['add_end_ym']:''?></td>
                </tr>                    
            </tbody>
        </table>
    </div>    
    
    
    <!-- 자격및교육 -->
    <div class="info_table">
        <div class="div_title">
            자격및교육
        </div>
        <table class="data_table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:20%;">취득/수료일</th>
                    <th style="width:;">자격교육내용</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                print_r2($shl);
                $idx = 0;
                for($j=0;$j<sizeof($shl['certificate']);$j++) {
//                    print_r2($shl['certificate'][$j]);
                    // 없으면 건너뜀
                    if(!$shl['certificate'][$j]['shl_title']) {continue;}
                    $idx++;
                    
                    echo '  <tr>
                                <td>'.$shl['certificate'][$j]['shl_yearmonth'].'</td>
                                <td>'.$shl['certificate'][$j]['shl_title'].'</td>
                            </tr>                    
                    ';
                }
                if($idx==0) {
                    echo '  <tr><td colspan="10">정보가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- 어학능력 -->
    <div class="info_table">
        <div class="div_title">
            어학능력
        </div>
        <table class="data_table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:15%;">취득일</th>
                    <th style="width:15%;">언어</th>
                    <th style="width:;">시험명</th>
                    <th style="width:15%;">점수</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                print_r2($shl);
                $idx = 0;
                for($j=0;$j<sizeof($shl['language']);$j++) {
//                    print_r2($shl['language'][$j]);
                    // 없으면 건너뜀
                    if(!$shl['language'][$j]['shl_content']) {continue;}
                    $idx++;
                    
                    echo '  <tr>
                                <td>'.$shl['language'][$j]['shl_yearmonth'].'</td>
                                <td>'.$g5['set_language_value'][$shl['language'][$j]['shl_type2']].'</td>
                                <td>'.$g5['set_exam_'.$shl['language'][$j]['shl_type2'].'_value'][$shl['language'][$j]['shl_content']].'</td>
                                <td>'.$shl['language'][$j]['shl_score'].'</td>
                            </tr>                    
                    ';
                }
                if($idx==0) {
                    echo '  <tr><td colspan="10">정보가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- 첨부문서 -->
    <div class="info_table">
        <div class="div_title">
            첨부문서
        </div>
        <table class="data_table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:;">파일명</th>
                    <th style="width:15%;">다운로드</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                print_r2($apc['applicant_attach']);
                $idx = 0;
                for($j=0;$j<3;$j++) {
//                    print_r2($apc['applicant_attach'][$j]);
                    // 없으면 건너뜀
                    if(!$apc['applicant_attach'][$j]['fle_name']) {continue;}
                    $idx++;
                    
                    echo '  <tr>
                                <td>'.$apc['applicant_attach'][$j]['name'].'</td>
                                <td>'.$apc['applicant_attach'][$j]['down'].'</td>
                            </tr>                    
                    ';
                }
                if($idx==0) {
                    echo '  <tr><td colspan="10">정보가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- 자기소개서 -->
    <div class="info_table">
        <div class="div_title">
            자기소개서
        </div>
        <div class="div_profile">
            <?=conv_content($apc['apc_profile'],2)?>
        </div>
    </div>


    <div class="logo_watermark"><img src="<?php echo G5_THEME_IMG_URL; ?>/logo_watermark.png"></div>
</div>





<div class="btn_fixed_top">
    <a href="./applicant_down.php?apc_idx=<?=$apc_idx?>" class="btn btn_submit">다운로드</a>
    <a href="javascript:window.close();" class="btn btn_02">창닫기</a>
</div>

<script>
$(function(e) {

    
});

</script>

<?php
include_once ('./_tail.sub.php');
?>

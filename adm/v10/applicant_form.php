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
//$qstr .= '&st_date='.$st_date.'&en_date='.$en_date; // 추가로 확장해서 넘겨야 할 변수들
// 추가 변수 생성
foreach($_REQUEST as $key => $value ) {
    if(substr($key,0,4)=='ser_') {
    //    print_r3($key.'='.$value);
        if(is_array($value)) {
            foreach($value as $k2 => $v2 ) {
//                print_r3($key.$k2.'='.$v2);
                $qstr .= '&'.$key.'[]='.$v2;
                $form_input .= '<input type="hidden" name="'.$key.'[]" value="'.$v2.'" class="frm_input">'.PHP_EOL;
            }
        }
        else {
            $qstr .= '&'.$key.'='.$value;
            $form_input .= '<input type="hidden" name="'.$key.'" value="'.$value.'" class="frm_input">'.PHP_EOL;
        }
    }    
}

if ($w == '') {
    $sound_only = '<strong class="sound_only">필수</strong>';
    $w_display_none = ';display:none';  // 쓰기에서 숨김
    
    ${$pre}[$pre.'_work_status'] = 'working';
    ${$pre}[$pre.'_status'] = 'ok';
}
else if ($w == 'u') {
    $u_display_none = ';display:none;';  // 수정에서 숨김
	
    ${$pre} = get_table_meta($table_name, $pre.'_idx', ${$pre."_idx"});
    $rct = get_table_meta('recruit', 'rct_idx', ${$pre}['rct_idx']);
//    print_r3($apc);

    if (!${$pre}[$pre.'_idx'])
		alert('존재하지 않는 자료입니다.');
    
    // 희망직종
//    print_r3($g5['category_up_idxs'][$apc['trm_idx_category']]);
	$apc['cats'] = explode(',', preg_replace("/\s+/", "", $g5['category_up_idxs'][$apc['trm_idx_category']]));
//    print_r3($apc['cats']);
    $apc['apc_category1'] = $apc['cats'][0] ?: '';
    $apc['apc_category2'] = $apc['cats'][1] ?: '';

	// 관련 파일 추출
	$sql = "SELECT * FROM {$g5['file_table']} 
			WHERE fle_db_table = '".$table_name."' AND fle_db_id = '".${$pre.'_idx'}."' ORDER BY fle_sort, fle_reg_dt DESC ";
	$rs = sql_query($sql,1);
	// print_r3($sql);
	for($i=0;$row=sql_fetch_array($rs);$i++) {
		${$pre}[$row['fle_type']][$row['fle_sort']]['file'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
//		'<span>&nbsp;&nbsp;'.$row['fle_name_orig'].'&nbsp;&nbsp;</span><a href="../..'.$row['fle_path'].'/'.$row['fle_name_orig'].'" download>파일다운로드</a>'
		 '&nbsp;&nbsp;'.$row['fle_name_orig'].'&nbsp;&nbsp;<a href="'.G5_USER_ADMIN_URL.'/lib/download.php?file_fullpath='.urlencode(G5_PATH.$row['fle_path'].'/'.$row['fle_name']).'&file_name_orig='.$row['fle_name_orig'].'">파일다운로드</a>'
		.'&nbsp;&nbsp;<input type="checkbox" name="'.$row['fle_type'].'_del['.$row['fle_sort'].']" value="1"> <span>삭제</span>'
		:'';
		${$pre}[$row['fle_type']][$row['fle_sort']]['fle_name'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
		$row['fle_name'] : '' ;
		${$pre}[$row['fle_type']][$row['fle_sort']]['fle_path'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
		$row['fle_path'] : '' ;
		${$pre}[$row['fle_type']][$row['fle_sort']]['exists'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
		1 : 0 ;
	}
	
    
	// 대표이미지
	$fle_type3 = "applicant_list";
	if(${$pre}[$fle_type3][0]['fle_name']) {
		${$pre}[$fle_type3][0]['thumbnail'] = thumbnail(${$pre}[$fle_type3][0]['fle_name'], 
						G5_PATH.${$pre}[$fle_type3][0]['fle_path'], G5_PATH.${$pre}[$fle_type3][0]['fle_path'],
						200, 200, 
						false, true, 'center', true, $um_value='85/3.4/15'
		);	// is_create, is_crop, crop_mode
        ${$pre}[$fle_type3][0]['thumbnail_img'] = '<img src="'.G5_URL.${$pre}[$fle_type3][0]['fle_path'].'/'.${$pre}[$fle_type3][0]['thumbnail'].'" width="60" height="60">';
	}
	else {
		${$pre}[$fle_type3][0]['thumbnail'] = 'default.png';
		${$pre}[$fle_type3][0]['fle_path'] = '/data/'.$fle_type3;
	}

    
    // 학력/자격/교육/어학
    $sql = " SELECT * FROM {$g5['school_table']} WHERE apc_idx = '".${$pre."_idx"}."' ORDER BY shl_idx ";
    $rs = sql_query($sql,1);
//    echo $sql.'<br>';
    for($x=0;$row=sql_fetch_array($rs);$x++) {
//       print_r2($row);
        $row['shl_yearmonth_arr'] = explode("-",$row['shl_yearmonth']);
        $row['shl_year'] = $row['shl_yearmonth_arr'][0];
        $row['shl_month'] = $row['shl_yearmonth_arr'][1];
        unset($row['shl_yearmonth_arr']);
        $shl[$row['shl_type1']][] = $row;
    }
//    print_r3($shl);
    
    
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
//    print_r3($add);
        
    
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
    }
//    print_r3($crr);
    
    
    
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');


// 라디오&체크박스 선택상태 자동 설정 (필드명 배열 선언!)
$check_array=array('mb_field');
for ($i=0;$i<sizeof($check_array);$i++) {
	${$check_array[$i].'_'.${$pre}[$check_array[$i]]} = ' checked';
}

$html_title = ($w=='')?'등록':'수정'; 
$g5['title'] = '지원자정보 '.$html_title;
include_once ('./_head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_basic">기본정보</a></li>
    <li><a href="#anc_school">학력정보</a></li>
    <li><a href="#anc_career">경력사항</a></li>
    <li><a href="#anc_additional">추가사항</a></li>
    <li><a href="#anc_certificate">자격및교육</a></li>
    <li><a href="#anc_language">어학능력</a></li>
</ul>';

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js
?>
<style>
.div_mip {color:#818181;}
.mip_price {font-size:0.8em;color:#a9a9a9;margin-left:10px;}
.btn_mip_delete {border:solid 1px #ddd;border-radius:3px;padding:1px 4px;font-size:0.7em;margin-left:10px;}
.div_empty {color:#818181;}
.btn_mip_delete {cursor:pointer;}
.change_alert{color: #e61212;}
.row_chk{float: right;font-weight: normal;}
input.readonly{background-color: #f3f3f3 !important;color: #969696;}
/* 비밀번호 타입 스타일*/
input[type=new-password]{
    -webkit-text-security: disc;
    -webkit-text-security: circle;
    -webkit-text-security: square;
    -webkit-text-security: disc;
}    
</style>

<form name="form01" id="form01" action="./<?=$g5['file_name']?>_update.php" onsubmit="return form01_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="<?=$pre?>_idx" value="<?php echo ${$pre."_idx"} ?>">
<?=$form_input?>


<div class="local_desc01 local_desc" style="display:no ne;">
    <p>모든 항목의 내용을 정확히 입력한 후 [확인]을 클릭하세요.</p>
</div>

    
<div id="anc_basic" class="tbl_frm01 tbl_wrap">
	<h2 class="h2_frm">기본정보</h2>
	<?php echo $pg_anchor ?>
	<table>
		<colgroup>
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
		</colgroup>
		<tbody>
			<tr>
				<th scope="row">채용공고</th>
				<td colspan="3">
                    <?=help('채용공고와 상관없이 지원자 정보만 등록하는 경우는 채용공고를 비워두세요.')?>
					<input type="hidden" name="rct_idx" value="<?=${$pre}['rct_idx']?>" class="frm_input"><!-- 공고idx -->
					<input type="text" name="rct_subject" value="<?=$rct['rct_subject']?>" id="rct_subject" class="frm_input" style="width:50%;" readonly>
					<a href="./recruit_select.php?file_name=<?php echo $g5['file_name']?>" class="btn btn_02 btn_recruit">찾기</a>
				</td>
			</tr>
			<tr>
				<?php
				$ar['id'] = 'apc_name';
				$ar['name'] = '이름';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '70px';
				echo create_td_input($ar);
				unset($ar);
				?>
				<?php
				$ar['id'] = 'apc_email';
				$ar['name'] = '이메일';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '200px';
				echo create_td_input($ar);
				unset($ar);
				?>
			</tr>
			<tr>
				<th scope="row">성별</th>
				<td>
                    <?php
                    if(is_array($g5['set_mb_gender_value'])) {
                        foreach ($g5['set_mb_gender_value'] as $k1=>$v1) {
                            ${$k1.'_checked'} = ($apc['apc_gender']==$k1)?'checked':'';
                            echo '<input type="radio" name="apc_gender" value="'.$k1.'" id="apc_gender_'.$k1.'" '.${$k1.'_checked'}.'>
                                  <label for="apc_gender_'.$k1.'">'.$v1.'</label>'.PHP_EOL;
                        }
                    }                    
                    ?>
				</td>
				<?php
				$ar['id'] = 'apc_birth';
				$ar['name'] = '생년월일';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '80px';
				echo create_td_input($ar);
				unset($ar);
				?>
			</tr>
			<tr>
				<?php
				$ar['id'] = 'apc_tel';
				$ar['name'] = '전화';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '200px';
				echo create_td_input($ar);
				unset($ar);
				?>
				<?php
				$ar['id'] = 'apc_hp';
				$ar['name'] = '휴대폰';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '200px';
				echo create_td_input($ar);
				unset($ar);
				?>
			</tr>
			<tr>
				<th>희망직종</th>
				<td>
					<script>
					<?php
					for($i=0;$i<sizeof($g5['category']);$i++) {
						if($g5['category'][$i]['depth']==0) {
							echo 'var category'.$g5['category'][$i]['term_idx'].' = {};'.PHP_EOL;
							$category_idx[$i] = explode(",",$g5['category'][$i]['down_idxs']);
							$category_name[$i] = explode("^",$g5['category'][$i]['down_names']);
							for($j=1;$j<sizeof($category_idx[$i]);$j++) {
								echo "category".$g5['category'][$i]['term_idx']."['".$category_idx[$i][$j]."'] = '".$category_name[$i][$j]."';".PHP_EOL;
								// 선택된 항목인 경우 select option 생성
								if(${$pre}['apc_category1']==$g5['category'][$i]['term_idx']) {
									$gugun_select .= '<option value="'.$category_idx[$i][$j].'">'.$category_name[$i][$j].'</option>';
								}
							}
						}
						// print_r2($g5['category'][$i]);
					}
					?>
					// $.each(category9, function(i, v){
					// 	console.log(i+':'+v);
					// });
					</script>
					<select id="apc_category1" name="apc_category1" apc_category1="<?=${$pre}['apc_category1']?>" class="required" required>
						<option value="">업종선택</option>
						<?=$category_form_depth0_options?>
					</select> 
					<script>$('select[name="apc_category1"]').val('<?=${$pre}['apc_category1']?>');</script>
					<select id="apc_category2" name="apc_category2" apc_category2="<?=${$pre}['apc_category2']?>" class="required" required>
						<option value="">직종선택</option>
						<?=$gugun_select?>
					</select>
					<script>$('select[name="apc_category2"]').val('<?=${$pre}['trm_idx_category']?>');</script>
					<script>
						$(document).on('change','#apc_category1',function(e){
							// console.log( $(this).val() );
							$("option",'#apc_category2').remove(); // 2차항목 초기화
							$('#apc_category2').append("<option value=''>직종선택</option>");
							var this_category = "category"+$(this).val(); // 선택항목의 2차 Object
							$.each(eval(this_category), function(i, v){
//								 console.log(i+':'+v);
								$('#apc_category2').append("<option value='"+i+"'>"+v+"</option>");
							});
							// 기존값이 있었다면 선택상태로 설정
							if( $(this).val()==$('#apc_category1').attr('apc_category1') && $('#apc_category2').attr('apc_category2')!='' ) {
								$('select[name="apc_category2"]').val( $('#apc_category2').attr('apc_category2') );
							}
						});
					</script>
				</td>
                <th scope="row">재직상태</th>
                <td>
                    <select name="<?=$pre?>_work_status" id="<?=$pre?>_work_status">
                        <option value="">재직상태선택</option>
                        <?=$g5['set_work_status_options']?>
                    </select>
                    <script>$('select[name="<?=$pre?>_work_status"]').val('<?=${$pre}[$pre.'_work_status']?>');</script>
                </td>
			</tr>
            <tr>
                <th scope="row">사진 이미지</th>
                <td>
                    <div style="float:left;margin-right:8px;"><?=${$pre}['applicant_list'][0]['thumbnail_img']?></div>
                    <input type="file" name="applicant_list_file[0]" class="frm_input">
                    <?=${$pre}['applicant_list'][0]['file']?>

                </td>
                <th scope="row">비밀번호</th>
                <td>
					<input type="new-password" name="apc_password" class="frm_input"><!--변경할비밀번호 입력-->
                </td>
            </tr>
			<tr>
				<th scope="row">주소</th>
				<td colspan="3" class="td_addr_line">
					<label for="apc_zip" class="sound_only">우편번호</label>
					<input type="text" name="apc_zip" value="<?php echo ${$pre}['apc_zip1'].${$pre}['apc_zip2']; ?>" id="apc_zip" class="frm_input readonly" size="5" maxlength="6">
					<button type="button" class="btn_frmline" onclick="win_zip('form01', 'apc_zip', 'apc_addr1', 'apc_addr2', 'apc_addr3', 'apc_addr_jibeon');">주소 검색</button><br>
					<input type="text" name="apc_addr1" value="<?php echo ${$pre}['apc_addr1'] ?>" id="apc_addr1" class="frm_input readonly" size="60">
					<label for="apc_addr1">기본주소</label><br>
					<input type="text" name="apc_addr2" value="<?php echo ${$pre}['apc_addr2'] ?>" id="apc_addr2" class="frm_input" size="60">
					<label for="apc_addr2">상세주소</label>
					<br>
					<input type="text" name="apc_addr3" value="<?php echo ${$pre}['apc_addr3'] ?>" id="apc_addr3" class="frm_input" size="60">
					<label for="apc_addr3">참고항목</label>
					<input type="hidden" name="apc_addr_jibeon" value="<?php echo $com['apc_addr_jibeon']; ?>"><br>
				</td>
			</tr>
            <?php
            $ar['id'] = 'apc_profile';
            $ar['name'] = '자기소개';
            $ar['type'] = 'textarea';
            $ar['value'] = ${$pre}[$ar['id']];
            $ar['colspan'] = 3;
            echo create_tr_input($ar);
            unset($ar);
            ?>
            <tr>
                <th scope="row">첨부파일</th>
                <td colspan="3">
                    <?php
                    for($i=0;$i<3;$i++) {
                        echo '<div style="margin-bottom:5px;">';
                        echo '<input type="file" name="applicant_attach_file['.$i.']" class="frm_input">';
                        echo ${$pre}['applicant_attach'][$i]['file'];
                        echo '</div>';
                    }
                    ?>
                </td>
            </tr>
            <?php
            $ar['id'] = 'apc_memo';
            $ar['name'] = '관리자메모';
            $ar['type'] = 'textarea';
            $ar['value'] = ${$pre}[$ar['id']];
            $ar['colspan'] = 3;
            echo create_tr_input($ar);
            unset($ar);
            ?>
            <tr>
                <th scope="row">관리상태</th>
                <td colspan="3">
                    <select name="<?=$pre?>_status" id="<?=$pre?>_status">
                        <option value="">선택하세요.</option>
                        <?=$g5['set_apc_status_options']?>
                    </select>
                    <script>$('select[name="<?=$pre?>_status"]').val('<?=${$pre}[$pre.'_status']?>');</script>
                </td>
            </tr>
		</tbody>
	</table>
</div>

<div id="anc_school" class="tbl_frm01 tbl_wrap">
	<h2 class="h2_frm">학력정보</h2>
	<?php echo $pg_anchor ?>
	<table>
		<colgroup>
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
		</colgroup>
		<tbody>
            <?php
            $shl_type = 'highschool';
            $x=0;
            ?>
			<tr>
				<th>고등학교</th>
				<td colspan="3">
                    <input type="hidden" name="<?=$shl_type?>[shl_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$shl_type?>[shl_idx][]" value="<?=$shl[$shl_type][$x]['shl_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$shl_type?>[shl_type1][]" value="<?=$shl_type?>" class="frm_input" style="width:150px;">
                    학교명: <input type="text" name="<?=$shl_type?>[shl_title][]" value="<?=$shl[$shl_type][$x]['shl_title']?>" class="frm_input" style="width:150px;">
                    &nbsp;&nbsp;
                    졸업년월:
                    <select name="<?=$shl_type?>[shl_year][]" id="shl_year_<?=$shl_type?>_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_year_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_year']?>');</script>
                    <select name="<?=$shl_type?>[shl_month][]" id="shl_month_<?=$shl_type?>_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_month_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_month']?>');</script>

                    <select name="<?=$shl_type?>[shl_graduate_type][]" id="shl_graduate_type_<?=$shl_type?>_<?=$x?>">
                        <option value="">선택하세요.</option>
                        <?=$g5['set_shl_graduate_type_value_options']?>
                    </select>
                    <script>$('#shl_graduate_type_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_graduate_type']?>');</script>

                </td>
			</tr>
            <?php
            $shl_type = 'university';
            $x=0;
            ?>
			<tr>
				<th>대학교</th>
				<td colspan="3">
                    <input type="hidden" name="<?=$shl_type?>[shl_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$shl_type?>[shl_idx][]" value="<?=$shl[$shl_type][$x]['shl_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$shl_type?>[shl_type1][]" value="<?=$shl_type?>" class="frm_input" style="width:150px;">
                    학교명: <input type="text" name="<?=$shl_type?>[shl_title][]" value="<?=$shl[$shl_type][$x]['shl_title']?>" class="frm_input" style="width:150px;">
                    &nbsp;&nbsp;
                    졸업년월:
                    <select name="<?=$shl_type?>[shl_year][]" id="shl_year_<?=$shl_type?>_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_year_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_year']?>');</script>
                    <select name="<?=$shl_type?>[shl_month][]" id="shl_month_<?=$shl_type?>_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_month_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_month']?>');</script>

                    <select name="<?=$shl_type?>[shl_graduate_type][]" id="shl_graduate_type_<?=$shl_type?>_<?=$x?>">
                        <option value="">선택하세요.</option>
                        <?=$g5['set_shl_graduate_type_value_options']?>
                    </select>
                    <script>$('#shl_graduate_type_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_graduate_type']?>');</script>

                    &nbsp;&nbsp;
                    전공: <input type="text" name="<?=$shl_type?>[shl_content][]" value="<?=$shl[$shl_type][$x]['shl_content']?>" class="frm_input" style="width:150px;">

                    &nbsp;&nbsp;
                    <?php
                    if(is_array($g5['set_school_type_value'])) {
                        foreach ($g5['set_school_type_value'] as $k1=>$v1) {
//                            echo $k1.'/'.$v1.'<br>';
                            ${$k1.'_checked'} = ($shl[$shl_type][$x]['shl_type2']==$k1)?'checked':'';
                            echo '<input type="radio" name="'.$shl_type.'[shl_type2][]" value="'.$k1.'" id="shl_type2_'.$k1.'_'.$shl_type.'_'.$x.'" '.${$k1.'_checked'}.'>
                                  <label for="shl_type2_'.$k1.'_'.$shl_type.'_'.$x.'">'.$v1.'</label>'.PHP_EOL;
                        }
                    }                    
                    ?>
                </td>
			</tr>
		</tbody>
	</table>
</div>

<div id="anc_career" class="tbl_frm01 tbl_wrap">
	<h2 class="h2_frm">경력사항</h2>
	<?php echo $pg_anchor ?>
	<table>
		<colgroup>
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
		</colgroup>
		<tbody>
            <?php
            for($x=0;$x<3;$x++) {
                // 직종 셀렉트박스
                for($i=0;$i<sizeof($g5['category']);$i++) {
                    if($g5['category'][$i]['depth']==0) {
                        $category_idx[$i] = explode(",",$g5['category'][$i]['down_idxs']);
                        $category_name[$i] = explode("^",$g5['category'][$i]['down_names']);
                        for($j=1;$j<sizeof($category_idx[$i]);$j++) {
                            // 선택된 항목인 경우 select option 생성
                            if($crr[$x]['crr_category1']==$g5['category'][$i]['term_idx']) {
                                $job_select[$x] .= '<option value="'.$category_idx[$i][$j].'">'.$category_name[$i][$j].'</option>';
                            }
                        }
                    }
                    // print_r2($g5['category'][$i]);
                }                
            ?>
			<tr>
				<th>경력<?=($x+1)?></th>
				<td colspan="3">
                    <input type="hidden" name="crr_chk[]" value="<?php echo $x ?>">
                    <input type="hidden" name="crr_idx[]" value="<?=$crr[$x]['crr_idx']?>" class="frm_input" style="width:150px;">

                    <select name="crr_category1[]" id="crr_category1_<?=$x?>" crr_category1="<?=$crr[$x]['crr_category1']?>">
						<option value="">업종선택</option>
						<?=$category_form_depth0_options?>
					</select>
                    <script>$('#crr_category1_<?=$x?>').val('<?=$crr[$x]['crr_category1']?>');</script>
                    <select name="crr_category2[]" id="crr_category2_<?=$x?>" crr_category2="<?=$crr[$x]['crr_category2']?>">
						<option value="">직종선택</option>
						<?=$job_select[$x]?>
					</select>
                    <script>$('#crr_category2_<?=$x?>').val('<?=$crr[$x]['crr_category2']?>');</script>
					<script>
						$(document).on('change','#crr_category1_<?=$x?>',function(e){
							// console.log( $(this).val() );
							$("option",'#crr_category2_<?=$x?>').remove(); // 2차항목 초기화
							$('#crr_category2_<?=$x?>').append("<option value=''>직종선택</option>");
							var this_category = "category"+$(this).val(); // 선택항목의 2차 Object
							$.each(eval(this_category), function(i, v){
//								 console.log(i+':'+v);
								$('#crr_category2_<?=$x?>').append("<option value='"+i+"'>"+v+"</option>");
							});
							// 기존값이 있었다면 선택상태로 설정
							if( $(this).val()==$('#crr_category1_<?=$x?>').attr('crr_category1') && $('#crr_category2_<?=$x?>').attr('crr_category2')!='' ) {
								$('#crr_category2_<?=$x?>').val( $('#crr_category2_<?=$x?>').attr('crr_category2') );
							}
						});
					</script>

                    &nbsp;&nbsp;
                    회사명: <input type="text" name="crr_company[]" value="<?=$crr[$x]['crr_company']?>" class="frm_input" style="width:150px;">

                    &nbsp;&nbsp;
                    근무기간:
                    <select name="crr_start_year[]" id="crr_start_year_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#crr_start_year_<?=$x?>').val('<?=$crr[$x]['crr_start_year']?>');</script>
                    <select name="crr_start_month[]" id="crr_start_month_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#crr_start_month_<?=$x?>').val('<?=$crr[$x]['crr_start_month']?>');</script>
                    ~
                    <select name="crr_end_year[]" id="crr_end_year_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#crr_end_year_<?=$x?>').val('<?=$crr[$x]['crr_end_year']?>');</script>
                    <select name="crr_end_month[]" id="crr_end_month_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#crr_end_month_<?=$x?>').val('<?=$crr[$x]['crr_end_month']?>');</script>

                    &nbsp;&nbsp;
                    연봉: <input type="text" name="crr_pay[]" value="<?=$crr[$x]['crr_pay']?>" class="frm_input" style="width:60px;">만원
                    
                    <div style="height:5px;"></div>
					담당업무: <input type="text" name="crr_job[]" value="<?=$crr[$x]['crr_job']?>" class="frm_input" style="width:92%;">
                    <div style="height:5px;"></div>
					퇴사사유: <input type="text" name="crr_quit_why[]" value="<?=$crr[$x]['crr_quit_why']?>" class="frm_input" style="width:92%;">

                </td>
			</tr>            
            <?php
            }
            ?>            
		</tbody>
	</table>
</div>

<div id="anc_additional" class="tbl_frm01 tbl_wrap">
	<h2 class="h2_frm">추가사항</h2>
	<?php echo $pg_anchor ?>
	<table>
		<colgroup>
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
		</colgroup>
		<tbody>
			<tr>
                <?php
                $add_type = 'disability';
                $x=0;
                ?>
				<th>장애여부</th>
				<td>
                    <input type="hidden" name="<?=$add_type?>[add_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$add_type?>[add_idx][]" value="<?=$add[$add_type][$x]['add_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$add_type?>[add_type][]" value="<?=$add_type?>" class="frm_input" style="width:150px;">
                    <?php
                    if(is_array($g5['set_additional_'.$add_type.'_value'])) {
                        foreach ($g5['set_additional_'.$add_type.'_value'] as $k1=>$v1) {
//                            echo $k1.'/'.$v1.'<br>';
                            ${$k1.'_checked'} = ($add[$add_type][$x]['add_value']==$k1)?'checked':'';
                            echo '<input type="radio" name="'.$add_type.'[add_value][]" value="'.$k1.'" id="add_value_'.$k1.'_'.$add_type.'_'.$x.'" '.${$k1.'_checked'}.'>
                                  <label for="add_value_'.$k1.'_'.$add_type.'_'.$x.'">'.$v1.'</label>'.PHP_EOL;
                        }
                    }                    
                    ?>
                </td>
                <?php
                $add_type = 'patriot';
                $x=0;
                ?>
				<th>보훈대상</th>
				<td>
                    <input type="hidden" name="<?=$add_type?>[add_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$add_type?>[add_idx][]" value="<?=$add[$add_type][$x]['add_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$add_type?>[add_type][]" value="<?=$add_type?>" class="frm_input" style="width:150px;">
                    <?php
                    if(is_array($g5['set_additional_'.$add_type.'_value'])) {
                        foreach ($g5['set_additional_'.$add_type.'_value'] as $k1=>$v1) {
//                            echo $k1.'/'.$v1.'<br>';
                            ${$k1.'_checked'} = ($add[$add_type][$x]['add_value']==$k1)?'checked':'';
                            echo '<input type="radio" name="'.$add_type.'[add_value][]" value="'.$k1.'" id="add_value_'.$k1.'_'.$add_type.'_'.$x.'" '.${$k1.'_checked'}.'>
                                  <label for="add_value_'.$k1.'_'.$add_type.'_'.$x.'">'.$v1.'</label>'.PHP_EOL;
                        }
                    }                    
                    ?>
                </td>
			</tr>
			<tr>
                <?php
                $add_type = 'military';
                $x=0;
                ?>
				<th>병역사항</th>
				<td>
                    <input type="hidden" name="<?=$add_type?>[add_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$add_type?>[add_idx][]" value="<?=$add[$add_type][$x]['add_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$add_type?>[add_type][]" value="<?=$add_type?>" class="frm_input" style="width:150px;">
                    <?php
                    if(is_array($g5['set_additional_'.$add_type.'_value'])) {
                        foreach ($g5['set_additional_'.$add_type.'_value'] as $k1=>$v1) {
//                            echo $k1.'/'.$v1.'<br>';
                            ${$k1.'_checked'} = ($add[$add_type][$x]['add_value']==$k1)?'checked':'';
                            echo '<input type="radio" name="'.$add_type.'[add_value][]" value="'.$k1.'" id="add_value_'.$k1.'_'.$add_type.'_'.$x.'" '.${$k1.'_checked'}.'>
                                  <label for="add_value_'.$k1.'_'.$add_type.'_'.$x.'">'.$v1.'</label>'.PHP_EOL;
                        }
                    }                    
                    ?>
                </td>
                <?php
                $add_type = 'militaryterm';
                $x=0;
                ?>
				<th>군 복무기간</th>
				<td>
                    <input type="hidden" name="<?=$add_type?>[add_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$add_type?>[add_idx][]" value="<?=$add[$add_type][$x]['add_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$add_type?>[add_type][]" value="<?=$add_type?>" class="frm_input" style="width:150px;">
                    <select name="<?=$add_type?>[add_start_year][]" id="add_start_year_<?=$add_type?>_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#add_start_year_<?=$add_type?>_<?=$x?>').val('<?=$add[$add_type][$x]['add_start_year']?>');</script>
                    <select name="<?=$add_type?>[add_start_month][]" id="add_start_month_<?=$add_type?>_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#add_start_month_<?=$add_type?>_<?=$x?>').val('<?=$add[$add_type][$x]['add_start_month']?>');</script>
                    ~
                    <select name="<?=$add_type?>[add_end_year][]" id="add_end_year_<?=$add_type?>_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#add_end_year_<?=$add_type?>_<?=$x?>').val('<?=$add[$add_type][$x]['add_end_year']?>');</script>
                    <select name="<?=$add_type?>[add_end_month][]" id="add_end_month_<?=$add_type?>_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#add_end_month_<?=$add_type?>_<?=$x?>').val('<?=$add[$add_type][$x]['add_end_month']?>');</script>
                </td>
			</tr>
		</tbody>
	</table>
</div>

<div id="anc_certificate" class="tbl_frm01 tbl_wrap">
	<h2 class="h2_frm">자격및교육</h2>
	<?php echo $pg_anchor ?>
	<table>
		<colgroup>
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
		</colgroup>
		<tbody>
            <?php
            $shl_type = 'certificate';
            for($x=0;$x<3;$x++) {
            ?>
			<tr>
				<th>자격교육내용</th>
				<td colspan="3">
                    <input type="hidden" name="<?=$shl_type?>[shl_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$shl_type?>[shl_idx][]" value="<?=$shl[$shl_type][$x]['shl_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$shl_type?>[shl_type1][]" value="<?=$shl_type?>" class="frm_input" style="width:150px;">
                    <input type="text" name="<?=$shl_type?>[shl_title][]" value="<?=$shl[$shl_type][$x]['shl_title']?>" class="frm_input" style="width:150px;">
                    &nbsp;&nbsp;
                    취득/수료일:
                    <select name="<?=$shl_type?>[shl_year][]" id="shl_year_<?=$shl_type?>_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_year_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_year']?>');</script>
                    <select name="<?=$shl_type?>[shl_month][]" id="shl_month_<?=$shl_type?>_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_month_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_month']?>');</script>
                </td>
			</tr>
            <?php
            }
            ?>
		</tbody>
	</table>
</div>

<div id="anc_language" class="tbl_frm01 tbl_wrap">
	<h2 class="h2_frm">어학능력</h2>
	<?php echo $pg_anchor ?>
	<table>
		<colgroup>
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
			<col class="grid_4" style="width:15%;">
			<col style="width:35%;">
		</colgroup>
		<tbody>
            <?php
            $shl_type = 'language';
            $x=0;
            ?>
            <script>
            <?php
            if(is_array($g5['set_language_value'])) {
                foreach ($g5['set_language_value'] as $k1=>$v1) {
//                    echo $k1.'/'.$v1.'<br>';
                    echo 'var exam_'.$k1.' = {};'.PHP_EOL;
                    
                    if(is_array($g5['set_exam_'.$k1.'_value'])) {
                        foreach ($g5['set_exam_'.$k1.'_value'] as $k2=>$v2) {
        //                    echo $k2.'/'.$v2.'<br>';
                            // Object 변수생성
                            echo "exam_".$k1."['".$k2."'] = '".$v2."';".PHP_EOL;

                            // 선택된 항목인 경우 select option 생성
                            if($shl[$shl_type][$x]['shl_type2']==$k1) {
                                $exam_select .= '<option value="'.$k2.'">'.$v2.'</option>';
                            }
                        }
                    }                
                }
            }
            ?>
            </script>
			<tr>
				<th>외국어</th>
				<td colspan="3">
                    <input type="hidden" name="<?=$shl_type?>[shl_chk][]" value="<?php echo $x ?>">
                    <input type="hidden" name="<?=$shl_type?>[shl_idx][]" value="<?=$shl[$shl_type][$x]['shl_idx']?>" class="frm_input" style="width:150px;">
                    <input type="hidden" name="<?=$shl_type?>[shl_type1][]" value="<?=$shl_type?>" class="frm_input" style="width:150px;">

                    <select name="<?=$shl_type?>[shl_type2][]" id="shl_type2_<?=$shl_type?>_<?=$x?>" language="<?=$shl[$shl_type][$x]['shl_type2']?>">
						<option value="">외국어선택</option>
                        <?=$g5['set_language_value_options']?>
					</select>
                    <script>$('#shl_type2_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_type2']?>');</script>

                    <select name="<?=$shl_type?>[shl_content][]" id="shl_content_<?=$shl_type?>_<?=$x?>" exam="<?=$shl[$shl_type][$x]['shl_content']?>">
						<option value="">공인시험선택</option>
						<?=$exam_select?>
					</select>
                    <script>$('#shl_content_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_content']?>');</script>
					<script>
						$(document).on('change','#shl_type2_<?=$shl_type?>_<?=$x?>',function(e){
							// console.log( $(this).val() );
							$("option",'#shl_content_<?=$shl_type?>_<?=$x?>').remove(); // 2차항목 초기화
							$('#shl_content_<?=$shl_type?>_<?=$x?>').append("<option value=''>공인시험선택</option>");
							var this_exam = "exam_"+$(this).val(); // 선택항목의 2차 Object
							$.each(eval(this_exam), function(i, v){
//								 console.log(i+':'+v);
								$('#shl_content_<?=$shl_type?>_<?=$x?>').append("<option value='"+i+"'>"+v+"</option>");
							});
							// 기존값이 있었다면 선택상태로 설정
							if( $(this).val()==$('#shl_type2_<?=$shl_type?>_<?=$x?>').attr('language') && $('#shl_content_<?=$shl_type?>_<?=$x?>').attr('exam')!='' ) {
								$('#shl_content_<?=$shl_type?>_<?=$x?>').val( $('#shl_content_<?=$shl_type?>_<?=$x?>').attr('exam') );
							}
						});
                        // 직접 입력인 경우 시험명 보임, 숨김
						$(document).on('change','#shl_content_<?=$shl_type?>_<?=$x?>',function(e){
							if( $(this).val() == 'direct' ) {
                                $('#shl_type_<?=$shl_type?>_<?=$x?>').show();
                            }
                            else {
                                $('#shl_type_<?=$shl_type?>_<?=$x?>').hide();
                            }
						});
					</script>
                    
                    <!-- 직접인 경우만 보여줌 -->
                    <input type="text" name="<?=$shl_type?>[shl_title][]" id="shl_type_<?=$shl_type?>_<?=$x?>"
                           value="<?=$shl[$shl_type][$x]['shl_title']?>" class="frm_input" style="width:120px;display:<?=($shl[$shl_type][$x]['shl_content']!='direct')?'none':''?>;">
                    &nbsp;&nbsp;
                    점수: <input type="text" name="<?=$shl_type?>[shl_score][]" value="<?=$shl[$shl_type][$x]['shl_score']?>" class="frm_input" style="width:80px;">
                    &nbsp;&nbsp;
                    취득일:
                    <select name="<?=$shl_type?>[shl_year][]" id="shl_year_<?=$shl_type?>_<?=$x?>">
                        <option value="">연도선택</option>
                        <?php
                        for($i=date("Y");$i>1950;$i--) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_year_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_year']?>');</script>
                    <select name="<?=$shl_type?>[shl_month][]" id="shl_month_<?=$shl_type?>_<?=$x?>">
                        <option value="">월선택</option>
                        <?php
                        for($i=1;$i<13;$i++) {
                            echo '<option value="'.sprintf("%02d",$i).'">'.sprintf("%02d",$i).'</option>';
                        }
                        ?>
                    </select>
                    <script>$('#shl_month_<?=$shl_type?>_<?=$x?>').val('<?=$shl[$shl_type][$x]['shl_month']?>');</script>
                </td>
			</tr>
		</tbody>
	</table>
</div>

<div class="btn_fixed_top">
    <a href="./<?=$fname?>_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey='s'>
</div>
</form>

<script>
$(function(e) {
    
    $(document).on('click','.btn_recruit',function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        winRecruit = window.open(href, "winRecruit", "left=100,top=100,width=520,height=600,scrollbars=1");
        winRecruit.focus();
        return false;

    });
    
    // 달력 datapicker
    $("input[name$=_date], #apc_birth").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" });


});

function form01_submit(f) {

    // 사진 파일
    if (!$('input[name^=applicant_list_file]').val().match(/\.(gif|jpe?g|png)$/i) && $('input[name^=applicant_list_file]').val()) {
        alert('사진은 이미지 파일만 가능합니다.(gif, jpg, png)');
        return false;
    }
    
    return true;
}
</script>

<?php
include_once ('./_tail.php');
?>

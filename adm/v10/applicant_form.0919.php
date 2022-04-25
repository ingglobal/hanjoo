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

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

${$pre} = get_table_meta($table_name, $pre.'_idx', ${$pre."_idx"});
$rct = get_table_meta('recruit', 'rct_idx', ${$pre}['rct_idx']);

if ($w == '') {
    $sound_only = '<strong class="sound_only">필수</strong>';
    $w_display_none = ';display:none';  // 쓰기에서 숨김
    
    ${$pre}[$pre.'_status'] = 'working';
    ${$pre}[$pre.'_status'] = 'pending';
}
else if ($w == 'u') {
    $u_display_none = ';display:none;';  // 수정에서 숨김
	
    if (!${$pre}[$pre.'_idx'])
		alert('존재하지 않는 자료입니다.');

	// 관련 파일 추출
	$sql = "SELECT * FROM {$g5['file_table']} 
			WHERE fle_db_table = '".$table_name."' AND fle_db_id = '".${$pre.'_idx'}."' ORDER BY fle_sort, fle_reg_dt DESC ";
	$rs = sql_query($sql,1);
	// print_r3($sql);
	for($i=0;$row=sql_fetch_array($rs);$i++) {
		${$pre}[$row['fle_type']][$row['fle_sort']]['file'] = (is_file(G5_PATH.$row['fle_path'].'/'.$row['fle_name'])) ? 
		'<span>&nbsp;&nbsp;'.$row['fle_name_orig'].'&nbsp;&nbsp;</span><a href="../..'.$row['fle_path'].'/'.$row['fle_name_orig'].'" download>파일다운로드</a>'
		// '&nbsp;&nbsp;'.$row['fle_name_orig'].'&nbsp;&nbsp;<a href="'.G5_USER_ADMIN_URL.'/lib/download.php?file_fullpath='.urlencode(G5_PATH.$row['fle_path'].'/'.$row['fle_name']).'&file_name_orig='.$row['fle_name_orig'].'">파일다운로드</a>'
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
<input type="hidden" name="ser_apc_channel" value="<?=$ser_apc_channel?>">
<input type="hidden" name="ser_area1" value="<?=$ser_area1?>">
<input type="hidden" name="ser_area2" value="<?=$ser_area2?>">
<input type="hidden" name="ser_apc_type" value="<?=$ser_apc_type?>">
<input type="hidden" name="ser_apc_level" value="<?=$ser_apc_level?>">
<input type="hidden" name="ser_keyword" value="<?=$ser_keyword?>">
<input type="hidden" name="ser_benefit" value="<?=$ser_benefit?>">
<input type="hidden" name="ser_department" value="<?=$ser_department?>">
<input type="hidden" name="ser_mb_name_saler" value="<?=$ser_mb_name_saler?>">
<input type="hidden" name="ser_mb_id_worker" value="<?=$ser_mb_id_worker?>">


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
					<input type="hidden" name="rct_idx" value="<?=${$pre}['rct_idx']?>" class="frm_input"><!-- 공고idx -->
					<input type="text" name="rct_subject" value="<?=$rct['rct_subject']?>" id="rct_subject" class="frm_input required" style="width:50%;" required readonly>
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
				<?php
				$ar['id'] = 'apc_gender';
				$ar['name'] = '성별';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '70px';
				echo create_td_input($ar);
				unset($ar);
				?>
				<?php
				$ar['id'] = 'apc_birth';
				$ar['name'] = '생년월일';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '70px';
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
                <th scope="row">사진 이미지</th>
                <td colspan="3">
                    <div style="float:left;margin-right:8px;"><?=${$pre}['applicant_list'][0]['thumbnail_img']?></div>
                    <input type="file" name="applicant_list_file[0]" class="frm_input">
                    <?=${$pre}['applicant_list'][0]['file']?>

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
            $ar['id'] = 'rct_profile';
            $ar['name'] = '자기소개';
            $ar['type'] = 'textarea';
				$ar['value'] = ${$pre}[$ar['id']];
            $ar['colspan'] = 3;
            echo create_tr_input($ar);
            unset($ar);
            ?>
			<tr>
				<?php
				$ar['id'] = 'trm_idx_category';
				$ar['name'] = '희망직종';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}[$ar['id']];
				$ar['width'] = '70px';
				echo create_td_input($ar);
				unset($ar);
				?>
                <th scope="row">재직상태</th>
                <td>
                    <select name="<?=$pre?>_work_status" id="<?=$pre?>_work_status">
                        <option value="">재직상태선택</option>
                        <?=$g5['set_work_status_options']?>
                    </select>
                    <script>$('select[name="<?=$pre?>_work_status"]').val('<?=${$pre}[$pre.'_work_status']?>');</script>
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
			<tr>
				<th>카테고리</th>
				<td colspan="3">
					<script>
					<?php
					for($i=0;$i<sizeof($g5['category']);$i++) {
						if($g5['category'][$i]['depth']==0) {
							echo 'var category'.$g5['category'][$i]['term_idx'].' = {};'.PHP_EOL;
							$gugun_idx[$i] = explode(",",$g5['category'][$i]['down_idxs']);
							$gugun_name[$i] = explode(",",$g5['category'][$i]['down_names']);
							for($j=1;$j<sizeof($gugun_idx[$i]);$j++) {
								echo "category".$g5['category'][$i]['term_idx']."['".$gugun_idx[$i][$j]."'] = '".$gugun_name[$i][$j]."';".PHP_EOL;
								// 선택된 항목인 경우 select option 생성
								if(${$pre}['apc_category1']==$g5['category'][$i]['term_idx']) {
									$gugun_select .= '<option value="'.$gugun_idx[$i][$j].'">'.$gugun_name[$i][$j].'</option>';
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
					<select id="apc_category1" name="apc_category1" apc_category1="<?=${$pre}['apc_category1']?>">
						<option value="">업종선택</option>
						<?=$category_form_depth0_options?>
					</select> 
					<script>$('select[name="apc_category1"]').val('<?=${$pre}['apc_category1']?>');</script>
					<select id="apc_category2" name="apc_category2" apc_category2="<?=${$pre}['apc_category2']?>">
						<option value="">직종선택</option>
						<?=$gugun_select?>
					</select>
					<script>$('select[name="apc_category2"]').val('<?=${$pre}['apc_category2']?>');</script>
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
			<tr>
				<?php
				$ar['id'] = 'apc_people_limit';
				$ar['name'] = '방문가능 인원';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}['apc_people_limit'];
				echo create_td_input($ar);
				unset($ar);
				?>
				<?php
				$ar['id'] = 'apc_reserve_tel1';
				$ar['name'] = '예약전화번호';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}['apc_reserve_tel1'];
				echo create_td_input($ar);
				unset($ar);
				?>
			</tr>
			<tr>
				<th>방문가능 시간</th>
				<td colspan="3">
					<input type="checkbox" id="apc_weekend_yn" <?=$weekend_checked?> onclick="javascript:if(this.checked){this.form.apc_weekend_yn_value.value='1'}else{this.form.apc_weekend_yn_value.value='0'}">
					<label for="apc_weekend_yn">주말방문가능</label>
					<input type="hidden" name="apc_weekend_yn" id="apc_weekend_yn_value" value="<?=${$pre}['apc_weekend_yn']?>"><br>
					<input type="text" name="apc_time_posible" id="apc_time_posible" value="<?=${$pre}['apc_time_posible']?>" class="frm_input" style="width:100%;">
				</td>
			</tr>
			<?php
			$ar['id'] = 'apc_reserve_desc';
			$ar['name'] = '예약안내';
			$ar['type'] = 'textarea';
			$ar['value'] = ${$pre}['apc_reserve_desc'];
			$ar['colspan'] = 3;
			echo create_tr_input($ar);
			unset($ar);
			?>
			<?php
			$ar['id'] = 'apc_additional';
			$ar['name'] = '캠페인 추가정보';
			$ar['type'] = 'textarea';
			$ar['value'] = ${$pre}['apc_additional'];
			$ar['width'] = '100%';
			$ar['colspan'] = 3;
			echo create_tr_input($ar);
			unset($ar);
			?>
			<tr>
				<th>추가키워드</th>
				<td colspan="3">
					<input type="text" name="apc_keyword2" id="apc_keyword2" value="<?=$add_kyes?>" class="frm_input" style="width:100%;">
				</td>
			</tr>
			<tr>
				<th scope="row">가이드라인</th>
				<td colspan="3">
					<input type="file" name="applicant_attach_file[0]" class="frm_input">
					<?php echo ${$pre}['applicant_attach'][0]['file']; ?>
				</td>
			</tr>
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
				$ar['id'] = 'apc_people_limit';
				$ar['name'] = '방문가능 인원';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}['apc_people_limit'];
				echo create_td_input($ar);
				unset($ar);
				?>
				<?php
				$ar['id'] = 'apc_reserve_tel1';
				$ar['name'] = '예약전화번호';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}['apc_reserve_tel1'];
				echo create_td_input($ar);
				unset($ar);
				?>
			</tr>
			<tr>
				<th>방문가능 시간</th>
				<td colspan="3">
					<input type="checkbox" id="apc_weekend_yn" <?=$weekend_checked?> onclick="javascript:if(this.checked){this.form.apc_weekend_yn_value.value='1'}else{this.form.apc_weekend_yn_value.value='0'}">
					<label for="apc_weekend_yn">주말방문가능</label>
					<input type="hidden" name="apc_weekend_yn" id="apc_weekend_yn_value" value="<?=${$pre}['apc_weekend_yn']?>"><br>
					<input type="text" name="apc_time_posible" id="apc_time_posible" value="<?=${$pre}['apc_time_posible']?>" class="frm_input" style="width:100%;">
				</td>
			</tr>
			<?php
			$ar['id'] = 'apc_reserve_desc';
			$ar['name'] = '예약안내';
			$ar['type'] = 'textarea';
			$ar['value'] = ${$pre}['apc_reserve_desc'];
			$ar['colspan'] = 3;
			echo create_tr_input($ar);
			unset($ar);
			?>
			<?php
			$ar['id'] = 'apc_additional';
			$ar['name'] = '캠페인 추가정보';
			$ar['type'] = 'textarea';
			$ar['value'] = ${$pre}['apc_additional'];
			$ar['width'] = '100%';
			$ar['colspan'] = 3;
			echo create_tr_input($ar);
			unset($ar);
			?>
			<tr>
				<th>추가키워드</th>
				<td colspan="3">
					<input type="text" name="apc_keyword2" id="apc_keyword2" value="<?=$add_kyes?>" class="frm_input" style="width:100%;">
				</td>
			</tr>
			<tr>
				<th scope="row">가이드라인</th>
				<td colspan="3">
					<input type="file" name="applicant_attach_file[0]" class="frm_input">
					<?php echo ${$pre}['applicant_attach'][0]['file']; ?>
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
			<tr>
				<?php
				$ar['id'] = 'apc_people_limit';
				$ar['name'] = '방문가능 인원';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}['apc_people_limit'];
				echo create_td_input($ar);
				unset($ar);
				?>
				<?php
				$ar['id'] = 'apc_reserve_tel1';
				$ar['name'] = '예약전화번호';
				$ar['type'] = 'input';
				$ar['value'] = ${$pre}['apc_reserve_tel1'];
				echo create_td_input($ar);
				unset($ar);
				?>
			</tr>
			<tr>
				<th>방문가능 시간</th>
				<td colspan="3">
					<input type="checkbox" id="apc_weekend_yn" <?=$weekend_checked?> onclick="javascript:if(this.checked){this.form.apc_weekend_yn_value.value='1'}else{this.form.apc_weekend_yn_value.value='0'}">
					<label for="apc_weekend_yn">주말방문가능</label>
					<input type="hidden" name="apc_weekend_yn" id="apc_weekend_yn_value" value="<?=${$pre}['apc_weekend_yn']?>"><br>
					<input type="text" name="apc_time_posible" id="apc_time_posible" value="<?=${$pre}['apc_time_posible']?>" class="frm_input" style="width:100%;">
				</td>
			</tr>
			<?php
			$ar['id'] = 'apc_reserve_desc';
			$ar['name'] = '예약안내';
			$ar['type'] = 'textarea';
			$ar['value'] = ${$pre}['apc_reserve_desc'];
			$ar['colspan'] = 3;
			echo create_tr_input($ar);
			unset($ar);
			?>
			<?php
			$ar['id'] = 'apc_additional';
			$ar['name'] = '캠페인 추가정보';
			$ar['type'] = 'textarea';
			$ar['value'] = ${$pre}['apc_additional'];
			$ar['width'] = '100%';
			$ar['colspan'] = 3;
			echo create_tr_input($ar);
			unset($ar);
			?>
			<tr>
				<th>추가키워드</th>
				<td colspan="3">
					<input type="text" name="apc_keyword2" id="apc_keyword2" value="<?=$add_kyes?>" class="frm_input" style="width:100%;">
				</td>
			</tr>
			<tr>
				<th scope="row">가이드라인</th>
				<td colspan="3">
					<input type="file" name="applicant_attach_file[0]" class="frm_input">
					<?php echo ${$pre}['applicant_attach'][0]['file']; ?>
				</td>
			</tr>
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
		<tr>
			<th scope="row">이미지(들)</th>
			<td colspan="3">
				<?=help('캠페인 상세 이미지에 썸네일과 함께 나타나는 이미지입니다.')?>
				<?php
				for($i=0;$i<4;$i++) {
					echo '<div style="margin-bottom:5px;">';
					echo '<input type="file" name="campaign_detail_file['.$i.']" class="frm_input">';
					echo ${$pre}['campaign_detail'][$i]['file'];
					echo '</div>';
				}
				?>
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
    $("input[name$=_date]").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" });


});

function form01_submit(f) {

    
    return true;
}
</script>

<?php
include_once ('./_tail.php');
?>

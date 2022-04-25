<?php
$sub_menu = "950100";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

// 변수 설정, 필드 구조 및 prefix 추출
$table_name = 'applicant';
$g5_table_name = $g5[$table_name.'_table'];
$fields = sql_field_names($g5_table_name);
$pre = substr($fields[0],0,strpos($fields[0],'_'));
$fname = preg_replace("/_list/","",$g5['file_name']); // _list을 제외한 파일명
//$qstr .= '&ser_apc_channel='.$ser_apc_channel.'&ser_area1='.$ser_area1.'&ser_area2='.$ser_area2.'&ser_apc_type='.$ser_apc_type; // 추가로 확장해서 넘겨야 할 변수들
//print_r3($qstr);
//print_r3($_REQUEST);
// 추가 변수 생성
foreach($_REQUEST as $key => $value ) {
    if(substr($key,0,4)=='ser_') {
    //    print_r3($key.'='.$value);
        if(is_array($value)) {
            foreach($value as $k2 => $v2 ) {
//                print_r3($key.$k2.'='.$v2);
                $qstr .= '&'.$key.'[]='.$v2;
            }
        }
        else {
            $qstr .= '&'.$key.'='.$value;
        }
    }    
}
//print_r3($qstr);


$g5['title'] = '지원자관리';
//include_once('./_top_menu_applicant.php');
include_once('./_head.php');
//echo $g5['container_sub_title'];

//print_r2($g5['set_mb_gender_value']);
//echo array_search('남자',$g5['set_mb_gender_value']);

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
	$sst = "apc_idx";
    //$sst = "apc_sort, ".$pre."_reg_dt";
    $sod = "DESC";
}
$sql_order = " ORDER BY {$sst} {$sod} ";

$rows = $g5['setting']['set_applicant_page_rows'] ? $g5['setting']['set_applicant_page_rows'] : $config['cf_page_rows'];
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " SELECT *
		{$sql_common}
		{$sql_search}
        {$sql_order}
		LIMIT {$from_record}, {$rows} 
";
//echo $sql.'<br>';
$result = sql_query($sql,1);

// 전체 게시물 수
$sql = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>
<style>
.td_apc_apply,
.td_rct_subject {text-align:left !important;}
.td_mng {width:90px;max-width:90px;}
#div_category label
,#div_area label {margin-right:10px;color:#0caf02;display:inline-block;}
#div_category label i
,#div_area label i {border:solid 1px #ddd;padding:3px;cursor:pointer;color:#818181;}
.btn_left_edge {border-top-right-radius:0 !important;border-bottom-right-radius:0 !important;cursor:default;font-weight:normal !important;}
.btn_left_edge2 {border-top-right-radius:0 !important;border-bottom-right-radius:0 !important;margin-right:-3px;border-right:solid 1px #929292 !important;}
.btn_right_edge {border-top-left-radius:0 !important;border-bottom-left-radius:0 !important;}
.btn_center {border-radius:0 !important;margin:0 -2px 0 -3px;border-right:solid 1px #929292 !important;border-left:solid 1px #929292 !important;}
.td_rct_subject a,
.td_mb_name a {text-decoration: underline;}
.td_admin {width:100px;}
.td_apc_phoso {width:40px;}
.td_apc_birth {width:80px;}
.td_apc_email {width:80px;}
.td_apc_career {width:40px;}
.td_apc_status {width:75px;}
.td_apc_reg_dt {width:40px;}
.td_admin a{height:23px;line-height:23px;font-weight:normal;font-size:0.9em;}
</style>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">총건수 </span><span class="ov_num"> <?php echo number_format($total_count) ?> </span></span>
</div>

<div class="local_desc01 local_desc" style="display:none;">
    <p>간단설명</p>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get" style="width:100%;">
<label for="sfl" class="sound_only">검색대상</label>
<select name="ser_mb_id" id="ser_mb_id">
    <option value="">담당자전체</option>
    <?php
    $sql = " SELECT * FROM {$g5['member_table']} WHERE mb_level = 8 ORDER BY mb_datetime ";
    $rs = sql_query($sql,1);
    for($i=0;$row=sql_fetch_array($rs);$i++) {
        echo '<option value="'.$row['mb_id'].'">'.$row['mb_name'].'</option>';
    }
    ?>
</select>
<script>$('#ser_mb_id').val('<?=$ser_mb_id?>').attr('selected','selected');</script>
<select name="sfl" id="sfl">
    <option value="">검색항목</option>
    <option value="apc_name" <?=get_selected($sfl, 'apc_name')?>>이름</option>
    <option value="apc_email" <?=get_selected($sfl, 'apc_email')?>>이메일</option>
    <option value="apc_hp" <?=get_selected($sfl, 'apc_hp')?>>휴대폰</option>
    <option value="apc_profile" <?=get_selected($sfl, 'apc_profile')?>>자기소개</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit btn_submit2" value="검색">
<div class="detaile_search <?=($_SESSION['ss_campaign_search_open'])?'on':'';?>">
	<?=($_SESSION['ss_campaign_search_open'])?'닫기':'상세';?> <i></i>
</div>
<div class="detaile_box <?=($_SESSION['ss_campaign_search_open'])?'open':'';?>">
	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption><?php echo $g5['title']; ?></caption>
			<colgroup>
				<col class="grid_4" style="width:8%;">
				<col style="width:38%;">
				<col class="grid_4" style="width:8%;">
				<col style="width:45%;">
			</colgroup>
			<tbody>
				<tr>
					<th>업직종</th>
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
                        <select id="apc_category1" name="apc_category1" apc_category1="<?=${$pre}['apc_category1']?>">
                            <option value="">업종선택</option>
                            <?=$category_form_depth0_options?>
                        </select> 
                        <script>$('select[name="apc_category1"]').val('<?//=${$pre}['apc_category1']?>');</script>
                        <select id="apc_category2" name="apc_category2" apc_category2="<?=${$pre}['apc_category2']?>">
                            <option value="">직종선택</option>
                            <?=$gugun_select?>
                        </select>
                        <script>$('select[name="apc_category2"]').val('<?//=${$pre}['trm_idx_category']?>');</script>
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
//                                if( $(this).val()==$('#apc_category1').attr('apc_category1') && $('#apc_category2').attr('apc_category2')!='' ) {
//                                    $('select[name="apc_category2"]').val( $('#apc_category2').attr('apc_category2') );
//                                }
                            });
                            $(document).on('change','#apc_category2',function(e){
//                                 console.log( $(this).val() );
//                                 console.log( $(this).find(':checked').text() );
                                 var this_idx = $(this).val();
                                 var this_name = $(this).find(':checked').text();
                                // 항목 추가
                                var cat_dom = '<label><input type="hidden" name="ser_category[]" id="ser_category_'+this_idx+'" value="'+this_idx+'">'+this_name+' <i class="fa fa-times"></i> </label>';
                                $('#div_category').append(cat_dom);
                            });
                            // 항목제거
                            $(document).on('click','#div_category i.fa-times',function(e){
                                $(this).closest('label').remove();
                            });
                        </script>
                        <div id="div_category">
                            <?php
                            if(is_array($ser_category)) {
                                foreach($ser_category as $k1=>$v1) {
                                    echo '<label><input type="hidden" name="ser_category[]" id="ser_category_'.$v1.'" value="'.$v1.'">'.$g5['category_name'][$v1].' <i class="fa fa-times"></i> </label>';
                                }
                            }
                            ?>
                        </div>
					</td>
					<th>지역</th>
					<td>
						<script>
						<?php
						for($i=0;$i<sizeof($g5['sigungu']);$i++) {
							if($g5['sigungu'][$i]['depth']==0) {
								echo 'var area'.$g5['sigungu'][$i]['term_idx'].' = {};'.PHP_EOL;
								$gugun_idx[$i] = explode(",",$g5['sigungu'][$i]['down_idxs']);
								$gugun_name[$i] = explode("^",$g5['sigungu'][$i]['down_names']);
                                
                                echo "area".$g5['sigungu'][$i]['term_idx']."['".$g5['sigungu'][$i]['term_idx']."'] = '".$g5['sigungu'][$i]['term_name']."전체';".PHP_EOL;
								for($j=1;$j<sizeof($gugun_idx[$i]);$j++) {
									echo "area".$g5['sigungu'][$i]['term_idx']."['".$gugun_idx[$i][$j]."'] = '".$gugun_name[$i][$j]."';".PHP_EOL;
									// 선택된 시도인 경우 select option 생성
									if($ser_area1==$g5['sigungu'][$i]['term_idx']) {
										$gugun_select .= '<option value="'.$gugun_idx[$i][$j].'">'.$gugun_name[$i][$j].'</option>';
									}
								}
							}
							// print_r2($g5['sigungu'][$i]);
						}
						?>
						// $.each(area9, function(i, v){
						// 	console.log(i+':'+v);
						// });
						</script>
						<select id="ser_area1" name="ser_area1" ser_area1="<?=$ser_area1?>">
							<option value="">시도선택</option>
							<?=$sigungu_form_depth0_options?>
						</select>
						<script>$('select[name="ser_area1"]').val('<?//=$ser_area1?>');</script>
						<select id="ser_area2" name="ser_area2" ser_area2="<?=$ser_area2?>">
							<option value="">구군선택</option>
							<?=$gugun_select?>
						</select>
						<script>$('select[name="ser_area2"]').val('<?//=$ser_area2?>');</script>
						<script>
							$(document).on('change','#ser_area1',function(e){
								// console.log( $(this).val() );
								$("option",'#ser_area2').remove(); // 구군 초기화
								$('#ser_area2').append("<option value=''>구군선택</option>");
								var this_area = "area"+$(this).val(); // 선택지역의 구군 Object
								$.each(eval(this_area), function(i, v){
									// console.log(i+':'+v);
									$('#ser_area2').append("<option value='"+i+"'>"+v+"</option>");
								});
								// 기존값이 있었다면 선택상태로 설정
//								if( $(this).val()==$('#ser_area1').attr('ser_area1') && $('#ser_area2').attr('ser_area2')!='' ) {
//									$('select[name="ser_area2"]').val( $('#ser_area2').attr('ser_area2') );
//								}
							});
                            $(document).on('change','#ser_area2',function(e){
                                var this_idx = $(this).val();
                                var this_sido = $('#ser_area1').find(':checked').text();
                                var this_name = $(this).find(':checked').text();
                                // 항목 추가 (전체라는 이름이 있으면 sido값만 추가)
                                if( /전체/.test( this_name ) ) {
                                    var addr_dom = '<label><input type="hidden" name="ser_area[]" value="'+this_sido+'">'+this_sido+' <i class="fa fa-times"></i> </label>';
                                }
                                else {
                                    var addr_dom = '<label><input type="hidden" name="ser_area[]" value="'+this_sido+' '+this_name+'">'+this_sido+' '+this_name+' <i class="fa fa-times"></i> </label>';
                                }
                                $('#div_area').append(addr_dom);
                            });
                            // 항목제거
                            $(document).on('click','#div_area i.fa-times',function(e){
                                $(this).closest('label').remove();
                            });
						</script>
                        <div id="div_area">
                            <?php
                            if(is_array($ser_area)) {
                                foreach($ser_area as $k1=>$v1) {
                                    echo '<label><input type="hidden" name="ser_area[]" value="'.$v1.'">'.$v1.' <i class="fa fa-times"></i> </label>';
                                }
                            }
                            ?>
                        </div>
					</td>
				</tr>
				<tr>
					<th>경력</th>
					<td>
						<input type="text" name="ser_st_apc_work_year" value="<?=$ser_st_apc_work_year?>" class="frm_input" style="width:40px"> 년
						~
						<input type="text" name="ser_en_apc_work_year" value="<?=$ser_en_apc_work_year?>" class="frm_input" style="width:40px"> 년
                        <span style="color:lightgray;">(예: 2.5년 = 2년6개월)</span>
					</td>
					<th>나이</th>
					<td>
						<input type="text" name="ser_st_age" value="<?=$ser_st_age?>" class="frm_input" style="width:40px"> 세
						~
						<input type="text" name="ser_en_age" value="<?=$ser_en_age?>" class="frm_input" style="width:40px"> 세
					</td>
				</tr>
				<tr>
					<th>연봉</th>
					<td>
						<input type="text" name="ser_st_pay" value="<?=$ser_st_pay?>" class="frm_input" style="width:60px"> 만원
						~
						<input type="text" name="ser_en_pay" value="<?=$ser_en_pay?>" class="frm_input" style="width:60px"> 만원
					</td>
					<th>성별</th>
					<td>
						<input type="radio" name="ser_gender" id="ser_gender_all" value="" checked=""><label for="ser_gender_all">전체</label>
						<?php
						if(is_array($g5['set_mb_gender_value'])) {
							foreach($g5['set_mb_gender_value'] as $k1=>$v1) {
								echo '<input type="radio" name="ser_gender" id="ser_gender_'.$k1.'" value="'.$k1.'"><label for="ser_gender_'.$k1.'">'.$v1.'</label>';
							}
						}
						?>
						<script>$('#ser_gender_<?=$ser_gender?>').attr('checked','checked');</script>
                    </td>
				</tr>
				<tr>
					<th>학력</th>
					<td>
						<input type="checkbox" name="ser_school_type[]" id="ser_school_type_highschool" value="highschool"><label for="ser_school_type_highschool">고등학교</label>
						<?php
						if(is_array($g5['set_school_type_value'])) {
							foreach($g5['set_school_type_value'] as $k1=>$v1) {
								echo '<input type="checkbox" name="ser_school_type[]" id="ser_school_type_'.$k1.'" value="'.$k1.'"><label for="ser_school_type_'.$k1.'">'.$v1.'</label>';
							}
						}
						?>
						<script>
						<?php
						if(is_array($ser_school_type)) {
							foreach($ser_school_type as $k1=>$v1) {
								?>
								// console.log('<?=$v1?>');
								$('input[id="ser_school_type_<?=$v1?>"]').attr('checked','checked');
								<?php
							}
						}
						?>
						</script>
					</td>
					<th>장애여부</th>
					<td>
						<input type="radio" name="ser_disability" id="ser_disability_all" value="" checked=""><label for="ser_disability_all">관계없음</label>
						<?php
                        if(is_array($g5['set_additional_disability_value'])) {
                            foreach ($g5['set_additional_disability_value'] as $k1=>$v1) {
                                echo '<input type="radio" name="ser_disability" id="ser_disability_'.$k1.'" value="'.$k1.'">
                                      <label for="ser_disability_'.$k1.'">'.$v1.'</label>'.PHP_EOL;
                            }
                        }                    
						?>
						<script>$('#ser_disability_<?=$ser_disability?>').attr('checked','checked');</script>
                    </td>
				</tr>
				<tr>
					<th>어학능력</th>
					<td>
                        <script>
                        <?php
                        if(is_array($g5['set_language_value'])) {
                            foreach ($g5['set_language_value'] as $k1=>$v1) {
            //                    echo $k1.'/'.$v1.'<br>';
                                echo 'var exam_'.$k1.' = {};'.PHP_EOL;

                                if(is_array($g5['set_exam_'.$k1.'_value'])) {
                                    foreach ($g5['set_exam_'.$k1.'_value'] as $k2=>$v2) {
                                        if($k2=='direct') {continue;}
                    //                    echo $k2.'/'.$v2.'<br>';
                                        // Object 변수생성
                                        echo "exam_".$k1."['".$k2."'] = '".$v2."';".PHP_EOL;

                                        // 선택된 항목인 경우 select option 생성
                                        if($lang_type2==$k1) {
                                            $exam_select .= '<option value="'.$k2.'">'.$v2.'</option>';
                                        }
                                    }
                                }                
                            }
                        }
                        ?>
                        </script>
                        <select name="lang_type2" id="lang_type2" language="<?=$lang_type2?>">
                            <option value="">외국어선택</option>
                            <?=$g5['set_language_value_options']?>
                        </select>
                        <script>$('#lang_type2').val('<?=$lang_type2?>');</script>

                        <select name="lang_content" id="lang_content" exam="<?=$lang_content?>">
                            <option value="">공인시험선택</option>
                            <?=$exam_select?>
                        </select>
                        <script>$('#lang_content').val('<?=$lang_content?>');</script>
                        <script>
                            $(document).on('change','#lang_type2',function(e){
                                // console.log( $(this).val() );
                                $("option",'#lang_content').remove(); // 2차항목 초기화
                                $('#lang_content').append("<option value=''>공인시험선택</option>");
                                var this_exam = "exam_"+$(this).val(); // 선택항목의 2차 Object
                                $.each(eval(this_exam), function(i, v){
    //								 console.log(i+':'+v);
                                    $('#lang_content').append("<option value='"+i+"'>"+v+"</option>");
                                });
                                // 기존값이 있었다면 선택상태로 설정
                                if( $(this).val()==$('#lang_type2').attr('language') && $('#lang_content').attr('exam')!='' ) {
                                    $('#lang_content').val( $('#lang_content').attr('exam') );
                                }
                            });
                        </script>
						<input type="text" name="ser_score" value="<?=$ser_score?>" class="frm_input" style="width:50px"> 점 이상
                        
					</td>
					<th>자격/교육</th>
					<td>
						<input type="text" name="ser_certificate" value="<?=$ser_certificate?>" class="frm_input" style="width:150px">
                    </td>
				</tr>
				<tr>
					<th>재직상태</th>
					<td>
						<input type="radio" name="ser_work_status" id="ser_work_status_all" value="" checked=""><label for="ser_work_status_all">관계없음</label>
						<?php
                        if(is_array($g5['set_work_status_value'])) {
                            foreach ($g5['set_work_status_value'] as $k1=>$v1) {
                                echo '<input type="radio" name="ser_work_status" id="ser_work_status_'.$k1.'" value="'.$k1.'">
                                      <label for="ser_work_status_'.$k1.'">'.$v1.'</label>'.PHP_EOL;
                            }
                        }                    
						?>
						<script>$('#ser_work_status_<?=$ser_work_status?>').attr('checked','checked');</script>
                    </td>
					<th>관리상태</th>
					<td>
						<input type="radio" name="ser_apc_status" id="ser_apc_status_all" value="" checked=""><label for="ser_apc_status_all">관계없음</label>
						<?php
                        if(is_array($g5['set_apc_status_value'])) {
                            foreach ($g5['set_apc_status_value'] as $k1=>$v1) {
                                if($k1=='trash') {continue;}
                                echo '<input type="radio" name="ser_apc_status" id="ser_apc_status_'.$k1.'" value="'.$k1.'">
                                      <label for="ser_apc_status_'.$k1.'">'.$v1.'</label>'.PHP_EOL;
                            }
                        }                    
						?>
						<script>$('#ser_apc_status_<?=$ser_apc_status?>').attr('checked','checked');</script>
                    </td>
				</tr>
				<tr>
					<th>채용공고</th>
					<td colspan="3">
                        <?php
                        if($ser_rct_idx) {
                            $rct = get_table_meta('recruit','rct_idx',$ser_rct_idx);
                        }
                        ?>
                        <input type="hidden" name="ser_rct_idx" value="<?=$rct['rct_idx']?>" class="frm_input"><!-- 공고idx -->
                        <input type="text" name="rct_subject" value="<?=$rct['rct_subject']?>" id="rct_subject" class="frm_input" style="width:300px;" readonly>
                        <a href="./recruit_select.php?file_name=<?php echo $g5['file_name']?>" class="btn btn_02 btn_recruit">찾기</a>
                    </td>
				</tr>
			</tbody>
		</table>

	</div>
	<div class="search_btn">
		<input type="submit" value="검색" class="search_btns search_btn01" accesskey="">
		<span class="search_btns search_btn02">닫기</span>
	</div>
</div>
<script>
// 채용공고 찾기
$(document).on('click','.btn_recruit',function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    winRecruit = window.open(href, "winRecruit", "left=100,top=100,width=520,height=600,scrollbars=1");
    winRecruit.focus();
    return false;

});
    
// 담당자 찾기
$(document).on('click','.btn_member',function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    winMember = window.open(href, "winMember", "left=100,top=100,width=520,height=600,scrollbars=1");
    winMember.focus();
    return false;

});
    
// 검색 부분 상세, 닫기 버튼 클릭
$(".detaile_search").click(function(){	
	if($(".detaile_box").hasClass("open") === true) {
		$(".detaile_box").removeClass("open");
		$(this).removeClass("on");
		$(this).html('상세 <i></i>');
		search_detail('close');
	} else {
		$(".detaile_box").addClass("open");
		$(this).addClass("on");
		$(this).html('닫기 <i></i>');
		search_detail('open');
	};
});
// 취소 버튼 클릭
$(".search_btn .search_btn02").click(function(){
	$(".detaile_box").removeClass("open");
	$(this).removeClass("on");
	$(".detaile_search").html('상세 <i></i>');
	search_detail('close');
});
function search_detail(flag) {
	$.getJSON(g5_user_admin_url+'/ajax/session_set.php',{"search_detail":flag},function(res) {
		if(res.result == true) {
			console.log(res.flag);
			console.log(res.msg);
		}
	});
}
</script>
</form>












<form name="form01" id="form01" action="./<?=$g5['file_name']?>_update.php" onsubmit="return form01_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="w" value="">
<input type="hidden" name="st_date" value="<?=$st_date?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="apc_list_chk">
            <label for="chkall" class="sound_only">전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">사진</th>
        <th scope="col" style="width:56px;">이름</th>
        <th scope="col" style="width:40px;">성별</th>
        <th scope="col">생년월일</th>
        <th scope="col">이메일</th>
        <th scope="col" style="width:100px;">휴대폰</th>
        <th scope="col">주소</th>
        <th scope="col">희망직종</th>
        <th scope="col">경력사항</th>
        <th scope="col" style="width:55px;">재직상태</th>
        <th scope="col">채용공고</th>
        <th scope="col" style="width:55px;">담당자</th>
        <th scope="col" style="width:55px;">상태</th>
        <th scope="col" style="width:55px;">접수일</th>
        <th scope="col">관리</th>
    </tr>
    <tr>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 담당자
        $row['mb'] = get_table('member','mb_id',$row['mb_id'],'mb_name');
        $row['mb_manager_text'] = $row['mb']['mb_name'] ? '<a href="?ser_mb_id='.$row['mb_id'].'">'.$row['mb']['mb_name'].'</a>'
                                                        : $row['apc_manager'];

		$fle_width = '30';
		$fle_height = '30';
		// 관련 파일 추출
		$sql = "SELECT * FROM {$g5['file_table']} 
				WHERE fle_db_table = 'applicant'
                    AND fle_db_id = '".$row['apc_idx']."'
                ORDER BY fle_sort, fle_reg_dt DESC
        ";
		$rs = sql_query($sql,1);
			//echo $sql;
		for($j=0;$row1=sql_fetch_array($rs);$j++) {
			$row[$row1['fle_type']][$row1['fle_sort']]['file'] = (is_file(G5_PATH.$row1['fle_path'].'/'.$row1['fle_name'])) ? 
								'&nbsp;&nbsp;'.$row1['fle_name_orig'].'&nbsp;&nbsp;<a href="'.G5_USER_ADMIN_URL.'/lib/download.php?file_fullpath='.urlencode(G5_PATH.$row1['fle_path'].'/'.$row1['fle_name']).'&file_name_orig='.$row1['fle_name_orig'].'">파일다운로드</a>'
								.'&nbsp;&nbsp;<input type="checkbox" name="'.$row1['fle_type'].'_del['.$row1['fle_sort'].']" value="1"> 삭제'
								:'';
			$row[$row1['fle_type']][$row1['fle_sort']]['fle_name'] = (is_file(G5_PATH.$row1['fle_path'].'/'.$row1['fle_name'])) ? 
								$row1['fle_name'] : '' ;
			$row[$row1['fle_type']][$row1['fle_sort']]['fle_path'] = (is_file(G5_PATH.$row1['fle_path'].'/'.$row1['fle_name'])) ? 
								$row1['fle_path'] : '' ;
			$row[$row1['fle_type']][$row1['fle_sort']]['exists'] = (is_file(G5_PATH.$row1['fle_path'].'/'.$row1['fle_name'])) ? 
								1 : 0 ;
		}

		// 대표이미지
		$fle_type3 = "applicant_list";
		if($row[$fle_type3][0]['fle_name']) {
			$row[$fle_type3][0]['thumbnail'] = thumbnail($row[$fle_type3][0]['fle_name'], 
							G5_PATH.$row[$fle_type3][0]['fle_path'], G5_PATH.$row[$fle_type3][0]['fle_path'],
							200, 200, 
							false, true, 'center', true, $um_value='85/3.4/15'
			);	// is_create, is_crop, crop_mode
			$row[$fle_type3][0]['thumbnail_img'] = '<img src="'.G5_URL.$row[$fle_type3][0]['fle_path'].'/'.$row[$fle_type3][0]['thumbnail'].'" width="'.$fle_width.'" height="'.$fle_height.'">';
		}
		else {
			$row[$fle_type3][0]['thumbnail'] = 'no_image.gif';
			$row[$fle_type3][0]['fle_path'] = '/theme/v10/img';
			$row[$fle_type3][0]['thumbnail_img'] = '<img src="'.G5_URL.$row[$fle_type3][0]['fle_path'].'/'.$row[$fle_type3][0]['thumbnail'].'" width="'.$fle_width.'" height="'.$fle_height.'">';
		}		
        // print_r2($row);
        
        
        // 버튼들
        $s_view = '<a href="./applicant_view.php?'.$qstr.'&apc_idx='.$row['apc_idx'].'" class="btn btn_03 btn_view">보기</a>';
        $s_mod = '<a href="./applicant_form.php?'.$qstr.'&w=u&apc_idx='.$row['apc_idx'].'" class="btn btn_03">수정</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>" tr_id="<?php echo $row['apc_idx'] ?>">
        <td class="td_chk">
            <input type="hidden" name="apc_idx[<?php echo $i ?>]" value="<?php echo $row['apc_idx'] ?>" id="apc_idx_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['apc_name']); ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_apc_phoso"><?=$row[$fle_type3][0]['thumbnail_img']?></td><!-- 사진 -->
        <td class="td_apc_name"><?=$row['apc_name']?></td><!-- 이름 -->
        <td class="td_apc_gender"><?=$g5['set_mb_gender_value'][$row['apc_gender']]?></td><!-- 성별 -->
        <td class="td_apc_birth"><?=$row['apc_birth']?></td><!-- 생년월일 -->
        <td class="td_apc_email"><?=$row['apc_email']?></td><!-- 이메일 -->
        <td class="td_apc_hp"><?=$row['apc_hp']?></td><!-- 휴대폰 -->
        <td class="td_apc_addr"><?=cut_str($row['apc_addr1'],10,'..')?></td><!-- 주소 -->
        <td class="td_apc_trm_idx_category"><?=$g5['category_name'][$row['trm_idx_category']]?></td><!-- 희망직종 -->
        <td class="td_apc_career"><?=$row['apc_work_year']?></td><!-- 경력사항 -->
        <td class="td_apc_work_status"><?=$g5['set_work_status_value'][$row['apc_work_status']]?></td><!-- 재직상태 -->
        <td class="td_rct_subject"><a href="?ser_rct_idx=<?=$row['rct_idx']?>" title="<?=$row['rct_subject']?>"><?=cut_str($row['rct_subject'],25,'..')?></a></td><!-- 채용공고 -->
        <td class="td_mb_name"><?=$row['mb_manager_text']?></td><!-- 담당자 -->
        <td class="td_apc_status"><!-- 상태 -->
            <select name="apc_status[<?php echo $i ?>]" id="apc_status_<?php echo $i ?>">
                <option value="">상태선택</option>
                <?php
                if(is_array($g5['set_apc_status_value'])) {
                    foreach($g5['set_apc_status_value'] as $k1=>$v1) {
                        echo '<option value="'.$k1.'" '.get_selected($row['apc_status'], $k1).'>'.$v1.'</option>';
                    }                    
                }
                ?>
            </select>
        </td>
        <td class="td_apc_reg_dt"><?=substr($row['apc_reg_dt'],5,5)?></td><!-- 접수일 -->
        <td class="td_admin">
			<?=$s_view?>
			<?=$s_mod?>
		</td>
    </tr>
    <?php
    }
    if ($i == 0)
        echo "<tr><td colspan='20' class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <?php
    // meta 변수 추출
    $sql = "SELECT * FROM {$g5['meta_table']} 
            WHERE mta_db_table='member/applicant'
                AND mta_db_id='".$member['mb_id']."'
                AND mta_key='applicant_select'
            LIMIT 1
    ";
//    echo $sql.'<br>';
    $row = sql_fetch($sql,1);
	$apc_idxs = $row['mta_value'] ? explode(',', preg_replace("/\s+/", "", $row['mta_value'] )) : [];
    ?>
    <?php if (!auth_check($auth[$sub_menu],'d',1)) { ?>
       <a href="javascript:" id="btn_message_all" class="btn btn_02 btn_left_edge2 btn_message_all" message_count="<?=$total_count?>">전체메시지(<?=number_format($total_count)?>)</a>
       <a href="javascript:" id="btn_message_select" class="btn btn_02 btn_right_edge btn_message_select" message_count="<?=count($apc_idxs)?>">선택메시지(<?=number_format(count($apc_idxs))?>)</a>
       <a href="javascript:alert('작업중입니다.')" id="btn_excel_upload" class="btn btn_02">엑셀등록</a>
       <a href="./<?=$fname?>_excel_down.php?<?=$qstr?>" id="btn_excel_down" total_count="<?=$total_count?>" class="btn btn_02" style="margin-right:100px;">엑셀다운</a>
    <?php } ?>
    <?php if(!auth_check($auth[$sub_menu],"d",1)) { ?>
        <input type="submit" name="act_button" value="선택담기" onclick="document.pressed=this.value" class="btn_02 btn">
        <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn_02 btn">
        <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn_02 btn">
    <?php } ?>
     <a href="./<?=$fname?>_form.php" id="btn_add" class="btn btn_01">추가하기</a> 
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<div id="modal01" title="엑셀 파일 업로드" style="display:none;">
    <form name="form02" id="form02" action="./<?=$fname?>_excel_upload.php" onsubmit="return form02_submit(this);" method="post" enctype="multipart/form-data">
        <table>
        <tbody>
        <tr>
            <td style="line-height:130%;padding:10px 0;">
                <ol>
                    <li>반드시 <span class="color_red">정해진 양식의 엑셀</span>을 사용하세요.</li>
                    <li>엑셀은 97-2003통합문서만 등록가능합니다. (*.xls파일로 저장)</li>
                    <li>엑셀은 하단에 탭으로 여러개 있으면 등록 안 됩니다. (한개의 독립 문서이어야 합니다.)</li>
                </ol>
            </td>
        </tr>
        <tr>
            <td style="padding:15px 0;">
                <input type="file" name="file_excel" onfocus="this.blur()">
            </td>
        </tr>
        <tr>
            <td style="padding:15px 0;">
                <button type="submit" class="btn btn_01">확인</button>
            </td>
        </tr>
        </tbody>
        </table>
    </form>
</div>

<script>
var posY;
$(function(e) {

    // 엑셀등록 버튼
    $( "#btn_excel_upload" ).on( "click", function(e) {
        e.preventDefault();
        $( "#modal01" ).dialog( "open" );
    });
    $( "#modal01" ).dialog({
        autoOpen: false
        , position: { my: "right-10 top-10", of: "#btn_excel_upload"}
    });

    // 엑셀다운
    $(document).on('click','#btn_excel_down',function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        var total_count = $(this).attr('total_count');
        if(total_count > 100) {
            if(confirm('데이터 숫자가 너무 많습니다.\n서버에 영향을 줄 수 있으므로 검색 범위를 줄여 주세요.\n그래도 다운로드하시겠습니까?')) {
                self.location.href = href;
            }
        }
        else {
            self.location.href = href;
        }
        return false;
    });
    
    // 메시지 발송
    $(document).on('click','.btn_message_all, .btn_message_select',function(e){
        e.preventDefault();
        var type = ( $(e.target).attr('id')=='btn_message_all' ) ? 'all':'select';
        var message_count = $(this).attr('message_count');
        if(message_count > 100) {
            if(confirm('전체메시지 발송 숫자가 너무 많습니다. 그래도 발송하시겠습니까?')) {
                message_win(type, message_count);
            }
        }
        else {
            message_win(type, message_count);
        }
        return false;
    });

    // 보기 버튼
    $(document).on('click','.btn_view',function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        winView = window.open(href, "winView", "left=100,top=100,width=900,height=700,scrollbars=1");
        winView.focus();
        return false;
    });

});

// 메시지 발송 함수
function message_win(type, count) {
    data_serialized = $('#fsearch').serialize();
    winMessage = window.open("./group_message.<?=$fname?>.php?type="+type+"&message_count="+count+"&"+data_serialized, "winMessage", "left=100,top=100,width=700,height=700,scrollbars=1");
    winMessage.focus();
}
    
    
function form01_submit(f)
{

    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

	if(document.pressed == "선택수정") {
		$('input[name="w"]').val('u');
	}
	if(document.pressed == "선택삭제") {
		if (!confirm("선택한 항목(들)을 정말 삭제 하시겠습니까?\n복구가 어려우니 신중하게 결정 하십시오.")) {
			return false;
		}
		else {
			$('input[name="w"]').val('d');
		} 
	}

    return true;
}

// 엑셀 등록 실행
function form02_submit(f) {
    if (!f.file_excel.value) {
        alert('엑셀 파일(.xls)을 입력하세요.');
        return false;
    }
    else if (!f.file_excel.value.match(/\.xls$|\.xlsx$/i) && f.file_excel.value) {
        alert('엑셀 파일만 업로드 가능합니다.');
        return false;
    }

    return true;
}
</script>

<?php
include_once ('./_tail.php');
?>
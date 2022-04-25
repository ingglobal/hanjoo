<?php
$sub_menu = "950100";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'w');
//print_r2($_REQUEST);
//exit;

// 변수 설정, 필드 구조 및 prefix 추출
$table_name = 'applicant';
$g5_table_name = $g5[$table_name.'_table'];
$fields = sql_field_names($g5_table_name);
$pre = substr($fields[0],0,strpos($fields[0],'_'));
$fname = preg_replace("/_form_update/","",$g5['file_name']); // _form_update를 제외한 파일명

// 변수 자동 설정
for($i=0;$i<sizeof($fields);$i++) {
    // 공백 제거
    $_POST[$fields[$i]] = @trim($_POST[$fields[$i]]);
    // 천단위 제거
    if(preg_match("/_price$/",$fields[$i]) || preg_match("/_point$/",$fields[$i]))
        $_POST[$fields[$i]] = preg_replace("/,/","",$_POST[$fields[$i]]);
}

// 변수 재설정
$_POST['apc_zip1'] = substr($_POST['apc_zip'], 0, 3);
$_POST['apc_zip2'] = substr($_POST['apc_zip'], 3);
$_POST['trm_idx_category'] = $_POST['apc_category2'];
$_POST['apc_update_dt'] = G5_TIME_YMD;


// 공통쿼리
$skips[] = $pre.'_idx';	// 건너뛸 변수 배열
$skips[] = $pre.'_reg_dt';
$skips[] = $pre.'_password';

//$adds[] = $pre.'_sort';	// 포함할 변수 배열
//$adds[] = $pre.'_memo';
//$adds[] = $pre.'_status';

// 공통쿼리
for($i=0;$i<sizeof($fields);$i++) {
    if(in_array($fields[$i],$skips)) {continue;}
    //if(in_array($fields[$i],$adds)) {
        $sql_commons[] = " ".$fields[$i]." = '".$_POST[$fields[$i]]."' ";
    //}
}

// after sql_common value setting
// $sql_commons[] = " com_idx = '".$_SESSION['ss_com_idx']."' ";

// 새로운 비번이 있는 경우에만 업데이트
if($_POST['apc_password']) {
    $new_pass = get_encrypt_string($_POST['apc_password']);
    $sql_commons[] = " apc_password = '".$new_pass."' ";
}


// 공통쿼리 생성
$sql_common = (is_array($sql_commons)) ? implode(",",$sql_commons) : '';


if ($w == '' || $w == 'c') {
    
    $sql = " INSERT INTO {$g5_table_name} SET 
                {$sql_common} 
                , ".$pre."_reg_dt = '".G5_TIME_YMDHIS."'
	";
    sql_query($sql,1);
	${$pre."_idx"} = sql_insert_id();
    
}
else if ($w == 'u') {
	
	${$pre} = get_table_meta($table_name, $pre.'_idx', ${$pre."_idx"});
    if (!${$pre}[$pre.'_idx'])
		alert('존재하지 않는 자료입니다.');
 
    $sql = "	UPDATE {$g5_table_name} SET 
					{$sql_common}
				WHERE ".$pre."_idx = '".${$pre."_idx"}."' 
	";
    //echo $sql.'<br>';
    sql_query($sql,1);

}
else if ($w == 'd') {

    $sql = "UPDATE {$g5_table_name} SET
                ".$pre."_status = 'trash'
            WHERE ".$pre."_idx = '".${$pre."_idx"}."'
    ";
    sql_query($sql,1);
    goto_url('./'.$fname.'_list.php?'.$qstr, false);

	//파일만 삭제
	${$pre} = get_table_meta($table_name, $pre.'_idx', ${$pre."_idx"});
	delete_jt_files(array("fle_db_table"=>$table_name, "fle_db_id"=>${$pre}['apc_idx'], "fle_delete_file"=>1));
    
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');




// 사진이미지 ----------------
$fle_type = "applicant_list";
for($i=0;$i<count($_FILES[$fle_type.'_file']['name']);$i++) {
	// 삭제인 경우
	if (${$fle_type.'_del'}[$i] == 1) {
		if($mb_id) {
			delete_jt_file(array("fle_db_table"=>$table_name, "fle_db_id"=>${$pre."_idx"}, "fle_type"=>$fle_type, "fle_sort"=>$i, "fle_delete"=>1));
		}
		else {
			// fle_db_id를 던져서 바로 삭제할 수도 있고 $fle_db_table, $fle_db_id, $fle_token 를 던져서 삭제할 수도 있음
			delete_jt_file(array("fle_db_table"=>$table_name
								,"fle_db_id"=>${$pre."_idx"}
								,"fle_type"=>$fle_type
								,"fle_sort"=>$i
								,"fle_delete"=>1
			));
		}
	}
	// 파일 등록
	if ($_FILES[$fle_type.'_file']['name'][$i]) {
		$upfile_info = upload_jt_file(array("fle_idx"=>$fle_idx
							,"mb_id"=>$member['mb_id']
							,"fle_src_file"=>$_FILES[$fle_type.'_file']['tmp_name'][$i]
							,"fle_orig_file"=>$_FILES[$fle_type.'_file']['name'][$i]
							,"fle_mime_type"=>$_FILES[$fle_type.'_file']['type'][$i]
							,"fle_content"=>$fle_content
							,"fle_path"=>'/data/'.$fle_type		//<---- 저장 디렉토리
							,"fle_db_table"=>$table_name
							,"fle_db_id"=>${$pre."_idx"}
							,"fle_type"=>$fle_type
							,"fle_sort"=>$i
		));
		//print_r2($upfile_info);
	}
}
// exit;

// 첨부파일 ----------------
$fle_type = "applicant_attach";
for($i=0;$i<count($_FILES[$fle_type.'_file']['name']);$i++) {
	// 삭제인 경우
	if (${$fle_type.'_del'}[$i] == 1) {
		if($mb_id) {
			delete_jt_file(array("fle_db_table"=>$table_name, "fle_db_id"=>${$pre."_idx"}, "fle_type"=>$fle_type, "fle_sort"=>$i, "fle_delete"=>1));
		}
		else {
			// fle_db_id를 던져서 바로 삭제할 수도 있고 $fle_db_table, $fle_db_id, $fle_token 를 던져서 삭제할 수도 있음
			delete_jt_file(array("fle_db_table"=>$table_name
								,"fle_db_id"=>${$pre."_idx"}
								,"fle_type"=>$fle_type
								,"fle_sort"=>$i
								,"fle_delete"=>1
			));
		}
	}
	// 파일 등록
	if ($_FILES[$fle_type.'_file']['name'][$i]) {
		$upfile_info = upload_jt_file(array("fle_idx"=>$fle_idx
							,"mb_id"=>$member['mb_id']
							,"fle_src_file"=>$_FILES[$fle_type.'_file']['tmp_name'][$i]
							,"fle_orig_file"=>$_FILES[$fle_type.'_file']['name'][$i]
							,"fle_mime_type"=>$_FILES[$fle_type.'_file']['type'][$i]
							,"fle_content"=>$fle_content
							,"fle_path"=>'/data/'.$fle_type		//<---- 저장 디렉토리
							,"fle_db_table"=>$table_name
							,"fle_db_id"=>${$pre."_idx"}
							,"fle_type"=>$fle_type
							,"fle_sort"=>$i
		));
//		 print_r2($upfile_info);
	}
}
// exit;


// 경력
for ($i=0; $i<count($_REQUEST['crr_chk']); $i++) {
    // 실제 번호를 넘김
    $k = $_REQUEST['crr_chk'][$i];

    $ar['apc_idx'] = ${$pre."_idx"};
    $ar['crr_idx'] = $_REQUEST['crr_idx'][$k];
    $ar['crr_company'] = $_REQUEST['crr_company'][$k];
    $ar['crr_start_year'] = $_REQUEST['crr_start_year'][$k];
    $ar['crr_start_month'] = $_REQUEST['crr_start_month'][$k];
    $ar['crr_end_year'] = $_REQUEST['crr_end_year'][$k];
    $ar['crr_end_month'] = $_REQUEST['crr_end_month'][$k];
    $ar['crr_pay'] = $_REQUEST['crr_pay'][$k];
    $ar['trm_idx_category'] = $_REQUEST['crr_category2'][$k];
    $ar['crr_job'] = $_REQUEST['crr_job'][$k];
    $ar['crr_quit_why'] = $_REQUEST['crr_quit_why'][$k];
    $crr_idx[$i] = career_update($ar);
//    print_r2($ar);
    unset($ar);
    
    // 경력 연수
    $crr = get_table('career','crr_idx',$crr_idx[$i]);
//    print_r2($crr);
    if($crr['crr_end_ym']!='-' && $crr['crr_start_ym']!='-' && $crr['crr_end_ym']>=$crr['crr_start_ym']) {
        $sql = " SELECT TIMESTAMPDIFF(MONTH, '".$crr['crr_start_ym']."-01', '".$crr['crr_end_ym']."-01') AS m ";
        $ym = sql_fetch($sql,1);
//        echo ($ym['m']+1).'개월<br>';
        $mtotal += ($ym['m']+1);
    }
}
//exit;

// 경력 연수 업데이트
$y = sprintf('%d', $mtotal/12);
$m = $mtotal%12;
$work_year = round($mtotal/12,2);
//echo $mtotal.' 총개월<br>';
//echo $y.'년<br>';
//echo $m.'개월<br>';
//echo $work_year.'<br>';
$sql = "	UPDATE {$g5_table_name} SET 
                ".$pre."_work_year = '".$work_year."' 
            WHERE ".$pre."_idx = '".${$pre."_idx"}."' 
";
//echo $sql.'<br>';
sql_query($sql,1);
//exit;


// 학력/자격/교육/어학
//print_r3($g5['set_shl_type1_value']);
if(is_array($g5['set_shl_type1_value'])) {
    foreach ($g5['set_shl_type1_value'] as $k1=>$v1) {
//        echo $k1.'/'.$v1.'<br>';
//        print_r2($_REQUEST[$k1]);
        for ($i=0; $i<count($_REQUEST[$k1]['shl_chk']); $i++) {
            // 실제 번호를 넘김
            $k = $_REQUEST[$k1]['shl_chk'][$i];

            $ar['apc_idx'] = ${$pre."_idx"};
            $ar['shl_idx'] = $_REQUEST[$k1]['shl_idx'][$k];
            $ar['shl_type1'] = $_REQUEST[$k1]['shl_type1'][$k];
            $ar['shl_type2'] = $_REQUEST[$k1]['shl_type2'][$k];
            $ar['shl_year'] = $_REQUEST[$k1]['shl_year'][$k];
            $ar['shl_month'] = $_REQUEST[$k1]['shl_month'][$k];
            $ar['shl_graduate_type'] = $_REQUEST[$k1]['shl_graduate_type'][$k];
            $ar['shl_title'] = $_REQUEST[$k1]['shl_title'][$k];
            $ar['shl_content'] = $_REQUEST[$k1]['shl_content'][$k];
            $ar['shl_score'] = $_REQUEST[$k1]['shl_score'][$k];
            $shl_idx[$i] = school_update($ar);
//            print_r2($ar);
            unset($ar);
//            echo $shl_idx[$i].'<br>';
        }
    }        
}
//exit;


// 추가사항
if(is_array($g5['set_additional_value'])) {
    foreach ($g5['set_additional_value'] as $k1=>$v1) {
        for ($i=0; $i<count($_REQUEST[$k1]['add_chk']); $i++) {
            // 실제 번호를 넘김
            $k = $_REQUEST[$k1]['add_chk'][$i];

            $ar['apc_idx'] = ${$pre."_idx"};
            $ar['add_idx'] = $_REQUEST[$k1]['add_idx'][$k];
            $ar['add_type'] = $_REQUEST[$k1]['add_type'][$k];
            $ar['add_start_year'] = $_REQUEST[$k1]['add_start_year'][$k];
            $ar['add_start_month'] = $_REQUEST[$k1]['add_start_month'][$k];
            $ar['add_end_year'] = $_REQUEST[$k1]['add_end_year'][$k];
            $ar['add_end_month'] = $_REQUEST[$k1]['add_end_month'][$k];
            $ar['add_value'] = $_REQUEST[$k1]['add_value'][$k];
            $ar['add_content'] = $_REQUEST[$k1]['add_content'][$k];
            $add_idx[$i] = additional_update($ar);
//            print_r2($ar);
            unset($ar);
        }
    }
}
//exit;



//-- 체크박스 값이 안 넘어오는 현상 때문에 추가, 폼의 체크박스는 모두 배열로 선언해 주세요.
$checkbox_array=array();
for ($i=0;$i<sizeof($checkbox_array);$i++) {
	if(!$_REQUEST[$checkbox_array[$i]])
		$_REQUEST[$checkbox_array[$i]] = 0;
}

//// 메타 입력 (디비에 있는 설정된 값은 입력하지 않는다.)
//$fields[] = "mms_zip";	// 건너뛸 변수명 배열
//$fields[] = "mms_sido_cd";	// 건너뛸 변수명 배열
//foreach($_REQUEST as $key => $value ) {
//	// 해당 테이블에 있는 필드 제외하고 테이블 prefix 로 시작하는 변수들만 업데이트
//	if(!in_array($key,$fields) && substr($key,0,3)==$pre) {
//		//echo $key."=".$_REQUEST[$key]."<br>";
//		meta_update(array("mta_db_table"=>$table_name,"mta_db_id"=>${$pre."_idx"},"mta_key"=>$key,"mta_value"=>$value));
//	}
//}


//exit;
//$qstr .= '&ser_department='.$ser_department.'&ser_mb_name_saler='.$ser_mb_name_saler.'&ser_mb_id_worker='.$ser_mb_id_worker;
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

//goto_url('./'.$fname.'_list.php?'.$qstr, false);
goto_url('./'.$fname.'_form.php?'.$qstr.'&w=u&'.$pre.'_idx='.${$pre."_idx"}, false);
?>
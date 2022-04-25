<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

if($member['mb_level']<4)
	alert_close('접근할 수 없는 페이지입니다.');

//print_r2($_REQUEST);
//exit;

$g5['title'] = '그룹메시지 발송';
include_once(G5_PATH.'/head.sub.php');
?>
<style>
.div_start,
.div_result {border:solid 1px #ddd;padding:10px;background:#f2f2f2;}
.div_start {margin-bottom:10px;}
.div_result {margin-top:10px;}
</style>
<div style="padding:10px;">
    <div class="div_start" style='border:solid 1px #ddd;margin-bottom:10px;padding:10px;background:#f2f2f2;'>
        <p>그룹 메시지 발송중 ...<p><font color=crimson><b>[끝]</b></font> 이라는 단어가 나오기 전에는 중간에 중지하지 마세요.</p>
    </div>
    <span id="cont"></span>
</div>
<?php
include_once(G5_PATH.'/tail.sub.php');


// 제목 & 내용
$subject = $_REQUEST['gme_subject'];
$content = ($_REQUEST['gme_type']=='hp') ? $_REQUEST['gme_hp_content'] : $_REQUEST['gme_content'];




$countgap = 10; // 몇건씩 보낼지 설정
$maxscreen = 500; // 몇건씩 화면에 보여줄건지?
$sleepsec = 200;  // 천분의 몇초간 쉴지 설정

flush();
ob_flush();


$sql_common = " FROM {$g5['applicant_table']} AS apc ";

$where = array();
//$where[] = " (1) ";   // 디폴트 검색조건
$where[] = " apc_status NOT IN ('delete', 'trash') ";


// 선택메시지인 경우 meta값에서 해당 정보 추출
if($type=='select') {
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
    if($apc_idxs[0])
        $where[] = " apc_idx IN (".implode(',',$apc_idxs).") ";
    else
        $where[] = " (0) ";
    
}
// 전체 발송인 경우는 검색조건을 추출한 후 발송
else {

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

    // 채용공고
    if ($ser_rct_idx) {
        $where[] = " apc.rct_idx = '".$ser_rct_idx."' ";
    }

    // 담당자
    if ($ser_mb_id) {
        $where[] = " mb_id = '".$ser_mb_id."' ";
    }

}


// 최종 WHERE 생성
if ($where)
    $sql_search = ' WHERE '.implode(' AND ', $where);


$sql = " SELECT *
		{$sql_common}
		{$sql_search}
";
//echo $sql.'<br>';
//exit;
$result = sql_query($sql,1);

$cnt = 0;
for ($i=0; $row=sql_fetch_array($result); $i++) {

    // 제목 및 내용 치환
    $patterns = array('/{이름}/','/{닉네임}/','/{회원아이디}/','/{이메일}/');
    $replacements = array($row['apc_name'],$row['apc_nick'],$row['mb_id'],$row['apc_email']);

    $subject = preg_replace($patterns, $replacements, $subject);
    $content = preg_replace($patterns, $replacements, $content);
    $from_email = ($member['mb_email']) ? $member['mb_email'] : $config['cf_admin_email'];

    if($gme_type=='email') {
        
        $sw = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $row['apc_email']);
        // 올바른 메일 주소만
        if ($sw == true) {
            $cnt++;

            // content 정보 추가
//            $mb_md5 = md5($row['mb_id'].$row['mb_email'].$row['mb_datetime']);
//            $content = $content.'<p>더 이상 정보 수신을 원치 않으시면 [<a href="'
//                        .G5_BBS_URL.'/email_stop.php?mb_id='.$row['mb_id'].'&amp;mb_md5='.$mb_md5.'" target="_blank">수신거부</a>] 해 주십시오.</p>';

            $message[$i] = mailer($config['cf_admin_email_name'], $from_email, $row['apc_email'], $subject, $content, 1);
            $status[$i] = ($message[$i]==1) ? 'ok' : 'fail';

            echo "<script> document.all.cont.innerHTML += '".$cnt.". ".$row['apc_email']." (".$row['apc_name'].")<br>'; </script>\n";
        }
        
        // 메일 발송 시 메일 주소
        $log['msg_email'] = $row['apc_email'];
    }
    else if($gme_type=='hp') {
        
        // 뿌리오 발송
        if(check_hp($row['apc_hp'])) {
            $cnt++;
            $ar['mb_id'] = $member['mb_id'];
            $ar['from_number'] = hyphen_hp_remove($member['mb_hp']);
            $ar['to_number'] = $row['apc_hp'];
            $ar['subject'] = $subject;
            $ar['content'] = $content;
//            $ar['content'] = $content.$i;
//            print_r2($ar);
            $message[$i] = ppurio_send($ar);
            unset($ar);
            $status[$i] = ($message[$i]->result=='ok') ? 'ok' : 'fail';
            $message[$i] = addslashes(serialize($message[$i]));

            echo "<script> document.all.cont.innerHTML += '".$cnt.". ".$row['apc_hp']." (".$row['apc_name'].")<br>'; </script>\n";
        }
        
        // 문자 발송 시 휴대폰 번호
        $log['msg_hp'] = $row['apc_hp'];
    }
    
    
    // 발송로그 입력
    $log['mb_id'] = $member['mb_id'];
    $log['msg_db_table'] = 'applicant/message/'.$gme_type;
    $log['msg_db_id'] = $member['mb_id'];
    $log['msg_type'] = $gme_type;
    $log['msg_subject'] = $subject;
    $log['msg_content'] = $content;
    $log['msg_result'] = $message[$i];
    $log['msg_status'] = $status[$i];
    message_insert($log);
    unset($log);
    

    //echo "+";
    flush();
    ob_flush();
    ob_end_flush();
    usleep($sleepsec);
    if ($cnt % $countgap == 0) {
        echo "<script> document.all.cont.innerHTML += '<br>'; document.body.scrollTop += 1000; </script>\n";
    }
    // 화면을 지운다... 부하를 줄임
    if ($cnt % $maxscreen == 0) {
        echo "<script> document.all.cont.innerHTML = ''; document.body.scrollTop += 1000; </script>\n";            
    }
    
}

// 그룹메시지 초기화
$ar['mta_db_table'] = 'member/applicant';
$ar['mta_db_id'] = $member['mb_id'];
$ar['mta_key'] = 'applicant_select';
$ar['mta_value'] = '';
meta_update($ar);
unset($ar);


?>
<script>
    document.all.cont.innerHTML += "<font style='font-size:1.5em;color:crimson;'><b>[끝]</b></font>";
    document.all.cont.innerHTML += "<div class='div_result'>총 <?php echo number_format($cnt) ?>건 발송</div>";
    document.body.scrollTop += 1000;
    // 부모창 새로고침
    opener.location.reload();
</script>

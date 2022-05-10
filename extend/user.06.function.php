<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// TimescaleDB 
if(!function_exists('sql_query_ps')){
function sql_query_ps($sql,$error=0)
{
    global $db;

	if(!$sql)
		return false;
    
    try {
        $db->query($sql);
        return true;
    }
    catch(PDOException $e) {
        if($error) {
            // return $e->getMessage();
            $result = die("<p>$sql<p>" . $e->getMessage() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
            return $result;
        }
        else 
            return $sql;
    }
}
}

// TimescaleDB 
// get_table_ps('g5_shop_item','it_id',215021535,'it_name')	// 4번째 매개변수는 테이블명과 같으면 생략할 수 있다.
if(!function_exists('get_table_ps')){
function get_table_ps($db_table,$db_field,$db_id,$db_fields='*')
{
    global $db;

	if(!$db_table||!$db_field||!$db_id)
		return false;
    
    $table_name = 'g5_1_'.$db_table;
    $sql = " SELECT ".$db_fields." FROM ".$table_name." WHERE ".$db_field." = '".$db_id."' LIMIT 1 ";
    //print_r3($sql);
    //echo $sql.'<br>';
    try {
        $stmt = $db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    return $row;
}
}


// 배너출력
if(!function_exists('display_banner10')){
function display_banner10($bo_table, $device, $skin_dir='', $skin='', $position, $subject_len=40, $cache_time=1)
{
    global $g5;

    if (!$position) $position = 'main';
    if (!$skin) $skin = 'boxbanner.skin.php';

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $banner_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/board/'.$match[1];
            if(!is_dir($banner_skin_path))
                $banner_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/board/'.$match[1];
            $banner_skin_url = str_replace(G5_PATH, G5_URL, $banner_skin_path);
        } else {
            $banner_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/board/'.$match[1];
            $banner_skin_url = str_replace(G5_PATH, G5_URL, $banner_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $banner_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/board/'.$skin_dir;
            $banner_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/board/'.$skin_dir;
        } else {
            $banner_skin_path = G5_SKIN_PATH.'/board/'.$skin_dir;
            $banner_skin_url  = G5_SKIN_URL.'/board/'.$skin_dir;
        }
    }

    // $cache_fwrite = false;
    $cache_fwrite = true;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/banner10-{$bo_table}-{$skin_dir}-{$skin}-{$device}-serial.php";

        if(!file_exists($cache_file)) {
            $cache_fwrite = true;
        } else {
            if($cache_time > 0) {
                $filetime = filemtime($cache_file);
                if($filetime && $filetime < (G5_SERVER_TIME - 3600 * $cache_time)) {
                    @unlink($cache_file);
                    $cache_fwrite = true;
                }
            }
            
            if(!$cache_fwrite) {
                try{
                    $file_contents = file_get_contents($cache_file);
                    $file_ex = explode("\n\n", $file_contents);
                    $caches = unserialize(base64_decode($file_ex[1]));
                    echo $file_contents;

                    $list = (is_array($caches) && isset($caches['list'])) ? $caches['list'] : array();
                    $bo_subject = (is_array($caches) && isset($caches['bo_subject'])) ? $caches['bo_subject'] : '';
                } catch(Exception $e){
                    $cache_fwrite = true;
                    $list = array();
                }
            }
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();
        
        // $device 관련
        $sql_device = (G5_IS_MOBILE) ? " AND wr_8 IN ('all','mo') " : " AND wr_8 IN ('all','pc') ";

        // 게시물 관련 정보
		$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
		$sql = "SELECT * FROM {$tmp_write_table}
                WHERE ca_name = '".$position."' AND wr_is_comment = 0
                    {$sql_device}
                ORDER BY convert(wr_7, decimal)
        ";
        // echo $sql.'<br>';
        $result = sql_query($sql,1);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
	        $row['file'] = get_file($bo_table, $row['wr_id']);
			
            $list[$i] = $row;
        }
        

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $caches = array(
                'list' => $list,
                );
            $cache_content = "<?php if (!defined('_GNUBOARD_')) exit; ?>\n\n";
            $cache_content .= serialize($caches);  //serialize

            fwrite($handle, $cache_content);
            fclose($handle);

            @chmod($cache_file, 0640);
        }
    }
    //print_r2($list);

    ob_start();
    include $banner_skin_path.'/'.$skin;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
}


// 네비 메뉴 출력
if(!function_exists('board_navi10')){
function board_navi10($bo_table, $device, $skin_dir='', $skin='', $subject_len=40, $cache_time=1)
{
    global $g5;

    if (!$skin) $skin = 'navi.skin.php';
    
    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $navi_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/board/'.$match[1];
            if(!is_dir($navi_skin_path))
                $navi_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/board/'.$match[1];
            $navi_skin_url = str_replace(G5_PATH, G5_URL, $navi_skin_path);
        } else {
            $navi_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/board/'.$match[1];
            $navi_skin_url = str_replace(G5_PATH, G5_URL, $navi_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $navi_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/board/'.$skin_dir;
            $navi_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/board/'.$skin_dir;
        } else {
            $navi_skin_path = G5_SKIN_PATH.'/board/'.$skin_dir;
            $navi_skin_url  = G5_SKIN_URL.'/board/'.$skin_dir;
        }
    }

    //$cache_fwrite = false;
    $cache_fwrite = true;
    if(G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH."/cache/navi10-{$bo_table}-{$skin_dir}-{$skin}-{$device}-serial.php";

        if(!file_exists($cache_file)) {
            $cache_fwrite = true;
        } else {
            if($cache_time > 0) {
                $filetime = filemtime($cache_file);
                if($filetime && $filetime < (G5_SERVER_TIME - 3600 * $cache_time)) {
                    @unlink($cache_file);
                    $cache_fwrite = true;
                }
            }
            
            if(!$cache_fwrite) {
                try{
                    $file_contents = file_get_contents($cache_file);
                    $file_ex = explode("\n\n", $file_contents);
                    $caches = unserialize(base64_decode($file_ex[1]));
                    echo $file_contents;

                    $list = (is_array($caches) && isset($caches['list'])) ? $caches['list'] : array();
                    $bo_subject = (is_array($caches) && isset($caches['bo_subject'])) ? $caches['bo_subject'] : '';
                } catch(Exception $e){
                    $cache_fwrite = true;
                    $list = array();
                }
            }
        }
    }

    if(!G5_USE_CACHE || $cache_fwrite) {
        $list = array();
        
        // $device 관련
        $sql_device_pc = ($device=='pc') ? " AND wr1.wr_1 = '' " : "";
        $sql_device_mobile = ($device=='mobile') ? " AND wr1.wr_2 = '' " : "";

        // 게시물 관련 정보
		$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
		$sql = "	SELECT wr1.wr_id, wr1.wr_reply, wr1.wr_subject, wr1.wr_link1, wr1.wr_file, wr1.wr_1, wr1.wr_2, wr1.wr_3, wr1.wr_4, wr1.wr_5, wr1.wr_10
						,GROUP_CONCAT(wr2.wr_subject ORDER BY wr2.wr_reply SEPARATOR '^') AS group_subject
						,GROUP_CONCAT(wr2.wr_content ORDER BY wr2.wr_reply SEPARATOR '^') AS group_content
						,GROUP_CONCAT(wr2.wr_link1 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_link1
						,GROUP_CONCAT(wr2.wr_1 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_wr_1
						,GROUP_CONCAT(wr2.wr_2 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_wr_2
						,GROUP_CONCAT(wr2.wr_3 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_wr_3
						,GROUP_CONCAT(wr2.wr_4 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_wr_4
						,GROUP_CONCAT(wr2.wr_5 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_wr_5
						,GROUP_CONCAT(wr2.wr_6 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_wr_6
						,GROUP_CONCAT(wr2.wr_10 ORDER BY wr2.wr_reply SEPARATOR '^') AS group_wr_10
						,COUNT(wr2.wr_id) AS group_count
					FROM {$tmp_write_table} AS wr1
						JOIN {$tmp_write_table} AS wr2
					WHERE wr1.wr_is_comment = 0 
                        {$sql_device_pc}
                        {$sql_device_mobile}
                        AND wr1.wr_4 = ''
                        AND wr1.wr_9 = '' AND wr2.wr_9 = ''
						AND wr1.wr_num = wr2.wr_num
						AND wr2.wr_reply LIKE CONCAT(wr1.wr_reply,'%')
					GROUP BY wr1.wr_num, wr1.wr_reply
					ORDER BY wr1.wr_num DESC, wr1.wr_reply
		";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
			// 단계
			$row['wr_depth'] = strlen($row['wr_reply']);
			
			// 그룹 배열 
			$row['group_subject_items'] = explode('^', $row['group_subject']);
			$row['group_content_items'] = explode('^', $row['group_content']);
			for ($j=0; $j<count($row['group_content_items']); $j++) {
				$row['group_content_items'][$j] = unserialize($row['group_content_items'][$j]);
			}
			$row['group_link1_items'] = explode('^', $row['group_link1']);
			$row['group_wr_1_items'] = explode('^', $row['group_wr_1']);
			$row['group_wr_2_items'] = explode('^', $row['group_wr_2']);
			$row['group_wr_3_items'] = explode('^', $row['group_wr_3']);
			$row['group_wr_4_items'] = explode('^', $row['group_wr_4']);
			$row['group_wr_5_items'] = explode('^', $row['group_wr_5']);
			$row['group_wr_6_items'] = explode('^', $row['group_wr_6']);
			$row['group_wr_10_items'] = explode('^', $row['group_wr_10']);
			
            $list[$i] = $row;
        }
        

        if($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $caches = array(
                'list' => $list,
                );
            $cache_content = "<?php if (!defined('_GNUBOARD_')) exit; ?>\n\n";
            $cache_content .= base64_encode(serialize($caches));  //serialize

            fwrite($handle, $cache_content);
            fclose($handle);

            @chmod($cache_file, 0640);
        }
    }
    //print_r2($list);

    ob_start();
    include $navi_skin_path.'/'.$skin;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
}

// 네비 정보 출력 (사용자단), 관리자단 부분은 skin단 list.html 참조
// $rtn 값이 없으면(디폴트) echo 로 li를 바로 뿌려준다.
if(!function_exists('put_navi_menu')){
function put_navi_menu($row, $rtn=0, $class_name='active')
{
    global $g5,$ca,$it,$bo_table,$cont;

    // 배열전체를 복사
    $list = $row;
    unset($row);
//    print_r2($list);

	// 메뉴 active 설정
//    echo $g5['navi_menu'].'<br>';
//    echo $list['wr_10'].'='.substr($g5['navi_menu'],0,($list['wr_depth']+1)*2).'<br>';
    // 게시물 링크인 경우 기본 active룰을 따른다.
	if($g5['navi_menu'])
		$list['wr_active'] = ( substr($g5['navi_menu'],0,($list['wr_depth']+1)*2) == $list['wr_10'] ) ? $class_name : '';
    
    // 게시판 링크만 있는 경우 (1단계메뉴와 2단계 메뉴가 같은 링크일 수 있으므로 예외처리해 줘야 함)
    if( !parse_url2($list['wr_link1'],"wr_id") && parse_url2($list['wr_link1'],"bo_table") ) {
        //print_r2($board);
        //echo $g5['navi_menu'].'/'.$board['bo_10'].'<br>';
        // 1단계인 경우는 게시판 앞에 두자리 코드만 같으면 active 처리해 줘야 함
        // 2단계인 경우는 bo_table까지 일치해야 한다.
        if($list['wr_depth']==0)
            $list['wr_active'] = ( substr($g5['navi_menu'],0,2) == $list['wr_10'] ) ? $class_name : '';
        else
            $list['wr_active'] = ( parse_url2($list['wr_link1'],"bo_table") == $bo_table && $g5['navi_menu'] == $list['wr_10'] ) ? $class_name : '';
    }
    // 쇼핑몰 카테고리 링크인 경우
    if( parse_url2($list['wr_link1'],"ca_id") ) {
        //print_r2($ca);
		$list['wr_active'] = ( $g5['navi_menu'] == $ca['ca_10'] ) ? $class_name : '';
    }
    // 상품 상세보기 링크인 경우
    if( parse_url2($list['wr_link1'],"it_id") ) {
        //print_r2($it);
		$list['wr_active'] = ( $g5['navi_menu'] == $it['it_10'] ) ? $class_name : '';
    }
    // 내용 콘텐츠인 경우
    if( parse_url2($list['wr_link1'],"co_id") ) {
        //print_r2($it);
		$list['wr_active'] = ( $g5['navi_menu'] == $cont['co_10'] ) ? $class_name : '';
    }
	
    // 새창 띄우기인지
    $list['wr_target'] = (!$list['wr_3']) ? '' : ' target="_blank"';
    //print_r2($list);
    
    // 링크 있으면
    if($list['wr_link1']) {
        // 링크에 link= 있으면 내부링크
        if( preg_match("/link=/",$list['wr_link1']) )
            $list['wr_link1'] = "javascript:scrollto('".parse_url2($list['wr_link1'],"link")."')";
        else
            $list['wr_link1'] = add_g5_url($list['wr_link1']);
    }
    else {
		$list['wr_link1'] = "javascript:";
    }
    // 링크 닫기
    $list['_a'] = ( $list['wr_link1'] ) ? '</a>' : '';


    // 첨부 파일이 있는 경우 (메뉴 이미지로 활용, 두개인 경우 오버 효과까지!)
    if( is_array($list['wr_file']) ) {
        $list['file'] = get_file($list['bo_table'], $list['wr_id']);
        // 첨부파일 썸네일 추출
        $list['thumb'] = get_list_thumbnail($list['bo_table'], $list['wr_id'], $thumb_width, $thumb_height, false, true);
        if($list['thumb']['src']) {
            $list['img'] = $list['thumb']['src'];
        } else {
            $list['img'] = G5_IMG_URL.'/no_img.png';
            $list['thumb']['alt'] = '이미지가 없습니다.';
        }
        $list['img_content'] = '<img src="'.$list['img'].'" alt="'.$list['thumb']['alt'].'" >';
    }
   
    $list['depth_no'] = ($list['wr_depth']==1) ? '1010' : '10';
    $list['depth_no'] = ($list['wr_depth']==2) ? '101010' : $list['depth_no'];
    
    // 항목 출력
    $list['li'] = '
        <li class="li'.$list['depth_no'].' '.$list['wr_active'].'">
            <a href="'.$list['wr_link1'].'" class="" '.$list['wr_target'].'>'.$list['wr_subject'].'</a>
    '.PHP_EOL;
    if(!$rtn) {echo $list['li'];}

    return $list;
}
}


// 뿌리오 메시지 발송
if(!function_exists('ppurio_send')){
function ppurio_send($arr)
{
	global $g5,$member;
    
    $_api_url = 'https://message.ppurio.com/api/send_utf8_json.php';     // UTF-8 인코딩과 JSON 응답용 호출 페이지

    $_param['userid'] = $g5['setting']['set_ppurio_userid'];           // [필수] 뿌리오 아이디
//    $_param['callback'] = hyphen_hp_remove($g5['setting']['set_ppurio_callback']);    // [필수] 발신번호 - 숫자만
    $_param['callback'] = trim($arr['from_number']);    // [필수] 발신번호 - 숫자만
    $_param['phone'] = hyphen_hp_remove($arr['to_number']);       // [필수] 수신번호 - 여러명일 경우 |로 구분 '010********|010********|010********'
    $_param['msg'] = $arr['content'];   // [필수] 문자내용 - 이름(names)값이 있다면 [*이름*]가 치환되서 발송됨
//    $_param['names'] = '';            // [선택] 이름 - 여러명일 경우 |로 구분 '홍길동|이순신|김철수'

    $_curl = curl_init();
    curl_setopt($_curl,CURLOPT_URL,$_api_url);
    curl_setopt($_curl,CURLOPT_POST,true);
    curl_setopt($_curl,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($_curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($_curl,CURLOPT_POSTFIELDS,$_param);
    $_result = curl_exec($_curl);
    curl_close($_curl);

    $_result = json_decode($_result);
/*
 * 응답값
 *
 *  <성공시>
 *    result : 'ok'                           - 전송결과 성공
 *    type   : 'sms'                          - 단문은 sms 장문은 lms 포토문자는 mms
 *    msgid  : '123456789'                    - 발송 msgid (예약취소시 필요)
 *    ok_cnt : 1                              - 발송건수
 *
 *  <실패시>
 *    result : 'invalid_member'               - 연동서비스 신청이 안 됐거나 없는 아이디
 *    result : 'under_maintenance'            - 요청시간에 서버점검중인 경우
 *    result : 'allow_https_only'             - http 요청인 경우
 *    result : 'invalid_ip'                   - 등록된 접속가능 IP가 아닌 경우
 *    result : 'invalid_msg'                  - 문자내용에 오류가 있는 경우
 *    result : 'invalid_names'                - 이름에 오류가 있는 경우
 *    result : 'invalid_subject'              - 제목에 오류가 있는 경우
 *    result : 'invalid_sendtime'             - 예약발송 시간에 오류가 있는 경우 (10분이후부터 다음해말까지 가능)
 *    result : 'invalid_sendtime_maintenance' - 예약발송 시간에 서버점검 예정인 경우
 *    result : 'invalid_phone'                - 수신번호에 오류가 있는 경우
 *    result : 'invalid_msg_over_max'         - 문자내용이 너무 긴 경우
 *    result : 'invalid_callback'             - 발신번호에 오류가 있는 경우
 *    result : 'once_limit_over'              - 1회 최대 발송건수 초과한 경우
 *    result : 'daily_limit_over'             - 1일 최대 발송건수 초과한 경우
 *    result : 'not_enough_point'             - 잔액이 부족한 경우
 *    result : 'over_use_limit'               - 한달 사용금액을 초과한 경우
 *    result : 'server_error'                 - 기타 서버 오류
 */
    
//    print_r2($_result);
    return $_result;
    
}
}

// 메시지발송로그
if(!function_exists('message_insert')){
function message_insert($arr)
{
	global $g5;
	
	if(!$arr['msg_content'])
		return 0;

	$sql = " INSERT INTO {$g5['message_table']} SET
				com_idx        		= '".$arr['com_idx']."'
				, mb_id        		= '".$arr['mb_id']."'
				, msg_db_table      = '".$arr['db_table']."'
				, msg_db_id      	= '".$arr['db_id']."'
				, msg_type        	= '".$arr['msg_type']."'
				, msg_hp        	= '".$arr['msg_hp']."'
				, msg_email        	= '".$arr['msg_email']."'
				, msg_subject       = '".$arr['msg_subject']."'
				, msg_content       = '".$arr['msg_content']."'
				, msg_result        = '".$arr['msg_result']."'
				, msg_status        = '".$arr['msg_status']."'
				, msg_reg_dt        = '".G5_TIME_YMDHIS."'
				, msg_update_dt     = '".G5_TIME_YMDHIS."'
	";
    sql_query($sql,1);
    $msg_idx = sql_insert_id();
    
    return $msg_idx;
}
}

                                             
// 추가사항
if(!function_exists('additional_update')){
function additional_update($arr)
{
	global $g5,$config;
	
	if(!$arr['apc_idx'])
		return 0;

    $g5_table_name = $g5['additional_table'];
    $fields = sql_field_names($g5_table_name);
    $pre = substr($fields[0],0,strpos($fields[0],'_'));
    
    // 변수 재설정
    $arr[$pre.'_update_dt'] = G5_TIME_YMDHIS;
    $arr['add_start_ym'] = $arr['add_start_year'].'-'.$arr['add_start_month'];   // 년월
    $arr['add_end_ym'] = $arr['add_end_year'].'-'.$arr['add_end_month'];   // 년월

    // 공통쿼리
    $skips[] = $pre.'_idx';	// 건너뛸 변수 배열
    $skips[] = $pre.'_reg_dt';
    for($i=0;$i<sizeof($fields);$i++) {
        if(in_array($fields[$i],$skips)) {continue;}
        $sql_commons[] = " ".$fields[$i]." = '".$arr[$fields[$i]]."' ";
    }

    // after sql_common value setting
    // $sql_commons[] = " com_idx = '".$arr['ss_com_idx']."' ";

    // 공통쿼리 생성
    $sql_common = (is_array($sql_commons)) ? implode(",",$sql_commons) : '';
    
    $sql = "SELECT * FROM {$g5_table_name} 
            WHERE add_idx = '{$arr['add_idx']}'
    ";
//    echo $sql.'<br>';
    $row = sql_fetch($sql,1);
	if($row[$pre."_idx"]) {
		$sql = "UPDATE {$g5_table_name} SET 
                    {$sql_common} 
				WHERE ".$pre."_idx = '".$row[$pre."_idx"]."'
        ";
		sql_query($sql,1);
	}
	else {
		$sql = "INSERT INTO {$g5_table_name} SET 
                    {$sql_common} 
                    , ".$pre."_reg_dt = '".G5_TIME_YMDHIS."'
        ";
		sql_query($sql,1);
        $row[$pre."_idx"] = sql_insert_id();
	}
//    echo $sql.'<br>';
    return $row[$pre."_idx"];
}
}

// 경력사항
if(!function_exists('career_update')){
function career_update($arr)
{
	global $g5,$config;
	
	if(!$arr['apc_idx'])
		return 0;

    $g5_table_name = $g5['career_table'];
    $fields = sql_field_names($g5_table_name);
    $pre = substr($fields[0],0,strpos($fields[0],'_'));
    
    // 변수 재설정
    $arr[$pre.'_update_dt'] = G5_TIME_YMDHIS;
    $arr['crr_start_ym'] = $arr['crr_start_year'].'-'.$arr['crr_start_month'];   // 년월
    $arr['crr_end_ym'] = $arr['crr_end_year'].'-'.$arr['crr_end_month'];   // 년월

    // 공통쿼리
    $skips[] = $pre.'_idx';	// 건너뛸 변수 배열
    $skips[] = $pre.'_reg_dt';
    for($i=0;$i<sizeof($fields);$i++) {
        if(in_array($fields[$i],$skips)) {continue;}
        $sql_commons[] = " ".$fields[$i]." = '".$arr[$fields[$i]]."' ";
    }

    // after sql_common value setting
    // $sql_commons[] = " com_idx = '".$arr['ss_com_idx']."' ";

    // 공통쿼리 생성
    $sql_common = (is_array($sql_commons)) ? implode(",",$sql_commons) : '';
    
    $sql = "SELECT * FROM {$g5_table_name} 
            WHERE crr_idx = '{$arr['crr_idx']}'
    ";
//    echo $sql.'<br>';
    $row = sql_fetch($sql,1);
	if($row[$pre."_idx"]) {
		$sql = "UPDATE {$g5_table_name} SET 
                    {$sql_common} 
				WHERE ".$pre."_idx = '".$row[$pre."_idx"]."'
        ";
		sql_query($sql,1);
	}
	else {
		$sql = "INSERT INTO {$g5_table_name} SET 
                    {$sql_common} 
                    , ".$pre."_reg_dt = '".G5_TIME_YMDHIS."'
        ";
		sql_query($sql,1);
        $row[$pre."_idx"] = sql_insert_id();
	}
//    echo $sql.'<br>';
    return $row[$pre."_idx"];
}
}


// 학력/자격/교육/어학
if(!function_exists('school_update')){
function school_update($arr)
{
	global $g5,$config;
	
	if(!$arr['apc_idx'])
		return 0;

    $g5_table_name = $g5['school_table'];
    $fields = sql_field_names($g5_table_name);
    $pre = substr($fields[0],0,strpos($fields[0],'_'));
    
    // 변수 재설정
    $arr[$pre.'_update_dt'] = G5_TIME_YMDHIS;
    $arr['shl_yearmonth'] = $arr['shl_year'].'-'.$arr['shl_month'];   // 년월

    // 공통쿼리
    $skips[] = $pre.'_idx';	// 건너뛸 변수 배열
    $skips[] = $pre.'_reg_dt';
    for($i=0;$i<sizeof($fields);$i++) {
        if(in_array($fields[$i],$skips)) {continue;}
        $sql_commons[] = " ".$fields[$i]." = '".$arr[$fields[$i]]."' ";
    }

    // after sql_common value setting
    // $sql_commons[] = " com_idx = '".$arr['ss_com_idx']."' ";

    // 공통쿼리 생성
    $sql_common = (is_array($sql_commons)) ? implode(",",$sql_commons) : '';
    
    $sql = "SELECT * FROM {$g5_table_name} 
            WHERE shl_idx = '{$arr['shl_idx']}'
    ";
//    echo $sql.'<br>';
    $row = sql_fetch($sql,1);
	if($row[$pre."_idx"]) {
		$sql = "UPDATE {$g5_table_name} SET 
                    {$sql_common} 
				WHERE ".$pre."_idx = '".$row[$pre."_idx"]."'
        ";
		sql_query($sql,1);
	}
	else {
		$sql = "INSERT INTO {$g5_table_name} SET 
                    {$sql_common} 
                    , ".$pre."_reg_dt = '".G5_TIME_YMDHIS."'
        ";
		sql_query($sql,1);
        $row[$pre."_idx"] = sql_insert_id();
	}
//    echo $sql.'<br>';
    return $row[$pre."_idx"];
}
}


// 휴대폰번호 정상적인지 체크 return=1 일 때 정상
if(!function_exists('check_hp')){
function check_hp($hp)
{
    $hp = hyphen_hp_number($hp);    // 하이픈(-)을 넣어준다.
//    echo $hp.'<br>';
    if ( preg_match( '/^(010|011|016|017|018|019)-[^0][0-9]{3,4}-[0-9]{4}/',$hp) ) {
        return 1;
    }
    else {
//        echo "잘못된 휴대폰 번호입니다. 숫자, - 를 포함한 숫자만 입력하세요.";
        return 0;
    }
}
}

// 휴대폰번호의 하이픈(-)을 제거하고 숫자만
if(!function_exists('hyphen_hp_remove')){
function hyphen_hp_remove($hp)
{
    $hp = preg_replace("/-/", "", trim($hp));
    return $hp;
}
}


?>
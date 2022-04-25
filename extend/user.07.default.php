<?php

// 로그인을 할 때마다 로그 파일 삭제해야 용량을 확보할 수 있음 
if(basename($_SERVER["SCRIPT_FILENAME"]) == 'login_check.php') {
	// 지난시간을 초로 계산해서 적어주시면 됩니다.
	$del_time_interval = 3600 * 2;	// Default = 2 시간

	// 이력서 파일 삭제
	if ($dir=@opendir(G5_DATA_PATH.'/resume')) {
	    while($file=readdir($dir)) {
            if($file == '.' || $file == '..')
                continue;

            $each_file = G5_DATA_PATH.'/resume/'.$file;
//            echo $each_file.'<br>';
	        if (!$atime=@fileatime($each_file))
	            continue;
	        if (time() > $atime + $del_time_interval)
	            unlink($each_file);
	    }
    }
    
    // // 5년이 지난 데이터 삭제
    // $del_limit_year = $g5['setting']['set_applicant_del_year'] ? $g5['setting']['set_applicant_del_year'] : 5;
    // $sql = "DELETE FROM {$g5['applicant_table']}
    //         WHERE apc_reg_dt < DATE_ADD(now() , INTERVAL -".$del_limit_year." YEAR)
    // ";
    // sql_query($sql,1);
//    echo $sql.'<br>';
//    exit;

}



// 뿌리오 발송결과
$set_values = explode("\n", $g5['setting']['set_ppurio_call_status']);
foreach ($set_values as $set_value) {
	list($key, $value) = explode('=', trim($set_value));
    if($key&&$value) {
        $g5['set_ppurio_call_status'][$key] = $value.' ('.$key.')';
        $g5['set_ppurio_call_status_value'][$key] = $value;
        $g5['set_ppurio_call_status_options'] .= '<option value="'.trim($key).'">'.trim($value).' ('.$key.')</option>';
        $g5['set_ppurio_call_status_value_options'] .= '<option value="'.trim($key).'">'.trim($value).'</option>';
    }
}
unset($set_values);unset($set_value);


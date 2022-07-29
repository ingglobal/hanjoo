<?php
include_once('./_common.php');

if($sorted){
$sort_arr = explode(',',$sorted);
echo json_encode($sort_arr);
for($i=1;$i<=count($sort_arr);$i++){
    $mta_mod_sql = " UPDATE {$g5['meta_table']} SET
                        mta_number = {$i}
                        ,mta_update_dt = '".G5_TIME_YMDHIS."'
                    WHERE mta_db_table = 'member' 
                        AND mta_db_id = '{$member['mb_id']}'
                        AND mta_key = 'dashboard_menu'
                        AND mta_status = 'ok'
                        AND mta_idx = '{$sort_arr[$i-1]}'
    ";
    sql_query($mta_mod_sql);
}    
}


//상태값이 trash로 된 이후 일주일이 지난 데이터는 회원을 불문하고 전부 삭제한다. 
$mta_rm_sql = " DELETE FROM {$g5['meta_table']}
                WHERE mta_db_table = 'member'
                    AND mta_key = 'dashboard_menu'
                    AND mta_status = 'trash'
                    AND mta_update_dt < DATE_SUB(NOW(), interval 7 day)
";
sql_query($mta_rm_sql);
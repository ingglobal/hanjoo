<?php
include_once('./_common.php');

if($sorted){
$sort_arr = explode(',',$sorted);
echo json_encode($sort_arr);
for($i=1;$i<=count($sort_arr);$i++){
    $mta_mod_sql = " UPDATE {$g5['meta_table']} SET
                        mta_number = {$i}
                    WHERE mta_db_table = 'member' 
                        AND mta_db_id = '{$member['mb_id']}'
                        AND mta_key = 'dashboard_menu'
                        AND mta_idx = '{$sort_arr[$i-1]}'
    ";
    sql_query($mta_mod_sql);
}    
}

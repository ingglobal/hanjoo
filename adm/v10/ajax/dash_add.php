<?php
include_once('./_common.php');
$meta_sql = " SELECT mta_idx FROM {$g5['meta_table']} 
                WHERE mta_db_table = 'member' 
                    AND mta_db_id = '{$member['mb_id']}'
                    AND mta_key = 'dashboard_menu'
                ORDER BY mta_number
";
$result = sql_query($meta_sql);
$cd_arr = array();
for($j=11;$j<90;$j++){
    $cd_arr[$j-10] = $j;
}
// echo json_encode($cd_arr);
// result->num_rows
$sort_num = 0;
if($result->num_rows){
$sort_num = $result->num_rows;
for($i=1;$row=sql_fetch_array($result);$i++){
    $mta_mod_sql = " UPDATE {$g5['meta_table']} SET
                        mta_value = '915{$cd_arr[$i]}0'
                        ,mta_number = {$i}
                    WHERE mta_db_table = 'member' 
                        AND mta_db_id = '{$member['mb_id']}'
                        AND mta_key = 'dashboard_menu'
                        AND mta_idx = '{$row['mta_idx']}'
    ";
    sql_query($mta_mod_sql);
}    
}
//array('915000', '대시보드', ''.G5_USER_ADMIN_URL.'/index.php', 'index');

$sort_num++;
echo $sort_num.':'.$cd_arr[$sort_num];
$sql = " INSERT INTO {$g5['meta_table']} SET
            mta_db_table = 'member'
            ,mta_db_id = '{$member['mb_id']}'
            ,mta_key = 'dashboard_menu'
            ,mta_value = '915{$cd_arr[$sort_num]}0'
            ,mta_title = '대시보드{$sort_num}'
            ,mta_number = '{$sort_num}'
";
sql_query($sql);
<?php
include_once('./_common.php');
$cd_arr = array();
for($j=11;$j<90;$j++){
    $cd_arr[$j-10] = $j;
}

//$mta_idx 값으로 개인별 packery 순서값도 삭제하도록 쿼리 추가해야 한다.(packery 개발완료후)


//해당 sub_menu코드의 메뉴를 삭제한다.
$mta_del_sql = " UPDATE {$g5['meta_table']} SET
                    mta_status = 'trash'
                    ,mta_update_dt = '".G5_TIME_YMDHIS."'
                WHERE mta_db_table = 'member'
                    AND mta_db_id = '{$member['mb_id']}'
                    AND mta_key = 'dashboard_menu'
                    AND mta_idx= '{$mta_idx}'
";
sql_query($mta_del_sql);

//남은 sub_menu코드의 메뉴들을 조회한다.
$mta_sql = " SELECT mta_idx FROM {$g5['meta_table']} 
                WHERE mta_db_table = 'member' 
                    AND mta_db_id = '{$member['mb_id']}'
                    AND mta_key = 'dashboard_menu'
                    AND mta_status = 'ok'
                ORDER BY mta_number
";
$result = sql_query($mta_sql);
$str = '';
if($result->num_rows){
for($i=1;$row=sql_fetch_array($result);$i++){
    $mta_mod_sql = " UPDATE {$g5['meta_table']} SET
                        mta_value = '915{$cd_arr[$i]}0'
                        ,mta_number = '{$i}'
                        ,mta_update_dt = '".G5_TIME_YMDHIS."'
                    WHERE mta_db_table = 'member'
                        AND mta_db_id = '{$member['mb_id']}'
                        AND mta_key = 'dashboard_menu'
                        AND mta_idx = '{$row['mta_idx']}'
                        AND mta_status = 'ok'
    ";
    $str .= $mta_mod_sql;
    sql_query($mta_mod_sql);
}
}
// echo $str;


//상태값이 trash로 된 이후 일주일이 지난 데이터는 회원을 불문하고 전부 삭제한다. 
$mta_rm_sql = " DELETE FROM {$g5['meta_table']}
                WHERE mta_db_table = 'member'
                    AND mta_key = 'dashboard_menu'
                    AND mta_status = 'trash'
                    AND mta_update_dt < DATE_SUB(NOW(), interval 7 day)
";
sql_query($mta_rm_sql);
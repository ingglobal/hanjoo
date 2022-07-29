<?php
$tmta_sql = " SELECT mta_idx,mta_value,mta_title,mta_number FROM {$g5['meta_table']} 
                WHERE mta_db_table = 'member' 
                    AND mta_db_id = '{$member['mb_id']}'
                    AND mta_key = 'dashboard_menu'
                ORDER BY mta_number
";
$tmresult = sql_query($tmta_sql,1);
$sub_menus = array();
$sub_menu_titles = array();
if($tmresult->num_rows){
for($i=0;$tmrow=sql_fetch_array($tmresult);$i++){
    $sub_menus[$tmrow['mta_idx']] = $tmrow['mta_value'];
    $sub_menu_titles[$tmrow['mta_idx']] = $tmrow['mta_title'];
}
}

if($tmresult->num_rows && !$idx) $sub_menu = $sub_menus[key($sub_menus)];
else if($tmresult->num_rows && $idx) $sub_menu = $sub_menus[$idx];
else $sub_menu = ($menu915_last)?$menu915_last[0]:'915900';
$sub_menu_title = ($sub_menu_titles[$idx])?$sub_menu_titles[$idx]:'대시보드';
$g5['title'] = $sub_menu_title;
// $sub_menu = '915110';
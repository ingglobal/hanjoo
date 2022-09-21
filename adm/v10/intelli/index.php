<?php
$sub_menu = "920110";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$g5['title'] = '실시간모니터링';
// include_once('./_top_menu_db.php');
include_once('./_head.php');
// echo $g5['container_sub_title'];

add_stylesheet('<link rel="stylesheet" href="'.G5_USER_ADMIN_URL.'/css/intelli/style.css">', 2);
if(is_file(G5_USER_ADMIN_PATH.'/css/intelli/'.$g5['file_name'].'.css')) {
    add_stylesheet('<link rel="stylesheet" href="'.G5_USER_ADMIN_URL.'/css/intelli/'.$g5['file_name'].'.css">', 2);
}
?>
<style>
</style>

<div class="local_desc01 local_desc" style="display:none;">
    <p>작업중!!</p>
</div>

<div class="div_recommend">
    <div class="title01">
        최적파라미타
        <span class="btn_more"><a href="./best_list.php">더보기</a></span>
    </div>
    <div class="cont01">
        <?php
        // 각 설비별로 최적값 추출
        if(is_array($g5['set_dicast_mms_idxs_array'])) {
            foreach($g5['set_dicast_mms_idxs_array'] as $k1=>$v1) {
                // echo $k1.'=>'.$v1.'<br>';
                $sql = "SELECT *
                        FROM {$g5['data_measure_best_table']}
                        WHERE mms_idx = '".$v1."'
                        ORDER BY dmb_reg_dt DESC
                        LIMIT 1
                ";
                // echo $sql.'<br>';
                $one = sql_fetch($sql,1);
                // print_r2($one);
                echo '<div class="rec_item">
                        <p>'.$g5['mms'][$one['mms_idx']]['mms_name'].'</p>
                        <strong>'.$one['dmb_dt'].'</strong>
                        <span>'.$one['dmb_min'].'~'.$one['dmb_max'].' ('.$one['dmb_group_count'].')</span>
                    </div>
                ';
            }
        }
        // print_r2($best);
        ?>
    </div>
</div>





<?php
include_once ('./_tail.php');
?>

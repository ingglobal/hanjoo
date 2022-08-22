<?php
// $sub_menu = '915110';
include_once('./_common.php');

$g5['title'] = '대시보드';
include_once ('./_head.php');
//$sub_menu : 현재 메뉴코드 915140
//$cur_mta_idx : 현재 메타idx 422

$demo = 0;  // 데모인 경우 1로 설정하세요.

$sql = " SELECT * FROM {$g5['dash_grid_table']} WHERE mta_idx = '{$cur_mta_idx}' AND dsg_status = 'ok' ORDER BY dsg_order ";
// echo $sql.'<br>';
$result = sql_query($sql,1);
?>
<style>
</style>
<?php if($result->num_rows){ 
echo '<div class="pkr">'.PHP_EOL;
echo '<div class="pkr-sizer"></div>'.PHP_EOL;

$acc_wd = 0;
$pos_x = 0;
$pos_json = '[';
for($i=0;$row=sql_fetch_array($result);$i++){
    $pkr_item_w = (!$row['dsg_width_num'])?:' pkr-item-w'.$row['dsg_width_num'];
    $pkr_item_h = (!$row['dsg_height_num'])?:' pkr-item-h'.$row['dsg_height_num'];
    $it_wd_per = $g5['set_pkr_size_value'][$row['dsg_width_num']] / 100;
    $test_acc_wd = $acc_wd + $it_wd_per;
    // echo $pkr_item_w.'<br>';
    //첫번째 그리드는 무조건
    if($i==0){
        $pos_x = $acc_wd;
        $acc_wd = $it_wd_per;
        $pos_json .= '{"attr":"'.$row['dsg_idx'].'","x":'.$pos_x.'}';
    }
    else{
        if($test_acc_wd > 1){
            $pos_x = 0;
            $acc_wd = $it_wd_per;
        }
        else{
            $pos_x = $acc_wd;
            $acc_wd += $it_wd_per;
        }
        $pos_json .= ',{"attr":"'.$row['dsg_idx'].'","x":'.$pos_x.'}';
    }
   
?>
<div class="pkr-item<?=$pkr_item_w.$pkr_item_h?>" dsg_idx="<?=$row['dsg_idx']?>">
    <div class="pkr-cont" style="display:<?=$demo?'none':''?>;">
    <div class="pkt_wrapper">
        <?php
        // 대시보드 내용 구성 -----------------
        $sql1 = "SELECT *
                FROM {$g5['member_dash_table']}
                WHERE dsg_idx = '".$row['dsg_idx']."'
        ";
        // echo $sql1.'<br>';
        $row = sql_fetch($sql1,1);
        $row['sried'] = get_serialized($row['mbd_setting']);
        // unset($row['sried']['data_series']);   // hide temporally for debuging.
        // print_r2($row['sried']);
        $row['data'] = json_decode($row['sried']['data_series'],true);
        unset($row['mbd_setting']);
        unset($row['sried']['data_series']);
        for($j=0;$j<sizeof($row['data']);$j++) {
            // print_r2($row['data'][$j]);
            $row['chr_names'][] = $row['data'][$j]['name'];
            $row['chr_mms_idxs'][] = $row['data'][$j]['id']['mms_idx']; // in order to check multi mms
            // target should be from local
            if($row['data'][$j]['id']['dta_json_file']=='output.target') {
                $row['data'][$j]['id']['dta_data_url'] = strip_http(G5_ADMIN_URL).'/v10/ajax';
            }
        }
        // 그래프 이름 (tag name array if not desiganated name.)
        $row['mbd_graph_name'] = $row['sried']['graph_name'] ?: implode(", ",$row['chr_names']);
        // mms 다중 아이콘 표현 (mms_idx 중복 제거)
        $row['chr_mms_idxs'] = array_unique($row['chr_mms_idxs']);
        for($j=0;$j<sizeof($row['chr_mms_idxs']);$j++) {
            $row['chr_mms_idx_icons'] .= '<i class="fa fa-circle"></i>';
        }
        ?>
        <div class="pkt_title"><?=$row['mbd_graph_name']?></div>
    </div>
    </div>
    <i class="fa fa-pencil-square grid_edit grid_mod" aria-hidden="true"></i>
    <i class="fa fa-window-close grid_edit grid_del" aria-hidden="true"></i>
</div><!--//.pkr-item-->
<?php 
}
$pos_json .= ']';
// $pos_arr = json_decode($pos_json,true);
// print_r2($pos_arr);
echo '</div>'.PHP_EOL;//.pkr
} else { 
?>
<div class="dash_empty" style="display:no ne;">
    <p>대시보드 데이터가 없습니다.</p>
</div>
<?php } ?>
<?php include_once('./index_1_packery_script.php'); ?>
<script>
<?php if($result->num_rows){ ?>
$(function(){
    //개별 그리드 삭제
    $('.grid_del').on('click',function(){
        if(!confirm("관련 데이터의 복구가 불가능 하오니\n신중하게 결정하세요.\n선택하신 데이터를 정말로 삭제하시겠습니까?")){
            return false;
        }
        var ajax_url = g5_user_admin_ajax_url+'/grid_del.php';
        var mta_idx = <?=$cur_mta_idx?>;
        var dsg_idx = $(this).parent().attr('dsg_idx');
    
        $.ajax({
            type: 'POST',
            url: ajax_url,
            // dataType: 'text',
            timeout: 30000,
            data: {'mta_idx': mta_idx, 'dsg_idx': dsg_idx},
            success: function(res){
                location.reload();
            },
            error: function(req){
                alert('Status: ' + req.status + ' \n\rstatusText: ' + req.statusText + ' \n\rresponseText: ' + req.responseText);
            }
        });
    });
    
    var grid_focus;
    var mta_idx = <?=$cur_mta_idx?>; 
    // 그리드 편집모드 버튼 클릭
    $('.grid_mod').on('click',function(){
        grid_focus = $(this).parent();
        $(this).addClass('focus');
        $(this).siblings('.pkr-cont').addClass('focus');
        $('#dsm').css('display','flex');
    });
    //모달 닫기 버튼 클릭
    $('#dsm_bg,#dsm_close').on('click',function(){
        grid_focus.find('.grid_mod').removeClass('focus');
        grid_focus.find('.pkr-cont').removeClass('focus');
        $('#dsm').css('display','none');

        grid_focus = null;
    });
});
<?php } ?>
//대시보드 타이틀 옆에 표시된 편집모드 토글버튼
$('.ds_edit_btn').on('click',function(){
    if($(this).hasClass('focus')){
        $(this).removeClass('focus');
        $('.bs_edit').hide();
        $('.grid_edit').hide();
    }
    else{
        $(this).addClass('focus');
        $('.bs_edit').show();
        $('.grid_edit').show();
    }
});
</script>
<?php
include_once ('./index_2_dash_modal.php');
include_once ('./_tail.php');
?>

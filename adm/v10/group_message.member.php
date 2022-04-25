<?php
// 호출페이지들
// /adm/v10/applicant_form.php: 지원자정보등록 - 채용공고검색
include_once('./_common.php');

if($member['mb_level']<4)
	alert_close('접근할 수 없는 페이지입니다.');

//print_r2($_REQUEST);
//exit;

// 검색어 
$gme_subject = isset($_REQUEST['gme_subject']) ? clean_xss_tags($_REQUEST['gme_subject'], 1, 1) : '';

$html_title = '그룹메시지 발송';

$g5['title'] = $html_title;
include_once(G5_PATH.'/head.sub.php');

$sql_common = " from {$g5['group_message_table']} ";
$sql_where = " where (1) ";

if($gme_subject){
    $gme_subject = preg_replace('/\!\?\*$#<>()\[\]\{\}/i', '', strip_tags($gme_subject));
    $sql_where .= " and gme_subject like '%".sql_real_escape_string($gme_subject)."%' ";
}

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common . $sql_where;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select *
            $sql_common
            $sql_where
        order by gme_idx DESC
        limit $from_record, $rows
";
$result = sql_query($sql);

$qstr1 = 'gme_subject='.urlencode($gme_subject).'&file_name='.$file_name.'&item='.$item;

// 선택메시지인 경우는 초기화 버튼
if($type=='select') {
    $btn_reset = '<a href="" class="btn_reset">초기화</a>';
}
?>
<style>
.btn_reset {font-weight:normal;font-size:0.8em;padding:1px 7px 2px;border:solid 1px #ddd;background:#f2f2f2;margin-left:5px;}
.td_gme_type {width:100px;}
.td_gme_subject {text-align:left !important;}
</style>

<div id="sch_member_frm" class="new_win scp_new_win">
    <h1><?=$g5['title']?> <span style="color:#13d434;">(발송예정: <?=number_format($message_count)?>)<?=$btn_reset?></span></h1>

    <form name="form01" id="form01" method="get">
    <?php
    // 넘겨받은 변수를 그대로 재선언해서 넘김
    foreach($_REQUEST as $key => $value ) {
//        echo $key.'='.$value.'<br>';
        echo '<input type="hidden" name="'.$key.'" value="'.$value.'" class="frm_input">';
    }
    ?>
    <div id="scp_list_find">
        <label for="gme_subject" class="sound_only">제목</label>
        <input type="text" name="gme_subject" id="gme_subject" value="<?php echo get_text($gme_subject); ?>" class="frm_input required" required size="40">
        <input type="submit" value="검색" class="btn_frmline">
    </div>
    </form>
    <div class="tbl_head01 tbl_wrap new_win_con">
        <table>
        <caption>검색결과</caption>
        <thead>
        <tr>
            <th>메시지타입</th>
            <th>제목</th>
            <th>보내기</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for($i=0; $row=sql_fetch_array($result); $i++) {
        ?>
        <tr>
            <td class="td_gme_type"><?php echo $g5['set_gme_type_value'][$row['gme_type']] ?></td>
            <td class="td_gme_subject"><?php echo get_text($row['gme_subject']); ?></td>
            <td class="td_mng td_mng_s">
                <a href="button" class="btn btn_03 btn_select"
                    gme_idx="<?=$row['gme_idx']?>"
                    gme_subject="<?=$row['gme_subject']?>"
                >보내기</button>
            </td>
        </tr>
        <?php
        }
        if($i ==0)
            echo '<tr><td colspan="4" class="empty_table">검색된 자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr1.'&amp;page='); ?>

</div>

<script>
// 초기화
$(".btn_reset").on( "click", function(e) {
    e.preventDefault();
    //-- 디버깅 Ajax --//
    $.getJSON(g5_user_admin_url+'/ajax/group_message.php',{"aj":"r1"},function(res) {
        //alert(res.sql);
            if(res.result == true) {
                // 부모창 새로고치고 창닫기
                opener.location.reload();
                window.close();
            }
            else {
                alert(reg.msg);
            }
    });
});

$('.btn_select').click(function(e){
    e.preventDefault();
    if(confirm('발송량이 많으면 시간이 걸릴 수 있습니다.\n발송하는 동안 창을 닫지 마세요.')) {
        data_serialized = $('#form01').serialize();
        var gme_idx = $(this).attr('gme_idx');
        self.location = './<?=$g5['file_name']?>_update.php?gme_idx='+gme_idx+'&'+data_serialized;       
    }
});
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
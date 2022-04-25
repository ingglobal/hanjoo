<?php
// 호출페이지들
// /adm/v10/applicant_form.php: 지원자정보등록 - 채용공고검색
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

if($member['mb_level']<4)
	alert_close('접근할 수 없는 페이지입니다.');

//print_r2($_REQUEST);
//exit;

$g5['title'] = '그룹메시지 발송';
include_once(G5_PATH.'/head.sub.php');

$gme['gme_type'] = 'email';

// 선택메시지인 경우는 초기화 버튼
if($type=='select') {
    $btn_reset = '<a href="" class="btn_reset">초기화</a>';
}
?>
<style>
.btn_reset {font-weight:normal;font-size:0.8em;padding:1px 7px 2px;border:solid 1px #ddd;background:#f2f2f2;margin-left:5px;}
.new_win_con td {height:40px;}
</style>

<div id="sch_member_frm" class="new_win scp_new_win">
    <h1><?=$g5['title']?> <span style="color:#13d434;">(발송예정: <?=number_format($message_count)?>)<?=$btn_reset?></span></h1>

    <form name="form01" id="form01" action="./<?=$g5['file_name']?>_update.php" onsubmit="return form01_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <?php
    // 넘겨받은 변수를 그대로 재선언해서 넘김
    foreach($_REQUEST as $key => $value ) {
        if(is_array($value)) {
            foreach($value as $k2 => $v2 ) {
                echo '<input type="hidden" name="'.$key.'[]" value="'.$v2.'" class="frm_input">'.PHP_EOL;
            }
        }
        else {
            echo '<input type="hidden" name="'.$key.'" value="'.$value.'" class="frm_input">'.PHP_EOL;
        }
    }
    ?>

    <div class="tbl_wrap new_win_con">
        <table>
        <tbody>
        <tr>
            <td><input type="text" name="gme_subject" value="<?php echo get_sanitize_input($gme['gme_subject']); ?>" id="gme_subject" required class="required frm_input" style="width:100%;" placeholder="제목"></td>
        </tr>
        <tr>
            <td style="padding-left:5px;">
                <?=$g5['set_gme_type_radios']?>
                <script>
                    $("input:radio[name=set_gme_type]").each(function(e) { $(this).attr('name','gme_type') });
                    $('#set_gme_type_<?=$gme['gme_type']?>').prop('checked','checked');
                </script>
            </td>
        </tr>
        <tr class="tr_sms" style="display:<?=($gme['gme_type']=='email')?'none':''?>">
            <td>
                <textarea name="gme_hp_content" id="gme_hp_content"><?php echo get_text($gme['gme_content']); ?></textarea>
            </td>
        </tr>
        <!-- display:none 하면 editor plugin 이 해당 에디터를 못 찾는 이슈가 있어서 setTimeout처리합니다. -->
        <tr class="tr_email">
            <td style="padding-top:<?=($gme['gme_type']=='email')?'10px':'700px'?>;">
                <?php echo editor_html("gme_content", get_text(html_purifier($gme['gme_content']), 0)); ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
    <div class="btn_top" style="text-align:center;">
        <input type="submit" class="btn_submit btn" accesskey="s" value="보내기">
        <a href="javascript:window.close()" class="btn btn_02">창닫기</a>
    </div>
    </form>

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

$(document).on('click','input[name=gme_type]',function(e){
    if( $(this).val() == 'email' ) {
        $('.tr_sms').hide();
        $('.tr_email').show();
        $('.tr_email td').css('padding-top','10px');
    }
    else {
        $('.tr_sms').show();
        $('.tr_email').hide();
    }    
});
    
<?php
if($gme['gme_type']!='email') {
?>
    setTimeout(function(){
        $('.tr_email').hide()
    },1000);
<?php
}
?>

    
function form01_submit(f) {

    errmsg = "";
    errfld = "";

    check_field(f.gme_subject, "제목을 입력하세요.");
    if(f.gme_type.value=='email') {
        <?php echo get_editor_js("gme_content"); ?>
        <?php echo chk_editor_js("gme_content"); ?>
    }
    else {
        check_field(f.gme_hp_content, "내용을 입력하세요.");
    }
    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    if(confirm('발송량이 많으면 시간이 걸릴 수 있습니다.\n발송하는 동안 창을 닫지 마세요.')) {
        return true;
    }
    return false;

}
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
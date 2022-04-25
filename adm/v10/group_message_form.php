<?php
$sub_menu = "950300";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'r');

$html_title = '그룹 메시지';

$gme_idx = isset($_GET['gme_idx']) ? (int) $_GET['gme_idx'] : 0;
$gme = array('gme_idx'=>0, 'gme_subject'=>'');

if ($w == 'u') {
    $html_title .= '수정';
    $readonly = ' readonly';

    $sql = " select * from {$g5['group_message_table']} where gme_idx = '{$gme_idx}' ";
    $gme = sql_fetch($sql,1);
//    print_r3($gme);
    if (!$gme['gme_idx'])
        alert('등록된 자료가 없습니다.');
} else {
    $html_title .= '입력';
    $gme['gme_type'] = 'email';
}

$g5['title'] = $html_title;
include_once('./_head.php');
?>

<div class="local_desc"><p>내용에 {이름}, {이메일}, {공고제목} 처럼 내용에 삽입하면 해당 내용에 맞게 변환하여 메시지를 발송합니다.</p></div>

<form name="fmailform" id="fmailform" action="./group_message_form_update.php" onsubmit="return fmailform_check(this);" method="post">
<input type="hidden" name="w" value="<?php echo $w ?>" id="w">
<input type="hidden" name="gme_idx" value="<?php echo $gme['gme_idx'] ?>" id="gme_idx">
<input type="hidden" name="token" value="" id="token">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="gme_subject">제목<strong class="sound_only">필수</strong></label></th>
        <td><input type="text" name="gme_subject" value="<?php echo get_sanitize_input($gme['gme_subject']); ?>" id="gme_subject" required class="required frm_input" size="100"></td>
    </tr>
    <tr>
        <th scope="row">메시지 타입</th>
        <td>
            <?=$g5['set_gme_type_radios']?>
            <script>
                $("input:radio[name=set_gme_type]").each(function(e) { $(this).attr('name','gme_type') });
                $('#set_gme_type_<?=$gme['gme_type']?>').prop('checked','checked');
            </script>
        </td>
    </tr>
    <tr class="tr_sms" style="display:<?=($gme['gme_type']=='email')?'none':''?>">
        <th scope="row"><label for="gme_sms_content">메시지 내용</label></th>
        <td>
            <textarea name="gme_hp_content" id="gme_hp_content"><?php echo get_text($gme['gme_content']); ?></textarea>
        </td>
    </tr>
    <!-- display:none 하면 editor plugin 이 해당 에디터를 못 찾는 이슈가 있어서 setTimeout처리합니다. -->
    <tr class="tr_email">
        <th scope="row"><label for="gme_content">메일 내용</label></th>
        <td style="padding-top:<?=($gme['gme_type']=='email')?'10px':'700px'?>;"><?php echo editor_html("gme_content", get_text(html_purifier($gme['gme_content']), 0)); ?></td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top ">
    <input type="submit" class="btn_submit btn" accesskey="s" value="확인">
</div>
</form>

<script>
$(document).on('click','input[name=gme_type]',function(e){
    if( $(this).val() == 'email' ) {
        $('.tr_sms').hide();
        $('.tr_email').show();
        $('.tr_email td').css('padding-top','0');
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

    
function fmailform_check(f)
{
    errmsg = "";
    errfld = "";

    check_field(f.gme_subject, "제목을 입력하세요.");
    //check_field(f.gme_content, "내용을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    <?php echo get_editor_js("gme_content"); ?>
    <?php // echo chk_editor_js("gme_content"); ?>

    return true;
}

document.fmailform.gme_subject.focus();
</script>

<?php
include_once('./_tail.php');
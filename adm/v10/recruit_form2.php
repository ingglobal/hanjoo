<?php
$sub_menu = "950200";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu],'w');

// 변수 설정, 필드 구조 및 prefix 추출
$table_name = 'recruit';
$g5_table_name = $g5[$table_name.'_table'];
$fields = sql_field_names($g5_table_name);
$pre = substr($fields[0],0,strpos($fields[0],'_'));
$fname = preg_replace("/_form/","",$g5['file_name']); // _form을 제외한 파일명
$qstr .= '&sca='.$sca.'&ser_cod_type='.$ser_cod_type; // 추가로 확장해서 넘겨야 할 변수들

if ($w == '') {
    $sound_only = '<strong class="sound_only">필수</strong>';
    $w_display_none = ';display:none';  // 쓰기에서 숨김

    ${$pre}[$pre.'_expire_date'] = date("Y-m-d",G5_SERVER_TIME + 86400*6);
    ${$pre}[$pre.'_status'] = 'ok';
}
else if ($w == 'u') {
    $u_display_none = ';display:none;';  // 수정에서 숨김

	${$pre} = get_table_meta($table_name, $pre.'_idx', ${$pre."_idx"});
    if (!${$pre}[$pre.'_idx'])
		alert('존재하지 않는 자료입니다.');
    // print_r3(${$pre});
    $mb1 = get_table_meta('member','mb_id',${$pre}['mb_id']);

}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');


// 라디오&체크박스 선택상태 자동 설정 (필드명 배열 선언!)
$check_array=array('mb_field');
for ($i=0;$i<sizeof($check_array);$i++) {
	${$check_array[$i].'_'.${$pre}[$check_array[$i]]} = ' checked';
}

$html_title = ($w=='')?'추가':'수정'; 
$g5['title'] = '채용공고 '.$html_title;
include_once ('./_head.php');
?>
<style>
    .bop_price {font-size:0.8em;color:#a9a9a9;margin-left:10px;}
    .btn_bop_delete {color:#0c55a0;cursor:pointer;margin-left:20px;}
    a.btn_price_add {color:#3a88d8 !important;cursor:pointer;}
</style>

<form name="form01" id="form01" action="./<?=$g5['file_name']?>_update.php" onsubmit="return form01_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="<?=$pre?>_idx" value="<?php echo ${$pre."_idx"} ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">

<div class="local_desc01 local_desc" style="display:no ne;">
    <p>항목을 입력하고 오른편 상단 [확인]을 클릭하세요.</p>
</div>

<div class="tbl_frm01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4" style="width:15%;">
		<col style="width:35%;">
		<col class="grid_4" style="width:15%;">
		<col style="width:35%;">
    </colgroup>
	<tbody>
    <tr>
        <?php
        $ar['id'] = 'rct_subject';
        $ar['name'] = '제목';
        $ar['type'] = 'input';
        $ar['width'] = '100%';
        $ar['value'] = ${$pre}[$ar['id']];
        $ar['required'] = 'required';
        echo create_td_input($ar);
        unset($ar);
        ?>
		<th scope="row">구분</th>
		<td>
            <select name="rct_type" id="rct_type">
                <option value="">선택하세요</option>
                <?=$g5['set_rct_type_options']?>
            </select>
            <script>$('select[name="rct_type"]').val('<?=${$pre}['rct_type']?>');</script>
		</td>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'rct_work_place';
        $ar['name'] = '근무지';
        $ar['type'] = 'input';
        $ar['width'] = '120px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
		<th scope="row">담당자</th>
		<td>
            <input type="hidden" name="mb_id" value="<?=$mb1['mb_id']?>" class="frm_input" style="width:100px">
            <input type="text" name="mb_name" value="<?=$mb1['mb_name']?>" class="frm_input" style="width:100px" readonly>
            <a href="./member_select.php?file_name=<?php echo $g5['file_name']?>" class="btn btn_02 btn_member">찾기</a>
		</td>
		<th scope="row">공고채널</th>
		<td>
            <select name="rct_channel" id="rct_channel">
                <option value="">선택하세요</option>
                <?=$g5['set_rct_channel_options']?>
            </select>
            <script>$('select[name="rct_channel"]').val('<?=${$pre}['rct_channel']?>');</script>
		</td>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'rct_work_place';
        $ar['name'] = '근무지';
        $ar['type'] = 'input';
        $ar['width'] = '120px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'rct_expire_date';
        $ar['name'] = '마감일';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
    </tr>
    <tr>
        <th scope="row">배포 URL</th>
        <td colspan="3">
            <?=help('잡코리아, 사람인, 인크루트 등에 배포하고 연결할 링크입니다. 아래 코드를 복사하시면 됩니다.')?>
            <a href="<?=G5_URL.'/recruit/?'.${$pre}['rct_idx']?>" target="_blank"><?='<div>'.G5_URL.'/recruit/?'.${$pre}['rct_idx']?></a>
            <br>------------아래처럼 채널별로 분리할 수도 있습니다만...(이건 아닌 걸로!!) <br>
            <?php
            if(is_array($g5['set_rct_channel'])) {
                foreach($g5['set_rct_channel_value'] as $k1=>$v1) {
//                    echo $k1.$v1.'<br>';
                    echo '<div>'.$v1.'<br>'.G5_URL.'/recruit/?'.${$pre}['rct_idx'].'&from='.$k1.'</div>';
                }
            }
            ?>
        </td>
    </tr>
    <tr>
        <th scope="row">내용</th>
        <td colspan="3">
            <?php echo editor_html("rct_content", get_text(${$pre}['rct_content'], 0)); ?>
        </td>
    </tr>
    <tr>
        <th scope="row">모바일내용</th>
        <td colspan="3">
            <?php echo editor_html("rct_mobile_content", get_text(${$pre}['rct_mobile_content'], 0)); ?>
        </td>
    </tr>
    <?php
    $ar['id'] = 'rct_memo';
    $ar['name'] = '관리자 메모';
    $ar['type'] = 'textarea';
    $ar['value'] = ${$pre}[$ar['id']];
    $ar['colspan'] = 3;
    echo create_tr_input($ar);
    unset($ar);
    ?>
    <tr>
        <th scope="row">상태</th>
        <td colspan="3">
            <select name="<?=$pre?>_status" id="<?=$pre?>_status"
                <?php if (auth_check($auth[$sub_menu],"d",1)) { ?>onFocus='this.initialSelect=this.selectedIndex;' onChange='this.selectedIndex=this.initialSelect;'<?php } ?>>
                <?=$g5['set_rct_status_options']?>
            </select>
            <script>$('select[name="<?=$pre?>_status"]').val('<?=${$pre}[$pre.'_status']?>');</script>
        </td>
    </tr>
	</tbody>
	</table>
</div>

<div class="btn_fixed_top">
    <a href="./<?=$fname?>_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey='s'>
</div>
</form>

<script>
$(function() {
    // 담당자 찾기
    $(document).on('click','.btn_member',function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        winMember = window.open(href, "winMember", "left=100,top=100,width=520,height=600,scrollbars=1");
        winMember.focus();
        return false;

    });    

    $("input[name$=_date]").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" });

    // 불량타입 숨김,보임
	$("input[name=rct_defect]").click(function(e) {
        if( $(this).val() == 1 ) {
            $('#rct_type').show();
        }
        else
           $('#rct_type').hide();
	});

    // 가격 입력 쉼표 처리
	$(document).on( 'keyup','input[name$=_price], #bom_moq, #bom_lead_time',function(e) {
//        console.log( $(this).val() )
//		console.log( $(this).val().replace(/,/g,'') );
        if(!isNaN($(this).val().replace(/,/g,'')))
            $(this).val( thousand_comma( $(this).val().replace(/,/g,'') ) );
	});

});

// 숫자만 입력
function chk_Number(object){
    $(object).keyup(function(){
        $(this).val($(this).val().replace(/[^0-9|-]/g,""));
    });
}

function form01_submit(f) {

    <?php echo get_editor_js("rct_content"); ?>
    <?php // echo chk_editor_js("rct_content"); ?>
    <?php echo get_editor_js("rct_mobile_content"); ?>
    <?php // echo chk_editor_js("rct_mobile_content"); ?>

    return true;
}

</script>

<?php
include_once ('./_tail.php');
?>

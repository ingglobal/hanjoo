<?php
$sub_menu = "950200";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu],'w');

// 변수 설정, 필드 구조 및 prefix 추출
$table_name = 'cast_shot_sub';
$g5_table_name = $g5[$table_name.'_table'];
$fields = sql_field_names($g5_table_name);
$pre = substr($fields[0],0,strpos($fields[0],'_'));
$fname = preg_replace("/_form/","",$g5['file_name']); // _form을 제외한 파일명
$qstr .= '&sca='.$sca.'&ser_cod_type='.$ser_cod_type; // 추가로 확장해서 넘겨야 할 변수들

if ($w == '') {
    $sound_only = '<strong class="sound_only">필수</strong>';
    $w_display_none = ';display:none';  // 쓰기에서 숨김

    ${$pre}[$pre.'_event_time'] = date("Y-m-d",G5_SERVER_TIME + 86400*6);
    ${$pre}[$pre.'_status'] = 'ok';
}
else if ($w == 'u'||$w == 'c') {
    $u_display_none = ';display:none;';  // 수정에서 숨김

	${$pre} = get_table_ps($table_name, $pre.'_idx', ${$pre."_idx"});
    if (!${$pre}[$pre.'_idx'])
		alert('존재하지 않는 자료입니다.');
    // print_r3(${$pre});

}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');


// 라디오&체크박스 선택상태 자동 설정 (필드명 배열 선언!)
$check_array=array('mb_field');
for ($i=0;$i<sizeof($check_array);$i++) {
	${$check_array[$i].'_'.${$pre}[$check_array[$i]]} = ' checked';
}

$html_title = ($w=='')?'추가':'수정';
$html_title = ($w=='c')?'복제':$html_title; 
$g5['title'] = '온도 '.$html_title;
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
        $ar['id'] = 'shot_id';
        $ar['name'] = '샷ID';
        $ar['type'] = 'input';
        $ar['value'] = ${$pre}[$ar['id']];
        $ar['required'] = 'required';
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'event_time';
        $ar['name'] = '발생시각';
        $ar['type'] = 'input';
        $ar['value'] = make_date(${$pre}[$ar['id']]);
        $ar['required'] = 'required';
        echo create_td_input($ar);
        unset($ar);
        ?>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'hold_temp';
        $ar['name'] = '보온로온도';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'upper_heat';
        $ar['name'] = '상형히트';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'lower_heat';
        $ar['name'] = '하형히트';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'upper_1_temp';
        $ar['name'] = '상금형1';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'upper_2_temp';
        $ar['name'] = '상금형2';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'upper_3_temp';
        $ar['name'] = '상금형3';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'upper_4_temp';
        $ar['name'] = '상금형4';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'upper_5_temp';
        $ar['name'] = '상금형5';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'upper_6_temp';
        $ar['name'] = '상금형6';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'lower_1_temp';
        $ar['name'] = '하금형1';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
    </tr>
    <tr>
        <?php
        $ar['id'] = 'lower_2_temp';
        $ar['name'] = '하금형2';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
        <?php
        $ar['id'] = 'lower_3_temp';
        $ar['name'] = '하금형3';
        $ar['type'] = 'input';
        $ar['width'] = '80px';
        $ar['value'] = ${$pre}[$ar['id']];
        echo create_td_input($ar);
        unset($ar);
        ?>
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

    $("input[name$=_date]").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" });

});

// 숫자만 입력
function chk_Number(object){
    $(object).keyup(function(){
        $(this).val($(this).val().replace(/[^0-9|-]/g,""));
    });
}

function form01_submit(f) {

    <?php // echo get_editor_js("rct_content"); ?>
    <?php // echo chk_editor_js("rct_content"); ?>

    return true;
}

</script>

<?php
include_once ('./_tail.php');
?>

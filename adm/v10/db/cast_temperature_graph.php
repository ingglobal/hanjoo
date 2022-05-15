<?php
$sub_menu = "925130";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$pre = 'css';
$fname = preg_replace("/_list/","",$g5['file_name']); // 파일명생성


$g5['title'] = '그래프(주조공정(SUB))';
include_once('./_top_menu_db.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

?>
<style>
#graph_wrapper {padding:0 5px;}
/* .local_sch01 {margin:0 0 10px;} */
.xbuttons {float:right;margin-right:8px;margin-bottom:3px;}
.xbuttons a {margin-left:2px;border:solid 1px #ddd;padding:2px 6px;}
.graph_wrap {position:relative;}
#report {display:none;position:absolute;top:0;left:0;}
#report span {border:solid 1px #bbb;}
#fchart {margin:0 0;}
#fchart .chr_name {font-weight:bold;font-size:1.5em;margin-right:6px;}
.table01 {width:auto;margin:0 auto;}
.table01 td {padding:7px 9px;}
.table01 td input {width:84px;-moz-outline: none;outline: none;ie-dummy: expression(this.hideFocus=true);}
.ui-slider-handle {-moz-outline: none;outline: none;ie-dummy: expression(this.hideFocus=true);}
.chr_control {display:none;}
#chr_type, #chr_line {height:30px;-moz-outline: none;outline: none;ie-dummy: expression(this.hideFocus=true);}
.chart_empty {text-align:center;height:200px;line-height:200px;}
.local_sch div {margin: 0;}
</style>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">총건수 </span><span class="ov_num"> <?php echo number_format($total_count) ?> </span></span>
</div>

<div class="local_desc01 local_desc" style="display:none;">
    <p>총건수가 65,411,218 이상이므로 기간 검색을 반드시 설정하세요. 하루 이상 입력 금지</p>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
기간:
<input type="text" name="st_date" value="<?php echo $st_date ?>" id="st_date" class="frm_input" style="width:80px;"> ~
<input type="text" name="en_date" value="<?php echo $en_date ?>" id="en_date" class="frm_input" style="width:80px;">
&nbsp;&nbsp;
<select name="sfl" id="sfl">
    <option value="WORK_SHIFT" <?=get_selected($sfl, 'WORK_SHIFT')?>>주야간</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>


<div class="tbl_head02 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<thead>
	<tr>
		<th scope="col">Idx</th>
		<th scope="col">샷ID</th>
		<th scope="col">발생시각</th>
		<th scope="col">보온로온도</th>
		<th scope="col">상형히트</th>
		<th scope="col">하형히트</th>
		<th scope="col">상금형1</th>
		<th scope="col">상금형2</th>
		<th scope="col">상금형3</th>
		<th scope="col">상금형4</th>
		<th scope="col">상금형5</th>
		<th scope="col">상금형6</th>
		<th scope="col">하금형1</th>
		<th scope="col">하금형2</th>
		<th scope="col">하금형3</th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<tbody class="tbl_body">
	<?php
    for ($i=0; $row=$stmt->fetch(PDO::FETCH_ASSOC); $i++) {

		// 스타일
		// $row['tr_bgcolor'] = ($i==0) ? '#fff7ea' : '' ;
		// $row['tr_color'] = ($i==0) ? 'blue' : '' ;

        $s_mod_a = '<a href="./'.$fname.'_form.php?'.$qstr.'&w=u&css_idx='.$row['css_idx'].'">';
        $s_mod = '<a href="./'.$fname.'_form.php?'.$qstr.'&w=u&css_idx='.$row['css_idx'].'" class="btn btn_03">수정</a>';
        $s_copy = '<a href="./'.$fname.'_form.php?'.$qstr.'&w=c&css_idx='.$row['css_idx'].'" class="btn btn_03">복제</a>';

        echo '
			<tr style="background-color:'.$row['tr_bgcolor'].';color:'.$row['tr_color'].'">
				<td>'.$s_mod_a.$row['css_idx'].'</a></td>
				<td>'.$row['shot_id'].'</td>
				<td>'.$row['event_time'].'</td>
				<td>'.$row['hold_temp'].'</td>
				<td>'.$row['upper_heat'].'</td>
				<td>'.$row['lower_heat'].'</td>
				<td>'.$row['upper_1_temp'].'</td>
				<td>'.$row['upper_2_temp'].'</td>
				<td>'.$row['upper_3_temp'].'</td>
				<td>'.$row['upper_4_temp'].'</td>
				<td>'.$row['upper_5_temp'].'</td>
				<td>'.$row['upper_6_temp'].'</td>
				<td>'.$row['lower_1_temp'].'</td>
				<td>'.$row['lower_2_temp'].'</td>
				<td>'.$row['lower_3_temp'].'</td>
				<td>'.$s_copy.'</td>
			</tr>
		';
	}
	if ($i == 0)
		echo '<tr class="no-data"><td colspan="8" class="text-center">등록(검색)된 자료가 없습니다.</td></tr>';
	?>
    </tbody>
    </table>
</div>
<!-- //리스트 테이블 -->

<script>
//-- $(document).ready 페이지로드 후 js실행 --//
$(document).ready(function(){
	$("#st_date,#en_date").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
		yearRange: "c-99:c+99",
		//maxDate: "+0d"
	});

	$( "#fsearch" ).submit(function(e) {
		if($('input[name=st_date]').val() > $('input[name=en_date]').val()) {
			alert('시작일이 종료일보다 큰 값이면 안 됩니다.');
			e.preventDefault();
		}
	});

});
</script>

<?php
include_once ('./_tail.php');
?>

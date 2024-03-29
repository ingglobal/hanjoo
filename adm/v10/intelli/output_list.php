<?php
$sub_menu = "920130";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$pre = 'css';
$fname = preg_replace("/_list/","",$g5['file_name']); // 파일명생성


$g5['title'] = '실시간데이터현황';
@include_once('./_top_menu_output.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

$sql_common = " FROM g5_1_xray_inspection ";

$where = array();
$where[] = " 1=1 ";   // 디폴트 검색조건

if ($stx) {
    switch ($sfl) {
		case ( $sfl == $pre.'_id' || $sfl == $pre.'_idx' ) :
            $where[] = " ({$sfl} = '{$stx}') ";
            break;
		case ($sfl == $pre.'_hp') :
            $where[] = " ({$sfl} LIKE '%{$stx}%') ";
            break;
       default :
            $where[] = " {$sfl} = '{$stx}' ";
            break;
    }
}

// 기간 검색
if ($st_date) {
    if ($st_time) {
        $where[] = " start_time >= '".$st_date.' '.$st_time."' ";
    }
    else {
        $where[] = " start_time >= '".$st_date.' 00:00:00'."' ";
    }
}
if ($en_date) {
    if ($en_time) {
        $where[] = " start_time <= '".$en_date.' '.$en_time."' ";
    }
    else {
        $where[] = " start_time <= '".$en_date.' 23:59:59'."' ";
    }
}

// 최종 WHERE 생성
if ($where)
    $sql_search = ' WHERE '.implode(' AND ', $where);


if (!$sst) {
    $sst = "start_time";
    $sod = "DESC";
}
$sql_order = " ORDER BY {$sst} {$sod} ";


if(sizeof($where)<=1) {
    $sql = " SELECT row_estimate AS cnt FROM hypertable_approximate_row_count('g5_1_xray_inspection') ";
}
else {
    $sql = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
}
$row = sql_fetch_pg($sql,1);
$total_count = $row['cnt'];


// $rows = $config['cf_page_rows'];
$rows = 100;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "SELECT *
        {$sql_common} {$sql_search} {$sql_order}
		LIMIT {$rows} OFFSET {$from_record}
";
// echo $sql.BR;
$result = sql_query_pg($sql,1);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

// 넘겨줄 변수가 추가로 있어서 qstr 별도 설정
$qstr = $qstr."&st_date=$st_date&en_date=$en_date"."&st_time=$st_time&en_time=$en_time";

add_stylesheet('<link rel="stylesheet" href="'.G5_USER_ADMIN_URL.'/js/timepicker/jquery.timepicker.css">', 0);
?>
<script type="text/javascript" src="<?=G5_USER_ADMIN_URL?>/js/timepicker/jquery.timepicker.js"></script>
<style>
.tbl_body td {text-align:center;border-bottom:solid 1px #e1e1e1;}
.td_dt {line-height:13px;}
.td_analysis {font-size:0.8em;}
.f_7 {font-size:0.7em;}
</style>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">총건수 </span><span class="ov_num"> <?php echo number_format($total_count) ?> </span></span>
</div>

<div class="local_desc01 local_desc" style="display:no ne;">
    <p>오른편 '분석' 항목의 아이콘을 클릭하여 관련 시간대 전후의 설비 상태 및 설비 알람을 확인하세요. &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-line-chart"></i> 측정그래프 &nbsp;&nbsp; <i class="fa fa-list-ul"></i> 설비알람</p>
    <p>엑셀다운로드를 하시면 검색한 결과를 엑셀파일로 다운로드합니다. 검색 범위를 선택하지 않으시면 현재 월의 데이터만 다운로드 됩니다. 검색범위를 너무 크게 잡지 마세요. (서버 부하 증가)</p>
    <p>기간검색 설정은 시작시간을 기준으로 검색합니다.</p>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
기간:
<input type="text" name="st_date" value="<?php echo $st_date ?>" id="st_date" class="frm_input" style="width:80px;"> ~
<input type="text" name="st_time" value="<?=$st_time?>" id="st_time" class="frm_input" autocomplete="off" style="width:65px;" placeholder="00:00:00">
~
<input type="text" name="en_date" value="<?php echo $en_date ?>" id="en_date" class="frm_input" style="width:80px;">
<input type="text" name="en_time" value="<?=$en_time?>" id="en_time" class="frm_input" autocomplete="off" style="width:65px;" placeholder="00:00:00">
&nbsp;&nbsp;
<select name="sfl" id="sfl">
    <option value="result" <?=get_selected($sfl, 'result')?>>결과</option>
    <option value="qrcode" <?=get_selected($sfl, 'qrcode')?>>QRCode</option>
    <option value="production_id" <?=get_selected($sfl, 'production_id')?>>생상품ID</option>
    <option value="work_shift" <?=get_selected($sfl, 'work_shift')?>>주야간</option>
    <option value="machine_id" <?=get_selected($sfl, 'machine_id')?>>설비번호</option>
    <?php
    for($i=1;$i<19;$i++) {
        echo '<option value="position_'.$i.'" '.get_selected($sfl, 'position_'.$i).'>'.$i.'번 포지션</option>';
    }
    ?>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>


<div class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<thead>
	<tr>
		<th scope="col">Idx</th>
		<th scope="col">작업일</th>
		<th scope="col">주야간</th>
		<th scope="col">시작~종료</th>
		<th scope="col">QRCode</th>
		<th scope="col">사양</th>
		<th scope="col">주조코드</th>
		<th scope="col">주조기</th>
		<th scope="col">주조시각</th>
		<th scope="col">생산품ID</th>
		<th scope="col">설비ID</th>
		<th scope="col">설비번호</th>
		<th scope="col">품질</th>
		<th scope="col">결과</th>
		<th scope="col">분석</th>
		<th scope="col" style="display:no ne;">관리</th>
	</tr>
	</thead>
	<tbody class="tbl_body">
	<?php
    for ($i=0; $row=sql_fetch_array_pg($result); $i++) {
        // 일반사양 - R, EV사양 - E
        $row['qrcode_ne'] = substr($row['qrcode'],6,1);

        // 주조코드
        $sql2 = " SELECT * FROM g5_1_qr_cast_code WHERE qrcode = '".$row['qrcode']."' ";
        // echo $sql2.'<br>';
        $row['cast'] = sql_fetch($sql2,1);
        // print_r3($row['cast']);
        // 주조시각
        $row['cast']['event_time_yn'] = (preg_match("/^[0-9][A-Z][0-9]{2}[0-9A-Z][0-9]{2}$/",$row['cast']['cast_code'])) ? 1 : 0;
        $row['cast']['event_dt'] = $row['cast']['event_time_yn'] ? substr($row['cast']['event_time'],5,11) : '';
        $row['cast']['mms_no'] = $row['cast']['event_time_yn'] ? substr($row['cast']['cast_code'],0,1) : 1;
        $row['cast']['cast_code'] = $row['cast']['event_time_yn'] ? $row['cast']['cast_code'] : '';
        $row['cast']['mms_name'] = $row['cast']['event_time_yn'] ? $g5['mms'][$g5['set_cast_code_no_value'][$row['cast']['mms_no']]]['mms_name'] : '';

        // 측정그래프 링크
        if($row['cast']['event_time_yn']) {
            $sql11 = " SELECT SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL -".$g5['setting']['set_cast_graph_before']." SECOND),1,10) AS st1_date
                        , SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL -".$g5['setting']['set_cast_graph_before']." SECOND),11,9) AS st1_time
                        , SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL +".$g5['setting']['set_cast_graph_after']." SECOND),1,10) AS en1_date
                        , SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL +".$g5['setting']['set_cast_graph_after']." SECOND),11,9) AS en1_time
                        , SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL -".$g5['setting']['set_cast_alarm_before']." SECOND),1,10) AS st2_date
                        , SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL -".$g5['setting']['set_cast_alarm_before']." SECOND),11,9) AS st2_time
                        , SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL +".$g5['setting']['set_cast_alarm_after']." SECOND),1,10) AS en2_date
                        , SUBSTRING(DATE_ADD('".$row['cast']['event_time']."' , INTERVAL +".$g5['setting']['set_cast_alarm_after']." SECOND),11,9) AS en2_time
            ";
            $dt = sql_fetch($sql11,1);
            $row['cast']['graph1'] = '<a href="../system/graph.php?st_date='.$dt['st1_date'].'&st_time='.$dt['st1_time'].'&en_date='.$dt['en1_date'].'&en_time='.$dt['en1_time'].'" target="_blank"><i class="fa fa-line-chart"></i></a>';
            $row['cast']['graph2'] = '<a href="../system/alarm_data_list.php?ser_mms_idx='.$g5['set_cast_code_no_value'][$row['cast']['mms_no']].'&st_date='.$dt['st2_date'].'&st_time='.$dt['st2_time'].'&en_date='.$dt['en2_date'].'&en_time='.$dt['en2_time'].'" target="_blank"><i class="fa fa-list-ul"></i></a>';
        }

		// 검사포인트
		for($j=0;$j<19;$j++) {
			$row['points_br'] = ($j%9==0 && $j>0) ? '<br>':'';
			$row['points'] .= '<a href="?'.$qstr.'&sfl=position_'.$j.'&stx='.$row['position_'.$j].'">'.$row['position_'.$j].'</a> '.$row['points_br'];
		}

		// 스타일
		// $row['tr_bgcolor'] = ($i==0) ? '#fff7ea' : '' ;
		// $row['tr_color'] = ($i==0) ? 'blue' : '' ;

        $s_mod_a = '<a href="./'.$fname.'_form.php?'.$qstr.'&w=u&xry_idx='.$row['xry_idx'].'">';
        $s_mod = '<a href="./'.$fname.'_form.php?'.$qstr.'&w=u&xry_idx='.$row['xry_idx'].'" class="btn btn_03">수정</a>';
        $s_copy = '<a href="./'.$fname.'_form.php?'.$qstr.'&w=c&xry_idx='.$row['xry_idx'].'" class="btn btn_03">복제</a>';

        echo '
            <tr tr_id="'.$i.'" style="background-color:'.$row['tr_bgcolor'].';color:'.$row['tr_color'].'">
                <td><span class="font_size_7">'.$row['xry_idx'].'</span></td>
                <td><span class="font_size_7">'.$row['work_date'].'</span></td>
                <td class="font_size_7">'.$g5['set_work_shift'][$row['work_shift']].'</td>
                <td class="td_dt"><span class="font_size_8">'.substr($row['start_time'],0,19).'<br>~'.substr($row['end_time'],0,19).'</span></td>
                <td class="f_7">'.$row['qrcode'].'</td>
                <td class="f_7">'.$row['qrcode_ne'].'</td>
                <td>'.$row['cast']['cast_code'].'</td>
                <td class="f_7">'.$row['cast']['mms_name'].'</td>
                <td class="f_7">'.$row['cast']['event_dt'].'</td>
                <td class="f_7">'.$row['production_id'].'</td>
                <td class="f_7">'.$row['machine_id'].'</td>
                <td class="font_size_7">'.$row['machine_no'].'</td>
                <td style="text-align:left;">'.$row['points'].'</td>
                <td>'.$row['result'].'</td>
                <td class="td_analysis">
                    '.$row['cast']['graph1'].'
                    &nbsp;
                    '.$row['cast']['graph2'].'
                </td>
                <td style="display:no ne;">'.$s_mod.'</td>
            </tr>
        ';
    }
	if ($i == 0)
		echo '<tr class="no-data"><td colspan="15" class="text-center">등록(검색)된 자료가 없습니다.</td></tr>';
	?>
    </tbody>
    </table>
</div>
<!-- //리스트 테이블 -->

<div class="btn_fixed_top" style="display:no ne;">
    <?php if($member['mb_manager_yn']) { ?>
        <a href="<?=G5_URL?>/device/xray/form.php" target="_blank" class="btn_04 btn">주조코드입력</a>
        <a href="./<?=$g5['file_name']?>_best.php" class="btn_04 btn btn_best" style="margin-right:50px;">최적파라메터임시생성</a>
        <a href="./<?=$fname?>_change.php" class="btn_04 btn btn_change">품질데이터조작</a>
        <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn_02 btn" style="display:none;">
        <?php } ?>
    <a href="./<?=$fname?>_excel_down.php?<?=$qstr?>" id="btn_add" class="btn btn_01">엑셀다운</a> 
    <a href="./<?=$fname?>_form.php" id="btn_add" class="btn btn_01" style="display:none;">추가하기</a> 
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<div id="modal20" title="날짜입력" style="display:none;">
    <form name="form20" id="form20" action="" onsubmit="return form20_submit(this);" method="post" enctype="multipart/form-data">
        <table>
        <tbody>
        <tr>
            <td style="line-height:130%;padding:10px 0;">
                <ul>
                    <li>시작날짜를 입력하세요.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="padding:5px 0;">
                <input type="text" name="ymd" class="frm_input" first="2019-07-01" value="<?=date("Y-m-d",G5_SERVER_TIME-86400*1)?>" placeholder="YYYY-MM-DD">
            </td>
        </tr>
        <tr>
            <td style="padding:5px 0;">
                <button type="submit" class="btn btn_01">확인</button>
            </td>
        </tr>
        </tbody>
        </table>
    </form>
</div>

<div id="modal30" title="날짜입력" style="display:none;">
    <form name="form30" id="form30" action="" onsubmit="return form30_submit(this);" method="post" enctype="multipart/form-data">
        <table>
        <tbody>
        <tr>
            <td style="line-height:130%;padding:10px 0;">
                <ul>
                    <li>시작날짜를 입력하세요.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="padding:5px 0;">
                <input type="text" name="ymd" class="frm_input" first="2019-07-01" value="<?=G5_TIME_YMD?>" placeholder="YYYY-MM-DD">
            </td>
        </tr>
        <tr>
            <td style="padding:5px 0;">
                <button type="submit" class="btn btn_01">확인</button>
            </td>
        </tr>
        </tbody>
        </table>
    </form>
</div>

<script>
//-- $(document).ready 페이지로드 후 js실행 --//
$(document).ready(function(){

    // 생성하기
    $( ".btn_best" ).on( "click", function(e) {
        e.preventDefault();
        $( "#modal20" ).dialog( "open" );
    });
    $( "#modal20" ).dialog({
        autoOpen: false
        , width:250
        , position: { my: "right-10 top-10", of: ".btn_best"}
    });
    // 일별가져오기
    $( ".btn_change" ).on( "click", function(e) {
        e.preventDefault();
        $( "#modal30" ).dialog( "open" );
    });
    $( "#modal30" ).dialog({
        autoOpen: false
        , width:250
        , position: { my: "right-10 top-10", of: ".btn_change"}
    });

    // timepicker 설정
    $("input[name$=_time]").timepicker({
        'timeFormat': 'H:i:s',
        'step': 10
    });

    // st_date chage
    $(document).on('focusin', 'input[name=st_date]', function(){
        // console.log("Saving value: " + $(this).val());
        $(this).data('val', $(this).val());
    }).on('change','input[name=st_date]', function(){
        var prev = $(this).data('val');
        var current = $(this).val();
        // console.log("Prev value: " + prev);
        // console.log("New value: " + current);
        if(prev=='') {
            $('input[name=st_time]').val('00:00:00');
        }
    });
    // en_date chage
    $(document).on('focusin', 'input[name=en_date]', function(){
        $(this).data('val', $(this).val());
    }).on('change','input[name=en_date]', function(){
        var prev = $(this).data('val');
        if(prev=='') {
            $('input[name=en_time]').val('23:59:59');
        }
    });

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

// specific day
function form20_submit(f) {
    var href = './<?=$g5['file_name']?>_best.php?ymd='+f.ymd.value;
    winBest = window.open(href, "winBest", "left=100,top=100,width=520,height=600,scrollbars=1");
    winBest.focus();
    $( "#modal20" ).dialog( "close" );
    return false;
}
function form30_submit(f) {
    var href = './<?=$g5['file_name']?>_change.php?ymd='+f.ymd.value;
    winChange = window.open(href, "winChange", "left=100,top=100,width=520,height=600,scrollbars=1");
    winChange.focus();
    $( "#modal30" ).dialog( "close" );
    return false;
}
</script>

<?php
include_once ('./_tail.php');
?>

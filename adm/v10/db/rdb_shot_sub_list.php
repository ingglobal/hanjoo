<?php
$sub_menu = "925130";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$g5['title'] = '주조공정(SUB)';
include_once('./_top_menu_db.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

// // 검색 조건
$st_date = ($st_date) ? $st_date : G5_TIME_YMD;
//$en_date = ($en_date) ? $en_date : '2016-03-31';
$en_date = ($en_date) ? $en_date : G5_TIME_YMD;

if($st_date > $en_date)
	alert("시작일이 종료일보다 큰 값이면 안 됩니다.");

$sql_common = " FROM {$g5['cast_shot_sub_table']} ";

$where = array();
$where[] = " (1) ";   // 디폴트 검색조건

if ($stx) {
    switch ($sfl) {
		case ( $sfl == $pre.'_id' || $sfl == $pre.'_idx' ) :
            $where[] = " ({$sfl} = '{$stx}') ";
            break;
		case ($sfl == $pre.'_hp') :
            $where[] = " REGEXP_REPLACE(mb_hp,'-','') LIKE '".preg_replace("/-/","",$stx)."' ";
            break;
		case ($sfl == 'event_time') :
            $where[] = " CONVERT(VARCHAR, {$sfl}, 23) = CONVERT(VARCHAR, '{$stx}', 23) ";
            break;
       default :
            $where[] = " ({$sfl} LIKE '%{$stx}%') ";
            break;
    }
}

// 날자 검색
if ($st_date) {
    $where[] = " event_time >= '".$st_date." 00:00:00' ";
}
if ($en_date) {
    $where[] = " event_time <= '".$en_date." 23:59:59' ";
}

// 최종 WHERE 생성
if ($where)
    $sql_search = ' WHERE '.implode(' AND ', $where);


if (!$sst) {
    $sst = "event_time";
    $sod = "DESC";
}
$sql_order = " ORDER BY {$sst} {$sod} ";


$sql = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql,1);
$total_count = $row['cnt'];


// $rows = $config['cf_page_rows'];
$rows = 100;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "SELECT *
        {$sql_common} {$sql_search} {$sql_order}
		LIMIT {$from_record}, {$rows}
";
// echo $sql.'<br>';
$result = sql_query($sql,1);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

// 넘겨줄 변수가 추가로 있어서 qstr 별도 설정
$qstr = $qstr."&st_date=$st_date&en_date=$en_date";
?>
<style>
.tbl_body td {text-align:center;}
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
	</tr>
	</thead>
	<tbody class="tbl_body">
	<?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

		// 스타일
		// $row['tr_bgcolor'] = ($i==0) ? '#fff7ea' : '' ;
		// $row['tr_color'] = ($i==0) ? 'blue' : '' ;

		echo '
			<tr style="background-color:'.$row['tr_bgcolor'].';color:'.$row['tr_color'].'">
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

<div class="btn_fixed_top">
    <?php if($member['mb_manager_yn']) { ?>
        <a href="javascript:" class="btn_04 btn btn_timescale" style="margin-right:50px;">TSDB입력</a>
        <a href="javascript:" class="btn_04 btn btn_copy" style="margin-right:50px;">내부복제</a>
        <a href="javascript:" class="btn_04 btn btn_sync_ymd">일별가져오기</a>
        <a href="javascript:" class="btn_04 btn btn_sync_ym">월별가져오기</a>
        <a href="javascript:" class="btn_04 btn btn_sync">가져오기</a>
    <?php } ?>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<div id="modal10" title="선택가져오기" style="display:none;">
    <form name="form10" id="form10" action="" onsubmit="return form10_submit(this);" method="post" enctype="multipart/form-data">
        <table>
        <tbody>
        <tr>
            <td style="line-height:130%;padding:10px 0;">
                <ul>
                    <li>ID를 입력하세요.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="padding:5px 0;">
                <input type="text" name="db_id" class="frm_input">
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

<div id="modal20" title="가져오기" style="display:none;">
    <form name="form20" id="form20" action="" onsubmit="return form20_submit(this);" method="post" enctype="multipart/form-data">
        <table>
        <tbody>
        <tr>
            <td style="line-height:130%;padding:10px 0;">
                <ul>
                    <li>시작월를 입력하세요.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="padding:5px 0;">
                <input type="text" name="ym" class="frm_input" first="2019-07" value="<?=substr(G5_TIME_YMD,0,-3)?>" placeholder="YYYY-MM">
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

<div id="modal30" title="가져오기" style="display:none;">
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

	// timescaleDB입력
    $(document).on('click','.btn_timescale',function(e){
        e.preventDefault();
        if(confirm('TSDB입력을 진행하시겠습니까?\n새창이 열리고 작업이 진행됩니다.\n진행하는 동안은 창을 닫지 마세요. 시간이 다소 걸릴 수 있습니다.')) {
            var href = '<?=G5_USER_URL?>/cron/<?=$g5['file_name']?>_timescale.php';
            winTimescale = window.open(href, "winTimescale", "left=100,top=100,width=520,height=600,scrollbars=1");
            winTimescale.focus();
            return false;
        }
    });

	// 내부복제
    $(document).on('click','.btn_copy',function(e){
        e.preventDefault();
        if(confirm('내부복제를 진행하시겠습니까?\n새창이 열리고 작업이 진행됩니다.\n진행하는 동안은 창을 닫지 마세요. 시간이 다소 걸릴 수 있습니다.')) {
            var href = './<?=$g5['file_name']?>_copy.php';
            var href = '<?=G5_USER_URL?>/cron/<?=$g5['file_name']?>_copy.php';
            winCopy = window.open(href, "winCopy", "left=100,top=100,width=520,height=600,scrollbars=1");
            winCopy.focus();
            return false;
        }
    });

	// 선택가져오기
    $( ".btn_sync_select" ).on( "click", function(e) {
        e.preventDefault();
        $( "#modal10" ).dialog( "open" );
    });
    $( "#modal10" ).dialog({
        autoOpen: false
        , width:250
        , position: { my: "right-10 top-10", of: ".btn_sync_select"}
    });
	// 월별가져오기
    $( ".btn_sync_ym" ).on( "click", function(e) {
        e.preventDefault();
        $( "#modal20" ).dialog( "open" );
    });
    $( "#modal20" ).dialog({
        autoOpen: false
        , width:250
        , position: { my: "right-10 top-10", of: ".btn_sync_ym"}
    });
	// 일별가져오기
    $( ".btn_sync_ymd" ).on( "click", function(e) {
        e.preventDefault();
        $( "#modal30" ).dialog( "open" );
    });
    $( "#modal30" ).dialog({
        autoOpen: false
        , width:250
        , position: { my: "right-10 top-10", of: ".btn_sync_ymd"}
    });
	// 가져오기
    $(document).on('click','.btn_sync',function(e){
        e.preventDefault();
        if(confirm('최신 정보 동기화를 진행하시겠습니까?\n새창이 열리고 동기화가 진행됩니다.\n진행하는 동안은 창을 닫지 마세요. 시간이 다소 걸릴 수 있습니다.')) {
            // var href = './<?=$g5['file_name']?>_sync.php';
            var href = '<?=G5_USER_URL?>/cron/<?=$g5['file_name']?>_sync.php';
            winSync = window.open(href, "winSync", "left=100,top=100,width=520,height=600,scrollbars=1");
            winSync.focus();
            return false;

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
function form10_submit(f) {
    if (!f.db_id.value) {
        alert('아이디를 입력하세요.');
        return false;
    }
    else {
        var href = './<?=$g5['file_name']?>_sync.php?db_id='+f.db_id.value;
        winSync = window.open(href, "winSync", "left=100,top=100,width=520,height=600,scrollbars=1");
        winSync.focus();
        $( "#modal10" ).dialog( "close" );
    }

    return false;
}
// specific month
function form20_submit(f) {
    // var href = './<?=$g5['file_name']?>_sync.php?ym='+f.ym.value;
    var href = '<?=G5_USER_URL?>/cron/<?=$g5['file_name']?>_sync.php?ym='+f.ym.value;
    winSync = window.open(href, "winSync", "left=100,top=100,width=520,height=600,scrollbars=1");
    winSync.focus();
    $( "#modal20" ).dialog( "close" );
    return false;
}
// specific month
function form30_submit(f) {
    var href = '<?=G5_USER_URL?>/cron/<?=$g5['file_name']?>_sync.php?ymd='+f.ymd.value;
    winSync = window.open(href, "winSync", "left=100,top=100,width=520,height=600,scrollbars=1");
    winSync.focus();
    $( "#modal30" ).dialog( "close" );
    return false;
}
</script>

<?php
include_once ('./_tail.php');
?>

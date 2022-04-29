<?php
$sub_menu = "950120";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$g5['title'] = '출탕현황';
include_once('./_head.php');
include_once('./_head.cubic.php');

// // 검색 조건
// $st_date = ($st_date) ? $st_date : date("Y-m",G5_SERVER_TIME).'-01';
// //$en_date = ($en_date) ? $en_date : '2016-03-31';
// $en_date = ($en_date) ? $en_date : G5_TIME_YMD;

// if($st_date > $en_date)
// 	alert("시작일이 종료일보다 큰 값이면 안 됩니다.");

$sql_common = " FROM MES_CHARGE_OUT "; 

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
		case ($sfl == 'WORK_DATE') :
            $where[] = " CONVERT(VARCHAR, {$sfl}, 23) = CONVERT(VARCHAR, '{$stx}', 23) ";
            break;
       default :
            $where[] = " ({$sfl} LIKE '%{$stx}%') ";
            break;
    }
}

// 날자 검색
if ($st_date) {
    $where[] = " WORK_DATE >= '".$st_date." 00:00:00' ";
}
if ($en_date) {
    $where[] = " WORK_DATE <= '".$en_date." 23:59:59' ";
}

// 최종 WHERE 생성
if ($where)
    $sql_search = ' WHERE '.implode(' AND ', $where);


if (!$sst) {
    $sst = "WORK_DATE";
    $sod = "DESC";
}
$sql_order = " ORDER BY {$sst} {$sod} ";


$sql = " SELECT COUNT(*) as CNT {$sql_common} {$sql_search} ";
// echo $sql.'<br>';
$result = $connect_db_pdo->query($sql);
$row=$result->fetch(PDO::FETCH_ASSOC);
$total_count = $row['CNT'];
// echo $total_count;
// exit;

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
$result = $connect_db_pdo->query($sql);

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
		<th scope="col">작업일</th>
		<th scope="col">주야간</th>
		<th scope="col">출탕시각</th>
		<th scope="col">출탕량</th>
		<th scope="col">출탕온도</th>
		<th scope="col">GBF후온도</th>
		<th scope="col">배탕주조기1(ID/NO)</th>
		<th scope="col">배탕주조기2(ID/NO)</th>
		<th scope="col">배탕주조기3(ID/NO)</th>
	</tr>
	</thead>
	<tbody class="tbl_body">
	<?php
	//echo $term_sql . '<br />';
	for ($i=0; $row=$result->fetch(PDO::FETCH_ASSOC); $i++) {
		
		// 스타일
		// $row['tr_bgcolor'] = ($i==0) ? '#fff7ea' : '' ;
		// $row['tr_color'] = ($i==0) ? 'blue' : '' ;
		
		echo '
			<tr style="background-color:'.$row['tr_bgcolor'].';color:'.$row['tr_color'].'">
				<td>'.$row['WORK_DATE'].'</td>
				<td>'.$cubic['set_work_shift'][$row['WORK_SHIFT']].'('.$row['WORK_SHIFT'].')</td>
				<td>'.$row['EVENT_TIME'].'</td>
				<td>'.$row['WEIGHT_OUT'].'</td>
				<td>'.$row['TEMP_OUT'].'</td>
				<td>'.$row['TEMP_GBF'].'</td>
				<td>'.$row['MACHINE_1_ID'].'/'.$row['MACHINE_1_NO'].'</td>
				<td>'.$row['MACHINE_2_ID'].'/'.$row['MACHINE_2_NO'].'</td>
				<td>'.$row['MACHINE_3_ID'].'/'.$row['MACHINE_3_NO'].'</td>
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
        <a href="javascript:" class="btn_04 btn btn_sync_select" style="display:none">선택가져오기</a>
        <a href="javascript:" class="btn_04 btn btn_sync_date">월별가져오기</a>
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


<script>
//-- $(document).ready 페이지로드 후 js실행 --//
$(document).ready(function(){
	// timescaleDB입력
    $(document).on('click','.btn_timescale',function(e){
        e.preventDefault();
        if(confirm('TSDB입력을 진행하시겠습니까?\n새창이 열리고 작업이 진행됩니다.\n진행하는 동안은 창을 닫지 마세요. 시간이 다소 걸릴 수 있습니다.')) {
            var href = './<?=$g5['file_name']?>_timescale.php';
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
	// 날짜가져오기
    $( ".btn_sync_date" ).on( "click", function(e) {
        e.preventDefault();
        $( "#modal20" ).dialog( "open" );
    });
    $( "#modal20" ).dialog({
        autoOpen: false
        , width:250
        , position: { my: "right-10 top-10", of: ".btn_sync_date"}
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
</script>

<?php
include_once ('./_tail.cubic.php');
include_once ('./_tail.php');
?>
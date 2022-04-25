<?php
$sub_menu = "960110";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$g5['title'] = '장입현황';
include_once('./_head.php');
include_once('./_head.cubic.php');

// // 검색 조건
// $st_date = ($st_date) ? $st_date : date("Y-m",G5_SERVER_TIME).'-01';
// //$en_date = ($en_date) ? $en_date : '2016-03-31';
// $en_date = ($en_date) ? $en_date : G5_TIME_YMD;

// if($st_date > $en_date)
// 	alert("시작일이 종료일보다 큰 값이면 안 됩니다.");

$sql_common = " FROM MES_CHARGE_IN "; 

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
		<th scope="col">장입시각</th>
		<th scope="col">총장입량</th>
		<th scope="col">인고트장입량</th>
		<th scope="col">스크랩장입량</th>
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
				<td>'.$row['WEIGHT_TOTAL'].'</td>
				<td>'.$row['WEIGHT_INGOT'].'</td>
				<td>'.$row['WEIGHT_SCRAP'].'</td>
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

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>


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
include_once ('./_tail.cubic.php');
include_once ('./_tail.php');
?>
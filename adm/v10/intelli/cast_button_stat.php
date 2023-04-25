<?php
$sub_menu = "920130";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$pre = 'mrk';
$fname = preg_replace("/_list/","",$g5['file_name']); // 파일명생성


$g5['title'] = '버튼누름통계';
@include_once('./_top_menu_output.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

// st_date, en_date
$st_date = $st_date ?: date("Y-m-d", G5_SERVER_TIME-86400*7); // -7일부터
$en_date = $en_date ?: date("Y-m-d");
$en_date2 = ($st_date==$en_date) ? '' : ' ~ '.$en_date; // wave(~) mark before en_date.

$st_time = $st_time ?: '00:00:00';
$en_time = $en_time ?: '23:59:59';

// 설비검색 조건, 설비번호가 기존 mes랑 달라서 조건 분기를 해야 함
if($ser_mms_idx) {
    $sql_mmses1 = " AND machine_id = '".$g5['mms'][$ser_mms_idx]['mms_idx2']."' ";
    $sql_mmses2 = " AND mms_idx = '".$ser_mms_idx."' ";
}

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>
<style>
.div_title_02f {font-size:2em;margin-bottom:10px;font-weight:bold;}
</style>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
</div>

<div class="local_desc01 local_desc" style="display:none;">
    <p>PLC값은 순차적으로 증가되는 값입니다. 참고값입니다.</p>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get" autocomplete="off">
<label for="sfl" class="sound_only">검색대상</label>
<?php
// 해당 범위 안의 모든 설비를 select option으로 만들어서 선택할 수 있도록 한다.
// Get all the mms_idx values to make them optionf for selection.
$sql2 = "SELECT mms_idx, mms_name
        FROM {$g5['mms_table']}
        WHERE com_idx = '".$_SESSION['ss_com_idx']."'
        ORDER BY mms_idx       
";
// echo $sql2.'<br>';
$result2 = sql_query($sql2,1);
?>
<select name="ser_mms_idx" id="ser_mms_idx">
    <option value="">설비전체</option>
    <?php
    for ($i=0; $row2=sql_fetch_array($result2); $i++) {
        // print_r2($row2);
        echo '<option value="'.$row2['mms_idx'].'" '.get_selected($ser_mms_idx, $row2['mms_idx']).'>'.$row2['mms_name'].'('.$row2['mms_idx'].')</option>';
    }
    ?>
</select>
<script>$('select[name=ser_mms_idx]').val("<?=$ser_mms_idx?>").attr('selected','selected');</script>

<script>$('select[name=ser_time_type]').val("<?=$ser_time_type?>").attr('selected','selected');</script>
기간:
<input type="text" name="st_date" value="<?php echo $st_date ?>" id="st_date" class="frm_input" style="width:80px;"> ~
<input type="text" name="st_time" value="<?=$st_time?>" id="st_time" class="frm_input" autocomplete="off" style="width:65px;" placeholder="00:00:00">
~
<input type="text" name="en_date" value="<?php echo $en_date ?>" id="en_date" class="frm_input" style="width:80px;">
<input type="text" name="en_time" value="<?=$en_time?>" id="en_time" class="frm_input" autocomplete="off" style="width:65px;" placeholder="00:00:00">
<input type="submit" class="btn_submit" value="검색">
</form>

<div id="report_wrapper">
    <!-- ========================================================================================= -->
	<!-- ========================================================================================= -->
	<div class="div_wrapper">
        <div class="div_left">
            <!-- ========================================================================================= -->
            <div class="div_title_02f"><i class="fa fa-check" aria-hidden="true"> 일자별 생산</i></div>
            <div class="div_info_body">

                <table class="table01">
                    <thead class="tbl_head">
                    <tr>
                        <th scope="col">설비</th>
                        <th scope="col">일자</th>
                        <th scope="col" style="width:10%">발생수</th>
                        <th scope="col" style="width:10%;">비율</th>
                        <th scope="col" style="width:150px;">그래프</th>
                    </tr>
                    </thead>
                    <tbody class="tbl_body">
                    <?php
                    $sql = "SELECT (CASE WHEN n='1' THEN ymd_date ELSE 'total' END) AS item_name
                                , SUM(count_sum) AS count_sum
                            FROM
                            (
                                SELECT 
                                    ymd_date
                                    , SUM(count_sum) AS count_sum
                                FROM
                                (
                                    (
                                    SELECT 
                                        CAST(ymd_date AS CHAR) AS ymd_date
                                        , 0 AS count_sum
                                    FROM g5_5_ymd AS ymd
                                    WHERE ymd_date BETWEEN '".$st_date."' AND '".$en_date."'
                                    ORDER BY ymd_date
                                    )
                                UNION ALL
                                    (
                                    SELECT
                                        substring( CAST(end_time AS CHAR),1,10) AS ymd_date
                                        , COUNT(csh_idx) AS count_sum
                                    FROM g5_1_cast_shot
                                    WHERE end_time >= '".$st_date." 00:00:00' AND end_time <= '".$en_date." 23:59:59'
                                            {$sql_mmses1}
                                    GROUP BY ymd_date
                                    ORDER BY ymd_date
                                    )
                                ) AS db_table
                                GROUP BY ymd_date
                            ) AS db2, g5_5_tally AS db_no
                            WHERE n <= 2
                            GROUP BY item_name
                            ORDER BY n DESC, item_name
                    ";
                    // echo $sql;
                    $result = sql_query($sql,1);

                    // 최고값 추출
                    $item_max = array();
                    $item_sum = 0;
                    $result = sql_query($sql,1);
                    for ($i=0; $row=sql_fetch_array($result); $i++) {
                        // print_r2($row);
                        if($row['item_name'] != 'total') {
                            $item_max[] = $row['count_sum'];
                            $item_sum += $row['count_sum'];
                        }
                    }
                    // echo max($item_max).'<br>';
                    // echo $item_sum.'<br>';
                    $arm_day_cat = array();
                    $result = sql_query($sql,1);
                    for ($i=0; $row=sql_fetch_array($result); $i++) {
                        // print_r2($row);

                        // 합계인 경우
                        if($row['item_name'] == 'total') {
                            $row['item_name'] = '합계';
                            $row['tr_class'] = 'tr_stat_total';
                        }
                        else {
                            $row['tr_class'] = 'tr_stat_normal';
                        }
                        // echo $item_sum.'<br>';

                        // 비율
                        $row['rate'] = ($item_sum) ? $row['count_sum'] / $item_sum * 100 : 0 ;
                        $row['rate_color'] = '#d1c594';
                        $row['rate_color'] = ($row['rate']>=80) ? '#72ddf5' : $row['rate_color'];
                        $row['rate_color'] = ($row['rate']>=100) ? '#ff9f64' : $row['rate_color'];

                        // 그래프
                        if($item_sum && $row['count_sum']) {
                            $row['rate_percent'] = $row['count_sum'] / max($item_max) * 100;
                            // $row['rate_percent'] = $row['count_sum'] / $item_sum * 100;
                            $row['graph'] = '<img class="graph_output" src="../img/dot.gif" style="width:'.$row['rate_percent'].'%;background:'.$row['rate_color'].';" height="8px">';
                        }

                        // 설비명
                        $row['mms_name'] = ($ser_mms_idx) ? $g5['mms'][$ser_mms_idx]['mms_name'] : '전체설비';

                        // First line total skip, start from second line.
                        if($i>0) {
                            echo '
                            <tr class="'.$row['tr_class'].'">
                                <td class="text_left">'.$row['mms_name'].'</td>
                                <td class="text_left">'.$row['item_name'].'</td>
                                <td class="text_right pr_5">'.number_format($row['count_sum']).'</td><!-- 발생수 -->
                                <td class="text_right pr_5">'.number_format($row['rate'],1).'%</td><!-- 비율 -->
                                <td class="td_graph text_left pl_0">'.$row['graph'].'</td>
                            </tr>
                            ';
                        }
                    }
                    if ($i <= 0)
                        echo '<tr class="tr_empty"><td class="td_empty" colspan="6">자료가 없습니다.</td></tr>';
                    ?>
                </tbody>
                </table>
            
            </div><!-- .div_info_body -->

        </div><!-- .div_left -->
        <div class="div_right">

            <!-- ========================================================================================= -->
            <div class="div_title_02f"><i class="fa fa-check" aria-hidden="true"> 일자별 버튼누름</i></div>
            <div class="div_info_body">

                <table class="table01">
                    <thead class="tbl_head">
                    <tr>
                        <th scope="col">설비</th>
                        <th scope="col">일자</th>
                        <th scope="col" style="width:10%">발생수</th>
                        <th scope="col" style="width:10%;">비율</th>
                        <th scope="col" style="width:150px;">그래프</th>
                    </tr>
                    </thead>
                    <tbody class="tbl_body">
                    <?php
                    $sql = "SELECT (CASE WHEN n='1' THEN ymd_date ELSE 'total' END) AS item_name
                                , SUM(count_sum) AS count_sum
                            FROM
                            (
                                SELECT 
                                    ymd_date
                                    , SUM(count_sum) AS count_sum
                                FROM
                                (
                                    (
                                    SELECT 
                                        CAST(ymd_date AS CHAR) AS ymd_date
                                        , 0 AS count_sum
                                    FROM g5_5_ymd AS ymd
                                    WHERE ymd_date BETWEEN '".$st_date."' AND '".$en_date."'
                                    ORDER BY ymd_date
                                    )
                                UNION ALL
                                    (
                                    SELECT
                                        substring( CAST(mrk_reg_dt AS CHAR),1,10) AS ymd_date
                                        , COUNT(mrk_idx) AS count_sum
                                    FROM g5_1_marking
                                    WHERE mrk_reg_dt >= '".$st_date." 00:00:00' AND mrk_reg_dt <= '".$en_date." 23:59:59'
                                            {$sql_mmses2}
                                    GROUP BY ymd_date
                                    ORDER BY ymd_date
                                    )
                                ) AS db_table
                                GROUP BY ymd_date
                            ) AS db2, g5_5_tally AS db_no
                            WHERE n <= 2
                            GROUP BY item_name
                            ORDER BY n DESC, item_name
                    ";
                    // echo $sql;
                    $result = sql_query($sql,1);

                    // 최고값 추출
                    $item_max = array();
                    $item_sum = 0;
                    $result = sql_query($sql,1);
                    for ($i=0; $row=sql_fetch_array($result); $i++) {
                        // print_r2($row);
                        if($row['item_name'] != 'total') {
                            $item_max[] = $row['count_sum'];
                            $item_sum += $row['count_sum'];
                        }
                    }
                    // echo max($item_max).'<br>';
                    // echo $item_sum.'<br>';
                    $arm_day_cat = array();
                    $result = sql_query($sql,1);
                    for ($i=0; $row=sql_fetch_array($result); $i++) {
                        // print_r2($row);

                        // 합계인 경우
                        if($row['item_name'] == 'total') {
                            $row['item_name'] = '합계';
                            $row['tr_class'] = 'tr_stat_total';
                        }
                        else {
                            $row['tr_class'] = 'tr_stat_normal';
                        }
                        // echo $item_sum.'<br>';

                        // 비율
                        $row['rate'] = ($item_sum) ? $row['count_sum'] / $item_sum * 100 : 0 ;
                        $row['rate_color'] = '#d1c594';
                        $row['rate_color'] = ($row['rate']>=80) ? '#72ddf5' : $row['rate_color'];
                        $row['rate_color'] = ($row['rate']>=100) ? '#ff9f64' : $row['rate_color'];

                        // 그래프
                        if($item_sum && $row['count_sum']) {
                            $row['rate_percent'] = $row['count_sum'] / max($item_max) * 100;
                            // $row['rate_percent'] = $row['count_sum'] / $item_sum * 100;
                            $row['graph'] = '<img class="graph_output" src="../img/dot.gif" style="width:'.$row['rate_percent'].'%;background:'.$row['rate_color'].';" height="8px">';
                        }

                        // 설비명
                        $row['mms_name'] = ($ser_mms_idx) ? $g5['mms'][$ser_mms_idx]['mms_name'] : '전체설비';

                        // First line total skip, start from second line.
                        if($i>0) {
                            echo '
                            <tr class="'.$row['tr_class'].'">
                                <td class="text_left">'.$row['mms_name'].'</td>
                                <td class="text_left">'.$row['item_name'].'</td>
                                <td class="text_right pr_5">'.number_format($row['count_sum']).'</td><!-- 발생수 -->
                                <td class="text_right pr_5">'.number_format($row['rate'],1).'%</td><!-- 비율 -->
                                <td class="td_graph text_left pl_0">'.$row['graph'].'</td>
                            </tr>
                            ';
                        }
                    }
                    if ($i <= 0)
                        echo '<tr class="tr_empty"><td class="td_empty" colspan="6">자료가 없습니다.</td></tr>';
                    ?>
                </tbody>
                </table>    
            
                </table>
            </div><!-- .div_info_body -->

        </div><!-- .div_right -->
    </div><!-- .div_wrapper -->
</div><!-- #report_wrapper -->
<script>
$(function(e) {
    $("input[name$=_date]").datepicker({
        closeText: "닫기",
        currentText: "오늘",
        monthNames: ["1월","2월","3월","4월","5월","6월", "7월","8월","9월","10월","11월","12월"],
        monthNamesShort: ["1월","2월","3월","4월","5월","6월", "7월","8월","9월","10월","11월","12월"],
        dayNamesMin:['일','월','화','수','목','금','토'],
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        showButtonPanel: true,
        yearRange: "c-99:c+99",
        //maxDate: "+0d"
    });

});
</script>

<?php
include_once ('./_tail.php');
?>

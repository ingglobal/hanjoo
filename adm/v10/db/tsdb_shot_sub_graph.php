<?php
$sub_menu = "940160";
include_once('./_common.php');

$g5['title'] = '온도(주조공정(SUB)) 그래프';
include_once('./_top_menu_tsdb.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

// // 검색 조건
$st_date = ($st_date) ? $st_date : date("Y-m-d",G5_SERVER_TIME-3600);
$st_time = ($st_time) ? $st_time : date("H:i:s",G5_SERVER_TIME-3600);
$en_date = ($en_date) ? $en_date : G5_TIME_YMD;
$en_time = ($en_time) ? $en_time : date("H:i:s",G5_SERVER_TIME);

?>
<style>
.graph_detail ul:after{display:block;visibility:hidden;clear:both;content:'';}
.graph_detail ul li {float:left;width:32%;margin-right:10px;margin-bottom:10px;}
.graph_detail ul li > div{border:solid 1px #ddd;height:300px;}
</style>

<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/highstock.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/data.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/exporting.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/themes/high-contrast-dark.js"></script>
<!-- 다양한 시간 표현을 위한 플러그인 -->
<script src="<?php echo G5_URL?>/lib/highcharts/moment.js"></script>


<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
    <input type="hidden" name="dta_minsec" value="<?=$dta_minsec?>" id="dta_minsec" class="frm_input" style="width:20px;">
    <input type="text" name="st_date" value="<?=$st_date?>" id="st_date" class="frm_input" autocomplete="off" style="width:80px;" >
    <input type="text" name="st_time" value="<?=$st_time?>" id="st_time" class="frm_input" autocomplete="off" style="width:65px;">
    ~
    <input type="text" name="en_date" value="<?=$en_date?>" id="en_date" class="frm_input" autocomplete="off" style="width:80px;">
    <input type="text" name="en_time" value="<?=$en_time?>" id="en_time" class="frm_input" autocomplete="off" style="width:65px;">
    <button type="submit" class="btn btn_01">확인</button>
</form>

<div id="graph_wrapper">

    <div class="graph_wrap">
        <!-- 차트 -->
        <div id="chart1" style="position:relative;width:100%; height:500px;">
            <div class="chart_empty">그래프가 존재하지 않습니다.</div>
        </div>
    </div><!-- .graph_wrap -->

</div><!-- #graph_wrapper -->

<div class="btn_fixed_top" style="display:none;">
    <a href="./chart2.php" class="btn_04 btn">분포도</a>
    <a href="./chart1.php" class="btn_04 btn">모니터링</a>
</div>


<script>
// Detail graph
Highcharts.getJSON('http://hanjoo.epcs.co.kr/php/hanjoo/device/json/usdeur.json?st_date=2022-06-02&st_time=13:33:14&en_date=2022-06-02&en_time=14:33:14', function(data) {

    var startDate = new Date(data[data.length - 1][0]), // Get year of last data point
        minRate = 1,
        maxRate = 0,
        startPeriod,
        date,
        rate,
        index;

    startDate.setMonth(startDate.getMonth() - 3); // a quarter of a year before last data point
    startPeriod = Date.UTC(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());

    for (index = data.length - 1; index >= 0; index = index - 1) {
        date = data[index][0]; // data[i][0] is date
        rate = data[index][1]; // data[i][1] is exchange rate
        if (date < startPeriod) {
            break; // stop measuring highs and lows
        }
        if (rate > maxRate) {
            maxRate = rate;
        }
        if (rate < minRate) {
            minRate = rate;
        }
    }

    // Create the chart
    Highcharts.stockChart('chart1', {

        rangeSelector: {
            selected: 1
        },
        title: {
            text: '온도(주조공정SUB)'
        },

        yAxis: {
            plotLines: [{
                value: 0.855,
                color: 'red',
                dashStyle: 'LongDash',
                width: 2,
                label: {
                    text: 'Last quarter minimum'
                }
            }]
        },

        series: [{
            name: '온도',
            data: data,
            tooltip: {
                valueDecimals: 4
            }
        }]
    });
});
</script>

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

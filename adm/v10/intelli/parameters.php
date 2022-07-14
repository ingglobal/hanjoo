<?php
$sub_menu = "920120";
include_once('./_common.php');

$g5['title'] = '그래프(주조공정(SUB))';
include_once('./_top_menu_db.php');
include_once('./_head.php');
echo $g5['container_sub_title'];


// 검색 조건
$st_time_ahead = 3600*1;  // 5hour ahead.

// Set the search period reset according to the last data input.
$sql = " SELECT * FROM g5_1_cast_shot_sub ORDER BY css_idx DESC LIMIT 1 ";
$one = sql_fetch($sql,1);
// print_r3($one);
$en_date = ($en_date) ? $en_date : substr($one['event_time'],0,10);
$en_time = ($en_time) ? $en_time : substr($one['event_time'],11);
$st_date = ($st_date) ? $st_date : date("Y-m-d",strtotime($en_date.' '.$en_time)-$st_time_ahead);
$st_time = ($st_time) ? $st_time : date("H:i:s",strtotime($en_date.' '.$en_time)-$st_time_ahead);
// echo $en_date.' '.$en_time.'<br>';
// echo $st_date.' '.$st_time.'<br>';
// exit;

// 17호기 분포
$sql = " SELECT * FROM g5_1_cast_shot_sub ORDER BY css_idx DESC LIMIT 1 ";


?>
<style>
.graph_wrap > div {margin-bottom:20px;}
</style>

<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/highstock.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/highcharts-more.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/data.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/exporting.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/themes/high-contrast-dark.js"></script>
<!-- 다양한 시간 표현을 위한 플러그인 -->
<script src="<?php echo G5_URL?>/lib/highcharts/moment.js"></script>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
    <input type="text" name="st_date" value="<?=$st_date?>" id="st_date" class="frm_input" autocomplete="off" style="width:80px;" >
    <input type="text" name="st_time" value="<?=$st_time?>" id="st_time" class="frm_input" autocomplete="off" style="width:65px;">
    ~
    <input type="text" name="en_date" value="<?=$en_date?>" id="en_date" class="frm_input" autocomplete="off" style="width:80px;">
    <input type="text" name="en_time" value="<?=$en_time?>" id="en_time" class="frm_input" autocomplete="off" style="width:65px;">
    <button type="submit" class="btn btn_01 btn_search">확인</button>
</form>

<div id="graph_wrapper">

<div class="graph_wrap">
    <!-- 차트 -->
    <div id="chart1" style="position:relative;width:100%; height:400px;">
        <div class="chart_empty">그래프가 존재하지 않습니다.</div>
    </div>
</div><!-- .graph_wrap -->
</div><!-- #graph_wrapper -->

<div class="btn_fixed_top" style="display:no ne;">
    <a href="./parameters.php" class="btn_04 btn">개별그래프</a>
    <a href="./parameters.php" class="btn_04 btn">전체그래프</a>
</div>


<script>
var ranges = [
        ['보온로온도', 650, 720],
        ['상형히트', 350, 362],
        ['하형히트', 391, 408],
        ['상금형1', null, null],
        ['상금형2', null, null],
        ['상금형3', 490, 520.225],
        ['상금형4', null, null],
        ['상금형5', 435.225, 475.225],
        ['상금형6', 394.5, 429.1],
        ['하금형1', 392.8, 427.7],
        ['하금형2', null, null],
        ['하금형3', null, null],
    ],
    averages = [
        ['보온로온도', 695],
        ['상형히트', 360],
        ['하형히트', 402],
        ['상금형1', null],
        ['상금형2', null],
        ['상금형3', 498],
        ['상금형4', null],
        ['상금형5', 470],
        ['상금형6', 410],
        ['하금형1', 400],
        ['하금형2', null],
        ['하금형3', null],
    ];

// 17호기 ----------------------------
Highcharts.chart('chart1', {

    title: {
        text: '17호기'
    },
    subtitle: {
        text: '최적 기준선이 가운데 나타나고 최대(위) 최소값(아래)이 표현됩니다.'
    },

    xAxis: {
        categories: ['보온로온도', '상형히트', '하형히트', '상금형1', '상금형2','상금형3', '상금형4','상금형5', '상금형6', '하금형1', '하금형2','하금형3']
    },
    yAxis: {
        title: {
            text: null
        }
    },

    tooltip: {
        crosshairs: true,
        shared: true,
        valueSuffix: '°C'
    },

    series: [{
        name: '최적',
        data: averages,
        type: 'spline',
        zIndex: 1,
        color: '#FF0000'
    }, {
        name: '범위',
        data: ranges,
        type: 'areasplinerange',
        lineWidth: 0,
        linkedTo: ':previous',
        color: Highcharts.getOptions().colors[0],
        fillOpacity: 0.5,
        zIndex: 0,
        marker: {
            enabled: false
        }
    }]
});
</script>

<?php
include_once ('./_tail.php');
?>

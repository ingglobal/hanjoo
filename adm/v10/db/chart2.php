<?php
$sub_menu = "925130";
include_once('./_common.php');

$g5['title'] = '그래프(주조공정(SUB))';
include_once('./_top_menu_db.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

?>
<style>
</style>

<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/highstock.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/highcharts-more.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/data.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/exporting.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/themes/high-contrast-dark.js"></script>
<!-- 다양한 시간 표현을 위한 플러그인 -->
<script src="<?php echo G5_URL?>/lib/highcharts/moment.js"></script>

<div class="local_desc01 local_desc" style="display:no ne;">
    <p>특정 기간 안에 최대, 최소값을 보여줍니다.</p>
    <p>17호기, 18호기, 19호기, 20호기 선택</p>
</div>

<div id="graph_wrapper">

<div class="graph_wrap">
    <!-- 차트 -->
    <div id="chart1" style="position:relative;width:100%; height:400px;">
        <div class="chart_empty">그래프가 존재하지 않습니다.</div>
    </div>
</div><!-- .graph_wrap -->
</div><!-- #graph_wrapper -->

<div class="btn_fixed_top">
    <a href="./chart2.php" class="btn_04 btn">분포도</a>
    <a href="./chart1.php" class="btn_04 btn">모니터링</a>
</div>


<script>
var ranges = [
        ['보온로온도', 14.3, 27.7],
        ['상형히트', 14.5, 27.8],
        ['하형히트', 15.5, 29.6],
        ['상금형1', 16.7, 30.7],
        ['상금형2', 16.5, 25.0],
        ['상금형3', 17.8, 25.7],
        ['상금형4', 13.5, 24.8],
        ['상금형5', 10.5, 21.4],
        ['상금형6', 13.5, 24.8],
        ['하금형1', 10.5, 21.4],
        ['하금형2', 9.2, 23.8],
        ['하금형3', 11.6, 21.8],
    ],
    averages = [
        ['보온로온도', 27],
        ['상형히트', 22.1],
        ['하형히트', 23],
        ['상금형1', 23.8],
        ['상금형2', 21.4],
        ['상금형3', 21.3],
        ['상금형4', 18.3],
        ['상금형5', 15.4],
        ['상금형6', 15.4],
        ['하금형1', 15.8],
        ['하금형2', 20.4],
        ['하금형3', 18.3],
    ];


Highcharts.chart('chart1', {

    title: {
        text: '온도값 분포'
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
        name: 'Temperature',
        data: averages,
        type: 'spline',
        zIndex: 1,
        color: '#FF0000'
    }, {
        name: 'Range',
        data: ranges,
        type: 'arearange',
        lineWidth: 0,
        linkedTo: ':previous',
        color: Highcharts.getOptions().colors[0],
        fillOpacity: 0.6,
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

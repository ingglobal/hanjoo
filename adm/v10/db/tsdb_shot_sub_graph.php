<?php
$sub_menu = "940160";
include_once('./_common.php');

$g5['title'] = '온도(주조공정(SUB)) 그래프';
include_once('./_top_menu_tsdb.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

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

<div class="local_desc01 local_desc" style="display:no ne;">
    <p>1분에 한번씩 reloading. 제품 생산 카운터가 있으면 추가되고 아니면 같은 그래프 유지!</p>
    <p>몇 개의 shot을 보여줄 지 설정을 해 주면 되겠습니다. 한 페이지에 max 15개 정도가 될 거 같습니다.</p>
    <p>17호기, 18호기, 19호기, 20호기</p>
</div>

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
Highcharts.getJSON('https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/usdeur.json', function (data) {

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
                value: maxRate,
                color: 'red',
                dashStyle: 'solid',
                width: 1,
                label: {
                    text: 'Last quarter maximum'
                }
            }]
        },

        series: [{
            name: 'USD to EUR',
            data: data,
            tooltip: {
                valueDecimals: 4
            }
        }]
    });
});
</script>

<?php
include_once ('./_tail.php');
?>

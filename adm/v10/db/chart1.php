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
var colors = Highcharts.getOptions().colors;

Highcharts.chart('chart1', {
    chart: {
        type: 'spline'
    },

    title: {
        text: '주조 파라메타 모니터링'
    },
    subtitle: {
        text: '최적의 양품 조건 (빨간색) & 실시간 파라메타 분포'
    },
    legend: {
        layout: 'proximate',
        align: 'right'
    },
    xAxis: {
        categories: ['보온로온도', '상형히트', '하형히트', '상금형1', '상금형2','상금형3', '상금형4','상금형5', '상금형6', '하금형1', '하금형2','하금형3']
    },

    plotOptions: {
        series: {
            point: {
                events: {
                    click: function () {
                        window.location.href = this.series.options.website;
                    }
                }
            },
            cursor: 'pointer'
        }
    },

    series: [
        {
            name: 'Standard',
            data: [34.8, 43.0, 51.2, 41.4, 64.9, 72.4, 72.4, 51.2, 41.4, 64.9, 72.4, 17.4],
            website: 'https://www.nvaccess.org',
            color: '#FF0000'
        }, {
            name: '250 (17호기)',
            data: [33.8, 42.0, 51.2, 40.4, 68.9, 70.4, 70.4, null, 40.4, 62.9, 70.4, 17.2],
            website: 'https://www.freedomscientific.com/Products/Blindness/JAWS',
            dashStyle: 'ShortDot',
            color: '#B1B1B1',
            marker: {
                symbol: 'diamond'
            }
        }, {
            name: '249 (17호기)',
            data: [33.8, 42.0, 51.2, 40.4, 68.9, 73.4, 70.4, null, 40.4, 62.9, 70.4, 18.2],
            website: 'http://www.apple.com/accessibility/osx/voiceover',
            dashStyle: 'ShortDot',
            color: '#B1B1B1',
            marker: {
                symbol: 'diamond'
            }
        }, {
            name: '248 (17호기)',
            data: [33.8, 42.0, 51.2, 40.4, 68.9, 77.4, 70.4, null, 40.4, 62.9, 70.4, 17.7],
            website: 'https://support.microsoft.com/en-us/help/22798/windows-10-complete-guide-to-narrator',
            dashStyle: 'ShortDot',
            color: '#B1B1B1',
            marker: {
                symbol: 'diamond'
            }
        }, {
            name: '247 (17호기)',
            data: [30.8, 42.0, 51.2, 40.4, 68.9, 69.4, 70.4, null, 40.4, 62.9, 70.4, 19.2],
            website: 'http://www.zoomtext.com/products/zoomtext-magnifierreader',
            dashStyle: 'ShortDot',
            color: '#B1B1B1',
            marker: {
                symbol: 'diamond'
            }
        }, {
            name: '246 (17호기)',
            data: [35.8, 42.0, 51.2, 40.4, 68.9, 67.4, 70.4, null, 40.4, 62.9, 70.4, 18.2],
            website: 'http://www.disabled-world.com/assistivedevices/computer/screen-readers.php',
            dashStyle: 'ShortDot',
            color: '#B1B1B1',
            marker: {
                symbol: 'diamond'
            }
        }, {
            name: '245 (17호기)',
            data: [35.8, 42.0, 51.2, 40.4, 68.9, 64.4, 70.4, null, 40.4, 62.9, 70.4, 17.0],
            website: 'http://www.disabled-world.com/assistivedevices/computer/screen-readers.php',
            dashStyle: 'ShortDot',
            color: '#B1B1B1',
            marker: {
                symbol: 'diamond'
            }
        }
    ]
});    
</script>

<?php
include_once ('./_tail.php');
?>

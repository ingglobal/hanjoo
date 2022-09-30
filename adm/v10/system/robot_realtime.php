<?php
$sub_menu = "925140";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$g5['title'] = '로봇실시간제어';
include_once('./_top_menu_robot.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

$type_array = array('tq1'=>'토크1','tq2'=>'토크2','tq3'=>'토크3','tq4'=>'토크4','tq5'=>'토크5','tq6'=>'토크6'
                    ,'et1'=>'온도1','et2'=>'온도2','et3'=>'온도3','et4'=>'온도4','et5'=>'온도5','et6'=>'온도6');
// foreach($type_array as $k1=>$v1) {
//     echo $k1.'=>'.$v1.'<br>';
// }
?>
<style>
/* /adm/v10/css/robot_realtime.css 에서 기본설정 */
</style>

<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/highstock.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/data.js"></script>
<script src="<?=G5_URL?>/lib/highcharts/Highcharts/code/highcharts-more.js"></script>
<script src="<?=G5_URL?>/lib/highcharts/Highstock/code/modules/solid-gauge.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/modules/exporting.js"></script>
<script src="<?php echo G5_URL?>/lib/highcharts/Highstock/code/themes/high-contrast-dark.js"></script>
<!-- 다양한 시간 표현을 위한 플러그인 -->
<script src="<?php echo G5_URL?>/lib/highcharts/moment.js"></script>


<div class="local_desc01 local_desc" style="display:no ne;">
    <p>노란색 라인은 알림경고, 빨간색 라인은 정지위치를 표시합니다. <a href="./config_form_robot.php">[설정하기]</a></p>
    <p>초기 로딩 시 10초 버퍼링 후 실시간 값을 표현합니다.</p>
    <p>빨간색(정지) 값을 초과하는 상태가 발생하면 <span style="color:darkorange;">즉시 작업을 중단</span>합니다. 설정된 안정화 시간이 지난 후 다시 작동됩니다. [설정하기] 페이지에서 수정하세요.</p>
</div>

<div class="chart_wrapper">
    <div class="chart_left">
        <div class="chart_title">
            <strong>로봇1</strong>
            <div class="buttons">
                <a href="javascript:alert('정말 중지시키겠습니까?');">로봇중지</a>
                <a href="javascript:alert('경고를 전달하시겠습니까?');">경고</a>
                <a href="javascript:alert('로봇을 재시작 시키겠습니까?');">로봇재시작</a>
            </div>
        </div>
        <div id="chart1_tq1"></div><!-- 토크1 -->
        <div id="chart1_tq2"></div><!-- 토크2 -->
        <div id="chart1_tq3"></div><!-- 토크3 -->
        <div id="chart1_tq4"></div><!-- 토크4 -->
        <div id="chart1_tq5"></div><!-- 토크5 -->
        <div id="chart1_tq6"></div><!-- 토크6 -->
        <div id="chart1_et1"></div><!-- 온도1 -->
        <div id="chart1_et2"></div><!-- 온도2 -->
        <div id="chart1_et3"></div><!-- 온도3 -->
        <div id="chart1_et4"></div><!-- 온도4 -->
        <div id="chart1_et5"></div><!-- 온도5 -->
        <div id="chart1_et6"></div><!-- 온도6 -->
    </div>
    <div class="chart_right">
        <div class="chart_title">
            <strong>로봇2</strong>
            <div class="buttons">
                <a href="javascript:alert('정말 중지시키겠습니까?');">로봇중지</a>
                <a href="javascript:alert('경고를 전달하시겠습니까?');">경고</a>
                <a href="javascript:alert('로봇을 재시작 시키겠습니까?');">로봇재시작</a>
            </div>
        </div>
        <div id="chart2_tq1"></div><!-- 토크1 -->
        <div id="chart2_tq2"></div><!-- 토크2 -->
        <div id="chart2_tq3"></div><!-- 토크3 -->
        <div id="chart2_tq4"></div><!-- 토크4 -->
        <div id="chart2_tq5"></div><!-- 토크5 -->
        <div id="chart2_tq6"></div><!-- 토크6 -->
        <div id="chart2_et1"></div><!-- 온도1 -->
        <div id="chart2_et2"></div><!-- 온도2 -->
        <div id="chart2_et3"></div><!-- 온도3 -->
        <div id="chart2_et4"></div><!-- 온도4 -->
        <div id="chart2_et5"></div><!-- 온도5 -->
        <div id="chart2_et6"></div><!-- 온도6 -->
    </div>
</div>


<script>
<?php
for($x=1;$x<3;$x++) {
    foreach($type_array as $k1=>$v1) {
?>
Highcharts.chart('chart<?=$x?>_<?=$k1?>', {
    chart: {
        type: 'spline',
        animation: Highcharts.svg, // don't animate in old IE
        marginRight: 10,
        events: {
            load: function () {
                var series0 = this.series[0];   // 그래프중에서 첫번째 (실제로 여러개의 그래프가 들어갈 수 있음)
                // console.log(this.series[0]);
                console.log('<?=G5_USER_URL?>/json/robot.php?token=1099de5drf09&robot=<?=$x?>&type=<?=$k1?>');
                setInterval(function () {
                    $.getJSON(g5_user_url+'/json/robot.php',{"token":"1099de5drf09","robot":"<?=$x?>","type":"<?=$k1?>"},function(res) {
                        // console.log(res);
                        $.each(res, function(i, v) {
                            // console.log(i+':'+v);
                            // console.log(i+':'+v['x']+','+v['y']);
                            var setTime = i*1000;
                            // console.log(setTime+':'+v['x']+','+v['y']);
                            setTimeout(function(e){
                                series0.addPoint([v['x'], v['y']], true, true);
                            },setTime);
                        });
                    });
                }, 10000);
            }
        }
    },
    time: {
        useUTC: false
    },
    title: {
        text: '<?=$v1?>'
    },
    accessibility: {
        announceNewData: {
            enabled: true,
            minAnnounceInterval: 15000,
            announcementFormatter: function (allSeries, newSeries, newPoint) {
                if (newPoint) {
                    return 'New point added. Value: ' + newPoint.y;
                }
                return false;
            }
        }
    },
    xAxis: {
        type: 'datetime',
        tickPixelInterval: 150
    },
    yAxis: {
        title: {
            text: 'Value'
        },
        plotLines: [{
                value: 24,  // 경고 기준값
                color: 'yellow',
                dashStyle: 'solid',
                width: 3
            },
            {
                value: 45,  // 정지 기준값
                color: 'red',
                dashStyle: 'solid',
                width: 3
            }]
    },
    plotOptions: {
        series: {
            marker: {
                enabled: true   // point dot display
            }
        }
    },
    legend: {
        enabled: false
    },
    exporting: {
        enabled: false
    },
    tooltip: {
        formatter: function(e) {
            var tooltip1 =  moment(this.x).format("YYYY-MM-DD HH:mm:ss");
            // console.log(this);
            var tooltip2 = [];
            $.each(this.points, function () {
                var this_name = this.series.name;
                tooltip1 += '<br/><span style="color:' + this.color + '">\u25CF '+this_name+'</span>: <b>' + this.point.y + '</b>';
            });
            return tooltip1;
        },
        split: false,
        shared: true
    },
    series: [{
        name: '<?=$v1?>',
        data: (function () {
            // generate an array of random data
            var data = [],
                time = (new Date()).getTime(),
                i;
            for (i = -29; i <= 0; i += 1) {
                data.push({
                    x: time + i * 1000,
                    y: Math.random()*20
                });
            }
            return data;
        }())
    }]
});
<?php
    }
}
?>

</script>



<?php
include_once ('./_tail.php');
?>

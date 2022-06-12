<?php
$sub_menu = "940160";
include_once('./_common.php');

$g5['title'] = '온도(주조공정(SUB)) 그래프';
include_once('./_top_menu_tsdb.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

// 검색 조건
$st_time_ahead = 3600*5;  // 5hour ahead.
// $st_date = ($st_date) ? $st_date : date("Y-m-d",G5_SERVER_TIME-$st_time_ahead);
// $st_time = ($st_time) ? $st_time : date("H:i:s",G5_SERVER_TIME-$st_time_ahead);
// $en_date = ($en_date) ? $en_date : G5_TIME_YMD;
// $en_time = ($en_time) ? $en_time : date("H:i:s",G5_SERVER_TIME);

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



// mms_idx
$mms_idx = ($mms_idx) ? $mms_idx : 45;
// item_type
$item_type = ($item_type) ? $item_type : 'hold_temp';
// query string
$qs = 'token=1099de5drf09&mms_idx='.$mms_idx.'&st_date='.$st_date.'&st_time='.$st_time.'&en_date='.$en_date.'&en_time='.$en_time.'&item_type='.$item_type;
?>
<style>
.graph_detail ul:after{display:block;visibility:hidden;clear:both;content:'';}
.graph_detail ul li {float:left;width:32%;margin-right:10px;margin-bottom:10px;}
.graph_detail ul li > div{border:solid 1px #ddd;height:300px;}
.div_btn_add {float:right;}
#fsearch {display:block;}
#fsearch .div_btn_add {margin:0 !important;}
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
    <button type="submit" class="btn btn_01 btn_search">확인</button>

    <div class="div_btn_add" style="float:right;display:no ne;">
        <a href="./data_graph_add_hanjoo.php?file_name=<?php echo $g5['file_name']?>" class="btn btn_03 btn_add_chart"><i class="fa fa-bar-chart"></i>불러오기</a>
        <a href="javascript:alert('설정된 그래프를 대시보드로 내보냅니다.');" class="btn btn_03 btn_add_dash" style="display:none;"><i class="fa fa-line-chart"></i> 내보내기</a>
    </div>
</form>

<div id="graph_wrapper">

    <div class="graph_wrap">
        <!-- 차트 -->
        <div id="chart1" style="position:relative;width:100%; height:500px;line-height:300px;text-align:center;border:solid 1px #ddd;">
            그래프를 추가하세요.
        </div>
    </div><!-- .graph_wrap -->

</div><!-- #graph_wrapper -->

<div class="btn_fixed_top" style="display:no ne;">
    <a href="./tsdb_shot_sub_graph.php" class="btn_04 btn">단일그래프</a>
    <a href="./chart1.php" class="btn_04 btn" style="display:none;">모니터링</a>
</div>


<script>
var graphs2 = [], seriesOptions = [], data_series = [], graph_type = 'spline', graph_line = 'solid',
    seriesCounter = 0, chart, options;

// ======================================================================
// graphs attr in in chart div
// 변수가 바뀌면 graph_id를 바꿔줘야 합니다. 테스트하려면 주석 해제 후 [확인]만 하면 됩니다.
// graphs[0] = {
//     dta_data_url: "icmms.co.kr/device/json",
//     dta_json_file: "measure",
//     dta_group: "mea",
//     mms_idx: 7,
//     dta_type: 1,
//     dta_no: 0,
//     graph_type: 'spline',
//     graph_line: 'solid',
//     graph_name: '측정1',
//     graph_id: 'bWVhc3VyZV9tZWFfN18xXzBfMF8wXzAsMV8wXw'
// };
// graphs[1] = {
//     dta_data_url: "icmms.co.kr/device/json",
//     dta_json_file: "output",
//     dta_group: "product",
//     mms_idx: 7,
//     dta_type: 1,
//     dta_no: 0,
//     graph_type: 'spline',
//     graph_line: 'solid',
//     graph_name: '생산1',
//     graph_id: 'b3V0cHV0X3Byb2R1Y3RfN18xXzBfMF8wXzAsMV8wXw'
// };
// $("#chart1").attr("graphs",JSON.stringify(graphs));


function createChart() {
    // var chart = new Highcharts.stockChart({
    options = {
        chart: {
            renderTo: 'chart1',
            // type: 'spline',   // line, spline, area, areaspline, column, bar, pie, scatter, gauge, arearange, areasplinerange, columnrange
            events: {
                redraw: function() {
                    $('#xmin').val(this.xAxis[0].min);
                    $('#xmax').val(this.xAxis[0].max);
                    $('#ymin').val(this.yAxis[0].min);
                    $('#ymax').val(this.yAxis[0].max);
                    // console.log(this.yAxis[0].max);
                    // console.log(this.yAxis[0].min);
                    // bottom slider min, max change
                    chr_move_slider.slider("option", "min", parseInt(this.yAxis[0].min));
                    chr_move_slider.slider("option", "max", parseInt(this.yAxis[0].max));
                },
                load: function() {
                    $('#xmin').val(this.xAxis[0].min);
                    $('#xmax').val(this.xAxis[0].max);
                    $('#ymin').val(this.yAxis[0].min);
                    $('#ymax').val(this.yAxis[0].max);
                    // console.log(this.yAxis[0].max);
                    // console.log(this.yAxis[0].min);
                    // bottom slider min, max change
                    chr_move_slider.slider("option", "min", parseInt(this.yAxis[0].min));
                    chr_move_slider.slider("option", "max", parseInt(this.yAxis[0].max));
                }
            },
        },
        
        animation: false,

        xAxis: {
            // min: 1587635789000,
            // max: 1587643939000,
            type: 'datetime',
            labels: {
                formatter: function() {
                    return moment(this.value).format("MM/DD HH:mm");
                }
            },
            events: {
                setExtremes: function (e) {
                    $('#xmin').val(e.min);
                    $('#xmax').val(e.max);
                }
            }
        },

        yAxis: {
            // max: 1800,   // 크게 확대해서 보려면 20
            // min: -100,  // 크게 확대해서 보려면 -10, 없애버리면 자동 스케일
            showLastLabel: true,    // 위 아래 마지막 label 보임 (이게 없으면 끝label이 안 보임)
            scrollbar: {
                enabled: true
            },
            opposite: false,
            tickInterval: null,
            // minorTickInterval: 5,
            // minorTickLength: 0,
        },

        plotOptions: {
            series: {
                showInNavigator: true,
                turboThreshold: 0,
                events: {
                    legendItemClick: function (e) {
                        e.preventDefault();
                        // console.log(this);
                        // console.log(this.userOptions);
                        // console.log(this.userOptions.data[0]);
                        var chr_idx = this.userOptions._colorIndex; // _symbolIndex가 undefined일 때가 있어서 _colorIndex로 대체함
                        var chr_name = this.userOptions.name;
                        var old_type = this.userOptions.type;
                        var old_dashStyle = this.userOptions.dashStyle;
                        var old_amp = this.userOptions.data[0].yamp;
                        var old_move = this.userOptions.data[0].ymove;
                        $('#fchart input[name=chr_idx]').val(chr_idx);
                        $('#fchart .chr_name').text(chr_name);

                        // reset value of amplification, move
                        chr_amp_slider.slider("option", "value", old_amp);
                        chr_move_slider.slider("option", "value", old_move);
                        $('#chr_amp_value').val(old_amp);
                        $('#chr_move_value').val(old_move);
                        $('#chr_type option[value="'+old_type+'"]').attr('checked','checked');
                        $('#chr_type').val(old_type);
                        $('#chr_line').val(old_dashStyle);

                        $('.chr_control').show();
                    }
                },
                dataGrouping: {
                    enabled: false, // dataGrouping 안 함 (range가 변경되면 평균으로 바뀌어서 헷갈림)
                },
                marker: {
                    enabled: true   // point dot display
                }
            }
        },

        navigator: {
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    second: '%H:%M:%S',
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%Y-%m',
                    year: '%Y-%m'
                }
            },
        },

        navigation: {
            buttonOptions: {
                enabled: true, // contextButton (인쇄, 다운로드..) 설정 (기본옵션 사용자들에게는 안 보이게!!)
                align: 'right',
                x: -20,
                y: 15
            }
        },

        legend: {
            enabled: true,
        },

        rangeSelector: {
            enabled: false,
        },

        tooltip: {
            formatter: function(e) {
                // var tooltip1 =  moment(this.x).format("YYYY-MM-DD HH:mm:ss");
                if($('#dta_item').val()=='daily'||$('#dta_item').val()=='weekly') {
                    var tooltip1 =  moment(this.x).format("MM/DD");
                }
                else if($('#dta_item').val()=='monthly') {
                    var tooltip1 =  moment(this.x).format("YYYY-MM");
                }
                else if($('#dta_item').val()=='yearly') {
                    var tooltip1 =  moment(this.x).format("YYYY");
                }
                else {
                    var tooltip1 =  moment(this.x).format("MM/DD HH:mm:ss");
                }
                // console.log(this);
                var tooltip2 = [];
                $.each(this.points, function () {
                    // console.log(this);
                    tooltip1 += '<br/><span style="color:' + this.color + '">\u25CF '+this.series.name+'</span>: <b>' + this.point.yraw + '</b>';
                    if(this.point.y!=this.point.yraw) {
                        if(this.point.yamp!=1)
                            tooltip2[0] = '×' + this.point.yamp;
                        if(this.point.ymove!=0) {
                            var tooltip2_unit = (this.point.ymove>0) ? '+':'';  // -기호는 자동으로 붙음
                            tooltip2[1] = tooltip2_unit + this.point.ymove;
                        }
                        // console.log(tooltip2);
          
                        if(tooltip2.length>=1) {
                            tooltip1 += '<span style="font-size:0.8em;"> (' + tooltip2.join(" ") + ')</span>';
                        }
                    }
                });
                return tooltip1;
            },
            split: false,
            shared: true
        },
        series: seriesOptions
        
    };

    chart = new Highcharts.stockChart(options);
    removeLogo();
    // console.log( chart.series );
    
}

// As we're loading the data asynchronously, we don't know what order it will arrive.
// So we keep a counter and create the chart when all the data is loaded.
function drawChart(data) {
    // find which graph
    var para = urlParaToJSON2(this.url); // get values from Json Url
    // console.log(this.url);
    var graph_id = para.graph_id;
    // console.log('기준: '+graph_id);
    
    // idx 찾기 (비동기라 어떤 idx가 왔는지 모르기 때문!!)
    if( $("#chart1").attr("graphs") != undefined ) {
        graphs =  JSON.parse( $("#chart1").attr("graphs") );
        for(i=0;i<graphs.length;i++) {
            if( graph_id == graphs[i].graph_id ) {
                var chr_idx = i;
            }
        }
        console.log(chr_idx + ' arrived.');
            
        // console.log(graphs[chr_idx]);
        // 해당하는 graphs 배열에서 값을 뽑아서 graph_id 를 생성
        var graph_id1 = getGraphId(graphs[chr_idx].mms_idx, graphs[chr_idx].dta_type, graphs[chr_idx].dta_no);
        var chr_id = {
            mms_idx: graphs[chr_idx].mms_idx,
            dta_type: graphs[chr_idx].dta_type,
            dta_no: graphs[chr_idx].dta_no,
            graph_name: graphs[chr_idx].graph_name,
            graph_id: graph_id1
        };

        // data variable definition <<<<==============================================
        seriesOptions[chr_idx] = {
            name: decodeURIComponent(graphs[chr_idx].graph_name),
            id:chr_id,
            type: graphs[chr_idx].graph_type,
            dashStyle: graphs[chr_idx].graph_line,
            data: data
        };

        // Create chart when all data loaded.
        seriesCounter += 1;
        if (seriesCounter == graphs.length) {
            console.log('graph drawing .................................');
            console.log('seriesOptions length: ' + seriesOptions.length);
            createChart();
        }
    }
}

// ==========================================================================================
// 그래프 호출 =================================================================================
// ==========================================================================================
$(document).on('click','#fsearch button[type=submit]',function(e){
    e.preventDefault();
    var frm = $('#fsearch');
    var st_date = frm.find('#st_date').val() || '';
    var st_time = frm.find('#st_time').val() || '';
    var en_date = frm.find('#en_date').val() || '';
    var en_time = frm.find('#en_time').val() || '';
    if(st_date==''||en_date==''||st_time==''||en_time=='') {
        alert('검색 날짜, 시간을 입력하세요.');
        return false;
    }

    dta_loading('show');
 
    // get the graphs attribute form target object div
    var graphs =  JSON.parse( $("#chart1").attr("graphs") );
    // console.log(graphs);
    // console.log(graphs.length);

    // 다중 그래프 표현
    for(i=0;i<graphs.length;i++) {
        // console.log(i+' --------------- ');
        var dta_data_url_host = graphs[i].dta_data_url_host;
        var dta_data_url_path = graphs[i].dta_data_url_path;
        var dta_data_url_file = graphs[i].dta_data_url_file;
        var mms_idx = graphs[i].mms_idx;
        var mms_name = graphs[i].mms_name;
        var dta_type = graphs[i].dta_type;
        var dta_no = graphs[i].dta_no;
        var graph_name = graphs[i].graph_name;
        var graph_id1 = getGraphId(mms_idx, dta_type, dta_no);
        // console.log(i+'. '+graph_id1);

        // 그래프 호출 URL
        var dta_url = 'http://'+dta_data_url_host+dta_data_url_path+'/'+dta_data_url_file+'?token=1099de5drf09'
                        +'&mms_idx='+mms_idx+'&dta_type='+dta_type+'&dta_no='+dta_no
                        +'&st_date='+st_date+'&st_time='+st_time+'&en_date='+en_date+'&en_time='+en_time
                        +'&graph_id='+graph_id1;
        //..........................................
        console.log(dta_url);

        Highcharts.getJSON(
            dta_url,
            drawChart
        );

    }
    dta_loading('hide');
    $('.div_btn_add').show();

});


// 로딩 spinner 이미지 표시/비표시
function dta_loading(flag) {
    var img_loading = $('<i class="fa fa-spin fa-spinner" id="spinner" style="position:absolute;top:80px;left:46%;font-size:4em;"></i>');
    if(flag=='show') {
        // console.log('show');
        $('#chart1').append(img_loading);
    }
    else if(flag=='hide') {
        // console.log('hide');
        $('#spinner').remove();
    }
}

// highchart.com이라는 로고 제거
function removeLogo() {
    //Highcharts.com 로고 제거
    setTimeout(function(e){
        $('.highcharts-credits').remove();
    },10);
}

// amplification setting
var chr_amp_slider = $( "#chr_amp" ).slider({
    range: "max",
    step: 0.5,
    min: 0.5,
    max: 5,
    value: 1, // Default
    slide: function( event, ui ) {
        $( "#chr_amp_value" ).val( ui.value );
    },
    stop: function( event, ui ) {
        // 증폭 값이 바뀌면 적용
        // console.log(ui.value);
        $('#fchart button[type=submit]').trigger('click');
    }
});
$( "#chr_amp_value" ).val( $( "#chr_amp" ).slider( "value" ) );   // default value display

// value move setting
var chr_move_slider = $( "#chr_move" ).slider({
    range: "max",
    min: -200,
    max: 200,
    value: 0,   // Default
    slide: function( event, ui ) {
        $( "#chr_move_value" ).val( ui.value );
    },
    stop: function( event, ui ) {
        // 이동 값이 바뀌면 적용
        // console.log(ui.value);
        $('#fchart button[type=submit]').trigger('click');
    }
});
$( "#chr_move_value" ).val( $( "#chr_move" ).slider( "value" ) );   // default value display


// 그래프 불러오기 (팝업모달)
$(document).on('click','.btn_add_chart',function(e){
    e.preventDefault();
    var frm = $('#fsearch');
    var com_idx = '<?=$com['com_idx']?>';
    var mms_idx = '<?=$mms['mms_idx']?>';
    var st_date = frm.find('#st_date').val() || '';
    var st_time = frm.find('#st_time').val() || '';
    var en_date = frm.find('#en_date').val() || '';
    var en_time = frm.find('#en_time').val() || '';
    if(st_date==''||en_date=='') {
        alert('검색 날짜를 입력하세요.');
    }
    else {
        var href = $(this).attr('href');
        winAddChart = window.open(href+'&com_idx='+com_idx+'&sch_field=mms_idx&sch_word='+mms_idx+'&st_date='+st_date+'&st_time='+st_time+'&en_date='+en_date+'&en_time='+en_time,"winAddChart","left=100,top=100,width=520,height=600,scrollbars=1");
        winAddChart.focus();
    }
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

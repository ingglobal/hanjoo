<?php
$sub_menu = "940160";
include_once('./_common.php');

$g5['title'] = '온도(주조공정(SUB)) 그래프';
include_once('./_top_menu_tsdb.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

// 검색 조건
$st_time_ahead = 3600*24;  // 5hour ahead.
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
        <a href="./data_graph_add.php?file_name=<?php echo $g5['file_name']?>" class="btn btn_03 btn_add_chart"><i class="fa fa-bar-chart"></i>불러오기</a>
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
    var dta_url = (dta_item=='minute'||dta_item=='second') ? '' : '.sum'; // measure.php(그룹핑), measure.sum.php(일자이상)
    var dta_file = (dta_item=='minute'||dta_item=='second') ? '' : '.sum'; // measure.php(그룹핑), measure.sum.php(일자이상)
    if(st_date==''||en_date=='') {
        alert('검색 날짜를 입력하세요.');
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
        var dta_data_url = graphs[i].dta_data_url;
        var dta_json_file = graphs[i].dta_json_file;
        var dta_group = graphs[i].dta_group;
        var mms_idx = graphs[i].mms_idx;
        var mms_name = graphs[i].mms_name;
        var dta_type = graphs[i].dta_type;
        var dta_no = graphs[i].dta_no;
        var shf_no = graphs[i].shf_no;
        var dta_mmi_no = graphs[i].dta_mmi_no;
        var dta_defect = graphs[i].dta_defect;
        var dta_defect_type = graphs[i].dta_defect_type;
        var dta_code = graphs[i].dta_code;
        var graph_name = graphs[i].graph_name;
        var graph_id1 = getGraphId(dta_json_file, dta_group, mms_idx, dta_type, dta_no, shf_no, dta_mmi_no, dta_defect, dta_defect_type, dta_code);
        // console.log(i+'. '+graph_id1);

        // 그래프 호출 URL
        var dta_url = '//'+dta_data_url+'/'+dta_json_file+dta_file+'.php?token=1099de5drf09'
                        +'&mms_idx='+mms_idx+'&dta_group='+dta_group+'&shf_no='+shf_no+'&dta_mmi_no='+dta_mmi_no
                        +'&dta_type='+dta_type+'&dta_no='+dta_no
                        +'&dta_defect='+dta_defect+'&dta_defect_type='+dta_defect_type
                        +'&dta_code='+dta_code
                        +'&dta_item='+dta_item+'&dta_unit='+dta_unit
                        +'&st_date='+st_date+'&st_time='+st_time+'&en_date='+en_date+'&en_time='+en_time
                        +'&graph_id='+graph_id1;
        // console.log(dta_url);

        Highcharts.getJSON(
            dta_url,
            drawChart
        );

    }
    dta_loading('hide');
    $('.div_btn_add').show();

});

// Detail graph ---------------
Highcharts.getJSON(g5_url+'/device/rdb/shot_sub.multi.php?<?=$qs?>', function(data) {

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
                value: 690,
                color: 'red',
                dashStyle: 'LongDash',
                width: 2,
                label: {
                    text: 'Last quarter minimum'
                }
            }]
        },

        series: [{
            name: '값',
            data: data,
            tooltip: {
                valueDecimals: 4
            }
        }]
    });
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

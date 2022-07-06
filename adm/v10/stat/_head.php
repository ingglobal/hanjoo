<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

include_once(G5_USER_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

// jquery-ui css
add_stylesheet('<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_USER_ADMIN_URL.'/css/chart.css">', 2);
add_javascript('<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>',2);
add_javascript('<script src="https://code.highcharts.com/highcharts.js"></script>',2);
add_javascript('<script src="https://code.highcharts.com/modules/exporting.js"></script>',2);
add_javascript('<script src="https://code.highcharts.com/modules/export-data.js"></script>',2);
add_javascript('<script src="https://code.highcharts.com/modules/accessibility.js"></script>',2);
add_javascript('<script src="'.G5_USER_ADMIN_LIB_URL.'/highcharts/Highstock/code/themes/high-contrast-dark.js"></script> ',2);
?>


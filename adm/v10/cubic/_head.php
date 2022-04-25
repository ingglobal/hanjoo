<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

include_once(G5_USER_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

// jquery-ui css
add_stylesheet('<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />', 0);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$(function(){
    // Test db display, Need to know what DB is using.
    <?php
    if(!preg_match("/_www$/",G5_MYSQL_DB) && !G5_IS_MOBILE) {
        echo "$('#ft p').prepend('<span style=\"color:darkorange;\">".G5_MYSQL_DB."</span>');";
    }
    ?>
});
</script>

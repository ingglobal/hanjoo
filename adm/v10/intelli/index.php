<?php
$sub_menu = "920110";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$g5['title'] = '실시간모니터링';
// include_once('./_top_menu_db.php');
include_once('./_head.php');
// echo $g5['container_sub_title'];

?>
<style>
</style>

<div class="local_desc01 local_desc" style="display:no ne;">
    <p>작업중!!</p>
</div>



<?php
include_once ('./_tail.php');
?>

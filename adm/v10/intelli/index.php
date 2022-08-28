<?php
$sub_menu = "920110";
include_once('./_common.php');

auth_check($auth[$sub_menu],"r");

$g5['title'] = '실시간모니터링';
// include_once('./_top_menu_db.php');
include_once('./_head.php');
// echo $g5['container_sub_title'];

add_stylesheet('<link rel="stylesheet" href="'.G5_USER_ADMIN_URL.'/css/intelli/index.css">', 2);
?>
<style>
</style>

<div class="local_desc01 local_desc" style="display:none;">
    <p>작업중!!</p>
</div>

<div class="div_recommend">
    <div class="title01">
        추천파라미터
        <span class="btn_more">더보기</span>
    </div>
    <div class="cont01">
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
        <div class="rec_item">
            <p>보온로온도</p>
            <strong>687.4</strong>
            <span>22-07-15 10:00</span>
        </div>
    </div>
</div>





<?php
include_once ('./_tail.php');
?>

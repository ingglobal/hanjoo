<?php
$sub_menu = '950300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$g5['group_message_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$page = 1;

$sql = " select * {$sql_common} order by gme_idx desc ";
//print_r3($sql);
$result = sql_query($sql,1);

$g5['title'] = '그룹메시지관리';
include_once('./_top_menu_member.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

$colspan = 8;
?>
<style>
    .td_mng_adm {width:130px;}
</style>

<div class="local_desc01 local_desc">
    <p>
        <b>테스트 메시지 발송</b>은 현재 로그인된 관리자 휴대폰 또는 이메일로 테스트 메시지가 발송됩니다.<br>
        현재 등록된 메일은 총 <?php echo $total_count ?>건입니다.
    </p>
</div>


<form name="fmaillist" id="fmaillist" action="./group_message_delete.php" method="post">
<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col"><input type="checkbox" name="chkall" value="1" id="chkall" title="현재 페이지 목록 전체선택" onclick="check_all(this.form)"></th>
        <th scope="col">번호</th>
        <th scope="col">메시지타입</th>
        <th scope="col">제목</th>
        <th scope="col">작성일시</th>
        <th scope="col">테스트</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $s_vie = '<a href="./group_message_preview.php?gme_idx='.$row['gme_idx'].'" target="_blank" class="btn btn_03 btn_preview">미리보기</a>';
        $s_mod = '<a href="./group_message_form.php?'.$qstr.'&w=u&gme_idx='.$row['gme_idx'].'" class="btn btn_03">수정</a>';

        $num = number_format($total_count - ($page - 1) * $config['cf_page_rows'] - $i);

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['gme_subject']; ?> 메일</label>
            <input type="checkbox" id="chk_<?php echo $i ?>" name="chk[]" value="<?php echo $row['gme_idx'] ?>">
        </td>
        <td class="td_num_c"><?php echo $num ?></td>
        <td class="td_datetime"><?php echo $g5['set_gme_type_value'][$row['gme_type']] ?></td>
        <td class="td_left"><a href="./group_message_form.php?w=u&amp;gme_idx=<?php echo $row['gme_idx'] ?>"><?php echo $row['gme_subject'] ?></a></td>
        <td class="td_datetime"><?php echo $row['gme_reg_dt'] ?></td>
        <td class="td_test"><a href="./group_message_test.php?gme_idx=<?php echo $row['gme_idx'] ?>">테스트</a></td>
        <td class="td_mng_adm"><?php echo $s_vie.$s_mod; ?></td>
    </tr>

    <?php
    }
    if (!$i)
        echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>
<div class="btn_fixed_top">
    <input type="submit" value="선택삭제" class="btn btn_02">
    <a href="./group_message_form.php" id="message_add" class="btn btn_01">추가하기</a>
</div>
</form>

<script>
$(function() {
    $(document).on('click','.btn_preview',function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        winPreview = window.open(href, "winPreview", "left=100,top=100,width=600,height=600,scrollbars=1");
        winPreview.focus();
        return false;
    });
    
    
    $('#fmaillist').submit(function() {
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
            if (!is_checked("chk[]")) {
                alert("선택삭제 하실 항목을 하나 이상 선택하세요.");
                return false;
            }

            return true;
        } else {
            return false;
        }
    });
});
</script>

<?php
include_once ('./_tail.php');
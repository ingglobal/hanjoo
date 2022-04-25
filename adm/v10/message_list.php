<?php
$sub_menu = "950400";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '메시지발송이력';
// include_once('./_top_menu_rct.php');
include_once('./_head.php');
// echo $g5['container_sub_title'];

$sql_common = " FROM {$g5['message_table']} AS msg "; 

$where = array();
// 디폴트 검색조건 (used 제외)
$where[] = " msg_status NOT IN ('delete','trash') ";

// 검색어 설정
if ($stx != "") {
    switch ($sfl) {
		case ( $sfl == 'msg_idx' || $sfl == 'itm_idx' ) :
			$where[] = " {$sfl} = '".trim($stx)."' ";
            break;
		case ( $sfl == 'msg_content' ) :
			$where[] = " ({$sfl} LIKE '".trim($stx)."%' OR msg_mobile_content LIKE '".trim($stx)."%') ";
            break;
        default :
			$where[] = " $sfl LIKE '%".trim($stx)."%' ";
            break;
    }
}


// 최종 WHERE 생성
if ($where)
    $sql_search = ' WHERE '.implode(' AND ', $where);

if (!$sst) {
    $sst = "msg_idx";
    $sod = "desc";
}

$sql_order = " ORDER BY {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "SELECT *
        {$sql_common} {$sql_search} {$sql_order}
        LIMIT {$from_record}, {$rows}
";
// print_r3($sql);
$result = sql_query($sql,1);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
$qstr .= '&sca='.$sca.'&ser_cod_type='.$ser_cod_type; // 추가로 확장해서 넘겨야 할 변수들
?>
<style>
.td_msg_subject,
.td_msg_receiver,
.td_msg_content,
.td_msg_subject {text-align:left !important;}
.td_msg_reg_dt {width:150px;}
.td_msg_type {width:90px;}
.td_msg_expire_date {width:90px;}
.td_applicant_count a {text-decoration: underline;}
</style>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">총 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="msg_subject"<?php echo get_selected($_GET['sfl'], "msg_subject"); ?>>제목</option>
    <option value="msg_content"<?php echo get_selected($_GET['sfl'], "msg_content"); ?>>내용</option>
    <option value="msg_hp"<?php echo get_selected($_GET['sfl'], "msg_hp"); ?>>휴대폰</option>
    <option value="msg_email"<?php echo get_selected($_GET['sfl'], "msg_email"); ?>>이메일</option>
    <option value="msg_reg_dt"<?php echo get_selected($_GET['sfl'], "msg_reg_dt"); ?>>일시</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>

<div class="local_desc01 local_desc" style="display:none;">
    <p>모집현황 항목의 숫자를 클릭하면 해당 모집현황 검색 결과 페이지로 바로 이동합니다.</p>
</div>


<form name="form01" id="form01" action="./message_list_update.php" onsubmit="return form01_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="msg_list_chk" style="display:none;">
            <label for="chkall" class="sound_only">전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">일시</th>
        <th scope="col">구분</th>
        <th scope="col">수신자</th>
        <th scope="col"><?php echo subject_sort_link('msg_subject') ?>제목</a></th>
        <th scope="col">내용</th>
        <th scope="col">상태</th>
    </tr>
    <tr>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

        $s_mod = '<a href="./message_form.php?'.$qstr.'&amp;w=u&amp;msg_idx='.$row['msg_idx'].'" class="btn btn_03">수정</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>" tr_id="<?php echo $row['msg_idx'] ?>">
        <td class="td_chk" style="display:none;">
            <input type="hidden" name="msg_idx[<?php echo $i ?>]" value="<?php echo $row['msg_idx'] ?>" id="msg_idx_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['msg_subject']); ?> <?php echo get_text($row['msg_nick']); ?>님</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_msg_reg_dt"><?=$row['msg_reg_dt']?></td><!-- 일시 -->
        <td class="td_msg_type"><?=$g5['set_gme_type_value'][$row['msg_type']]?></td><!-- 구분 -->
        <td class="td_msg_receiver"><?=($row['msg_type']=='hp')?$row['msg_hp']:$row['msg_email']?></td><!-- 수신자 -->
        <td class="td_msg_subject"><?=$row['msg_subject']?></td><!-- 제목 -->
        <td class="td_msg_content"><?=cut_str(strip_tags($row['msg_content']),40)?></td><!-- 내용 -->
        <td class="td_msg_status"><?=$g5['set_msg_status_value'][$row['msg_status']]?></td><!-- 상태 -->
    </tr>
    <?php
    }
    if ($i == 0)
        echo "<tr><td colspan='20' class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top" style="display:none;">
    <?php if (!auth_check($auth[$sub_menu],'d')) { ?>
       <a href="javascript:" id="btn_excel_down" class="btn btn_02" style="margin-right:50px;display:none;">엑셀다운</a>
    <?php } ?>
    <?php if (!auth_check($auth[$sub_menu],'w')) { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    <a href="./message_form.php" id="member_add" class="btn btn_01">추가하기</a>
    <?php } ?>

</div>


</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<div id="modal01" title="엑셀 파일 업로드" style="display:none;">
    <form name="form02" id="form02" action="./message_excel_upload.php" onsubmit="return form02_submit(this);" method="post" enctype="multipart/form-data">
        <table>
        <tbody>
        <tr>
            <td style="line-height:130%;padding:10px 0;">
                <ol>
                    <li>엑셀은 97-2003통합문서만 등록가능합니다. (*.xls파일로 저장)</li>
                    <li>엑셀은 하단에 탭으로 여러개 있으면 등록 안 됩니다. (한개의 독립 문서이어야 합니다.)</li>
                </ol>
            </td>
        </tr>
        <tr>
            <td style="padding:15px 0;">
                <input type="file" name="file_excel" onfocus="this.blur()">
            </td>
        </tr>
        <tr>
            <td style="padding:15px 0;">
                <button type="submit" class="btn btn_01">확인</button>
            </td>
        </tr>
        </tbody>
        </table>
    </form>
</div>


<script>
// 엑셀등록 버튼
$( "#btn_excel_upload" ).on( "click", function() {
    $( "#modal01" ).dialog( "open" );
});
$( "#modal01" ).dialog({
    autoOpen: false
    , position: { my: "right-10 top-10", of: "#btn_excel_upload"}
});


// 가격 입력 쉼표 처리
$(document).on( 'keyup','input[name^=msg_price], input[name^=msg_count], input[name^=msg_lead_time]',function(e) {
    if(!isNaN($(this).val().replace(/,/g,'')))
        $(this).val( thousand_comma( $(this).val().replace(/,/g,'') ) );
});

// 숫자만 입력
function chk_Number(object){
    $(object).keyup(function(){
        $(this).val($(this).val().replace(/[^0-9|-]/g,""));
    });
}
    

function form01_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?php
include_once ('./_tail.php');
?>

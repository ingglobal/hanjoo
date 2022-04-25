<?php
// 호출페이지들
// /adm/v10/applicant_form.php: 지원자정보등록 - 채용공고검색
include_once('./_common.php');

if($member['mb_level']<4)
	alert_close('접근할 수 없는 페이지입니다.');

// 검색어 
$rct_subject = isset($_REQUEST['rct_subject']) ? clean_xss_tags($_REQUEST['rct_subject'], 1, 1) : '';

$html_title = '채용공고검색';

$g5['title'] = $html_title;
include_once(G5_PATH.'/head.sub.php');

$sql_common = " FROM {$g5['recruit_table']} AS rct
                    LEFT JOIN {$g5['member_table']} AS mb ON mb.mb_id = rct.mb_id
"; 
$where = array();
// 디폴트 검색조건 (used 제외)
$where[] = " rct_status NOT IN ('delete','trash') ";

// 검색어 설정
if ($stx != "") {
    switch ($sfl) {
		case ( $sfl == 'rct_idx' || $sfl == 'itm_idx' ) :
			$where[] = " {$sfl} = '".trim($stx)."' ";
            break;
		case ( $sfl == 'rct_content' ) :
			$where[] = " ({$sfl} LIKE '".trim($stx)."%' OR rct_mobile_content LIKE '".trim($stx)."%') ";
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
    $sst = "rct_idx";
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

$sql = "SELECT rct.*, mb_name
        {$sql_common} {$sql_search} {$sql_order}
        LIMIT {$from_record}, {$rows}
";
// print_r3($sql);
$result = sql_query($sql,1);

$qstr1 = '&file_name='.$file_name.'&item='.$item;
$qstr .= $qstr1;
?>
<style>
.td_rct_subject,
.td_rct_com_name {text-align:left !important;}
.td_rct_subject {width:50%;}
.btn_cancel {
    width: 30px;
    height: 30px;
    border: 1px solid #dcdcdc;
    background: #f2f2f2;
    padding: 5px 10px 4px;
    vertical-align: middle;
}
</style>

<div id="sch_member_frm" class="new_win scp_new_win">
    <h1><?=$g5['title']?></h1>

    <form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
    <input type="hidden" name="file_name" value="<?php echo $file_name; ?>" class="frm_input">
    <input type="hidden" name="item" value="<?php echo $item; ?>" class="frm_input">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="rct_com_name"<?php echo get_selected($_GET['sfl'], "rct_com_name"); ?>>회사명</option>
        <option value="rct_subject"<?php echo get_selected($_GET['sfl'], "rct_subject"); ?>>제목</option>
        <option value="mb_name"<?php echo get_selected($_GET['sfl'], "mb_name"); ?>>담당자</option>
        <option value="rct_content"<?php echo get_selected($_GET['sfl'], "rct_content"); ?>>내용</option>
        <option value="rct_work_place"<?php echo get_selected($_GET['sfl'], "rct_work_place"); ?>>근무지</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
    <input type="submit" class="btn_submit" value="검색">
    <a href="?<?=$qstr1?>" class="btn_cancel">취소</a>
    </form>
    <script>
        $(document).on('click','.btn_submit',function(e){
//            e.preventDefault();
            if($(e.target).val()=='취소') {
                self.location='?<?=$qstr?>'
                return false;
            }
        });
    </script>

    <div class="tbl_head01 tbl_wrap new_win_con">
        <table>
        <caption>검색결과</caption>
        <thead>
        <tr>
            <th>회사명</th>
            <th>제목</th>
            <th>담당자</th>
            <th>선택</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for($i=0; $row=sql_fetch_array($result); $i++) {
        ?>
        <tr>
            <td class="td_com_name"><?php echo $row['rct_com_name']; ?></td>
            <td class="td_rct_subject"><?php echo get_text($row['rct_subject']); ?></td>
            <td class="td_mb_name"><?php echo $row['mb_name']; ?></td>
            <td class="scp_find_select td_mng td_mng_s">
                <button type="button" class="btn btn_03 btn_select"
                    rct_idx="<?=$row['rct_idx']?>"
                    rct_subject="<?=$row['rct_subject']?>"
                >선택</button>
            </td>
        </tr>
        <?php
        }

        if($i ==0)
            echo '<tr><td colspan="4" class="empty_table">검색된 자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

</div>

<script>
$('.btn_select').click(function(e){
    e.preventDefault();
    var rct_idx = $(this).attr('rct_idx');
    var rct_subject = $(this).attr('rct_subject');

    <?php
    // 리스트
    if($file_name=='applicant_list') {
    ?>
        $("input[name=ser_rct_idx]", opener.document).val( rct_idx );
        $("input[name=rct_subject]", opener.document).val( rct_subject );
    <?php
    }
    // 수정
    if($file_name=='applicant_form') {
    ?>
        $("input[name=rct_idx]", opener.document).val( rct_idx );
        $("input[name=rct_subject]", opener.document).val( rct_subject );
    <?php
    }
    // 게시판 글쓰기
    if($file_name=='write'||$file_name=='error_code_form') {
    ?>
        $("input[name=com_idx]", parent.document).val( com_idx );
        $("input[name=com_name]", parent.document).val( com_name );
        $("input[name=rct_idx]", parent.document).val( rct_idx );
        $("input[name=rct_subject]", parent.document).val( rct_subject );
        $("input[name=imp_idx]", parent.document).val( imp_idx );
        $("input[name=imp_name]", parent.document).val( imp_name );
        $("#mms_info", parent.document).hide();
    <?php
    }
    ?>
    window.close();

});
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
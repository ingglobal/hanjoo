<?php
$sub_menu = "960900";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

if(!$config['cf_faq_skin']) $config['cf_faq_skin'] = "basic";
if(!$config['cf_mobile_faq_skin']) $config['cf_mobile_faq_skin'] = "basic";

$g5['title'] = '솔루션설정';
include_once('./_top_menu_setting.php');
include_once('./_head.php');
echo $g5['container_sub_title'];

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_default">기본설정</a></li>
    <li><a href="#anc_cf_agree">채용지원동의서</a></li>
    <li><a href="#anc_cf_ppurio">문자설정</a></li>
    <li style="display:none;"><a href="#anc_cf_email">이메일설정</a></li>
    <li><a href="#anc_cf_admin">관리설정</a></li>
</ul>';
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">

<section id="anc_cf_default">
	<h2 class="h2_frm">기본설정</h2>
	<?php echo $pg_anchor ?>
	
	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>기본설정</caption>
		<colgroup>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>
		<tr>
            <th scope="row">신체촬영타입</th>
            <td colspan="3">
                <textarea name="set_mbf_body_type" id="set_mbf_body_type" style="width:50%;"><?php echo get_text($g5['setting']['set_mbf_body_type']); ?></textarea>
            </td>
        </tr>
		<tr>
            <th scope="row">의료기관자료타입</th>
            <td colspan="3">
                <textarea name="set_mbf_medical_type" id="set_mbf_medical_type" style="width:50%;"><?php echo get_text($g5['setting']['set_mbf_medical_type']); ?></textarea>
            </td>
        </tr>
		<tr>
			<th scope="row">자료타입</th>
			<td>
				<input type="text" name="set_mbf_type" value="<?php echo $g5['setting']['set_mbf_type'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">사진영상구분</th>
			<td>
				<input type="text" name="set_mbf_file_type" value="<?php echo $g5['setting']['set_mbf_file_type'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">메시지타입</th>
			<td>
				<input type="text" name="set_gme_type" value="<?php echo $g5['setting']['set_gme_type'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">지원자상태</th>
			<td>
				<input type="text" name="set_apc_status" value="<?php echo $g5['setting']['set_apc_status'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">메시지발송결과</th>
			<td>
				<?php echo help('fail=실패,ok=발송완료') ?>
				<input type="text" name="set_msg_status" value="<?php echo $g5['setting']['set_msg_status'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">지원자관리 리스트수</th>
			<td>
				<?php echo help('지원자관리 페이지에서 한 페이지에 리스트되는 항목 갯수입니다.') ?>
				<input type="text" name="set_applicant_page_rows" value="<?php echo $g5['setting']['set_applicant_page_rows'] ?>" class="frm_input" style="width:30px;"> 개
			</td>
		</tr>
		<tr>
			<th scope="row">지원자정보삭제</th>
			<td>
				<?php echo help('설정 년수가 지난 지원자 정보를 자동으로 삭제합니다.') ?>
				<input type="text" name="set_applicant_del_year" value="<?php echo $g5['setting']['set_applicant_del_year'] ?>" class="frm_input" style="width:30px;"> 년
			</td>
		</tr>
		<tr>
            <th scope="row">PDF 파일 하단 내용</th>
            <td colspan="3">
                <textarea name="set_pdf_warning" id="set_pdf_warning"><?php echo get_text($g5['setting']['set_pdf_warning']); ?></textarea>
            </td>
        </tr>
		<tr>
			<th scope="row">디폴트상태값</th>
			<td colspan="3">
				<?php echo help('pending=대기,auto-draft=자동저장,ok=정상,hide=숨김,trash=삭제') ?>
				<input type="text" name="set_status" value="<?php echo $g5['setting']['set_status'] ?>" id="set_status" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">분류(카테고리) terms</th>
			<td>
				<?php echo help('전체 프로그램을 영향을 주는 설정입니다. 수정하지 마세요.') ?>
				<input type="text" name="set_taxonomies" value="<?php echo $g5['setting']['set_taxonomies'] ?>" id="set_taxonomies" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">회원레벨명 mb_level</th>
			<td>
				<input type="text" name="set_mb_levels" value="<?php echo $g5['setting']['set_mb_levels'] ?>" id="set_mb_levels" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">회원성별</th>
			<td>
				<input type="text" name="set_mb_gender" value="<?php echo $g5['setting']['set_mb_gender'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
        </tbody>
		</table>
	</div>
</section>

<section id="anc_cf_agree">
    <h2 class="h2_frm">채용지원동의서</h2>
    <?php echo $pg_anchor; ?>
    <div class="local_desc02 local_desc">
        <p>온라인 지원서 페이지의 동의서 관련 내용들입니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>동의서관리</caption>
        <colgroup>
            <col class="grid_4" style="width:200px;">
            <col>
        </colgroup>
        <tbody>
		<tr>
            <th scope="row">개인정보수집 및 이용동의</th>
            <td>
                <textarea name="set_agree_1" id="set_agree_1"><?php echo get_text($g5['setting']['set_agree_1']); ?></textarea>
            </td>
        </tr>
		<tr>
            <th scope="row">민감정보의 수집 및 이용동의</th>
            <td>
                <textarea name="set_agree_2" id="set_agree_2"><?php echo get_text($g5['setting']['set_agree_2']); ?></textarea>
            </td>
        </tr>
		<tr>
            <th scope="row">마케팅활용 정책</th>
            <td>
                <textarea name="set_agree_3" id="set_agree_3"><?php echo get_text($g5['setting']['set_agree_3']); ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

    
    
<section id="anc_cf_ppurio">
    <h2 class="h2_frm">문자설정</h2>
    <?php echo $pg_anchor; ?>
    <div class="local_desc02 local_desc">
        <p>뿌리오 관련 문자 설정입니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>문자설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
		<tr>
			<th scope="row">뿌리오아이디</th>
			<td colspan="3">
				<input type="text" name="set_ppurio_userid" value="<?php echo $g5['setting']['set_ppurio_userid'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
		<tr>
			<th scope="row">문자발송번호</th>
			<td colspan="3">
                <?php echo help('뿌리오에서 설정된 문자발송 번호를 입력하세요. 숫자만 입력하세요.') ?>
				<input type="text" name="set_ppurio_callback" value="<?php echo $g5['setting']['set_ppurio_callback'] ?>" class="frm_input" style="width:60%;">
			</td>
		</tr>
        </tbody>
        </table>
    </div>
</section>

<section id="anc_cf_email" style="display:none;">
    <h2 class="h2_frm">이메일설정</h2>
    <?php echo $pg_anchor; ?>
    <div class="local_desc02 local_desc">
        <p>이메일 관련 설정입니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>이메일설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">메일</th>
            <td colspan="3">
                <?php echo help('치환 변수: {제목} {업체명} {이름} {설비명} {코드} {만료일} {년월일} {남은기간} {HOME_URL}'); ?>
                <input type="text" name="set_email_subject" value="<?php echo $g5['setting']['set_email_subject']; ?>" class="frm_input" style="width:80%;" placeholder="메일제목">
                <?php echo editor_html("set_email_content", get_text($g5['setting']['set_email_content'], 0)); ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<section id="anc_cf_admin">
    <h2 class="h2_frm">관리설정</h2>
    <?php echo $pg_anchor; ?>
    <div class="local_desc02 local_desc">
        <p>관리자 설정입니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>관리설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_admin_company_name">회사명</label></th>
            <td>
                <input type="text" name="de_admin_company_name" value="<?php echo get_sanitize_input($default['de_admin_company_name']); ?>" id="de_admin_company_name" class="frm_input" size="30">
            </td>
            <th scope="row"><label for="de_admin_company_saupja_no">사업자등록번호</label></th>
            <td>
                <input type="text" name="de_admin_company_saupja_no"  value="<?php echo get_sanitize_input($default['de_admin_company_saupja_no']); ?>" id="de_admin_company_saupja_no" class="frm_input" size="30">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_owner">대표자명</label></th>
            <td colspan="3">
                <input type="text" name="de_admin_company_owner" value="<?php echo get_sanitize_input($default['de_admin_company_owner']); ?>" id="de_admin_company_owner" class="frm_input" size="30">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_tel">대표전화번호</label></th>
            <td>
                <input type="text" name="de_admin_company_tel" value="<?php echo get_sanitize_input($default['de_admin_company_tel']); ?>" id="de_admin_company_tel" class="frm_input" size="30">
            </td>
            <th scope="row"><label for="de_admin_company_fax">팩스번호</label></th>
            <td>
                <input type="text" name="de_admin_company_fax" value="<?php echo get_sanitize_input($default['de_admin_company_fax']); ?>" id="de_admin_company_fax" class="frm_input" size="30">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_zip">사업장우편번호</label></th>
            <td>
                <input type="text" name="de_admin_company_zip" value="<?php echo get_sanitize_input($default['de_admin_company_zip']); ?>" id="de_admin_company_zip" class="frm_input" size="10">
            </td>
            <th scope="row"><label for="de_admin_company_addr">사업장주소</label></th>
            <td>
                <input type="text" name="de_admin_company_addr" value="<?php echo get_sanitize_input($default['de_admin_company_addr']); ?>" id="de_admin_company_addr" class="frm_input" size="30">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_info_name">정보관리책임자명</label></th>
            <td>
                <input type="text" name="de_admin_info_name" value="<?php echo get_sanitize_input($default['de_admin_info_name']); ?>" id="de_admin_info_name" class="frm_input" size="30">
            </td>
            <th scope="row"><label for="de_admin_info_email">정보책임자 e-mail</label></th>
            <td>
                <input type="text" name="de_admin_info_email" value="<?php echo get_sanitize_input($default['de_admin_info_email']); ?>" id="de_admin_info_email" class="frm_input" size="30">
            </td>
        </tr>
		<tr>
            <th scope="row">관리자메모</th>
            <td colspan="3">
                <?php echo help('관리자 메모입니다.') ?>
                <textarea name="set_memo_admin" id="set_memo_admin"><?php echo get_text($g5['setting']['set_memo_admin']); ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
$(function(){

});

	$( ".btn_popup" ).on( "click", function(e) {
		e.preventDefault();
		var href = $(this).attr('href') + '/?set_map_default=' + $('input[name=set_map_default]').val();
		winPopup = window.open(href, "winPopup", "left=100,top=100,width=520,height=500,scrollbars=1");
		winPopup.focus();
	});

function fconfigform_submit(f) {

    <?php echo get_editor_js("set_email_content"); ?>
    <?php // echo chk_editor_js("set_email_content"); ?>

    f.action = "./config_form_update.php";
    return true;
}
</script>

<?php
include_once ('./_tail.php');
?>

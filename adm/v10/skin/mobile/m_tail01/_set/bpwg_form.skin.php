<?php
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
//adm/ajax/bpwidget_call_skin_config.php
//아작스로 이 페이지가 호출될때는 add_stylesheet() OR add_javascript()함수가 반영되지 않는다.
//add_stylesheet('<link rel="stylesheet" href="'.$bwg_skin_set_url.'/bpwg_form_style.css">', 1);
//이미지 업로드를 사용하려면 1로 변경하세요.
$file_upload_flag = 1;

//$file_size = $g5['bpwidget']['bwgf_filesize'];
$file_size = 300;

if($w == 'u'){
	//이미지 수정모드에서의 작음 섬네일 사이즈
	$thumb_wd = 80;
	$thumb_ht = 50;
	//이미지 수정팝에창에서의 중간 섬네일 사이즈
	$thumb_m_wd = 200;
	$thumb_m_ht = 120;
	
	$grpsql = " SELECT bwga_array FROM {$g5['bpwidget_attachment_table']}  WHERE bwga_type = 'option' AND bwgs_idx = '{$bwgs_idx}' GROUP BY bwga_array ";
	$grp_result = sql_query($grpsql,1);
	$optfile_group = array();
	//어떤종류의 파일배열이 있는지 총 종류를 뽑아내는 루프
	for($i=0;$grow=sql_fetch_array($grp_result);$i++){
		array_push($optfile_group,$grow['bwga_array']);
		${$grow['bwga_array']} = array();
	}
	//해당 위젯idx(bwgs_idx)의 option에 해당하는 파일 레코드를 전부 추출
	$optfsql = " SELECT * FROM {$g5['bpwidget_attachment_table']} WHERE bwga_type = 'option' AND bwgs_idx = '{$bwgs_idx}' ORDER BY bwga_array,bwga_sort,bwga_idx ";
	$otpf_result = sql_query($optfsql,1);
	for($i=0;$frow=sql_fetch_array($otpf_result);$i++){
		//등록 이미지 섬네일 생성
		$thumbf = thumbnail($frow['bwga_name'],G5_PATH.$frow['bwga_path'],G5_PATH.$frow['bwga_path'],$thumb_wd,$thumb_ht,false,true,'center');
		$thumbf_url = G5_URL.$frow['bwga_path'].'/'.$thumbf;
		$frow['thumb_url'] = $thumbf_url;
		if(preg_match("/\.svg/i",$frow['bwga_name'])){
			$frow['thumb_url'] = G5_URL.$frow['bwga_path'].'/'.$frow['bwga_name'];
		}
		//수정팝업에서의 중간크기 이미지 섬네일 생성
		$thumbfm = thumbnail($frow['bwga_name'],G5_PATH.$frow['bwga_path'],G5_PATH.$frow['bwga_path'],$thumb_m_wd,$thumb_m_ht,false,true,'center');
		$thumbfm_url = G5_URL.$frow['bwga_path'].'/'.$thumbfm;
		$frow['thumb_m_url'] = $thumbfm_url;
		if(preg_match("/\.svg/i",$frow['bwga_name'])){
			$frow['thumb_m_url'] = G5_URL.$frow['bwga_path'].'/'.$frow['bwga_name'];
		}
		//상단에 파일배열 종류에 해당하는 배열에 분류되어 파일레코드 요소를 담는다.
		array_push(${$frow['bwga_array']},$frow);
	}
	
	//파일배열 종류별 몇개씩 들어있는지와, 종류별 어떤 bwga_idx를 가지고 있는지 추출한다.
	for($i=0;$i<count($optfile_group);$i++){
		${$optfile_group[$i].'_bwga_idxs'} = '';
		for($j=0;$j<count(${$optfile_group[$i]});$j++){
			${$optfile_group[$i].'_bwga_idxs'} .= (($j == 0) ? '':',').${$optfile_group[$i]}[$j]['bwga_idx'];
		}
	}
}
//에스크로 정렬 설정
//$escro_align_left = ($escro_align == 'left') ? 'checked="checked"' : '';
//$escro_align_right = ($escro_align == '' || $escro_align == 'right') ? 'checked="checked"' : '';
//에스크로(kcp) 사용여부 설정
$escro_kcp_1 = ($escro_kcp == 'yes') ? 'checked="checked"' : '';
$escro_kcp_0 = ($escro_kcp == '' || $escro_kcp == 'no') ? 'checked="checked"' : '';
//에스크로(lg) 사용여부 설정
$escro_lg_1 = ($escro_lg == 'yes') ? 'checked="checked"' : '';
$escro_lg_0 = ($escro_lg == '' || $escro_lg == 'no') ? 'checked="checked"' : '';
//에스크로(kg) 사용여부 설정
$escro_kg_1 = ($escro_kg == 'yes') ? 'checked="checked"' : '';
$escro_kg_0 = ($escro_kg == '' || $escro_kg == 'no') ? 'checked="checked"' : '';
//에스크로(kb) 사용여부 설정
$escro_kb_1 = ($escro_kb == 'yes') ? 'checked="checked"' : '';
$escro_kb_0 = ($escro_kb == '' || $escro_kb == 'no') ? 'checked="checked"' : '';
//에스크로(ibk) 사용여부 설정
$escro_ibk_1 = ($escro_ibk == 'yes') ? 'checked="checked"' : '';
$escro_ibk_0 = ($escro_ibk == '' || $escro_ibk == 'no') ? 'checked="checked"' : '';
//에스크로(nh) 사용여부 설정
$escro_nh_1 = ($escro_nh == 'yes') ? 'checked="checked"' : '';
$escro_nh_0 = ($escro_nh == '' || $escro_nh == 'no') ? 'checked="checked"' : '';
/*
//에스크로(kgini) 사용여부 설정
$inicis_kg_1 = ($inicis_kg == 'yes') ? 'checked="checked"' : '';
$inicis_kg_0 = ($inicis_kg == '' || $inicis_kg == 'no') ? 'checked="checked"' : '';

//에스크로(Hana) 사용여부 설정
$escro_hn_1 = ($escro_hn == 'yes') ? 'checked="checked"' : '';
$escro_hn_0 = ($escro_hn == '' || $escro_hn == 'no') ? 'checked="checked"' : '';
//에스크로(EveryRich) 사용여부 설정
$escro_er_1 = ($escro_er == 'yes') ? 'checked="checked"' : '';
$escro_er_0 = ($escro_er == '' || $escro_er == 'no') ? 'checked="checked"' : '';
*/
/*
//링크 체크
$logo_url = ($logo_url) ? bwg_g5_url_check($logo_url) : '';
//라디오버튼
$nav_align_left = ($nav_align == 'left') ? 'checked="checked"' : '';
$nav_align_center = ($nav_align == 'center') ? 'checked="checked"' : '';
$nav_align_right = ($nav_align == '' || $nav_align == 'right') ? 'checked="checked"' : '';
<td colspan="<?=$colspan3?>" class="bwg_help">
	<?php echo bwg_help("1차메뉴 전체 정렬을 설정하세요.",1,'#f9fac6','#333333'); ?>
	<div>
		<label for="bwo_nav_align_left" class="label_radio first_child bwo_nav_align_left">
			<input type="radio" id="bwo_nav_align_left" name="bwo[nav_align]" value="left" <?=$nav_align_left?>>
			<strong></strong>
			<span>왼쪽</span>
		</label>
		<label for="bwo_nav_align_center" class="label_radio bwo_nav_align_center">
			<input type="radio" id="bwo_nav_align_center" name="bwo[nav_align]" value="center" <?=$nav_align_center?>>
			<strong></strong>
			<span>중앙</span>
		</label>
		<label for="bwo_nav_align_right" class="label_radio bwo_nav_align_right">
			<input type="radio" id="bwo_nav_align_right" name="bwo[nav_align]" value="right" <?=$nav_align_right?>>
			<strong></strong>
			<span>오른쪽</span>
		</label>
	</div>
</td>
//라디오버튼2
$radio_wu_disable_flag = ($w == 'u') ? 1 : 0; //수정모드에서 비활성화할 라디오버튼박스에 사용하는 변수
<?php echo bwgf_radio_checked($bwgf_device, 'bwgs_device', $bwgs_device, $radio_wu_disable_flag);//인수('pending=대기,ok=정상,hide=숨김,trash=삭제','bwgf_status(name속성)','ok(값)',0(값없음활성화),1(필수여부)) ?>
//컬러/투명도설정
<td colspan="<?=$colspan3?>" class="bwg_help">
	<?php echo bwg_help("첫번째 메뉴의 배경 색상을 설정하세요.",1,'#f9fac6','#333333'); ?>
	<?php echo bpwg_input_color('bwo[menu1_first_bg_color]',$menu1_first_bg_color,$w,1); ?>
</td>
//입력박스
<td class="bwg_help">
	<?php echo bwg_help("제일 상단 타이틀의 작은 문자의 내용을 입력하세요.",1,'#f9fac6','#333333'); ?>
	<input type="text" name="bwo[ttl_small]" class="bp_wdp100" value="<?=$ttl_small?>">
</td>
//숫자범위 100%
<td class="bwg_help">
	<?php echo bwg_help("1차메뉴의 너비(폭)를 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
	<?php
	$menu1_wd = (isset($menu1_wd)) ? $menu1_wd : 100;
	echo bpwg_input_range('bwo[menu1_wd]',$menu1_wd,$w,80,400,1,'100%',38,'px');
	?>
</td>
//숫자범위 147px
<td class="bwg_help">
	<?php echo bwg_help("1차메뉴의  높이를 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
	<?php
	$menu1_ht = (isset($menu1_ht)) ? $menu1_ht : 40;
	echo bpwg_input_range('bwo[menu1_ht]',$menu1_ht,$w,20,200,1,'147',38,'px');
	?>
</td>
//선택박스
<td>
	<?php
	$txt2_ani_disabled = 0;//($w == 'u') ? 1 : 0;
	?>
	<?php echo bwgf_select_selected($g5['bpwidget']['bwgf_text_animation_type'], 'bwo[text2_ani_type]', $text2_ani_type, 1, 0,$txt2_ani_disabled);//인수('pending=대기,ok=정상,hide=숨김,trash=삭제','bwo[text2_ani_type](name속성)','ok(값)',0(값없음활성화=1),1(필수여부=1),1(비활성화=1)) ?>
</td>
*/

$colspan11=11;
$colspan10=10;
$colspan9=9;
$colspan8=8;
$colspan7=7;
$colspan6=6;
$colspan5=5;
$colspan4=4;
$colspan3=3;
$colspan2=2;
?>
<link rel="stylesheet" href="<?=$bwg_skin_set_url?>/bpwg_form_style.css">
<div id="bwg_skin_set">
<h2 class="h2_frm">모바일 TAIL 영역의 옵션설정</h2>
<!--p>
<strong style="color:red;">핑크영역</strong>은 <strong style="color:blue;">텍스트SVG 패스(선) 애니메이션</strong>을 위한 설정내용입니다.<br>
일반 이미지는 SVG관련설정이 반영되지 않습니다.<br>
<strong><span style="color:red;">주의 : </span><span>SVG제작시 사용하는 폰트(서체)는 반드시 이미지로 변환(서체 깨트리기:Create Outline)해서 저장해 주세요.</span></strong><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(폰트(서체) 그대로 저장하시면 애니메이션 효과를 줄 수 없을 뿐만 아니라, 원하는 서체로 표시 되지 않을 수 있습니다.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;반드시 폰트(서체)를 테두리(선)와 면으로 변환해 주세요.)
</p><br-->
<table class="tbl_frm" id="bwg_skin_opt">
	<colgroup>
		<col span="1" width="70">
		<col span="1" width="110">
		<col span="1" width="70">
		<col span="1" width="110">
		<col span="1" width="70">
		<col span="1" width="110">
		<col span="1" width="70">
		<col span="1" width="110">
		<col span="1" width="70">
		<col span="1" width="110">
		<col span="1" width="70">
		<col span="1" width="110">
	</colgroup>
	<tbody>
		<tr>
			<th>기본폰트<br>색상</th>
			<td class="bwg_help">
				<?php echo bwg_help("기본폰트색상을 선택하세요.",1,'#f9fac6','#333333'); ?>
				<?php echo bpwg_input_color('bwo[tail_font_color]',$tail_font_color,$w,0); ?>
			</td>
			<th>기본폰트<br>크기</th>
			<td class="bwg_help">
				<?php echo bwg_help("푸터영역의 기본폰트 크기를 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$tail_font_size = (isset($tail_font_size)) ? $tail_font_size : 12;
				echo bpwg_input_range('bwo[tail_font_size]',$tail_font_size,$w,8,18,1,'100',38,'px');
				?>
			</td>
			<th>카피라이터<br>문장</th>
            <td colspan="<?=$colspan5?>">
				<input type="text" name="bwo[copyright]" class="bp_wdp100" value="<?=$copyright?>" size="30">
            </td>
			<th>푸터배경<br>색상</th>
			<td class="bwg_help">
				<?php echo bwg_help("푸터 배경색상을 설정하세요.",1,'#f9fac6','#333333'); ?>
				<?php echo bpwg_input_color('bwo[tail_bg_color]',$tail_bg_color,$w,0); ?>
			</td>
		</tr>
		<tr>
			<th>타이틀<br>폰트색상</th>
			<td class="bwg_help">
				<?php echo bwg_help("타이틀 폰트색상을 선택하세요.",1,'#f9fac6','#333333'); ?>
				<?php echo bpwg_input_color('bwo[tail_titlefont_color]',$tail_titlefont_color,$w,0); ?>
			</td>
			<th class="sthd_bg1">타이틀<br>폰트크기</th>
			<td class="bwg_help">
				<?php echo bwg_help("타이틀의 폰트 크기를 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$title_font_size = (isset($title_font_size)) ? $title_font_size : 14;
				echo bpwg_input_range('bwo[title_font_size]',$title_font_size,$w,8,30,1,'100',38,'px');
				?>
			</td>
			<th>푸터상단<br>라인색상</th>
			<td class="bwg_help">
				<?php echo bwg_help("푸터상단의 라인색상을 설정하세요.",1,'#f9fac6','#333333'); ?>
				<?php echo bpwg_input_color('bwo[tail_topline_color]',$tail_topline_color,$w,0); ?>
			</td>
			<th>CS전화<br>폰트색상</th>
			<td class="bwg_help">
				<?php echo bwg_help("CS전화번호 폰트색상을 선택하세요.",1,'#f9fac6','#333333'); ?>
				<?php echo bpwg_input_color('bwo[tail_cstelfont_color]',$tail_cstelfont_color,$w,0); ?>
			</td>
			<th>CS전화<br>폰트크기</th>
			<td class="bwg_help">
				<?php echo bwg_help("CS전화번호의 폰트 크기를 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$title_cstelfont_size = (isset($title_cstelfont_size)) ? $title_cstelfont_size : 14;
				echo bpwg_input_range('bwo[title_cstelfont_size]',$title_cstelfont_size,$w,8,30,1,'100%',38,'px');
				?>
			</td>
			<th>스크롤/PC<br>아이콘색상</th>
			<td class="bwg_help">
				<?php echo bwg_help("상중하이동 또는 PC모드 아이콘 색상을 선택하세요.",1,'#f9fac6','#333333'); ?>
				<?php echo bpwg_input_color('bwo[tail_icon_color]',$tail_icon_color,$w,0); ?>
			</td>
		</tr>
		<tr>
			<th>CS전화<br>상단간격</th>
			<td class="bwg_help">
				<?php echo bwg_help("CS전화 상단간격을 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$cstel_topgap_size = (isset($cstel_topgap_size)) ? $cstel_topgap_size : 20;
				echo bpwg_input_range('bwo[cstel_topgap_size]',$cstel_topgap_size,$w,10,40,1,'100%',38,'px');
				?>
			</td>
			<th>타이틀<br>상단간격</th>
			<td class="bwg_help">
				<?php echo bwg_help("타이틀 상단간격을 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$title_topgap_size = (isset($title_topgap_size)) ? $title_topgap_size : 30;
				echo bpwg_input_range('bwo[title_topgap_size]',$title_topgap_size,$w,10,40,1,'100%',38,'px');
				?>
			</td>
			<th>정보단락<br>상단간격</th>
			<td class="bwg_help">
				<?php echo bwg_help("정보단락의 상단간격을 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$p_topgap_size = (isset($p_topgap_size)) ? $p_topgap_size : 10;
				echo bpwg_input_range('bwo[p_topgap_size]',$p_topgap_size,$w,10,40,1,'100%',38,'px');
				?>
			</td>
			<th>문장별<br>상단간격</th>
			<td class="bwg_help">
				<?php echo bwg_help("문장별 상단간격을 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$txtline_topgap_size = (isset($txtline_topgap_size)) ? $txtline_topgap_size : 5;
				echo bpwg_input_range('bwo[txtline_topgap_size]',$txtline_topgap_size,$w,1,20,1,'100%',38,'px');
				?>
			</td>
			<th>스크롤/PC<br>아이콘크기</th>
			<td class="bwg_help">
				<?php echo bwg_help("스크롤/PC 아이콘 사이즈을 설정하세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
				<?php
				$icon_size = (isset($icon_size)) ? $icon_size : 20;
				echo bpwg_input_range('bwo[icon_size]',$icon_size,$w,10,30,1,'100',38,'px');
				?>
			</td>
			<th>스크롤/PC<br>배경색상</th>
			<td class="bwg_help">
				<?php echo bwg_help("상중하이동 또는 PC모드 아이콘의 배경색상을 선택하세요.",1,'#f9fac6','#333333'); ?>
				<?php echo bpwg_input_color('bwo[tail_icon_bg_color]',$tail_icon_bg_color,$w,0); ?>
			</td>
		</tr>
		<tr>
			<th>PC모드<br>아이콘정렬</th>
			<td class="bwg_help">
				<?php
				echo bwg_help("PC모드 아이콘 정렬을 선택하세요.",1,'#f9fac6','#333333');
				$pc_align_disabled = 0;//($w == 'u') ? 1 : 0;
				echo bwgf_select_selected($g5['bpwidget']['bwgf_horizontal_align2'], 'bwo[pc_align]', $pc_align, 0, 0,$pc_align_disabled);//인수('pending=대기,ok=정상,hide=숨김,trash=삭제','bwo[text2_ani_type](name속성)','ok(값)',0(값없음활성화=1),1(필수여부=1),1(비활성화=1)) 
				?>
			</td>
			<th>스크롤<br>아이콘정렬</th>
			<td class="bwg_help">
				<?php
				echo bwg_help("스크롤 아이콘 정렬을 선택하세요.",1,'#f9fac6','#333333');
				$scroll_align_disabled = 0;//($w == 'u') ? 1 : 0;
				echo bwgf_select_selected($g5['bpwidget']['bwgf_horizontal_align2'], 'bwo[scroll_align]', $scroll_align, 0, 0,$scroll_align_disabled);//인수('pending=대기,ok=정상,hide=숨김,trash=삭제','bwo[text2_ani_type](name속성)','ok(값)',0(값없음활성화=1),1(필수여부=1),1(비활성화=1)) 
				?>
			</td>
			<th scope="row">회사명</th>
            <td>
				<input type="text" name="de_admin_company_name" id="de_admin_company_name" class="bp_wdp100" value="<?=$default['de_admin_company_name']?>" size="30">
            </td>
			<th scope="row">대표자명</th>
            <td>
				<input type="text" name="de_admin_company_owner" id="de_admin_company_owner" class="bp_wdp100" value="<?=$default['de_admin_company_owner']?>" size="30">
            </td>
			<th scope="row">사업자<br>등록번호</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_company_saupja_no" id="de_admin_company_saupja_no" class="bp_wdp100" value="<?=$default['de_admin_company_saupja_no']?>" size="30">
            </td>
		</tr>
		<tr>
			<th scope="row">고객센터<br>타이틀</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="bwo[cs_title]" class="bp_wdp100" value="<?=$cs_title?>" size="30">
            </td colspan="<?=$colspan3?>">
			<th scope="row">회사정보<br>타이틀</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="bwo[companyinfo_title]" class="bp_wdp100" value="<?=$companyinfo_title?>" size="30">
            </td>
			<th scope="row">은행정보<br>타이틀</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="bwo[bankinfo_title]" class="bp_wdp100" value="<?=$bankinfo_title?>" size="30">
            </td>
		</tr>
		<tr>
			<th scope="row">대표<br>전화번호</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_company_tel" id="de_admin_company_tel" class="bp_wdp100" value="<?=$default['de_admin_company_tel']?>" size="30">
            </td>
			<th scope="row">팩스번호</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_company_fax" id="de_admin_company_fax" class="bp_wdp100" value="<?=$default['de_admin_company_fax']?>" size="30">
            </td>
			<th scope="row">통신판매업<br>신고번호</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_tongsin_no" id="de_admin_tongsin_no" class="bp_wdp100" value="<?=$default['de_admin_tongsin_no']?>" size="30">
            </td>
		</tr>
		<tr>
			<th scope="row">부가통신<br>사업자번호</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_buga_no" id="de_admin_buga_no" class="bp_wdp100" value="<?=$default['de_admin_buga_no']?>" size="30">
            </td>
			<th scope="row">정보관리<br>책임자명</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_info_name" id="de_admin_info_name" class="bp_wdp100" value="<?=$default['de_admin_info_name']?>" size="30">
            </td>
			<th scope="row">사업장<br>우편번호</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_company_zip" id="de_admin_company_zip" class="bp_wdp100" value="<?=$default['de_admin_company_zip']?>" size="30">
            </td>
		</tr>
		<tr>
			<th scope="row">사업장주소</th>
            <td colspan="<?=$colspan7?>">
				<input type="text" name="de_admin_company_addr" id="de_admin_company_addr" class="bp_wdp100" value="<?=$default['de_admin_company_addr']?>" size="30">
            </td>
            <th scope="row">정보책임자<br>e-mail</th>
            <td colspan="<?=$colspan3?>">
				<input type="text" name="de_admin_info_email" id="de_admin_info_email" class="bp_wdp100" value="<?=$default['de_admin_info_email']?>" size="30">
            </td>
		</tr>
		<tr>
			<th scope="row">은행계좌<br>번호</th>
            <td colspan="<?=$colspan3?>">
                <textarea class="bp_wdp100" name="de_bank_account" id="de_bank_account"><?=$default['de_bank_account']?></textarea>
            </td>
			<th scope="row">기타정보</th>
            <td colspan="<?=$colspan7?>">
                <textarea class="bp_wdp100" name="bwo[etc_info]"><?=$etc_info?></textarea>
            </td>
		</tr>
		<tr>
			<th>에스크로<br>이미지높이</th>
			<td class="bwg_help">
				<?php echo bwg_help("에스크로 이미지의 세로 크기(px)를 설정해 주세요.",1,'#f9fac6','#333333'); ?>
				<?php
				$escro_height = (isset($escro_height)) ? $escro_height : 80;
				echo bpwg_input_range('bwo[escro_height]',$escro_height,$w,40,100,1,'100',38,'px');
				?>
			</td>
			<th>에스크로<br>상단간격</th>
			<td class="bwg_help">
				<?php echo bwg_help("에스크로 하단간격(px)를 설정해 주세요.",1,'#f9fac6','#333333'); ?>
				<?php
				$escro_top_gap = (isset($escro_top_gap)) ? $escro_top_gap : 10;
				echo bpwg_input_range('bwo[escro_top_gap]',$escro_top_gap,$w,5,80,1,'100',38,'px');
				?>
			</td>
			<th>에스크로<br>사이간격</th>
			<td class="bwg_help">
				<?php echo bwg_help("에스크로 사이간격(px)를 설정해 주세요.",1,'#f9fac6','#333333'); ?>
				<?php
				$escro_margin = (isset($escro_margin)) ? $escro_margin : 5;
				echo bpwg_input_range('bwo[escro_margin]',$escro_margin,$w,0,30,1,'100',38,'px');
				?>
			</td>
			<th>에스크로<br>전체정렬</th>
			<td colspan="<?=$colspan5?>" class="bwg_help">
				<?php
				echo bwg_help("에스크로 전체 정렬을 선택하세요.",1,'#f9fac6','#333333');
				$escro_align_disabled = 0;//($w == 'u') ? 1 : 0;
				echo bwgf_select_selected($g5['bpwidget']['bwgf_horizontal_align'], 'bwo[escro_align]', $escro_align, 0, 0,$escro_align_disabled);//인수('pending=대기,ok=정상,hide=숨김,trash=삭제','bwo[text2_ani_type](name속성)','ok(값)',0(값없음활성화=1),1(필수여부=1),1(비활성화=1)) 
				?>
			</td>
		</tr>
		<tr>
			<th>에스크로<br>(KCP)</th>
			<td colspan="<?=$colspan2?>" class="bwg_help">
				<?php echo bwg_help("에스크로(KCP) 사용여부를 설정하세요.",1,'#f9fac6','#333333'); ?>
				<div>
					<label for="escro_kcp_1" class="label_radio first_child escro_kcp_1">
						<input type="radio" id="escro_kcp_1" name="bwo[escro_kcp]" value="yes" <?=$escro_kcp_1?>>
						<strong></strong>
						<span>사용</span>
					</label>
					<label for="escro_kcp_0" class="label_radio escro_kcp_0">
						<input type="radio" id="escro_kcp_0" name="bwo[escro_kcp]" value="no" <?=$escro_kcp_0?>>
						<strong></strong>
						<span>사용안함</span>
					</label>
				</div>
			</td>
			<th scope="row">ID<br>KEY<br>CODE</th>
            <td colspan="<?=$colspan2?>">
				<input type="text" name="bwo[escro_kcp_code]" class="bp_wdp100" value="<?=$escro_kcp_code?>" size="30">
            </td>
			<th class="">에스크로<br>이미지</th>
			<td colspan="<?=$colspan5?>">
				<?php
				$file_name = 'file_kcp';
				${$file_name.'_maxlength'} = 1;
				${$file_name.'_accept'} = 'png|jpg|jpeg|gif';
				//${$file_name.'_data_maxsize'} = 0; //업로드되는 파일들 전체용량
				${$file_name.'_data_maxfile'} = $file_size; //각각의 파일용량
				${$file_name.'_uploaded'} = count(${$file_name});
				${$file_name.'_remain_cnt'} = ${$file_name.'_maxlength'} - ${$file_name.'_uploaded'};
				echo "<p style='color:#223390;'>총 ".${$file_name.'_maxlength'}."개 까지만 가능하고, 현재 업로드 가능한 파일수는 ".${$file_name.'_remain_cnt'}."개 입니다.<br>각각의 파일 용량은 ".${$file_name.'_data_maxfile'}."KB이하로 업로드 해 주세요.</p>".PHP_EOL;
				if(${$file_name.'_remain_cnt'}){
				?>
				<input type="file" name="<?=$file_name?>[]" id="<?=$file_name?>" multiple class="with-preview" maxlength="<?=${$file_name.'_remain_cnt'}?>" accept="<?=${$file_name.'_accept'}?>" data-maxfile="<?=${$file_name.'_data_maxfile'}?>">
				<?php } ?>
				<?php if(count(${$file_name})){?>
				<div class="uploaded" uploaded_cnt="<?=(count(${$file_name}))?>">
					<div class="total_del_box">
						<div class="total_del_tbl">
							<div class="total_del_td">
								<img class="row_files_del" bwga_idxs="<?=${$file_name.'_bwga_idxs'}?>" width="20" height="20" src="<?=G5_BPWIDGET_IMG_URL?>/close_b.png" title="전체삭제">
							</div>
						</div>
					</div>
					<ul>
						<?php for($i=0;$i<count(${$file_name});$i++){?>
							<li>
								<img class="thumb" width="<?=$thumb_wd?>" height="<?=$thumb_ht?>" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" bwga_title="<?=${$file_name}[$i]['bwga_title']?>" bwga_rank="<?=${$file_name}[$i]['bwga_rank']?>" bwga_sort="<?=${$file_name}[$i]['bwga_sort']?>" bwga_status="<?=${$file_name}[$i]['bwga_status']?>" bwga_content="<?=${$file_name}[$i]['bwga_content']?>" thumb_m="<?=${$file_name}[$i]['thumb_m_url']?>" title="개별 이미지 변경" src="<?=${$file_name}[$i]['thumb_url']?>">
								<img class="thumb_del" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" width="24" height="24" title="개별 이미지 삭제" src="<?=G5_BPWIDGET_IMG_URL?>/close_bg_circle.png">
							</li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>에스크로<br>(LG)</th>
			<td colspan="<?=$colspan2?>" class="bwg_help">
				<?php echo bwg_help("에스크로(LG) 사용여부를 설정하세요.",1,'#f9fac6','#333333'); ?>
				<div>
					<label for="escro_lg_1" class="label_radio first_child escro_lg_1">
						<input type="radio" id="escro_lg_1" name="bwo[escro_lg]" value="yes" <?=$escro_lg_1?>>
						<strong></strong>
						<span>사용</span>
					</label>
					<label for="escro_lg_0" class="label_radio escro_lg_0">
						<input type="radio" id="escro_lg_0" name="bwo[escro_lg]" value="no" <?=$escro_lg_0?>>
						<strong></strong>
						<span>사용안함</span>
					</label>
				</div>
			</td>
			<th scope="row">ID<br>KEY<br>CODE</th>
            <td colspan="<?=$colspan2?>">
				<input type="text" name="bwo[escro_lg_code]" class="bp_wdp100" value="<?=$escro_lg_code?>" size="30">
            </td>
			<th class="">에스크로<br>이미지</th>
			<td colspan="<?=$colspan5?>">
				<?php
				$file_name = 'file_lg';
				${$file_name.'_maxlength'} = 1;
				${$file_name.'_accept'} = 'png|jpg|jpeg|gif';
				//${$file_name.'_data_maxsize'} = 0; //업로드되는 파일들 전체용량
				${$file_name.'_data_maxfile'} = $file_size; //각각의 파일용량
				${$file_name.'_uploaded'} = count(${$file_name});
				${$file_name.'_remain_cnt'} = ${$file_name.'_maxlength'} - ${$file_name.'_uploaded'};
				echo "<p style='color:#223390;'>총 ".${$file_name.'_maxlength'}."개 까지만 가능하고, 현재 업로드 가능한 파일수는 ".${$file_name.'_remain_cnt'}."개 입니다.<br>각각의 파일 용량은 ".${$file_name.'_data_maxfile'}."KB이하로 업로드 해 주세요.</p>".PHP_EOL;
				if(${$file_name.'_remain_cnt'}){
				?>
				<input type="file" name="<?=$file_name?>[]" id="<?=$file_name?>" multiple class="with-preview" maxlength="<?=${$file_name.'_remain_cnt'}?>" accept="<?=${$file_name.'_accept'}?>" data-maxfile="<?=${$file_name.'_data_maxfile'}?>">
				<?php } ?>
				<?php if(count(${$file_name})){?>
				<div class="uploaded" uploaded_cnt="<?=(count(${$file_name}))?>">
					<div class="total_del_box">
						<div class="total_del_tbl">
							<div class="total_del_td">
								<img class="row_files_del" bwga_idxs="<?=${$file_name.'_bwga_idxs'}?>" width="20" height="20" src="<?=G5_BPWIDGET_IMG_URL?>/close_b.png" title="전체삭제">
							</div>
						</div>
					</div>
					<ul>
						<?php for($i=0;$i<count(${$file_name});$i++){?>
							<li>
								<img class="thumb" width="<?=$thumb_wd?>" height="<?=$thumb_ht?>" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" bwga_title="<?=${$file_name}[$i]['bwga_title']?>" bwga_rank="<?=${$file_name}[$i]['bwga_rank']?>" bwga_sort="<?=${$file_name}[$i]['bwga_sort']?>" bwga_status="<?=${$file_name}[$i]['bwga_status']?>" bwga_content="<?=${$file_name}[$i]['bwga_content']?>" thumb_m="<?=${$file_name}[$i]['thumb_m_url']?>" title="개별 이미지 변경" src="<?=${$file_name}[$i]['thumb_url']?>">
								<img class="thumb_del" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" width="24" height="24" title="개별 이미지 삭제" src="<?=G5_BPWIDGET_IMG_URL?>/close_bg_circle.png">
							</li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>에스크로<br>(KG)</th>
			<td colspan="<?=$colspan2?>" class="bwg_help">
				<?php echo bwg_help("에스크로(KG) 사용여부를 설정하세요.",1,'#f9fac6','#333333'); ?>
				<div>
					<label for="escro_kg_1" class="label_radio first_child escro_kg_1">
						<input type="radio" id="escro_kg_1" name="bwo[escro_kg]" value="yes" <?=$escro_kg_1?>>
						<strong></strong>
						<span>사용</span>
					</label>
					<label for="escro_kg_0" class="label_radio escro_kg_0">
						<input type="radio" id="escro_kg_0" name="bwo[escro_kg]" value="no" <?=$escro_kg_0?>>
						<strong></strong>
						<span>사용안함</span>
					</label>
				</div>
			</td>
			<th scope="row">ID<br>KEY<br>CODE</th>
            <td colspan="<?=$colspan2?>">
				<input type="text" name="bwo[escro_kg_code]" class="bp_wdp100" value="<?=$escro_kg_code?>" size="30">
            </td>
			<th class="">에스크로<br>이미지</th>
			<td colspan="<?=$colspan5?>">
				<?php
				$file_name = 'file_kg';
				${$file_name.'_maxlength'} = 1;
				${$file_name.'_accept'} = 'png|jpg|jpeg|gif';
				//${$file_name.'_data_maxsize'} = 0; //업로드되는 파일들 전체용량
				${$file_name.'_data_maxfile'} = $file_size; //각각의 파일용량
				${$file_name.'_uploaded'} = count(${$file_name});
				${$file_name.'_remain_cnt'} = ${$file_name.'_maxlength'} - ${$file_name.'_uploaded'};
				echo "<p style='color:#223390;'>총 ".${$file_name.'_maxlength'}."개 까지만 가능하고, 현재 업로드 가능한 파일수는 ".${$file_name.'_remain_cnt'}."개 입니다.<br>각각의 파일 용량은 ".${$file_name.'_data_maxfile'}."KB이하로 업로드 해 주세요.</p>".PHP_EOL;
				if(${$file_name.'_remain_cnt'}){
				?>
				<input type="file" name="<?=$file_name?>[]" id="<?=$file_name?>" multiple class="with-preview" maxlength="<?=${$file_name.'_remain_cnt'}?>" accept="<?=${$file_name.'_accept'}?>" data-maxfile="<?=${$file_name.'_data_maxfile'}?>">
				<?php } ?>
				<?php if(count(${$file_name})){?>
				<div class="uploaded" uploaded_cnt="<?=(count(${$file_name}))?>">
					<div class="total_del_box">
						<div class="total_del_tbl">
							<div class="total_del_td">
								<img class="row_files_del" bwga_idxs="<?=${$file_name.'_bwga_idxs'}?>" width="20" height="20" src="<?=G5_BPWIDGET_IMG_URL?>/close_b.png" title="전체삭제">
							</div>
						</div>
					</div>
					<ul>
						<?php for($i=0;$i<count(${$file_name});$i++){?>
							<li>
								<img class="thumb" width="<?=$thumb_wd?>" height="<?=$thumb_ht?>" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" bwga_title="<?=${$file_name}[$i]['bwga_title']?>" bwga_rank="<?=${$file_name}[$i]['bwga_rank']?>" bwga_sort="<?=${$file_name}[$i]['bwga_sort']?>" bwga_status="<?=${$file_name}[$i]['bwga_status']?>" bwga_content="<?=${$file_name}[$i]['bwga_content']?>" thumb_m="<?=${$file_name}[$i]['thumb_m_url']?>" title="개별 이미지 변경" src="<?=${$file_name}[$i]['thumb_url']?>">
								<img class="thumb_del" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" width="24" height="24" title="개별 이미지 삭제" src="<?=G5_BPWIDGET_IMG_URL?>/close_bg_circle.png">
							</li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>에스크로<br>(KB국민)</th>
			<td colspan="<?=$colspan2?>" class="bwg_help">
				<?php echo bwg_help("에스크로(KB국민) 사용여부를 설정하세요.",1,'#f9fac6','#333333'); ?>
				<div>
					<label for="escro_kb_1" class="label_radio first_child escro_kb_1">
						<input type="radio" id="escro_kb_1" name="bwo[escro_kb]" value="yes" <?=$escro_kb_1?>>
						<strong></strong>
						<span>사용</span>
					</label>
					<label for="escro_kb_0" class="label_radio escro_kb_0">
						<input type="radio" id="escro_kb_0" name="bwo[escro_kb]" value="no" <?=$escro_kb_0?>>
						<strong></strong>
						<span>사용안함</span>
					</label>
				</div>
			</td>
			<th scope="row">ID<br>KEY<br>CODE</th>
            <td colspan="<?=$colspan2?>">
				<input type="text" name="bwo[escro_kb_code]" class="bp_wdp100" value="<?=$escro_kb_code?>" size="30">
            </td>
			<th class="">에스크로<br>이미지</th>
			<td colspan="<?=$colspan5?>">
				<?php
				$file_name = 'file_kb';
				${$file_name.'_maxlength'} = 1;
				${$file_name.'_accept'} = 'png|jpg|jpeg|gif';
				//${$file_name.'_data_maxsize'} = 0; //업로드되는 파일들 전체용량
				${$file_name.'_data_maxfile'} = $file_size; //각각의 파일용량
				${$file_name.'_uploaded'} = count(${$file_name});
				${$file_name.'_remain_cnt'} = ${$file_name.'_maxlength'} - ${$file_name.'_uploaded'};
				echo "<p style='color:#223390;'>총 ".${$file_name.'_maxlength'}."개 까지만 가능하고, 현재 업로드 가능한 파일수는 ".${$file_name.'_remain_cnt'}."개 입니다.<br>각각의 파일 용량은 ".${$file_name.'_data_maxfile'}."KB이하로 업로드 해 주세요.</p>".PHP_EOL;
				if(${$file_name.'_remain_cnt'}){
				?>
				<input type="file" name="<?=$file_name?>[]" id="<?=$file_name?>" multiple class="with-preview" maxlength="<?=${$file_name.'_remain_cnt'}?>" accept="<?=${$file_name.'_accept'}?>" data-maxfile="<?=${$file_name.'_data_maxfile'}?>">
				<?php } ?>
				<?php if(count(${$file_name})){?>
				<div class="uploaded" uploaded_cnt="<?=(count(${$file_name}))?>">
					<div class="total_del_box">
						<div class="total_del_tbl">
							<div class="total_del_td">
								<img class="row_files_del" bwga_idxs="<?=${$file_name.'_bwga_idxs'}?>" width="20" height="20" src="<?=G5_BPWIDGET_IMG_URL?>/close_b.png" title="전체삭제">
							</div>
						</div>
					</div>
					<ul>
						<?php for($i=0;$i<count(${$file_name});$i++){?>
							<li>
								<img class="thumb" width="<?=$thumb_wd?>" height="<?=$thumb_ht?>" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" bwga_title="<?=${$file_name}[$i]['bwga_title']?>" bwga_rank="<?=${$file_name}[$i]['bwga_rank']?>" bwga_sort="<?=${$file_name}[$i]['bwga_sort']?>" bwga_status="<?=${$file_name}[$i]['bwga_status']?>" bwga_content="<?=${$file_name}[$i]['bwga_content']?>" thumb_m="<?=${$file_name}[$i]['thumb_m_url']?>" title="개별 이미지 변경" src="<?=${$file_name}[$i]['thumb_url']?>">
								<img class="thumb_del" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" width="24" height="24" title="개별 이미지 삭제" src="<?=G5_BPWIDGET_IMG_URL?>/close_bg_circle.png">
							</li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>에스크로<br>(IBK)</th>
			<td colspan="<?=$colspan2?>" class="bwg_help">
				<?php echo bwg_help("에스크로(IBK) 사용여부를 설정하세요.",1,'#f9fac6','#333333'); ?>
				<div>
					<label for="escro_ibk_1" class="label_radio first_child escro_ibk_1">
						<input type="radio" id="escro_ibk_1" name="bwo[escro_ibk]" value="yes" <?=$escro_ibk_1?>>
						<strong></strong>
						<span>사용</span>
					</label>
					<label for="escro_ibk_0" class="label_radio escro_ibk_0">
						<input type="radio" id="escro_ibk_0" name="bwo[escro_ibk]" value="no" <?=$escro_ibk_0?>>
						<strong></strong>
						<span>사용안함</span>
					</label>
				</div>
			</td>
			<th scope="row">ID<br>KEY<br>CODE</th>
            <td colspan="<?=$colspan2?>">
				<input type="text" name="bwo[escro_ibk_code]" class="bp_wdp100" value="<?=$escro_ibk_code?>" size="30">
            </td>
			<th class="">에스크로<br>이미지</th>
			<td colspan="<?=$colspan5?>">
				<?php
				$file_name = 'file_ibk';
				${$file_name.'_maxlength'} = 1;
				${$file_name.'_accept'} = 'png|jpg|jpeg|gif';
				//${$file_name.'_data_maxsize'} = 0; //업로드되는 파일들 전체용량
				${$file_name.'_data_maxfile'} = $file_size; //각각의 파일용량
				${$file_name.'_uploaded'} = count(${$file_name});
				${$file_name.'_remain_cnt'} = ${$file_name.'_maxlength'} - ${$file_name.'_uploaded'};
				echo "<p style='color:#223390;'>총 ".${$file_name.'_maxlength'}."개 까지만 가능하고, 현재 업로드 가능한 파일수는 ".${$file_name.'_remain_cnt'}."개 입니다.<br>각각의 파일 용량은 ".${$file_name.'_data_maxfile'}."KB이하로 업로드 해 주세요.</p>".PHP_EOL;
				if(${$file_name.'_remain_cnt'}){
				?>
				<input type="file" name="<?=$file_name?>[]" id="<?=$file_name?>" multiple class="with-preview" maxlength="<?=${$file_name.'_remain_cnt'}?>" accept="<?=${$file_name.'_accept'}?>" data-maxfile="<?=${$file_name.'_data_maxfile'}?>">
				<?php } ?>
				<?php if(count(${$file_name})){?>
				<div class="uploaded" uploaded_cnt="<?=(count(${$file_name}))?>">
					<div class="total_del_box">
						<div class="total_del_tbl">
							<div class="total_del_td">
								<img class="row_files_del" bwga_idxs="<?=${$file_name.'_bwga_idxs'}?>" width="20" height="20" src="<?=G5_BPWIDGET_IMG_URL?>/close_b.png" title="전체삭제">
							</div>
						</div>
					</div>
					<ul>
						<?php for($i=0;$i<count(${$file_name});$i++){?>
							<li>
								<img class="thumb" width="<?=$thumb_wd?>" height="<?=$thumb_ht?>" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" bwga_title="<?=${$file_name}[$i]['bwga_title']?>" bwga_rank="<?=${$file_name}[$i]['bwga_rank']?>" bwga_sort="<?=${$file_name}[$i]['bwga_sort']?>" bwga_status="<?=${$file_name}[$i]['bwga_status']?>" bwga_content="<?=${$file_name}[$i]['bwga_content']?>" thumb_m="<?=${$file_name}[$i]['thumb_m_url']?>" title="개별 이미지 변경" src="<?=${$file_name}[$i]['thumb_url']?>">
								<img class="thumb_del" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" width="24" height="24" title="개별 이미지 삭제" src="<?=G5_BPWIDGET_IMG_URL?>/close_bg_circle.png">
							</li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>에스크로<br>(NH농협)</th>
			<td colspan="<?=$colspan2?>" class="bwg_help">
				<?php echo bwg_help("에스크로(NH농협) 사용여부를 설정하세요.",1,'#f9fac6','#333333'); ?>
				<div>
					<label for="escro_nh_1" class="label_radio first_child escro_nh_1">
						<input type="radio" id="escro_nh_1" name="bwo[escro_nh]" value="yes" <?=$escro_nh_1?>>
						<strong></strong>
						<span>사용</span>
					</label>
					<label for="escro_nh_0" class="label_radio escro_nh_0">
						<input type="radio" id="escro_nh_0" name="bwo[escro_nh]" value="no" <?=$escro_nh_0?>>
						<strong></strong>
						<span>사용안함</span>
					</label>
				</div>
			</td>
			<th scope="row">ID<br>KEY<br>CODE</th>
            <td colspan="<?=$colspan2?>">
				<input type="text" name="bwo[escro_nh_code]" class="bp_wdp100" value="<?=$escro_nh_code?>" size="30">
            </td>
			<th class="">에스크로<br>이미지</th>
			<td colspan="<?=$colspan5?>">
				<?php
				$file_name = 'file_nh';
				${$file_name.'_maxlength'} = 1;
				${$file_name.'_accept'} = 'png|jpg|jpeg|gif';
				//${$file_name.'_data_maxsize'} = 0; //업로드되는 파일들 전체용량
				${$file_name.'_data_maxfile'} = $file_size; //각각의 파일용량
				${$file_name.'_uploaded'} = count(${$file_name});
				${$file_name.'_remain_cnt'} = ${$file_name.'_maxlength'} - ${$file_name.'_uploaded'};
				echo "<p style='color:#223390;'>총 ".${$file_name.'_maxlength'}."개 까지만 가능하고, 현재 업로드 가능한 파일수는 ".${$file_name.'_remain_cnt'}."개 입니다.<br>각각의 파일 용량은 ".${$file_name.'_data_maxfile'}."KB이하로 업로드 해 주세요.</p>".PHP_EOL;
				if(${$file_name.'_remain_cnt'}){
				?>
				<input type="file" name="<?=$file_name?>[]" id="<?=$file_name?>" multiple class="with-preview" maxlength="<?=${$file_name.'_remain_cnt'}?>" accept="<?=${$file_name.'_accept'}?>" data-maxfile="<?=${$file_name.'_data_maxfile'}?>">
				<?php } ?>
				<?php if(count(${$file_name})){?>
				<div class="uploaded" uploaded_cnt="<?=(count(${$file_name}))?>">
					<div class="total_del_box">
						<div class="total_del_tbl">
							<div class="total_del_td">
								<img class="row_files_del" bwga_idxs="<?=${$file_name.'_bwga_idxs'}?>" width="20" height="20" src="<?=G5_BPWIDGET_IMG_URL?>/close_b.png" title="전체삭제">
							</div>
						</div>
					</div>
					<ul>
						<?php for($i=0;$i<count(${$file_name});$i++){?>
							<li>
								<img class="thumb" width="<?=$thumb_wd?>" height="<?=$thumb_ht?>" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" bwga_title="<?=${$file_name}[$i]['bwga_title']?>" bwga_rank="<?=${$file_name}[$i]['bwga_rank']?>" bwga_sort="<?=${$file_name}[$i]['bwga_sort']?>" bwga_status="<?=${$file_name}[$i]['bwga_status']?>" bwga_content="<?=${$file_name}[$i]['bwga_content']?>" thumb_m="<?=${$file_name}[$i]['thumb_m_url']?>" title="개별 이미지 변경" src="<?=${$file_name}[$i]['thumb_url']?>">
								<img class="thumb_del" bwga_idx="<?=${$file_name}[$i]['bwga_idx']?>" width="24" height="24" title="개별 이미지 삭제" src="<?=G5_BPWIDGET_IMG_URL?>/close_bg_circle.png">
							</li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</td>
		</tr>
	</tbody>
</table>
<script>
$('#bwgs_tab li a:contains(내용목록)').attr('href','javascript:');
var w = '<?=$w?>';
var rgba = '';
var bwgs_idx = <?=(($bwgs_idx)?$bwgs_idx:0)?>;
$(function(){
	//파일업로드
	if($('input[type="file"]').length){
		$('input[type="file"]').each(function(){
			$(this).MultiFile();
		});
	}
	//첨부파일 개별삭제 처리
	$('.thumb_del').on('click',function(){
		var bwga_idx = $(this).attr('bwga_idx');
		if(bwga_idx) file_single_del(bwga_idx);
		else alert('해당파일의 식별idx코드가 없습니다.');
	});
	//한줄의 첨부파일 전부삭제 처리
	$('.row_files_del').on('click',function(){
		var bwga_idxs = $(this).attr('bwga_idxs');
		if(bwga_idxs) files_row_del(bwga_idxs);
		else alert('해당줄 파일들의 식별idx코드가 없습니다.');
	});
	//이미지섬네일 버튼에 의해 이미지 변경 모달을 표시한다.
	$('.thumb').on('click',function(){
		var thumb_m = $('<img src="'+$(this).attr('thumb_m')+'" width="<?=$thumb_m_wd?>" height="<?=$thumb_m_ht?>">');
		var cur_img = $('#img_change_modal #cur_img');
		$('#img_change_modal').show();
		cur_img.find('img').remove();
		$(thumb_m).prependTo(cur_img);
		$('#img_change_modal input[name="bwgs_idx"]').val(bwgs_idx);
		$('#img_change_modal input[name="bwga_idx"]').val($(this).attr('bwga_idx'));
		$('#img_change_modal input[name="bwga_title"]').val($(this).attr('bwga_title'));
		$('#img_change_modal input[name="bwga_rank"]').val($(this).attr('bwga_rank'));
		$('#img_change_modal input[name="bwga_sort"]').val($(this).attr('bwga_sort'));
		$('#img_change_modal select[name="bwga_status"] option[value="'+$(this).attr('bwga_status')+'"]').attr('selected',true).siblings('option').attr('selected',false);
		$('#img_change_modal textarea[name="bwga_content"]').val($(this).attr('bwga_content'));
	});
	
	//이미지 변경 모달 닫기
	$('#img_change_bg, #img_change_modal_close, .img_change_close').on('click',function(){
		if($('#img_change_modal .MultiFile-remove').length) $('#img_change_modal .MultiFile-remove').trigger('click');
		$('#img_change_modal input[name="bwgs_idx"]').val('');
		$('#img_change_modal input[name="bwga_idx"]').val('');
		$('#img_change_modal input[name="bwga_title"]').val('');
		$('#img_change_modal input[name="bwga_rank"]').val('');
		$('#img_change_modal input[name="bwga_sort"]').val('');
		$('#img_change_modal select[name="bwga_sort"] option[value="ok"]').attr('selected',true).siblings('option').attr('selected',false);
		$('#img_change_modal textarea[name="bwga_content"]').val('');
		$('#img_change_modal').hide();
	});
});

//반드시 존재해야 하는 함수
function fbpwidgetoptionform_submit(){
	/*
	var format_url = /^(?:(?:[a-z]+):\/\/)?((?:[a-z\d\-]{2,}\.)+[a-z]{2,})(?::\d{1,5})?(?:\/[^\?]*)?(?:\?.+)?[\#]{0,1}$/i;
	var format_tel_sms = /^(tel|sms)\:[0-9]{2,3}\-[0-9]{3,4}\-[0-9]{4}/gm;
	var format_email = /^(mailto)\:[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
	var format_inner = /^(\#)[0-9a-zA-Z\_\-]*$/i;
	
	var logo_url = '';
	if($('input[name="bwo[logo_url]"]').val() != ''){
		logo_url = $('input[name="bwo[logo_url]"]').val();
		//if(!logo_url.match(format_url) && !logo_url.match(format_tel_sms) && !logo_url.match(format_email) && !logo_url.match(format_inner)){
		if(!logo_url.match(format_url)){
			alert('로고URL이 올바른 링크형식이 아닙니다.');
			$('input[name="bwo[logo_url]"]').focus();
			return false;
		}
	}
	*/
	return true;
}
</script>
</div><!--#bwg_skin_set-->
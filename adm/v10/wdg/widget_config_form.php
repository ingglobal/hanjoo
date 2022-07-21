<?php
include_once('./_extreme_top.php');
$sub_menu = $bpwg_sub_menu2;//"910200";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
auth_check($auth[$sub_menu], 'r');

//환경설정 wgf_name값을 일반변수로 변경 예)$g5['wdg']['wgf_country'] => $wgf_country
foreach($g5['wdg'] as $key => $val) $$key = $val;

// 라디오&체크박스 선택상태 자동 설정 (필드명 배열 선언!)
//$check_array=array('wgf_community_use','wgf_shop_use','wgf_only_mobile','wgf_device','wgf_site_type','wgf_community_use','wgf_use_mobile');
$check_array=array();
//print_r2($g5['wdg']);
for ($i=0;$i<sizeof($check_array);$i++) {
	${$check_array[$i].'_'.$g5['wdg'][$check_array[$i]]} = ' checked';
}

//########### 환경설정 관련 파일 : 시작{ ####################
$thumb_wd = 200;
$thumb_ht = 150;
$grpsql = " SELECT wga_array FROM {$g5['wdg_file_table']}  WHERE wga_type = 'config' GROUP BY wga_array ";
$grp_result = sql_query($grpsql,1);
$conffile_group = array();
//어떤종류의 파일배열이 있는지 총 종류를 뽑아내는 루프
for($i=0;$grow=sql_fetch_array($grp_result);$i++){
	array_push($conffile_group,$grow['wga_array']);
	${$grow['wga_array']} = array();
	${$grow['wga_array'].'_idx'} = 0;
}
//해당 위젯idx(bwgs_idx)의 option에 해당하는 파일 레코드를 전부 추출
$confsql = " SELECT * FROM {$g5['wdg_file_table']} WHERE wga_type = 'config' ";
$conf_result = sql_query($confsql,1);
for($i=0;$frow=sql_fetch_array($conf_result);$i++){
	$type_arr = explode('/',$frow['wga_mime_type']);
	$frow['type'] = $type_arr[0];//image or text
	$frow['file_path'] = G5_PATH.$frow['wga_path'].'/'.$frow['wga_name'];
	$frow['file_url'] = G5_URL.$frow['wga_path'].'/'.$frow['wga_name'];
	$frow['thumb_url'] = '';
	//등록 이미지 섬네일 생성
	if($frow['type'] == 'image'){
		$thumbf = thumbnail($frow['wga_name'],G5_PATH.$frow['wga_path'],G5_PATH.$frow['wga_path'],$thumb_wd,$thumb_ht,false,false,'center');
		$thumbf_url = G5_URL.$frow['wga_path'].'/'.$thumbf;
		$frow['thumb_url'] = $thumbf_url;
	}
	//상단에 파일배열 종류에 해당하는 배열에 분류되어 파일레코드 요소를 담는다.
	//array_push(${$frow['wga_array']},$frow);
	foreach($frow as $k=>$v)
		${$frow['wga_array']}[$k] = $v;
	${$frow['wga_array'].'_idx'} = $frow['wga_idx'];
}
//########### 환경설정 관련 파일 : 종료} ####################

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_bpwg_info">사이트기본정보</a></li>
    <li><a href="#anc_bpwg_basic">기본 설정</a></li>
    <li><a href="#anc_bpwg_opengraph">오픈그래프</a></li>
    <li><a href="#anc_bpwg_webmaster">웹마스터</a></li>
</ul>';
    //<li><a href="#anc_bpwg_dataset">데이터 설정</a></li>

// 확인 및 메인으로 버튼 정의">
$frm_submit = '<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
    <a href="'.G5_URL.'/" class="btn btn_02">메인으로</a>
</div>';

$g5['title'] = '위젯 환경설정';
include_once('./_head.php');

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

$conf_edit_flag = 1; //편집수정 필요시 값을 1로 변경
$readonly = (!$conf_edit_flag) ? " readonly" : "";
?>
<style>
.img_tr td{background:#efefef;}
</style>
<div id="bpwg_frm" class="bpwg_frm">
<form name="fbwgf" id="fbwgf" method="post" onsubmit="return fwgf_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<section id="anc_bpwg_info">
	<h2 class="h2_frm">사이트기본정보</h2>
    <?php echo $pg_anchor; ?>
	<table class="tbl_frm">
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
				<th>회사명</th>
				<td class="wdg_help">
					<input type="text" name="wgf_company_name" class="wg_wdp100" value="<?=$wgf_company_name?>">
				</td>
				<th>대표전화</th>
				<td class="wdg_help">
					<input type="text" name="wgf_main_tel" class="wg_wdp100" value="<?=$wgf_main_tel?>">
				</td>
				<th>CS전화</th>
				<td class="wdg_help">
					<input type="text" name="wgf_cs_tel" class="wg_wdp100" value="<?=$wgf_cs_tel?>">
				</td>
				<th>평일업무</th>
				<td class="wdg_help">
					<input type="text" name="wgf_weekday_time" class="wg_wdp100" value="<?=$wgf_weekday_time?>">
				</td>
				<th>점심시간</th>
				<td class="wdg_help">
					<input type="text" name="wgf_lunch_time" class="wg_wdp100" value="<?=$wgf_lunch_time?>">
				</td>
				<th>주말업무</th>
				<td class="wdg_help">
					<input type="text" name="wgf_weekend_time" class="wg_wdp100" value="<?=$wgf_weekend_time?>">
				</td>
			</tr>
			<tr>
				<th>대표자명</th>
				<td class="wdg_help">
					<input type="text" name="wgf_ceo_name" class="wg_wdp100" value="<?=$wgf_ceo_name?>">
				</td>
				<th>사업자번호</th>
				<td class="wdg_help">
					<input type="text" name="wgf_business_no" class="wg_wdp100" value="<?=$wgf_business_no?>">
				</td>
				<th>전화번호</th>
				<td class="wdg_help">
					<input type="text" name="wgf_company_tel" class="wg_wdp100" value="<?=$wgf_company_tel?>">
				</td>
				<th>팩스번호</th>
				<td class="wdg_help">
					<input type="text" name="wgf_company_fax" class="wg_wdp100" value="<?=$wgf_company_fax?>">
				</td>
				<th>사업장주소</th>
				<td colspan="<?=$colspan3?>" class="wdg_help">
					<input type="text" name="wgf_company_addr" class="wg_wdp100" value="<?=$wgf_company_addr?>">
				</td>
			</tr>
			<tr>
				<th>저작권문장</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="text" name="wgf_company_copyright" class="wg_wdp100" value="<?=$wgf_company_copyright?>">
				</td>
				<th>추가문장</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="text" name="wgf_company_addtext" class="wg_wdp100" value="<?=$wgf_company_addtext?>">
				</td>
			</tr>
			<tr class="img_tr">
				<th scope="row">로고1</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo1]" value="<?=$logo1_idx?>">
					<input type="file" name="logo1" class="">
					<label for="del_idx[logo1]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo1]" name="del_idx[logo1]" value="<?=$logo1_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo1['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo1['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
				<th scope="row">로고2</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo2]" value="<?=$logo2_idx?>">
					<input type="file" name="logo2" class="">
					<label for="del_idx[logo2]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo2]" name="del_idx[logo2]" value="<?=$logo2_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo2['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo2['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
			</tr>
			<tr class="img_tr">
				<th scope="row">로고3</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo3]" value="<?=$logo3_idx?>">
					<input type="file" name="logo3" class="">
					<label for="del_idx[logo3]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo3]" name="del_idx[logo3]" value="<?=$logo3_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo3['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo3['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
				<th scope="row">로고4</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo4]" value="<?=$logo4_idx?>">
					<input type="file" name="logo4" class="">
					<label for="del_idx[logo4]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo4]" name="del_idx[logo4]" value="<?=$logo4_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo4['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo4['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
			</tr>
			<tr class="img_tr">
				<th scope="row">로고5</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo5]" value="<?=$logo5_idx?>">
					<input type="file" name="logo5" class="">
					<label for="del_idx[logo5]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo5]" name="del_idx[logo5]" value="<?=$logo5_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo5['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo5['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
				<th scope="row">로고6</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo6]" value="<?=$logo6_idx?>">
					<input type="file" name="logo6" class="">
					<label for="del_idx[logo6]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo6]" name="del_idx[logo6]" value="<?=$logo6_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo6['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo6['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
			</tr>
			<tr class="img_tr">
				<th scope="row">로고7</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo7]" value="<?=$logo7_idx?>">
					<input type="file" name="logo7" class="">
					<label for="del_idx[logo7]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo7]" name="del_idx[logo7]" value="<?=$logo7_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo7['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo7['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
				<th scope="row">로고8</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<input type="hidden" name="fle_idx[logo8]" value="<?=$logo8_idx?>">
					<input type="file" name="logo8" class="">
					<label for="del_idx[logo8]" class="label_checkbox">
						<input type="checkbox" id="del_idx[logo8]" name="del_idx[logo8]" value="<?=$logo8_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($logo8['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$logo8['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
			<tr>
		</tbody>
	</table>
</section><!--#anc_bpwg_info-->
<section id="anc_bpwg_basic">
	<h2 class="h2_frm">위젯 환경설정</h2>
    <?php echo $pg_anchor; ?>
	<table class="tbl_frm">
		<colgroup>
			<col span="1" width="110">
			<col span="1" width="250">
			<col span="1" width="110">
			<col span="1" width="250">
			<col span="1" width="110">
			<col span="1" width="250">
		</colgroup>
		<tbody>
			<tr>
				<th>위젯목록<br>메뉴번호</th>
				<td class="wdg_help">
					<?php echo wdg_help("여섯자리 숫자 입력. 값이 없으면 기본값은 '910100'으로 입력됩니다.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_sub_menu"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$bpwg_sub_menu?>">
				</td>
				<th>위젯환경설정<br>메뉴번호</th>
				<td class="wdg_help">
					<?php echo wdg_help("여섯자리 숫자 입력. 값이 없으면 기본값 '910200'으로 입력됩니다.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_sub_menu2"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$bpwg_sub_menu2?>">
				</td>
				<th>위젯캐시<br>저장시간</th>
				<td class="wdg_help">
					<!--
					$cache_time은 시간단위 
					1시간=1, 5초=0.00139, 10초=0.0028, 20초=0.0056, 30초=0.0084, 40초=0.012, 50초=0.0139, 60초=0.0167, 3600초=1시간
					-->
					<?php echo wdg_help("캐시 저장시간의 값이 작을수록 위젯 수정후 반영되는 시간이 짧아집니다.",1,'#f9fac6','#333333'); ?>
					<?php echo wdg_select_selected($wgf_cachetime, 'wgf_cache_time', $wgf_cache_time, 0,0,0);//인수('pending=대기,ok=정상,hide=숨김,trash=삭제','wgf_status(name속성)','ok(값)',0(값없음활성화),1(필수여부)) ?>
				</td>
			</tr>
			<tr>
				<th>위젯스킨목록<br>메뉴번호</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<?php echo wdg_help("여섯자리 숫자 입력. 값이 없으면 기본값은 '910100'으로 입력됩니다.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_sub_menu3"<?=$readonly?> class="wg_wdx315<?=$readonly?>" value="<?=$bpwg_sub_menu3?>">
				</td>
			</tr>
			<tr>
				<th>개별업로드<br>파일용량</th>
				<td class="wdg_help">
					<?php echo wdg_help("(예 : 300)개별업로드 용량이 크면 페이지로딩에 영향을 줍니다.",1,'#f9fac6','#333333'); ?>
					최대 <input type="text" name="wgf_filesize" class="wg_wdp40" value="<?=$wgf_filesize?>" style="text-align:right;">&nbsp;KB 까지
				</td>
				<th>업로드하는<br>멀티파일 총용량</th>
				<td class="wdg_help">
					<?php echo wdg_help("(예 : 3000)멀티파일 총용량이 크면 페이지로딩에 영향을 줍니다.",1,'#f9fac6','#333333'); ?>
					최대 <input type="text" name="wgf_total_filesize" class="wg_wdp40" value="<?=$wgf_total_filesize?>" style="text-align:right;">&nbsp;KB 까지
				</td>
				<th>PC기본색상</th>
				<td class="wdg_help">
					<?php echo wdg_help("PC버전에서 사이트 전체 기본 배경/폰트 색상을 설정하세요.",1,'#f9fac6','#333333'); ?>
					<ul class="ul_pc_basic_color">
						<li>
						배경<br>
						<?php echo bpwg_input_color('wgf_default_bg',$wgf_default_bg,$w); ?>
						</li>
						<li>
						폰트<br>
						<?php echo bpwg_input_color('wgf_default_font',$wgf_default_font,$w); ?>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th>모바일 기본색상</th>
				<td class="wdg_help">
					<?php echo wdg_help("모바일 버전에서 사이트 전체 기본 배경/폰트 색상을 설정하세요.",1,'#f9fac6','#333333'); ?>
					<ul class="ul_pc_basic_color">
						<li>
						배경<br>
						<?php echo bpwg_input_color('wgf_mo_default_bg',$wgf_mo_default_bg,$w); ?>
						</li>
						<li>
						폰트<br>
						<?php echo bpwg_input_color('wgf_mo_default_font',$wgf_mo_default_font,$w); ?>
						</li>
					</ul>
				</td>
				<th>기본선형<br>그라데이션색상</th>
				<td colspan="<?=$colspan3?>" class="wdg_help">
					<?php echo wdg_help("사이트 전체 기본 선형 그라데이션 색상을 설정하세요.(주로 로그인,비번확인,비번찾기 페이지에서 사용됨.)",1,'#f9fac6','#333333'); ?>
					<ul class="ul_pc_basic_color">
						<li>
						From 색상<br>
						<?php echo bpwg_input_color('wgf_gradient_from',$wgf_gradient_from,$w); ?>
						</li>
						<li>
						To 색상<br>
						<?php echo bpwg_input_color('wgf_gradient_to',$wgf_gradient_to,$w); ?>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th>회전이미지업로드<br>최대갯수</th>
				<td class="wdg_help">
					<?php echo wdg_help("회전이미지의 등록가능한 최대개수를 설정하세요.(미세조정은 키보드의 방향키로 하세요.)<br><span style='color:red'>등록하는 전체 이미지의 용량을 잘 고려해서 설정하세요.</span><br><span style='color:red;'>이미지의 용량은 페이지 로딩에 큰 영향을 줍니다.</span>",1,'#f9fac6','#333333'); ?>
					<?php
					$wgf_rotation_maxcnt = (isset($wgf_rotation_maxcnt)) ? $wgf_rotation_maxcnt : 32;
					echo bpwg_input_range('wgf_rotation_maxcnt',$wgf_rotation_maxcnt,$w,16,90,1,'147',38,'개');
					?>
				</td>
				<th>회전이미지상태</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : pending=대기,ok=표시",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_rollimg_status"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_rollimg_status?>">
				</td>
				<th>디바이스 종류</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : pc=PC,mobile=MOBILE",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_device"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_device?>">
				</td>
			</tr>
			<tr>
				<th>캐시시간</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : 0=0초,0.00139=5초,0.0028=10초,0.0056=20초,0.0084=30초,0.012=40초,0.0139=50초,0.0167=60초,1=1시간",1,'#f9fac6','#333333'); ?>
					<!--
					$cache_time은 시간단위 
					1시간=1, 5초=0.00139, 10초=0.0028, 20초=0.0056, 30초=0.0084, 40초=0.012, 50초=0.0139, 60초=0.0167, 3600초=1시간
					-->
					<input type="text" name="wgf_cachetime"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_cachetime?>">
				</td>
				<th>언어설정</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : ko_KR=한국,en_US=영어,zh_CN=중국,ja_JP=일본",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_language"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_language?>">
				</td>
				<th>공통 상태</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : pending=대기,ok=정상,hide=숨김,trash=삭제",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_common_status"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_common_status?>">
				</td>
			</tr>
			<tr>
				<th>텍스트애니메이션 유형</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<?php echo wdg_help("예제 : flash=플래시,flip=플립,flipInX=플립인X,flipInY=플립인Y,fadeIn=패이드인,fadeInUp=패이드인위쪽,fadeInDown=패이드인아래쪽,fadeInLeft=패이드인왼쪽,fadeInRight=패이드인오른쪽,fadeInUpBig=페이드인위쪽크게,fadeInDownBig=페이드인아래쪽크게,rollIn=롤인,rotateInUpRight=회전위쪽오른쪽,bounceInLeft=바운스인왼쪽,bounceInRight=바운스인오른쪽",1,'#f9fac6','#333333'); ?>
					<!--p class="bp_fcgray">(예제 : flash=플래시,flip=플립,flipInX=플립인X,flipInY=플립인Y,fadeIn=패이드인,fadeInUp=패이드인위쪽,fadeInDown=패이드인아래쪽,fadeInLeft=패이드인왼쪽,fadeInRight=패이드인오른쪽,fadeInUpBig=페이드인위쪽크게,fadeInDownBig=페이드인아래쪽크게,rollIn=롤인,rotateInUpRight=회전위쪽오른쪽,bounceInLeft=바운스인왼쪽,bounceInRight=바운스인오른쪽)</p-->
					<input type="text" name="wgf_text_animation_type"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_text_animation_type?>">
				</td>
			</tr>
			<tr>
				<th>링크타겟</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : _self=현재창,_blank=새창",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_target"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_target?>">
				</td>
				<th>여부(예/아니오)</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : yes=예,no=아니오",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_yes_no"<?=$readonly?> class="wg_wdx240<?=$readonly?>" value="<?=$wgf_yes_no?>">
				</td>
				<th>너비/높이</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : width=너비,height=높이",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_width_height"<?=$readonly?> class="wg_wdx240<?=$readonly?>" value="<?=$wgf_width_height?>">
				</td>
			</tr>
			<tr>
				<th>표시여부확인</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : show=표시,hide=비표시",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_show_hide"<?=$readonly?> class="wg_wdx242<?=$readonly?>" value="<?=$wgf_show_hide?>">
				</td>
				<th>사용여부확인</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : use=사용,nouse=사용안함",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_use_nouse"<?=$readonly?> class="wg_wdx242<?=$readonly?>" value="<?=$wgf_use_nouse?>">
				</td>
				<th>자동여부확인</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : auto=자동,manual=수동",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_auto_manual"<?=$readonly?> class="wg_wdx242<?=$readonly?>" value="<?=$wgf_auto_manual?>">
				</td>
			</tr>
			<tr>
				<th>회전방향</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : cw=시계방향,ccw=반시계방향",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_cw_ccw"<?=$readonly?> class="wg_wdx242<?=$readonly?>" value="<?=$wgf_cw_ccw?>">
				</td>
				<th>회전중심유형</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : item=상품중심,camera=카메라중심",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_rotation_type"<?=$readonly?> class="wg_wdx242<?=$readonly?>" value="<?=$wgf_rotation_type?>">
				</td>
				<th>상품노출분류</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : 1=히트,2=추천,3=최신,4=인기,5=할인,6=분류,7=전체",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_item_show_type"<?=$readonly?> class="wg_wdx242<?=$readonly?>" value="<?=$wgf_item_show_type?>">
				</td>
			</tr>
			<tr>
				<th>사이트<br>기본너비</th>
				<td class="wdg_help">
					<?php echo wdg_help("사이트 기본너비(폭)을 설정해 주세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
					<?php
					$wgf_basic_width = (isset($wgf_basic_width)) ? $wgf_basic_width : 1100;
					echo bpwg_input_range('wgf_basic_width',$wgf_basic_width,$w,1080,1300,10,'147',48,'px');
					?>
				</td>
				<th>사이트하단<br>기본간격</th>
				<td class="wdg_help">
					<?php echo wdg_help("사이트 하단(푸터바로 위)의 기본간격을 설정해 주세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
					<?php
					$wgf_container_bottom_interval = (isset($wgf_container_bottom_interval)) ? $wgf_container_bottom_interval : 100;
					echo bpwg_input_range('wgf_container_bottom_interval',$wgf_container_bottom_interval,$w,20,200,10,'147',48,'px');
					?>
				</td>
				<th>PC최근자료그룹<br>상단간격</th>
				<td class="wdg_help">
					<?php echo wdg_help("PC메인에서 최근자료(레이티스트)그룹의 상단간격을 설정해 주세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
					<?php
					$wgf_latest_top_interval = (isset($wgf_latest_top_interval)) ? $wgf_latest_top_interval : 100;
					echo bpwg_input_range('wgf_latest_top_interval',$wgf_latest_top_interval,$w,20,200,10,'147',48,'px');
					?>
				</td>
			</tr>
			<tr>
				<th>위젯 사용범주</th>
				<td colspan="<?=$colspan3?>" class="wdg_help">
					<?php echo wdg_help("예제 : banner=배너,content=콘텐츠,board=게시판,shop=쇼핑몰,item=상품,turn=360회전이미지,section=섹션스킨,etc=기타",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_purpose"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_purpose?>">
				</td>
				<th>최근자료간<br>사이드간격</th>
				<td class="wdg_help">
					<?php echo wdg_help("최근자료간 사이드간격을 설정해 주세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
					<?php
					$wgf_latest_side_interval = (isset($wgf_latest_side_interval)) ? $wgf_latest_side_interval : 20;
					echo bpwg_input_range('wgf_latest_side_interval',$wgf_latest_side_interval,$w,0,80,1,'147',48,'px');
					?>
				</td>
			</tr>
			<tr>
				<th>가로정렬위치</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : left=왼쪽,center=가운데,right=오른쪽",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_horizontal_align"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_horizontal_align?>">
				</td>
				<th>가로정렬위치2</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : left=왼쪽,right=오른쪽",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_horizontal_align2"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_horizontal_align2?>">
				</td>
				<th>가로정렬위치3</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : left=왼쪽,center=가운데",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_horizontal_align3"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_horizontal_align3?>">
				</td>
			</tr>
			<tr>
				<th>단위</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : px=PX,%=%",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_unit"<?=$readonly?> class="wg_wdx240<?=$readonly?>" value="<?=$wgf_unit?>">
				</td>
				<th>단위2</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : px=PX,%=%,pt=PT,em=EM",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_unit2"<?=$readonly?> class="wg_wdx240<?=$readonly?>" value="<?=$wgf_unit2?>">
				</td>
				<th>검색유형</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : yes=상품검색,no=일반검색",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_sch_shop"<?=$readonly?> class="wg_wdx240<?=$readonly?>" value="<?=$wgf_sch_shop?>">
				</td>
			</tr>
			<tr>
				<th>모바일 최대너비</th>
				<td class="wdg_help">
					<?php echo wdg_help("PC화면에서 모바일화면 최대너비(폭)을 설정해 주세요.(미세조정은 키보드의 방향키로 하세요.)",1,'#f9fac6','#333333'); ?>
					<?php
					$wgf_mobile_max_width = (isset($wgf_mobile_max_width)) ? $wgf_mobile_max_width : 800;
					echo bpwg_input_range('wgf_mobile_max_width',$wgf_mobile_max_width,$w,640,900,10,'147',48,'px');
					?>
				</td>
				<th>세로정렬위치</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : top=상단,middle=가운데,bottom=하단",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_vertical_align"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=$wgf_vertical_align?>">
				</td>
				<th>세로정렬위치2</th>
				<td class="wdg_help">
					<?php echo wdg_help("예제 : top=상단,bottom=하단",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_vertical_align2"<?=$readonly?> class="wg_wdx240<?=$readonly?>" value="<?=$wgf_vertical_align2?>">
				</td>
			</tr>
			<tr>
				<th>사이트기본<br>버튼색상</th>
				<td class="wdg_help">
					<?php echo wdg_help("사이트에서 사용하는 기본 버튼색상을 설정하세요.<span style='color:#0000ff;'>(위의 첫번째 색상그룹은 버튼의 기본색상, 아래 두번째 색상그룹은 마우스오버시 색상, 아래 세번째 색상 그룹은 버튼폰트색상.)</span>",1,'#f9fac6','#333333'); ?>
					<ul class="adm_color_ul">
						<li class="adm_color_li"><p class="adm_color_p basic_color1"><?=$wgf_basic_color1?></p><?php echo bpwg_input_color('wgf_basic_color1',$wgf_basic_color1,$w); ?><p>#1</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_color2"><?=$wgf_basic_color2?></p><?php echo bpwg_input_color('wgf_basic_color2',$wgf_basic_color2,$w); ?><p>#2</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_color3"><?=$wgf_basic_color3?></p><?php echo bpwg_input_color('wgf_basic_color3',$wgf_basic_color3,$w); ?><p>#3</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_color4"><?=$wgf_basic_color4?></p><?php echo bpwg_input_color('wgf_basic_color4',$wgf_basic_color4,$w); ?><p>#4</p></li>
					</ul>
					<ul class="adm_color_ul" style="border-top:1px solid #ddd;">
						<li class="adm_color_li"><p class="adm_color_p basic_hover_color1"><?=$wgf_basic_hover_color1?></p><?php echo bpwg_input_color('wgf_basic_hover_color1',$wgf_basic_hover_color1,$w); ?><p>#1_hover</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_hover_color2"><?=$wgf_basic_hover_color2?></p><?php echo bpwg_input_color('wgf_basic_hover_color2',$wgf_basic_hover_color2,$w); ?><p>#2_hover</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_hover_color3"><?=$wgf_basic_hover_color3?></p><?php echo bpwg_input_color('wgf_basic_hover_color3',$wgf_basic_hover_color3,$w); ?><p>#3_hover</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_hover_color4"><?=$wgf_basic_hover_color4?></p><?php echo bpwg_input_color('wgf_basic_hover_color4',$wgf_basic_hover_color4,$w); ?><p>#4_hover</p></li>
					</ul>
					<ul class="adm_color_ul" style="border-top:1px solid #ddd;">
						<li class="adm_color_li"><p class="adm_color_p basic_font_color1"><?=$wgf_basic_font_color1?></p><?php echo bpwg_input_color('wgf_basic_font_color1',$wgf_basic_font_color1,$w); ?><p>#1_font</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_font_color2"><?=$wgf_basic_font_color2?></p><?php echo bpwg_input_color('wgf_basic_font_color2',$wgf_basic_font_color2,$w); ?><p>#2_font</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_font_color3"><?=$wgf_basic_font_color3?></p><?php echo bpwg_input_color('wgf_basic_font_color3',$wgf_basic_font_color3,$w); ?><p>#3_font</p></li>
						<li class="adm_color_li"><p class="adm_color_p basic_font_color4"><?=$wgf_basic_font_color4?></p><?php echo bpwg_input_color('wgf_basic_font_color4',$wgf_basic_font_color4,$w); ?><p>#4_font</p></li>
					</ul>
				</td>
				<td colspan="<?=$colspan4?>" class="wdg_help">
					<?php echo wdg_help("해당 색상을 사용한 버튼의 클래스명<strong style='color:blue;'>(예: .btn_submit,.btn_cart)</strong>각 클래스는 쉼표(,)로 구분하세요.",1,'#f9fac6','#333333'); ?>
					<p class="adm_basic_color_p first_p">#1_basic&nbsp; : <input type="text" name="wgf_basic_color1_class" class="wg_wdp90" value="<?=$wgf_basic_color1_class?>"></p>
					<p class="adm_basic_color_p">#1_hover : <input type="text" name="wgf_basic_color1_hover_class" class="wg_wdp90" value="<?=$wgf_basic_color1_hover_class?>"></p>
					<p class="adm_basic_color_p chief_p">#2_basic&nbsp; : <input type="text" name="wgf_basic_color2_class" class="wg_wdp90" value="<?=$wgf_basic_color2_class?>"></p>
					<p class="adm_basic_color_p">#2_hover : <input type="text" name="wgf_basic_color2_hover_class" class="wg_wdp90" value="<?=$wgf_basic_color2_hover_class?>"></p>
					<p class="adm_basic_color_p chief_p">#3_basic&nbsp; : <input type="text" name="wgf_basic_color3_class" class="wg_wdp90" value="<?=$wgf_basic_color3_class?>"></p>
					<p class="adm_basic_color_p">#3_hover : <input type="text" name="wgf_basic_color3_hover_class" class="wg_wdp90" value="<?=$wgf_basic_color3_hover_class?>"></p>
					<p class="adm_basic_color_p chief_p">#4_basic&nbsp; : <input type="text" name="wgf_basic_color4_class" class="wg_wdp90" value="<?=$wgf_basic_color4_class?>"></p>
					<p class="adm_basic_color_p">#4_hover : <input type="text" name="wgf_basic_color4_hover_class" class="wg_wdp90" value="<?=$wgf_basic_color4_hover_class?>"></p>
				</td>
			</tr>
			<tr>
				<th>상품유형아이콘<br>(배경/폰트)색상</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<?php echo wdg_help("상품유형아이콘 (배경/폰트)색상을 설정하세요.<span style='color:#ff0000;'>(본 테마에서는 배경색상은 반영이 안됩니다.)</span>",1,'#f9fac6','#333333'); ?>
					<ul class="adm_color_ul">
						<li class="adm_color_li"><p class="adm_color_p adm_type1">히트배경</p><?php echo bpwg_input_color('wgf_type1_bg',$wgf_type1_bg,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type1">히트폰트</p><?php echo bpwg_input_color('wgf_type1_font',$wgf_type1_font,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type2">추천배경</p><?php echo bpwg_input_color('wgf_type2_bg',$wgf_type2_bg,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type2">추천폰트</p><?php echo bpwg_input_color('wgf_type2_font',$wgf_type2_font,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type3">최신배경</p><?php echo bpwg_input_color('wgf_type3_bg',$wgf_type3_bg,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type3">최신폰트</p><?php echo bpwg_input_color('wgf_type3_font',$wgf_type3_font,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type4">인기배경</p><?php echo bpwg_input_color('wgf_type4_bg',$wgf_type4_bg,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type4">인기폰트</p><?php echo bpwg_input_color('wgf_type4_font',$wgf_type4_font,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type5">할인배경</p><?php echo bpwg_input_color('wgf_type5_bg',$wgf_type5_bg,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_type5">할인폰트</p><?php echo bpwg_input_color('wgf_type5_font',$wgf_type5_font,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_soldout">매진배경</p><?php echo bpwg_input_color('wgf_soldout_bg',$wgf_soldout_bg,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_soldout">매진폰트</p><?php echo bpwg_input_color('wgf_soldout_font',$wgf_soldout_font,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_coupon">쿠폰배경</p><?php echo bpwg_input_color('wgf_coupon_bg',$wgf_coupon_bg,$w); ?></li>
						<li class="adm_color_li"><p class="adm_color_p adm_coupon">쿠폰폰트</p><?php echo bpwg_input_color('wgf_coupon_font',$wgf_coupon_font,$w); ?></li>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
</section><!--#anc_bpwg_basic-->
<section id="anc_bpwg_opengraph">
	<h2 class="h2_frm">오픈그래프 설정</h2>
    <?php echo $pg_anchor; ?>
	<table class="tbl_frm">
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
				<th>URL</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php echo wdg_help("오픈 그래프의 og:url 부분에 들어갈 URL입니다. 자동으로 들어갑니다. 수정할 필요 없음",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_og_url"<?=$readonly?> class="wg_wdp100<?=$readonly?>" value="<?=G5_URL?>">
				</td>
			</tr>
			<tr>
				<th>타이틀</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php echo wdg_help("오픈 그래프의 og:title 부분에 들어갈 내용입니다.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_og_title" class="wg_wdp100" value="<?=$wgf_og_title?>">
				</td>
			</tr>
			<tr>
				<th>설명</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php echo wdg_help("오픈 그래프의 og:description 부분에 들어갈 내용입니다.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_og_description" class="wg_wdp100" value="<?=$wgf_og_description?>">
				</td>
			</tr>
			<tr>
				<th scope="row">이미지<br>(og:image)</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<?php echo wdg_help("오픈 그래프의 og:image 부분에 들어갈 이미지 파일입니다. 크기는 1200*1200px (SNS 채널에 따라 아래위 부분이 잘릴 수 있습니다.)",1,'#f9fac6','#333333'); ?>
					<input type="hidden" name="fle_idx[file_og]" value="<?=$file_og_idx?>">
					<input type="file" name="file_og" class="">
					<label for="del_idx[file_og]" class="label_checkbox">
						<input type="checkbox" id="del_idx[file_og]" name="del_idx[file_og]" value="<?=$file_og_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($file_og['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$file_og['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
				<th scope="row">사이트로고<br>(Favicon)</th>
				<td colspan="<?=$colspan5?>" class="wdg_help">
					<?php echo wdg_help("브라우저 탭에 표시되는 로고 또는 모바일에서 웹사이트를 홈화면 추가시 보이는 아이콘 이미지입니다. 크기는 192px*192px로 제작하세요.",1,'#f9fac6','#333333'); ?>
					<input type="hidden" name="fle_idx[favicon]" value="<?=$favicon_idx?>">
					<input type="file" name="favicon" class="">
					<label for="del_idx[favicon]" class="label_checkbox">
						<input type="checkbox" id="del_idx[favicon]" name="del_idx[favicon]" value="<?=$favicon_idx?>">
						<strong></strong>
						<span>삭제</span>
					</label>
					<?php if($favicon['thumb_url']){ ?>
					<div style="margin-top:5px;">
					<img src="<?=$favicon['thumb_url']?>">
					</div>
					<?php } ?>
				</td>
			</tr>
		</tbody>
	</table>
</section><!--#anc_bpwg_opengraph-->
<section id="anc_bpwg_webmaster">
	<h2 class="h2_frm">웹마스터 설정</h2>
    <?php echo $pg_anchor; ?>
	<table class="tbl_frm">
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
				<th>구글<br>웹마스터키</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php echo wdg_help("구글 웹마스타 설정을 위한 <strong style='color:red'>google-site-verification키</strong> 값을 입력해 주세요.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_google_site_verification" class="wg_wdp100" value="<?=$wgf_google_site_verification?>">
				</td>
			</tr>
			<tr>
				<th>네이버<br>웹마스터키</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php echo wdg_help("네이버 웹마스타 설정을 위한 <strong style='color:red'>naver-site-verification키</strong> 값을 입력해 주세요.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_naver_site_verification" class="wg_wdp100" value="<?=$wgf_naver_site_verification?>">
				</td>
			</tr>
			<tr>
				<th scope="row">사이트맵<br>파일</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php echo wdg_help("웹마스터 연동을 위한 sitemap.xml 파일을 업로드해 주세요.<br>기존 파일이 존재하면 덮어쓰기 됩니다.<br><strong>파일위치 : <span style='color:blue;'>".G5_wdg_DATA_URL."/seo/sitemap.xml</sapn></strong>",1,'#f9fac6','#333333'); ?>
					<p>반드시 사이트 오픈후 sitemap.xml파일(파일명 동일하게 작성)을 작성하여 업로드 해 주세요.<br>sitemap.xml을 만들어주는 사이트 여기-> [<a href="http://www.check-domains.com/sitemap/index.php" target="_blank" style="color:orange;">http://www.check-domains.com/sitemap/index.php</a>]<br>방법은 아래 순서를 참고 하세요.</p>
					<p>1. 사이트 기본URL을 Site URL입력란에 입력하세요.</p>
					<p>2. 아래 라디오버튼에서 "Server's response"를 체크하세요.</p>
					<p>3. 그 옆에 있는 "Frequency"의 드롭박스 목록에서 "Always"로 선택하세요.(Monthly가 아닙니다. 주의하세요!)</p>
					<p>4. Site URL입력란 오른쪽에 있는 노란색버튼"Create Sitemap"을 클릭합니다. </p>
					<p>5. 시간이 상당히 오래 걸리기 때문에 페이지를 절대 닫지말고 끝까지 기다리세요.(대략 30분정도 소요됨)</p>
					<p>6. 작성완료되면 다운받고, 파일명이 sitemap.xml인것을 확인후 현 사이트로 돌아와 업로드 해 주세요.</p>
					<hr style="border-top:1px solid #ddd;">
					<input type="file" name="sitemap" class="">
					<?php
					if(is_file(G5_wdg_DATA_PATH.'/seo/sitemap.xml')) echo '<strong style="color:blue;">'.G5_wdg_DATA_URL.'/seo/sitemap.xml 에 파일이 업로드 되어 있습니다.</strong>';
					else echo '<strong style="color:orange;">sitemap.xml파일을 업로드 해 주세요.</strong>';
					?>
				</td>
			</tr>
			<!--tr class="sound_only">
				<th>관리IP</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php //echo wdg_help("관리IP를 입력해 주세요.",1,'#f9fac6','#333333'); ?>
					<input type="text" name="wgf_admin_ip" class="wg_wdp100" value="<?=$wgf_admin_ip?>">
				</td>
			</tr>
			<tr>
				<th>로그인IP</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php //echo wdg_help("입력된 IP의 컴퓨터만 로그인버튼이 표시됩니다.<br>123.123.+ 도 입력 가능. (엔터로 구분).",1,'#f9fac6','#333333'); ?>
					<textarea name="wgf_login_ip" class="wg_wdx300" rows="6"><?=$wgf_login_ip?></textarea>
				</td>
			</tr-->
		</tbody>
	</table>
</section><!--#anc_bpwg_naverwebmaster-->
<section id="anc_bpwg_dataset">
	<!--
	<h2 class="h2_frm">데이터 설정</h2>
    <?php //echo $pg_anchor; ?>
	<table class="tbl_frm">
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
				<th>데이터<br>초기화</th>
				<td class="wdg_help">
					<?php //echo wdg_help("회원, 상품, 주문, 게시물 데이터를 초기화 합니다. 게시판 정보 및 상품카테고리 정보는 초기화되지 않습니다.",1,'#f9fac6','#333333'); ?>
					<a href="./bwg_init_data.php" class="btn_frmline" id="bwg_init_data">초기화하기</a>
				</td>
				<th>임시데이터<br>생성</th>
				<td class="wdg_help">
					<?php //echo wdg_help("테스트 목적으로 상품 분류, 상품 정보, 게시물등의 임시 데이터를 생성합니다.",1,'#f9fac6','#333333'); ?>
					<a href="./bwg_add_data.php" class="btn_frmline" id="bwg_add_data">임시데이터생성</a>
				</td>
				<th>등록자료<br>URL변경</th>
				<td colspan="<?=$colspan11?>" class="wdg_help">
					<?php //echo wdg_help("도메인을 변경했을 경우 등록자료/등록이미지등의 URL속성을 새로운 도메인으로 업데이트 해 주어야 합니다.",1,'#f9fac6','#333333'); ?>
					<a href="./bwg_change_url.php" class="btn_frmline" id="bwg_change_url">URL 업데이트</a>
				</td>
			</tr>
		</tbody>
	</table>
	-->
</section><!--#anc_bpwg_dataset-->
<?php echo $frm_submit; ?>
</form><!--#fbwgf-->
</div><!--#bpwg_frm-->
<script>
	/*
$(function(){
	$("#bwg_init_data").click(function(){
		var win_init_data = window.open(this.href, "win_init_data", "left=10,top=10,width=450,height=550");
		win_init_data.focus();
		return false;
	});
	$("#bwg_add_data").click(function(){
		var win_add_data = window.open(this.href, "win_add_data", "left=10,top=10,width=500,height=480");
		win_add_data.focus();
		return false;
	});
	$("#bwg_change_url").click(function(){
		var win_change_url = window.open(this.href, "win_change_url", "left=10,top=10,width=600,height=600");
		win_change_url.focus();
		return false;
	});
});
	*/
function fwgf_submit(f){
	<?php //echo get_editor_js("wgf_xxxxx1"); ?>	
	<?php //echo get_editor_js("wgf_xxxxx2"); ?>	
	<?php //echo get_editor_js("wgf_xxxxx3"); ?>	

	f.action = "./wdg_config_form_update.php";
	return true;
}
</script>
<?php
include(G5_wdg_ADMIN_PATH.'/admin.tail.sub.php');
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>
<?php
define('G5_IS_ADMIN', true);
include_once('../../../common.php');

// 기존 $board 배열 값에 meta_bale에서 추출한 값을 병합한다.
$board = @array_merge($board,get_meta('board/'.$bo_table,$bo_table));
if (G5_IS_MOBILE) {
    $board_skin_path    = @get_skin_path('board', $board['bo_adm_mobile_skin']);
    $board_skin_url     = @get_skin_url('board', $board['bo_adm_mobile_skin']);
} else {
    $board_skin_path    = @get_skin_path('board', $board['bo_adm_skin']);
    $board_skin_url     = @get_skin_url('board', $board['bo_adm_skin']);
}
//[0-9a-zA-Z_|0-9ㄱ-ㅎ가-힣_]{1,}=
foreach($board as $bo_key => $bo_val){
    if(preg_match("/^bo_[\d]{1,2}$/", $bo_key) || preg_match("/bo_adm_[a-z0-9A-Z]{1,}/", $bo_key)){
        // echo $bo_key."<br>";
        if(preg_match_all("/[0-9a-zA-Z_ㄱ-ㅎ가-힣]{1,}=[0-9a-zA-Z_ㄱ-ㅎ가-힣]{1,}/", $bo_val)){
            $bo_values = explode(',', preg_replace("/\s+/", "", $bo_val));
            // print_r2($bo_values);
            foreach($bo_values as $keys => $vals){
                // echo $vals."<br>";
                if(preg_match("/[0-9a-zA-Z_ㄱ-ㅎ가-힣]{1,}=[0-9a-zA-Z_ㄱ-ㅎ가-힣]{1,}/",$vals)){
                    list($key, $value) = explode('=', $vals);
                    // echo $key."<br>";                
                    $board[$bo_key.'_key_arr'][$key] = $value;
                    $board[$bo_key.'_rev_arr'][$value] = $key;
                    $board[$bo_key.'_keys'][] = $key;
                    $board[$bo_key.'_vals'][] = $value;
                    $board[$bo_key.'_key_radios'] .= '<label for="'.$bo_key.'_'.$key.'" class="'.$bo_key.'"><input type="radio" id="'.$bo_key.'_'.$key.'" name="'.$bo_key.'" value="'.$key.'">'.$value.'('.$key.')</label>';
                    $board[$bo_key.'_val_radios'] .= '<label for="'.$bo_key.'_'.$key.'" class="'.$bo_key.'"><input type="radio" id="'.$bo_key.'_'.$key.'" name="'.$bo_key.'" value="'.$key.'">'.$value.'</label>';
                    $board[$bo_key.'_key_options'] .= '<option value="'.trim($key).'">'.trim($value).' ('.$key.')</option>';
                    $board[$bo_key.'_val_options'] .= '<option value="'.trim($key).'">'.trim($value).'</option>';
                }
            }
        }
    }
}

// print_r3($board);
// exit;
if ($member['mb_level'] < 5)
    alert('승인된 회원만 접근 가능합니다.',G5_URL);
    
include_once(G5_ADMIN_PATH.'/admin.lib.php');

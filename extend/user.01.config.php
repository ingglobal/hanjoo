<?php
// 공통 변수, 상수 선언
define('G5_USER_DIR',                       'user');
define('G5_USER_ADMIN_DIR',                 'v10');
define('G5_AJAX_DIR',                       'ajax');
define('G5_USER_PATH',                      G5_PATH.'/'.G5_USER_DIR);
define('G5_USER_URL',                       G5_URL.'/'.G5_USER_DIR);
define('G5_USER_ADMIN_PATH',                G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR);
define('G5_USER_ADMIN_URL',                 G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR);
define('G5_USER_ADMIN_CSS_PATH',            G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/'.G5_CSS_DIR);
define('G5_USER_ADMIN_CSS_URL',             G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/'.G5_CSS_DIR);
define('G5_USER_ADMIN_JS_PATH',             G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/'.G5_JS_DIR);
define('G5_USER_ADMIN_JS_URL',              G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/'.G5_JS_DIR);
define('G5_USER_CSS_PATH',                  G5_USER_PATH.'/'.G5_CSS_DIR);
define('G5_USER_CSS_URL',                   G5_USER_URL.'/'.G5_CSS_DIR);
define('G5_USER_JS_PATH',                   G5_USER_PATH.'/'.G5_JS_DIR);
define('G5_USER_JS_URL',                    G5_USER_URL.'/'.G5_JS_DIR);
define('G5_USER_ADMIN_MOBILE_URL',          G5_USER_ADMIN_URL.'/'.G5_MOBILE_DIR);
define('G5_USER_ADMIN_MOBILE_CSS_PATH',     G5_USER_ADMIN_PATH.'/'.G5_MOBILE_DIR.'/'.G5_CSS_DIR);
define('G5_USER_ADMIN_MOBILE_CSS_URL',      G5_USER_ADMIN_URL.'/'.G5_MOBILE_DIR.'/'.G5_CSS_DIR);
define('G5_USER_ADMIN_MOBILE_JS_PATH',      G5_USER_ADMIN_PATH.'/'.G5_MOBILE_DIR.'/'.G5_JS_DIR);
define('G5_USER_ADMIN_MOBILE_JS_URL',       G5_USER_ADMIN_URL.'/'.G5_MOBILE_DIR.'/'.G5_JS_DIR);


define('NEW_TABLE_PREFIX',          G5_TABLE_PREFIX . '1_');
define('USER_TABLE_PREFIX',          G5_TABLE_PREFIX . '5_');

// G5_5_TABLE : 서울오빠 전용 확장 DB
$g5['setting_table']                = USER_TABLE_PREFIX . 'setting';
$g5['meta_table']                   = USER_TABLE_PREFIX . 'meta';
$g5['tally_table']                  = USER_TABLE_PREFIX . 'tally';
$g5['ymd_table']                    = USER_TABLE_PREFIX . 'ymd';
$g5['term_table']                   = USER_TABLE_PREFIX . 'term';
$g5['term_relation_table']          = USER_TABLE_PREFIX . 'term_relation';
$g5['ymd_table']                    = USER_TABLE_PREFIX . 'ymd';
$g5['file_table']                   = USER_TABLE_PREFIX . 'file';
$g5['banner_table']                 = USER_TABLE_PREFIX . 'banner';
$g5['history_table']                = USER_TABLE_PREFIX . 'history';
$g5['comment_table']                = USER_TABLE_PREFIX . 'comment';

// G5_1_TABLE : 공통된 프로젝트 확장 DB
$g5['applicant_table']              = NEW_TABLE_PREFIX . 'applicant';       //지원자
$g5['recruit_table']                = NEW_TABLE_PREFIX . 'recruit';         //채용관리
$g5['school_table']                 = NEW_TABLE_PREFIX . 'school';          //학교
$g5['career_table']                 = NEW_TABLE_PREFIX . 'career';          //경력
$g5['message_table']                = NEW_TABLE_PREFIX . 'message';          //메시지
$g5['group_message_table']          = NEW_TABLE_PREFIX . 'group_message';    //그룹메시지
$g5['additional_table']             = NEW_TABLE_PREFIX . 'additional';      //추가사항


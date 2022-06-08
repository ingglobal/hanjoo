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
define('G5_USER_ADMIN_IMG_PATH',            G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/'.G5_IMG_DIR);
define('G5_USER_ADMIN_IMG_URL',             G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/'.G5_IMG_DIR);
define('G5_USER_ADMIN_JS_PATH',             G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/'.G5_JS_DIR);
define('G5_USER_ADMIN_JS_URL',              G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/'.G5_JS_DIR);
define('G5_USER_ADMIN_LIB_PATH',            G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/'.G5_LIB_DIR);
define('G5_USER_ADMIN_LIB_URL',             G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/'.G5_LIB_DIR);
define('G5_USER_ADMIN_FORM_PATH',   		G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/form');
define('G5_USER_ADMIN_FORM_URL',   		    G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/form');
define('G5_USER_ADMIN_SVG_PATH',   		    G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/svg');
define('G5_USER_ADMIN_SVG_URL',   		    G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/svg');
define('G5_USER_ADMIN_SKIN_PATH',   		G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/skin');
define('G5_USER_ADMIN_SKIN_URL',   		    G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/skin');
define('G5_USER_ADMIN_SQL_PATH',   		    G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/sql');
define('G5_USER_ADMIN_SQL_URL',   		    G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/sql');
define('G5_USER_ADMIN_TEST_PATH',   		G5_ADMIN_PATH.'/'.G5_USER_ADMIN_DIR.'/test');
define('G5_USER_ADMIN_TEST_URL',   		    G5_ADMIN_URL.'/'.G5_USER_ADMIN_DIR.'/test');
define('G5_USER_CSS_PATH',                  G5_USER_PATH.'/'.G5_CSS_DIR);
define('G5_USER_CSS_URL',                   G5_USER_URL.'/'.G5_CSS_DIR);
define('G5_USER_JS_PATH',                   G5_USER_PATH.'/'.G5_JS_DIR);
define('G5_USER_JS_URL',                    G5_USER_URL.'/'.G5_JS_DIR);
define('G5_USER_ADMIN_MOBILE_URL',          G5_USER_ADMIN_URL.'/'.G5_MOBILE_DIR);
define('G5_USER_ADMIN_MOBILE_CSS_PATH',     G5_USER_ADMIN_PATH.'/'.G5_MOBILE_DIR.'/'.G5_CSS_DIR);
define('G5_USER_ADMIN_MOBILE_CSS_URL',      G5_USER_ADMIN_URL.'/'.G5_MOBILE_DIR.'/'.G5_CSS_DIR);
define('G5_USER_ADMIN_MOBILE_JS_PATH',      G5_USER_ADMIN_PATH.'/'.G5_MOBILE_DIR.'/'.G5_JS_DIR);
define('G5_USER_ADMIN_MOBILE_JS_URL',       G5_USER_ADMIN_URL.'/'.G5_MOBILE_DIR.'/'.G5_JS_DIR);


define('USER_TABLE_PREFIX',          G5_TABLE_PREFIX . '5_');

// G5_5_TABLE
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



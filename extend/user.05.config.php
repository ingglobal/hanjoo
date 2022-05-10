<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 사용자 테이블 정의
define('NEW_TABLE_PREFIX',          G5_TABLE_PREFIX . '1_');

// G5_1_TABLE : 공통된 프로젝트 확장 DB
$g5['cast_shot_table']              = NEW_TABLE_PREFIX . 'cast_shot';
$g5['cast_shot_sub_table']          = NEW_TABLE_PREFIX . 'cast_shot_sub';
$g5['cast_shot_pressure_table']     = NEW_TABLE_PREFIX . 'cast_shot_pressure';
$g5['charge_in_table']              = NEW_TABLE_PREFIX . 'charge_in';
$g5['charge_out_table']             = NEW_TABLE_PREFIX . 'charge_out';
$g5['engrave_qrcode_table']         = NEW_TABLE_PREFIX . 'engrave_qrcode';
$g5['melting_temp_table']           = NEW_TABLE_PREFIX . 'melting_temp';
$g5['xray_inspection_table']        = NEW_TABLE_PREFIX . 'xray_inspection';


// timescale DB connect
$dsn = "pgsql:dbname=test_db;port=5432 host=localhost";
try {
    $db = new PDO($dsn, "postgres", "super@ingglobal");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo $e->getMessage();
    exit;
}

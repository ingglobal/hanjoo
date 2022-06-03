<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// timescale DB connect
// $dsn = "pgsql:dbname=hanjoo_www;port=5432 host=localhost";

$dsn = "pgsql:dbname=hanjoo_www;port=5432 host=61.83.89.15";
try {
    $db = new PDO($dsn, "postgres", "super@ingglobal");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo $e->getMessage();
    exit;
}


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

$g5['company_table']                = NEW_TABLE_PREFIX.'company';
$g5['company_member_table']         = NEW_TABLE_PREFIX.'company_member';
$g5['company_saler_table']          = NEW_TABLE_PREFIX.'company_saler';
$g5['code_table']                   = NEW_TABLE_PREFIX.'code';
$g5['tag_code_table']               = NEW_TABLE_PREFIX.'tag_code';
$g5['imp_table']                    = NEW_TABLE_PREFIX.'imp';
$g5['mms_table']                    = NEW_TABLE_PREFIX.'mms';
$g5['mms_group_table']              = NEW_TABLE_PREFIX.'mms_group';
$g5['mms_parts_table']              = NEW_TABLE_PREFIX.'mms_parts';
$g5['mms_checks_table']             = NEW_TABLE_PREFIX.'mms_checks';
$g5['mms_status_table']             = NEW_TABLE_PREFIX.'mms_status';
$g5['mms_item_table']               = NEW_TABLE_PREFIX.'mms_item';
$g5['mms_item_price_table']         = NEW_TABLE_PREFIX.'mms_item_price';
$g5['maintain_table']               = NEW_TABLE_PREFIX.'maintain';
$g5['maintain_parts_table']         = NEW_TABLE_PREFIX.'maintain_parts';
$g5['shift_table']                  = NEW_TABLE_PREFIX.'shift';
$g5['shift_item_goal_table']        = NEW_TABLE_PREFIX.'shift_item_goal';
$g5['data_table']                   = NEW_TABLE_PREFIX.'data';
$g5['data_measure_table']           = NEW_TABLE_PREFIX.'data_measure';
$g5['data_measure_sum_table']       = NEW_TABLE_PREFIX.'data_measure_sum';
$g5['data_error_table']             = NEW_TABLE_PREFIX.'data_error';
$g5['data_error_sum_table']         = NEW_TABLE_PREFIX.'data_error_sum';
$g5['data_run_table']               = NEW_TABLE_PREFIX.'data_run';
$g5['data_run_sum_table']           = NEW_TABLE_PREFIX.'data_run_sum';
$g5['data_run_real_table']          = NEW_TABLE_PREFIX.'data_run_real';
$g5['data_output_table']            = NEW_TABLE_PREFIX.'data_output';
$g5['data_output_sum_table']        = NEW_TABLE_PREFIX.'data_output_sum';
$g5['data_downtime_table']          = NEW_TABLE_PREFIX.'data_downtime';
$g5['member_dash_table']            = NEW_TABLE_PREFIX.'member_dash';
$g5['alarm_table']                  = NEW_TABLE_PREFIX.'alarm';
$g5['offwork_table']                = NEW_TABLE_PREFIX.'offwork';
$g5['alarm_send_table']             = NEW_TABLE_PREFIX.'alarm_send';
$g5['alarm_tag_table']              = NEW_TABLE_PREFIX.'alarm_tag';
$g5['alarm_tag_send_table']         = NEW_TABLE_PREFIX.'alarm_tag_send';
$g5['cost_config_table']            = NEW_TABLE_PREFIX.'cost_config';

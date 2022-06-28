<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// timescale DB connect
// define('G5_PGSQL_HOST', '61.83.89.15');
define('G5_PGSQL_HOST', 'localhost');
define('G5_PGSQL_USER', 'postgres');
define('G5_PGSQL_PASSWORD', 'hanjoo@ingglobal');
define('G5_PGSQL_DB', 'hanjoo_www');

$dsn = "pgsql:dbname=".G5_PGSQL_DB.";port=5432 host=".G5_PGSQL_HOST;
try {
    $db = new PDO($dsn, G5_PGSQL_USER, G5_PGSQL_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo $e->getMessage();
    exit;
}




<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$sql_search에 조건절을 추가하는 방식으로 값을 지정해라
//예) $sql_search .= ($sql_search != '')?'WHERE (1)'.implode(' AND ', $where):implode(' AND ', $where);

$where = array();
$where[] = " wr_10 NOT IN ('trash','delete') ";   // 디폴트 검색조건

if ($ser_wr_10) {
    $where[] = " wr_10 = '{$ser_wr_10}' ";
}

if($where){
    if($sql_search) {
        $sql_search .= implode(' AND ', $where);
    }
    else {
        $sql_search = implode(' AND ', $where);
    }
}
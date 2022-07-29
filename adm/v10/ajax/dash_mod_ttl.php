<?php
include_once('./_common.php');
$mta_mod_sql = " UPDATE {$g5['meta_table']} SET
                    mta_title = '{$mta_title}'
                WHERE mta_db_table = 'member'
                    AND mta_db_id = '{$member['mb_id']}'
                    AND mta_key = 'dashboard_menu'
                    AND mta_value = '{$mta_value}'
";
sql_query($mta_mod_sql);
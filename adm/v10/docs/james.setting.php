// 설정 페이지 관련
// 네이티브 코어 업데이트 관련
// 정보를 저장하고 관리합니다.

# 네이티브 코어 버전 동기화 파일들입니다.
1. /config.php
    // 모바일 기기에서 DHTML 에디터 사용여부를 설정합니다.
    define('G5_IS_MOBILE_DHTML_USE', true); // editor in Mobile.
    define('G5_DB_ENGINE', 'MyISAM');
2. /plugin/jquery-ui/datepicker.php
    jquery-ui 충돌이 나요. 예전 꺼는 주석 처리하고 별도로 선언한 최근 jquery-ui를 사용하도록 합니다.

    


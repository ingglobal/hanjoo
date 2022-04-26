This is james work memo.

CREATE TABLE `g5_1_cast_shot_sub` (
  `mcs_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) NOT NULL COMMENT '샷ID',
  `event_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '발생시각',
  `hold_temp` double NOT NULL COMMENT '보온로온도',
  `upper_heat` double NOT NULL COMMENT '상형히트',
  `lower_heat` double NOT NULL COMMENT '하형히트',
  `upper_1_temp` double NOT NULL COMMENT '상금형1',
  `upper_2_temp` double NOT NULL COMMENT '상금형2',
  `upper_3_temp` double NOT NULL COMMENT '상금형3',
  `upper_4_temp` double NOT NULL COMMENT '상금형4',
  `upper_5_temp` double NOT NULL COMMENT '상금형5',
  `upper_6_temp` double NOT NULL COMMENT '상금형6',
  `lower_1_temp` double NOT NULL COMMENT '하금형1',
  `lower_2_temp` double NOT NULL COMMENT '하금형2',
  `lower_3_temp` double NOT NULL COMMENT '하금형3',
  PRIMARY KEY (`mcs_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_recruit` (
  `rct_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `apc_idx` bigint(20) NOT NULL DEFAULT '0' COMMENT '지원자idx',
  `rct_subject` varchar(255) NOT NULL DEFAULT '',
  `rct_type` varchar(50) NOT NULL DEFAULT '',
  `mb_id` varchar(50) NOT NULL DEFAULT '' COMMENT '담당자id',
  `rct_content` text NOT NULL,
  `rct_mobile_content` text NOT NULL,
  `rct_channel` varchar(20) NOT NULL DEFAULT '' COMMENT '공고채널',
  `rct_work_place` varchar(255) NOT NULL DEFAULT '' COMMENT '근무지',
  `rct_expire_date` date DEFAULT '0000-00-00' COMMENT '마감일',
  `rct_status` varchar(20) DEFAULT 'pending' COMMENT '상태',
  `rct_reg_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시',
  `rct_update_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '수정일시',
  PRIMARY KEY (`rct_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_career` (
  `crr_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `apc_idx` bigint(20) NOT NULL DEFAULT '0' COMMENT '지원자idx',
  `crr_company` varchar(255) NOT NULL DEFAULT '',
  `crr_start_date` date DEFAULT '0000-00-00' COMMENT '근무시작',
  `crr_end_date` date DEFAULT '0000-00-00' COMMENT '근무종료',
  `crr_pay` int(11) NOT NULL COMMENT '월급여',
  `trm_idx_category` bigint(20) NOT NULL DEFAULT '0' COMMENT '업직종idx',
  `crr_job` varchar(250) NOT NULL DEFAULT '' COMMENT '담당업무',
  `crr_quit_why` varchar(250) NOT NULL DEFAULT '' COMMENT '퇴사사유',
  `crr_reg_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시',
  `crr_update_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '수정일시',
  PRIMARY KEY (`crr_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_school` (
  `shl_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `apc_idx` bigint(20) NOT NULL DEFAULT '0' COMMENT '지원자idx',
  `shl_type1` varchar(50) NOT NULL DEFAULT '',
  `shl_type2` varchar(50) NOT NULL DEFAULT '',
  `shl_yeramonth` varchar(7) NOT NULL DEFAULT '',
  `shl_graduate_type` varchar(7) NOT NULL DEFAULT '' COMMENT '졸업타입',
  `shl_title` varchar(250) NOT NULL DEFAULT '' COMMENT '제목',
  `shl_pay` int(11) NOT NULL COMMENT '점수',
  `shl_reg_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시',
  `shl_update_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '수정일시',
  PRIMARY KEY (`shl_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_additional` (
  `add_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `apc_idx` bigint(20) NOT NULL DEFAULT '0' COMMENT '지원자idx',
  `add_start_ym` varchar(7) DEFAULT '' COMMENT '시작',
  `add_end_ym` varchar(7) DEFAULT '' COMMENT '종료',
  `add_title` varchar(250) NOT NULL DEFAULT '' COMMENT '제목',
  `add_content` varchar(250) NOT NULL DEFAULT '' COMMENT '내용',
  `add_reg_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시',
  `add_update_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '수정일시',
  PRIMARY KEY (`add_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_message` (
  `msg_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `com_idx` bigint(20) NOT NULL DEFAULT 0 COMMENT '업체번호',
  `mb_id` varchar(30) DEFAULT '',
  `msg_db_table` varchar(30) DEFAULT '',
  `msg_db_id` varchar(30) DEFAULT '',
  `msg_type` varchar(20) DEFAULT '' COMMENT '발송타입',
  `msg_hp` varchar(20) DEFAULT '' COMMENT '휴대폰',
  `msg_email` varchar(100) DEFAULT '' COMMENT '이메일',
  `msg_push` varchar(100) DEFAULT '' COMMENT '푸시코드',
  `msg_subject` varchar(255) DEFAULT '' COMMENT '제목',
  `msg_content` text NOT NULL COMMENT '내용',
  `msg_file1` varchar(255) NOT NULL COMMENT '첨부파일1',
  `msg_file2` varchar(255) NOT NULL COMMENT '첨부파일2',
  `msg_status` varchar(20) DEFAULT '' COMMENT '상태',
  `msg_reg_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '발송일시',
  `msg_update_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '수정일시',
  PRIMARY KEY (`msg_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



경영,사무
인사.총무
경리,회계,세무
비서
리셉션,인포메이션
사무보조,자료입력
마케팅,광고
기획,전략,홍보,광고
무역사무

영업, 고객상담
일반영업
판매,서비스
TM,아웃바운드
고객상담, 인바운드
일반CS

디자인
설계,CAD
일러스트,포토샵
웹디자인

전문,특수직
외국어,통역,번역
헤드헌터,잡매니저
상품기획, MD

서비스
제조(생산)
미화
경비
시설관리
물류센터
지게차 운전
운전
수행기사
판촉, 행사요원
매장판매, 매장관리
조리, 홀서빙

IT,인터넷
웹기획, 웹마스터
운영 프로그래머
서비스관리/네트워크 관리
컴퓨터/AS

건설,설계
토목설계
건축설계
부동산개발
입찰/PQ
건설사업관리
시공,공무,현장감독


toeic=TOEIC, toefl=TOEFL, teps=TEPS, ielts=IELTS, g-telp=G-TELP, slep=SLEp, gre=GRE, gmat=GMAT, direct=직접입력
jpt=JPT, jlpt=JLPT, jtra=JTRA, direct=직접입력
hsk=HSK, direct=직접입력


CREATE TABLE `g5_1_message` (
  `msg_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `msg_type` varchar(20) NOT NULL DEFAULT '',
  `msg_subject` varchar(255) NOT NULL DEFAULT '',
  `msg_content` mediumtext NOT NULL,
  `msg_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `msg_ip` varchar(255) NOT NULL DEFAULT '',
  `msg_last_option` text NOT NULL,
  PRIMARY KEY (`msg_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


SELECT trm_idx term_idx , GROUP_CONCAT(name) term_name , trm_name2 trm_name2 , trm_content trm_content , trm_more trm_more , trm_status trm_status , GROUP_CONCAT(cast(depth as char)) depth , GROUP_CONCAT(up_idxs) up_idxs , SUBSTRING_INDEX(SUBSTRING_INDEX(up_idxs, ',', GROUP_CONCAT(cast(depth as char))),',',-1) up1st_idx , SUBSTRING_INDEX(up_idxs, ',', 1) uptop_idx , GROUP_CONCAT(up_names) up_names , GROUP_CONCAT(down_idxs) down_idxs , GROUP_CONCAT(down_names) down_names , REPLACE(GROUP_CONCAT(down_idxs), CONCAT(SUBSTRING_INDEX(GROUP_CONCAT(down_idxs), ',', 1),','), '') down_idxs2 , REPLACE(GROUP_CONCAT(down_names), CONCAT(SUBSTRING_INDEX(GROUP_CONCAT(down_names), '|', 1),','), '') down_names2 , leaf_node_yn leaf_node_yn , SUM(table_row_count) table_row_count FROM ( ( SELECT term.trm_idx , CONCAT( REPEAT(' ', COUNT(parent.trm_idx) - 1), term.trm_name) AS name , term.trm_name2 , term.trm_content , term.trm_more , term.trm_status , (COUNT(parent.trm_idx) - 1) AS depth , GROUP_CONCAT(cast(parent.trm_idx as char) ORDER BY parent.trm_left) up_idxs , GROUP_CONCAT(parent.trm_name ORDER BY parent.trm_left SEPARATOR ' > ') up_names , NULL down_idxs , NULL down_names , (CASE WHEN term.trm_right - term.trm_left = 1 THEN 1 ELSE 0 END ) leaf_node_yn , 0 table_row_count , term.trm_left , 1 sw FROM g5_5_term AS term, g5_5_term AS parent WHERE term.trm_left BETWEEN parent.trm_left AND parent.trm_right AND term.trm_taxonomy = 'category' AND parent.trm_taxonomy = 'category' AND term.trm_status in ('ok','hide') AND parent.trm_status in ('ok','hide') GROUP BY term.trm_idx ORDER BY term.trm_left ) UNION ALL ( SELECT parent.trm_idx , NULL name , term.trm_name2 , term.trm_content , term.trm_more , term.trm_status , NULL depth , NULL up_idxs , NULL up_names , GROUP_CONCAT(cast(term.trm_idx as char) ORDER BY term.trm_left) AS down_idxs , GROUP_CONCAT(term.trm_name ORDER BY term.trm_left SEPARATOR '|') AS down_names , (CASE WHEN parent.trm_right - parent.trm_left = 1 THEN 1 ELSE 0 END ) leaf_node_yn , SUM(term.trm_count) table_row_count , parent.trm_left , 2 sw FROM g5_5_term AS term , g5_5_term AS parent WHERE term.trm_left BETWEEN parent.trm_left AND parent.trm_right AND term.trm_taxonomy = 'category' AND parent.trm_taxonomy = 'category' AND term.trm_status in ('ok','hide') AND parent.trm_status in ('ok','hide') GROUP BY parent.trm_idx ORDER BY parent.trm_left ) ) db_table
GROUP BY trm_idx ORDER BY trm_left


SELECT
    trm_idx term_idx
    , GROUP_CONCAT(name) term_name
    , trm_name2 trm_name2
    , trm_content trm_content
    , trm_more trm_more
    , trm_status trm_status
    , GROUP_CONCAT(cast(depth as char)) depth
    , GROUP_CONCAT(up_idxs) up_idxs
    , SUBSTRING_INDEX(SUBSTRING_INDEX(up_idxs, ',', GROUP_CONCAT(cast(depth as char))),',',-1) up1st_idx
    , SUBSTRING_INDEX(up_idxs, ',', 1) uptop_idx
    , GROUP_CONCAT(up_names) up_names
    , GROUP_CONCAT(down_idxs) down_idxs
    , GROUP_CONCAT(down_names) down_names
    , REPLACE(GROUP_CONCAT(down_idxs), CONCAT(SUBSTRING_INDEX(GROUP_CONCAT(down_idxs), ',', 1),','), '') down_idxs2
    , REPLACE(GROUP_CONCAT(down_names), CONCAT(SUBSTRING_INDEX(GROUP_CONCAT(down_names), '|', 1),','), '') down_names2
    , leaf_node_yn leaf_node_yn
    , SUM(table_row_count) table_row_count
FROM (	(
        SELECT term.trm_idx
            , CONCAT( REPEAT('   ', COUNT(parent.trm_idx) - 1), term.trm_name) AS name
            , term.trm_name2
            , term.trm_content
            , term.trm_more
            , term.trm_status
            , (COUNT(parent.trm_idx) - 1) AS depth
            , GROUP_CONCAT(cast(parent.trm_idx as char) ORDER BY parent.trm_left) up_idxs
            , GROUP_CONCAT(parent.trm_name ORDER BY parent.trm_left SEPARATOR ' > ') up_names
            , NULL down_idxs
            , NULL down_names
            , (CASE WHEN term.trm_right - term.trm_left = 1 THEN 1 ELSE 0 END ) leaf_node_yn
            , 0 table_row_count
            , term.trm_left
            , 1 sw
        FROM g5_5_term AS term,
                g5_5_term AS parent
        WHERE term.trm_left BETWEEN parent.trm_left AND parent.trm_right
            AND term.trm_taxonomy = 'category'
            AND parent.trm_taxonomy = 'category'
            AND term.trm_status in ('ok','hide') AND parent.trm_status in ('ok','hide')

            GROUP BY term.trm_idx
        ORDER BY term.trm_left
        )
    UNION ALL
        (
        SELECT parent.trm_idx
            , NULL name
            , term.trm_name2
            , term.trm_content
            , term.trm_more
            , term.trm_status
            , NULL depth
            , NULL up_idxs
            , NULL up_names
            , GROUP_CONCAT(cast(term.trm_idx as char) ORDER BY term.trm_left) AS down_idxs
            , GROUP_CONCAT(term.trm_name ORDER BY term.trm_left SEPARATOR '^') AS down_names
            , (CASE WHEN parent.trm_right - parent.trm_left = 1 THEN 1 ELSE 0 END ) leaf_node_yn
            , SUM(term.trm_count) table_row_count
            , parent.trm_left
            , 2 sw
        FROM g5_5_term AS term
                , g5_5_term AS parent
        WHERE term.trm_left BETWEEN parent.trm_left AND parent.trm_right
            AND term.trm_taxonomy = 'category'
            AND parent.trm_taxonomy = 'category'
            AND term.trm_status in ('ok','hide') AND parent.trm_status in ('ok','hide')

        GROUP BY parent.trm_idx
        ORDER BY parent.trm_left
        )
    ) db_table
GROUP BY trm_idx
ORDER BY trm_left

<div id="con_ttl">인사말</div>
<div id="con_en_ttl">Greeting</div>
<div style="margin-left: 20px;"><img alt="" height="200" src="http://dreamm0702.cafe24.com/data/editor/1401/3552651474_1389953654.9871.jpg" width="600" />
<div id="con_space">&nbsp;</div>
<div id="con_text"><strong><span style="color: rgb(95, 170, 41);">드림피플파트너스 홈페이지</span>를 방문해 주셔서 감사드립니다.</strong></div>
<div id="con_space">&nbsp;</div>
<div id="con_text">오늘날 급변하는 경영환경 속에서 기업은 지속적인 성장과 경쟁력 확보를 위해 선택과 집중, 핵심역량 강화, 고객감동, 스마트 경영 등을 앞다퉈 적용하고 있으며 특히, 경영 효율화 및 비용절감을 위해 상시적인 구조조정 체계를 유지하고 있습니다. 이중 기업의 효율적인 유지 및 경쟁력 강화를 위해 인적 관리의 중요성은 아무리 강조해도 지나침이 없으며, 이는 기업 성장 전략의 선택이 아닌 필수 조건으로 자리매김 하고 있습니다.</div>
<div id="con_space">&nbsp;</div>
<div id="con_text"><strong>&quot;회사별 특성에 맞는 효율적 인적자원 관리를 위한 전문적인 서비스 제공&quot;</strong></div>
<div id="con_text">저희 드림피플파트너스는 효율적 인적자원 관리를 위한 전문적인 서비스를 제공하고자 설립되었습니다. 원칙을 존중하고 기본에 충실한 자세로 초심을 잃지 않고 항상 변화 발전하는 모습을 통해 고객사에는 신속&middot;정확한 업무처리로 경쟁력 강화를 위한 효율적인 인적자원의 관리 기회를, 구직자에게는 개인의 잠재력을 개발하여 다양한 근로 및 경력 기회를 제공하는 고객감동 기업, 신뢰받는 기업이 될 수 있도록 최선을 다하겠습니다.</div>
<div id="con_space">&nbsp;</div>
<div id="con_text">감사합니다.</div>
<div id="con_space2">&nbsp;</div>
</div>



SELECT TIMESTAMPDIFF(MONTH, '2019-01-01', '2019-03-01');
SELECT TIMESTAMPDIFF(MONTH, '2019-01-01', '2019-04-01');
SELECT TIMESTAMPDIFF(YEAR, '2019-01-01', '2019-04-01') AS y, TIMESTAMPDIFF(MONTH, '2019-01-01', '2019-04-01') AS m;






메시지 발송 기획
1. 선택회원한테만 발송
2. 상단에 담기 버튼
  - 회원담기, 들어가면 [초기화]버튼도 있어야 할 듯
3. 상단에 [그룹메시지] 버튼
  - 어떤 메시지를 발송, 선택하기가 있어야 할 듯!
4. 버튼 모양이 이렇게 되어야 할 듯 하다.
  - [그룹메시지|전체(23,000)|선택(23)]
  - 검색결과 전체 보내기는 그럼 어떻게?

입력일 때(등록)
http://people0702.cafe24.com/recruit/?33

수정일 때
http://people0702.cafe24.com/recruit/?w=c&apc_idx=36621


5년이 지난 데이터
DELETE FROM g5_1_applicant
WHERE apc_reg_dt < DATE_ADD(now() , INTERVAL -5 YEAR)
.
SELECT DATE_ADD(now() , INTERVAL -5 YEAR)
.


// table 이전
DELETE FROM `g5_board_file` WHERE bo_table LIKE 'b0%'

김화식: kwsihimak@hanmail.net


CREATE TABLE `g5_1_body_record` (
  `bdr_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(50) NOT NULL DEFAULT '' COMMENT '회원id',
  `bdr_date` date DEFAULT '0000-00-00' COMMENT '촬영일',
  `bdr_memo` text NOT NULL,
  `bdr_status` varchar(20) DEFAULT 'pending' COMMENT '상태',
  `bdr_reg_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시',
  `bdr_update_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '수정일시',
  PRIMARY KEY (`bdr_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `g5_1_member_file` (
  `mbf_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(50) NOT NULL DEFAULT '' COMMENT '회원id',
  `bdr_idx` bigint(20) NOT NULL DEFAULT '0' COMMENT '신체촬영idx',
  `mbf_body_type` varchar(20) DEFAULT 'pending' COMMENT '신체위치구분',
  `mbf_file_type` varchar(20) DEFAULT 'pending' COMMENT '사진영상구분',
  `mbf_location` varchar(20) DEFAULT 'pending' COMMENT '파일위치',
  `mbf_medical_yn` int(11) NOT NULL COMMENT '의료파일여부',
  `mbf_analyze_yn` int(11) NOT NULL COMMENT '의료파일여부',
  `mbf_reg_dt` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시',
  PRIMARY KEY (`mbf_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


2020-11-02 일부터 시작한 것으로 판단됨

SELECT * FROM MES_CAST_SHOT_SUB WHERE EVENT_TIME < '2020-11-02 00:00:00.000' ORDER BY EVENT_TIME LIMIT 1
SELECT * FROM MES_CAST_SHOT_SUB WHERE EVENT_TIME > '2022-04-16 04:25:39.615'


SELECT event_time FROM g5_1_cast_shot_sub ORDER BY event_time LIMIT 1

// 하루 전체 복제
INSERT INTO g5_1_cast_shot_sub(shot_id, event_time, hold_temp, upper_heat,lower_heat,upper_1_temp,upper_2_temp,upper_3_temp,upper_4_temp,upper_5_temp,upper_6_temp,lower_1_temp,lower_2_temp,lower_3_temp)
SELECT shot_id, CONCAT('2020-11-09',' ',SUBSTRING(event_time,12)) AS event_time, hold_temp, upper_heat,lower_heat
    ,upper_1_temp,upper_2_temp,upper_3_temp,upper_4_temp,upper_5_temp,upper_6_temp,lower_1_temp
    ,lower_2_temp,lower_3_temp
FROM g5_1_cast_shot_sub WHERE event_time LIKE '2020-11-02%'

// 삭제 현재 1091027 (~0220-11-07)
DELETE FROM g5_1_cast_shot_sub WHERE event_time LIKE '2020-11-09%'
DELETE FROM g5_1_cast_shot_sub WHERE event_time > '2020-11-09 00:00:00'
DELETE FROM g5_1_cast_shot_sub WHERE event_time >= '2022-04-13 00:00:00'

update `g5_1_cast_shot_sub` set shot_id = mcs_idx

$ influx -import -path=ticker_data.txt -database=market -percision=s




SELECT * FROM g5_1_cast_shot_sub WHERE event_time >= '2020-11-02 00:00:00' AND event_time <= '2020-11-02 23:59:59'

INFLUXDB 성능 개선 작업
https://yenaworldblog.wordpress.com/2017/11/09/influxdb-%EC%84%B1%EB%8A%A5-%EA%B0%9C%EC%84%A0-%EC%9E%91%EC%97%85/
1. CQ 사용
    비싼 쿼리문을 날리는 경우에 (aggregation 같은 경우) 모든 시간에 대해 쿼리 하기에 오래걸림
    미리 쿼리 계산을 해서 별도의 measurement에 데이터를 넣어서 기간 별로 모든 데이터를 계산하지 않고 미리 계산된 데이터만 뽑아오는 방식으로 사용 가능
2. RP 사용
    retention policy 보존정책을 정해서 오래된 데이터들을 삭제함
    데이터 셋이 줄어들기 때문에 (down sampling) 검색해야 하는 속도가 빨라짐
    사용하지 않은 데이터들을 삭제하는 정책으로 influxdb query 속도를 높일 수 있음
    주의!! 중간에 보존 정책을 바꾸면 그동안에 쌓은 데이터가 다 날아갈 위험이 있음
    create/drop 하지말고 alter 로 변경 작업을 해야지 서비스 중인 데이터가 안전!!
    default vs DEFAULT
    default: InfluxDB가 새 데이터베이스를 만들 때 자동으로 생성하는 RP의 이름. 무한한 지속 기간과 복제 계수를 1로 설정함. 처음에는 DEFAULTRP 였지만 변경 될 수 있음
    DEFAULT: 쓰기에서 명시 적 RP를 제공하지 않으면 InfluxDB가 쓰는 RP

InfluxDB 테스트 및 Machbase와의 비교
https://kr.machbase.com/influxdb-%ED%85%8C%EC%8A%A4%ED%8A%B8-%EB%B0%8F-machbase%EC%99%80%EC%9D%98-%EB%B9%84%EA%B5%90/


[공식 문서 정리] InfluxDB와 SQL 데이터베이스의 비교
명령어 정리가 잘 되어 있네.
Flux
InfluxQL


from(bucket: "ing")
  |> range(start: v.timeRangeStart, stop: v.timeRangeStop)
//  |> range(start: 2021-01-01T00:00:00Z, stop: 2021-01-01T12:00:00Z)
  |> filter(fn: (r) => r["_measurement"] == "cast_shot_sub")
  |> aggregateWindow(every: v.windowPeriod, fn: last, createEmpty: false)
  |> yield(name: "last")
....
from(bucket: "ing")
  |> range(start: 2021-01-01T00:00:00Z, stop: 2021-01-01T12:00:00Z)
  // range(start: 1527031800, stop: 1527033600)
  |> filter(fn: (r) => r["_measurement"] == "cast_shot_sub")
  |> aggregateWindow(every: v.windowPeriod, fn: last, createEmpty: false)
  |> yield(name: "last")
....
from(bucket: "ing")
//  |> range(start: v.timeRangeStart, stop: v.timeRangeStop)
  |> range(start: 2020-11-02T08:15:42+09:00, stop: 2020-11-02T10:55:42+09:00)
//   |> range(start: 2020-11-02T08:15:42Z, stop: 2020-11-02T10:55:42Z)
  |> filter(fn: (r) => r["_measurement"] == "cast_shot_sub")
  |> aggregateWindow(every: v.windowPeriod, fn: last, createEmpty: false)
  |> yield(name: "last")
....
from(bucket: "ing")
  |> range(start: 2020-11-02T08:15:42+09:00, stop: 2020-11-02T10:55:42+09:00)
  |> filter(fn: (r) => r._measurement == "cast_shot_sub")
  |> aggregateWindow(every: v.windowPeriod, fn: last, createEmpty: false)
  |> yield(name: "last")
....
from(bucket: "ing")
  |> range(start: v.timeRangeStart, stop: v.timeRangeStop)
  |> filter(fn: (r) => r["_measurement"] == "cast_shot_sub")
  |> aggregateWindow(every: v.windowPeriod, fn: mean, createEmpty: false)
  |> yield(name: "mean")
....
from(bucket: "ing")
  |> range(start: 2020-11-02T08:15:42+09:00, stop: 2020-11-02T10:55:42+09:00)
  |> filter(fn: (r) => r["_measurement"] == "cast_shot_sub")
  |> aggregateWindow(every: v.windowPeriod, fn: last, createEmpty: false)
  |> yield(name: "last")
....
from(bucket: "ing")
  |> range(start: 2020-11-02T08:15:42+09:00, stop: 2020-11-02T10:55:42+09:00)
  |> filter(fn: (r) => r["_measurement"] == "cast_shot_sub" and r["_field"] == "hold_temp")
  |> aggregateWindow(every: v.windowPeriod, fn: last, createEmpty: false)
  |> yield(name: "last")
....
from(bucket: "ing")
|> range(start: v.timeRangeStart)
|> keyValues(keyColumns: ["shot_id"])
|> group()



List fields in a measurement
....
import "influxdata/influxdb/schema"

schema.measurementFieldKeys(
    bucket: "ing",
    measurement: "cast_shot_sub",
)
....
List tag keys in a measurement
Use the schema.measurementTagKeys function to list tag keys in a measurement. This function returns results from the last 30 days.
....
import "influxdata/influxdb/schema"

schema.measurementTagKeys(
    bucket: "ing",
    measurement: "cast_shot_sub",
)


List tag values in a measurement
Use the schema.measurementTagValues function to list tag values for a given tag in a measurement. This function returns results from the last 30 days.
....
import "influxdata/influxdb/schema"

schema.measurementTagValues(
    bucket: "ing",
    tag: "shot_id",
    measurement: "cast_shot_sub",
)
....


from(bucket: "ing")
|> range(start: 2020-11-02T08:15:42+09:00, stop: 2020-11-02T10:55:42+09:00)
|> filter(fn: (r) => r["_measurement"] == "cast_shot_sub")
|> count()
....
from(bucket: "mes")
|> range(start: 2020-11-02T08:15:42+09:00, stop: 2020-11-02T10:55:42+09:00)
|> filter(fn: (r) => r["_measurement"] == "cast_shot_sub")
|> count()

influxDB vs TimescaleDB
https://tzara.tistory.com/117


psql "postgres://tsdbadmin@vbjysvzz2g.hp6tz73i1r.tsdb.cloud.timescale.com:32530/tsdb?sslmode=require"
^^tiA**e@@칠.....

SELECT ROUND(AVG(fill_level), 2) AS avg_fill_level
    , time_bucket('10m',time) AS bucket
    , sensors.country_code, sensors.machine_id
FROM fill_measurements, sensors
WHERE sensor_id = sensors.id
    AND time >= '2021-04-05 02:00' AND time >= '2021-04-05 3:00'
GROUP BY bucket, sensors.country_code, sensors.machine_id
HAVING ROUND(AVG(fill_level),2) >= 251;


CREATE TABLE test1 (
    time        TIMESTAMPTZ         NOT NULL,
    location    text                NOT NULL,
    temperature DOUBLE PRECISION    NULL
);

CREATE TABLE test1 (
  mcs_idx SERIAL,
  shot_id integer NOT NULL,
  event_time TIMESTAMPTZ    NOT NULL,
  hold_temp DOUBLE PRECISION    NULL,
  upper_heat DOUBLE PRECISION    NULL,
  lower_heat DOUBLE PRECISION    NULL,
  upper_1_temp DOUBLE PRECISION    NULL,
  upper_2_temp DOUBLE PRECISION    NULL,
  upper_3_temp DOUBLE PRECISION    NULL,
  upper_4_temp DOUBLE PRECISION    NULL,
  upper_5_temp DOUBLE PRECISION    NULL,
  upper_6_temp DOUBLE PRECISION    NULL,
  lower_1_temp DOUBLE PRECISION    NULL,
  lower_2_temp DOUBLE PRECISION    NULL,
  lower_3_temp DOUBLE PRECISION    NULL
);

SELECT create_hypertable('test1', 'event_time');

timescaledb-parallel-copy --db-name new_db --table conditions --file old_db.csv --workers 4 --copy-options "CSV"
timescaledb-parallel-copy --db-name test_db --table test1 --file /var/www/kr.websiteman.py/php/timescale/test1.csv --workers 4 --copy-options "CSV"
timescaledb-parallel-copy user=postgres password=db@ypage2018 --db-name test_db --table test1 --file /var/www/kr.websiteman.py/php/timescale/test1.csv --workers 4 --copy-options "CSV"
timescaledb-parallel-copy -connection "host=localhost user=postgres password=db@ypage2018 sslmode=disable" --db-name test_db --table test1 --file /var/www/kr.websiteman.py/php/timescale/test1.csv --workers 4 --copy-options "CSV"

timescaledb-parallel-copy \
--connection host=localhost user=postgres password=db@ypage2018 sslmode=disable \
--db-name test_db --schema web --table test1 \
--file /var/www/kr.websiteman.py/php/timescale/test1.csv --workers 4 --reporting-period 30s --copy-options "CSV"

timescaledb-parallel-copy \
--connection host=localhost user=postgres password=db@ypage2018 sslmode=disable \
--db-name test_db --schema web --table test1 \
--file /var/www/kr.websiteman.py/php/timescale/test1.csv --workers 4 --reporting-period 30s --copy-options "CSV"


psql -d test_db -c "\COPY test1 FROM /var/www/kr.websiteman.py/php/timescale/test1.csv CSV"
psql -U postgres -d test_db -c "\COPY test1 FROM /var/www/kr.websiteman.py/php/timescale/test1.csv WITH (FORMAT CSV, HEADER)"
psql -U postgres -d test_db -c "\COPY test1 FROM /var/www/kr.websiteman.py/php/timescale/test2.csv WITH (FORMAT CSV, HEADER)"
psql -U postgres -d test_db -c "\COPY test1 FROM /var/www/kr.websiteman.py/php/timescale/g5_1_cast_shot_sub.csv WITH (FORMAT CSV, HEADER)"

INSERT INTO "test1" ("mcs_idx", "shot_id", "event_time", "hold_temp", "upper_heat", "lower_heat", "upper_1_temp", "upper_2_temp", "upper_3_temp", "upper_4_temp", "upper_5_temp", "upper_6_temp", "lower_1_temp", "lower_2_temp", "lower_3_temp")
VALUES (NULL, '2324', '2020-11-02 08:16:43', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2');


// install TimescaleDB
https://computingforgeeks.com/how-to-install-timescaledb-on-ubuntu/

Step 1: Update your system
sudo apt update
sudo apt upgrade


Step 2: Install PostgreSQL

Import  the repository signing key:
# sudo wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -

Add PostgreSQL apt repository:
# sudo sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list'

Update the package lists and install postgresql package:
# sudo apt update
# sudo apt install postgresql-12

The configuration file for PostgreSQL 10 is /etc/postgresql/12/main/postgresql.conf

Set PostgreSQL admin user’s password
# sudo su - postgres
# psql -c "alter user postgres with password 'db@ypage2018'"

if error occurs..
postgres@ypagepy:~$ psql -c "alter user postgres with password 'db@ypage2018'"
-su: /usr/bin/psql: /usr/bin/perl: bad interpreter: Permission denied
$ exit (back to root account)
$ sudo chmod a+x /usr/bin/perl

and do it again.

Step 3: Install TimescaleDB on Ubuntu 20.04|18.04
The last step is the installation of TimescaleDB on server


Add PPA:
$ exit (back to root)
$ sudo add-apt-repository ppa:timescale/timescaledb-ppa

Update APT package index to confirm if the repository was indeed added:
$ sudo apt-get update

Then install TimescaleDB for PostgreSQL 12, if you have PG 11, replace accordingly:
$ sudo apt install timescaledb-postgresql-12

Now update your PostgreSQL configuration settings for TimescaleDB:
$ sudo timescaledb-tune --quiet --yes

Saving changes to: /etc/postgresql/12/main/postgresql.conf


sudo systemctl restart postgresql
sudo systemctl status postgresql


Step 4: Test TimescaleDB installation on Ubuntu 20.04|18.04

Connect to PostgreSQL, using a superuser named postgres
$ sudo su - postgres
$ psql

postgres=# CREATE database test_db;

Connect to the database
postgres=# \c test_db

Extend the database with TimescaleDB
test_db=# CREATE EXTENSION IF NOT EXISTS timescaledb CASCADE;

Connect to your newly created database:
$ psql -U postgres -h localhost -d test_db


SELECT time_bucket('5 minutes', event_time) AS five_min, avg(lower_heat)
FROM test1
GROUP BY five_min
ORDER BY five_min DESC LIMIT 10;


SELECT table_size, index_size, toast_size, total_size FROM hypertable_relation_size_pretty('test1');

select pg_size_pretty(pg_database_size('test_db'));

SELECT show_chunks('test1', older_than => interval '20 months');





===========================================================

Migrate your TimescaleDB database to Timescale Cloud
Migrating the entire database at once
https://docs.timescale.com/cloud/latest/migrate-to-cloud/entire-database/#prerequisites


pg_dump -U postgres -W \
-h localhost -p 5432 -Fc -v \
-f dump.bak test_db


$ sudo su - postgres

psql “postgres://tsdbadmin:<CLOUD_PASSWORD>@<CLOUD_HOST>:<CLOUD_PORT>/tsdb?sslmode=require”
$ psql "postgres://tsdbadmin:^^tiAnne@@740620@vbjysvzz2g.hp6tz73i1r.tsdb.cloud.timescale.com:32530/tsdb?sslmode=require"
???
psql: error: connection to server on socket "@740620@vbjysvzz2g.hp6tz73i1r.tsdb.cloud.timescale.com/.s.PGSQL.32530" failed: Connection refused
due to the password with @ uh.....
try again without password.
$ psql "postgres://tsdbadmin@vbjysvzz2g.hp6tz73i1r.tsdb.cloud.timescale.com:32530/tsdb?sslmode=require"

Prepare your Timescale Cloud database for data restoration
by using timescaledb_pre_restore to stop background workers:
$ SELECT timescaledb_pre_restore();

pg_restore -U tsdbadmin -W \
-h <CLOUD_HOST> -p <CLOUD_PORT> --no-owner \
-Fc -v -d tsdb dump.bak
....
pg_restore -U tsdbadmin -W -h vbjysvzz2g.hp6tz73i1r.tsdb.cloud.timescale.com -p 32530 --no-owner -Fc -v -d tsdb dump.bak;
pg_restore --clean -U tsdbadmin -W -h vbjysvzz2g.hp6tz73i1r.tsdb.cloud.timescale.com -p 32530 --no-owner -Fc -v -d tsdb dump.bak;


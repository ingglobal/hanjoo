This is james work memo.

CREATE TABLE `g5_1_data_measure_58` (
  `dta_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `dta_type` tinyint(4) NOT NULL COMMENT '전류,전압등',
  `dta_no` int(11) NOT NULL DEFAULT '0' COMMENT '측정번호',
  `dta_value` double DEFAULT '0' COMMENT '데이터값',
  `dta_datetime` int(11) DEFAULT NULL COMMENT '일시 timestamp',
  `dta_dt` int(11) DEFAULT NULL COMMENT '일시 datetime',
  PRIMARY KEY (`dta_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `g5_1_cast_shot_sub` (
  `css_idx` bigint(20) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`css_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_cast_shot` (
  `csh_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) NOT NULL COMMENT '샷ID',
  `work_date` date DEFAULT CURRENT_TIMESTAMP COMMENT '작업일',
  `work_shift` int(11) NOT NULL COMMENT '주(1)/야(2)',
  `start_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '시작시각',
  `end_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '종료시각',
  `elapsed_time` int(11) NOT NULL COMMENT '경과시간',
  `machine_id` double NOT NULL COMMENT '설비ID',
  `machine_no` double NOT NULL COMMENT '설비번호',
  `item_no` double noT NULL COMMENT '금형번호',
  `item_name` double NOT NULL COMMENT '제품명',
  `mold_no` double noT NULL COMMENT '금형번호',
  `shot_no` int(11) nOT NULL COMMENT '샷번호',
  `pv_cycletime` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'PV사이클타임',
  `machine_cycletime` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '설비사이클타임',
  `product_cycletime` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '제품사이클타임',
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
  PRIMARY KEY (`csh_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_xray_inspection` (
  `xry_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_date` date DEFAULT CURRENT_TIMESTAMP COMMENT '작업일',
  `work_shift` int(11) NOT NULL COMMENT '주(1)/야(2)',
  `start_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '시작시각',
  `end_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '종료시각',
  `qrcode` int(11) NOT NULL COMMENT 'QRCode',
  `production_ID` int(11) NOT NULL COMMENT '생산품ID',
  `machine_id` double NOT NULL COMMENT '설비ID',
  `machine_no` double NOT NULL COMMENT '설비번호',
  `position_1` double NOT NULL COMMENT '위치1',
  `position_2` double NOT NULL COMMENT '위치2',
  `position_3` double NOT NULL COMMENT '위치3',
  `position_4` double NOT NULL COMMENT '위치4',
  `position_5` double NOT NULL COMMENT '위치5',
  `position_6` double NOT NULL COMMENT '위치6',
  `position_7` double NOT NULL COMMENT '위치7',
  `position_8` double NOT NULL COMMENT '위치8',
  `position_9` double NOT NULL COMMENT '위치9',
  `position_10` double NOT NULL COMMENT '위치10',
  `position_11` double NOT NULL COMMENT '위치11',
  `position_12` double NOT NULL COMMENT '위치12',
  `position_13` double NOT NULL COMMENT '위치13',
  `position_14` double NOT NULL COMMENT '위치14',
  `position_15` double NOT NULL COMMENT '위치15',
  `position_16` double NOT NULL COMMENT '위치16',
  `position_17` double NOT NULL COMMENT '위치17',
  `position_18` double NOT NULL COMMENT '위치18',
  PRIMARY KEY (`xry_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_charge_in` (
  `chi_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_date` date DEFAULT CURRENT_TIMESTAMP COMMENT '작업일',
  `work_shift` int(11) DEFAULT 0 NOT NULL COMMENT '주(1)/야(2)',
  `event_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '발생시각',
  `weight_total` double NOT NULL COMMENT '총장입량',
  `weight_ingot` double NOT NULL COMMENT '인고트 장입량',
  `weight_scrap` double NOT NULL COMMENT '스크랩 장입량',
  PRIMARY KEY (`chi_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_charge_out` (
  `cho_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_date` date DEFAULT CURRENT_TIMESTAMP COMMENT '작업일',
  `work_shift` int(11) NOT NULL COMMENT '주(1)/야(2)',
  `event_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '발생시각',
  `weight_out` int(11) DEFAULT 0 NOT NULL COMMENT '출탕량',
  `temp_out` int(11) DEFAULT 0 NOT NULL COMMENT '출탕온도',
  `temp_gbf` int(11) DEFAULT 0 NOT NULL COMMENT 'GBF 후 온도',
  `machine_1_id` int(11) DEFAULT 0 NOT NULL COMMENT '배탕주조기 1 ID',
  `machine_1_no` varchar(20) DEFAULT '' NOT NULL COMMENT '배탕주조기 1 번호',
  `machine_2_id` int(11) DEFAULT 0 NOT NULL COMMENT '배탕주조기 2 ID',
  `machine_2_no` varchar(20) DEFAULT '' NOT NULL COMMENT '배탕주조기 2 번호',
  `machine_3_id` int(11) DEFAULT 0 NOT NULL COMMENT '배탕주조기 3 ID',
  `machine_3_no` varchar(20) DEFAULT '' NOT NULL COMMENT '배탕주조기 3 번호',
  PRIMARY KEY (`cho_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_melting_temp` (
  `mlt_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_date` date DEFAULT CURRENT_TIMESTAMP COMMENT '작업일',
  `work_shift` int(11) NOT NULL COMMENT '주(1)/야(2)',
  `event_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '발생시각',
  `temp_avg` int(11) DEFAULT 0 NOT NULL COMMENT '평균온도',
  `temp_min` int(11) DEFAULT 0 NOT NULL COMMENT '최소온도',
  `temp_max` int(11) DEFAULT 0 NOT NULL COMMENT '최대온도',
  `alarm_min` int(11) DEFAULT 0 NOT NULL COMMENT '최소알람기준',
  `alarm_max` varchar(20) DEFAULT '' NOT NULL COMMENT '최대알람기준',
  PRIMARY KEY (`mlt_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_cast_shot_pressure` (
  `csr_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) NOT NULL COMMENT '샷ID',
  `event_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '발생시각',
  `detect_pressure` int(11) DEFAULT 0 NOT NULL COMMENT '검출',
  `target_pressure` int(11) DEFAULT 0 NOT NULL COMMENT '목표',
  `control_pressure` int(11) DEFAULT 0 NOT NULL COMMENT '조작',
  `deviation_pressure` int(11) DEFAULT 0 NOT NULL COMMENT '편차',
  PRIMARY KEY (`csr_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_engrave_qrcode` (
  `eqr_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_date` date DEFAULT CURRENT_TIMESTAMP COMMENT '작업일',
  `work_shift` int(11) NOT NULL COMMENT '주(1)/야(2)',
  `event_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '각인시각',
  `qrcode` varchar(30) DEFAULT '' NOT NULL COMMENT 'qrcode',
  `production_id` int(11) DEFAULT 0 NOT NULL COMMENT '생산품ID',
  PRIMARY KEY (`eqr_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `g5_1_factory_temphum` (
  `fct_idx` bigint(20) NOT NULL AUTO_INCREMENT,
  `work_date` date DEFAULT '0000-00-00' COMMENT '작업일',
  `work_shift` int(11) DEFAULT 0 NOT NULL COMMENT '주(1)/야(2)',
  `event_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '발생시각',
  `temp_avg` double NOT NULL COMMENT '평균온도',
  `temp_max` double NOT NULL COMMENT '온도최대',
  `temp_min` double NOT NULL COMMENT '온도최소',
  `hum_avg` double NOT NULL COMMENT '습도평균',
  `hum_max` double NOT NULL COMMENT '습도최대',
  `hum_min` double NOT NULL COMMENT '습도최소',
  PRIMARY KEY (`fct_idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




2020-11-02 일부터 시작한 것으로 판단됨

SELECT * FROM MES_CAST_SHOT_SUB WHERE EVENT_TIME < '2020-11-02 00:00:00.000' ORDER BY EVENT_TIME LIMIT 1
SELECT * FROM MES_CAST_SHOT_SUB WHERE EVENT_TIME > '2022-04-16 04:25:39.615'


SELECT event_time FROM g5_1_cast_shot_sub ORDER BY event_time LIMIT 1

// 온도 정보 하루 전체 복제
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


// 압력 정보 하루 전체 복제
INSERT INTO g5_1_cast_shot_pressure(shot_id, event_time, detect_pressure, target_pressure,control_pressure,deviation_pressure)
SELECT shot_id, CONCAT('2020-11-04',' ',SUBSTRING(event_time,12)) AS event_time, detect_pressure, target_pressure,control_pressure,deviation_pressure
FROM g5_1_cast_shot_pressure WHERE event_time LIKE '2020-11-02%'
....
INSERT INTO g5_1_cast_shot_pressure(shot_id, event_time, detect_pressure, target_pressure,control_pressure,deviation_pressure)
SELECT shot_id, CONCAT('2020-11-05',' ',SUBSTRING(event_time,12)) AS event_time, detect_pressure, target_pressure,control_pressure,deviation_pressure
FROM g5_1_cast_shot_pressure WHERE event_time LIKE '2020-11-03%'
....
INSERT INTO g5_1_cast_shot_pressure(shot_id, event_time, detect_pressure, target_pressure,control_pressure,deviation_pressure)
SELECT shot_id, CONCAT('2020-11-06',' ',SUBSTRING(event_time,12)) AS event_time, detect_pressure, target_pressure,control_pressure,deviation_pressure
FROM g5_1_cast_shot_pressure WHERE event_time LIKE '2020-11-04%'
....


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

CREATE TABLE test4 (
  mcs_idx SERIAL PRIMARY KEY,
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
SELECT create_hypertable('test2', 'event_time');
SELECT create_hypertable('test4', 'event_time');

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



// index가 없으니까.. 엄청 오래 걸리는구나!!
SELECT mlt_idx FROM g5_1_melting_temp WHERE work_date = '2022-03-10' AND work_shift = '2' AND event_time = '2022-03-10 22:27:00'

SELECT mlt_idx FROM g5_1_melting_temp WHERE work_date = '2022-03-10' AND work_shift = '2' AND event_time = '2022-03-10 23:42:00'

// The last inserted data.
SELECT * FROM `g5_1_cast_shot_pressure` WHERE event_time LIKE '2022-05-02%' ORDER BY event_time DESC LIMIT 1
132478245
DELETE FROM `g5_1_cast_shot_pressure` WHERE csp_idx > 132478245
DELETE FROM `g5_1_cast_shot_pressure` WHERE event_time > '2022-05-03 11:47:11'


SELECT * FROM `g5_1_cast_shot_sub` WHERE event_time LIKE '2022-05-02%' ORDER BY event_time DESC LIMIT 1
93709810
DELETE FROM `g5_1_cast_shot_sub` WHERE csp_idx > 93709810
DELETE FROM `g5_1_cast_shot_sub` WHERE event_time > '2022-05-03 12:00:00'

// query speed is too slow.
explain
SELECT csp_idx FROM g5_1_cast_shot_pressure WHERE shot_id = '408746' AND event_time = '2022-05-03 13:04:30.155'
SELECT csp_idx FROM g5_1_cast_shot_pressure WHERE shot_id = '408744' AND event_time = '2022-05-03 13:04:30.173'

// set shot_id index
ALTER TABLE `hanjoo_test`.`g5_1_cast_shot_pressure` ADD INDEX `idx_shot_id` (`shot_id`);


explain
SELECT css_idx FROM g5_1_cast_shot_sub WHERE shot_id = '408746' AND event_time = '2022-05-03 13:04:30.155'



SELECT * FROM g5_1_cast_shot_sub
WHERE (1)
  AND event_time >= '2022-05-09 00:00:00' AND event_time <= '2022-05-09 23:59:59'
ORDER BY event_time DESC LIMIT 0, 100

# mdate 컬럼 속성을 변경하지 않아야 함
WHERE mdate >= '2020-11-01'::timestamp AND mdate < '2020-11-06'::timestamp + interval '1 day'

SELECT *
FROM test2
WHERE event_time >= '2021-11-01'::timestamp
AND event_time < '2021-11-06'::timestamp + interval '1 day';

SELECT * FROM test2
WHERE event_time >= '2021-11-01 00:00:00'::timestamp
AND event_time < '2021-11-02 00:00:00'::timestamp
LIMIT 100;

SELECT COUNT(*) FROM test2;

SELECT * FROM test2 ORDER BY event_time LIMIT 100;


SELECT * FROM test2
WHERE 1=1 AND event_time >= '2022-04-12 00:00:00' AND event_time <= '2022-04-12 23:59:59'
ORDER BY event_time DESC LIMIT 100 OFFSET 0;

SELECT * FROM test2
ORDER BY event_time DESC LIMIT 100 OFFSET 0;

ANALYZE test2;
SELECT * FROM approximate_row_count('test2');

ANALYZE conditions;
SELECT * FROM approximate_row_count('conditions');


SELECT relname, n_tup_ins - n_tup_del as rowcount FROM pg_stat_all_tables;
SELECT relname, n_tup_ins - n_tup_del as rowcount FROM pg_stat_all_tables WHERE relname = 'test2';


SELECT 
  nspname AS schemaname,relname,reltuples
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE 
  nspname IN ('test2') AND
  relkind='r' 
ORDER BY reltuples DESC;


SELECT reltuples::bigint
FROM pg_catalog.pg_class
WHERE relname = 'test2';

SELECT reltuples AS estimate FROM pg_class where relname = 'test2';


SELECT c.reltuples::bigint AS estimate
FROM   pg_class c
JOIN   pg_namespace n ON n.oid = c.relnamespace
WHERE  c.relname = 'test2'
AND    n.nspname = 'postgres';
myschema=postgres

SELECT reltuples::bigint AS estimate
FROM   pg_class
WHERE  oid = 'postgres.test2'::regclass;

select nspname, pg_authid.rolname as schemaowner, nspacl
from pg_namespace
join pg_authid on pg_authid.oid = pg_namespace.nspowner;

// this might have some solution.
SELECT *
FROM pg_stat_user_tables 
WHERE relname like 'test%'

INSERT INTO "test2" ("shot_id", "event_time", "hold_temp", "upper_heat", "lower_heat", "upper_1_temp", "upper_2_temp", "upper_3_temp", "upper_4_temp", "upper_5_temp", "upper_6_temp", "lower_1_temp", "lower_2_temp", "lower_3_temp")
VALUES ('2324', '2020-11-02 08:16:43', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2');
INSERT INTO "test4" ("shot_id", "event_time", "hold_temp", "upper_heat", "lower_heat", "upper_1_temp", "upper_2_temp", "upper_3_temp", "upper_4_temp", "upper_5_temp", "upper_6_temp", "lower_1_temp", "lower_2_temp", "lower_3_temp")
VALUES ('2324', '2020-11-02 08:16:43', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2');
INSERT INTO "test4" ("shot_id", "event_time", "hold_temp", "upper_heat", "lower_heat", "upper_1_temp", "upper_2_temp", "upper_3_temp", "upper_4_temp", "upper_5_temp", "upper_6_temp", "lower_1_temp", "lower_2_temp", "lower_3_temp")
VALUES ('2324', '2020-11-02 08:16:43', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2');

// disppered?
UPDATE g5_1_cast_shot_sub SET shot_id = '90454369' , event_time = '2022-04-13 08:54:10' , hold_temp = '692' , upper_heat = '363.35' , lower_heat = '372.3' , upper_1_temp = '0' , upper_2_temp = '0' , upper_3_temp = '0' , upper_4_temp = '0' , upper_5_temp = '435.425' , upper_6_temp = '448.4' , lower_1_temp = '0' , lower_2_temp = '0' , lower_3_temp = '371.275' WHERE css_idx = '90454369'

// primary key is awkard.
ALTER SEQUENCE seq RESTART WITH 1;
UPDATE g5_1_cast_shot_sub SET idcolumn=nextval('seq');

ALTER SEQUENCE seq RESTART;
UPDATE g5_1_cast_shot_sub SET css_idx = DEFAULT;

ALTER SEQUENCE test2_mcs_idx_seq RESTART WITH 1453;
ALTER SEQUENCE test2_mcs_idx_seq RESTART WITH 90454371;


create sequence test_field1_seq;
create table test(field1 int not null default nextval('test_field1_seq'));

create table table3(id serial, firstname varchar(20));
create table table4(id int not null default nextval('table3_id_seq'), firstname varchar(20));

SELECT con.*
FROM pg_catalog.pg_constraint con
    INNER JOIN pg_catalog.pg_class rel
                ON rel.oid = con.conrelid
    INNER JOIN pg_catalog.pg_namespace nsp
                ON nsp.oid = connamespace
WHERE nsp.nspname = 'postgres'
      AND rel.relname = 'g5_1_cast_shot_sub';


SELECT constraint_name FROM information_schema.table_constraints
    WHERE table_name='g5_1_cast_shot_sub' AND constraint_type='UNIQUE';             

SELECT conname, contype
FROM pg_catalog.pg_constraint
JOIN pg_class t ON t.oid = c.conrelid
WHERE t.relname ='g5_1_cast_shot_sub';


SELECT column_name, data_type, character_maximum_length
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'g5_1_cast_shot_sub';

// get the last css_idx from temperature db.
SELECT * FROM g5_1_cast_shot_sub ORDER BY event_time DESC LIMIT 1

// timescale DB IN statement
SELECT * FROM public.g5_1_cast_shot_sub ORDER BY event_time DESC LIMIT 100
....
SELECT * FROM public.g5_1_cast_shot_sub ORDER BY event_time DESC LIMIT 1
....
SELECT * FROM public.g5_1_cast_shot_sub
WHERE shot_id IN (414691,414692,414693,414694,414695,414696,414697)
ORDER BY event_time DESC LIMIT 100
....


SELECT GROUP_CONCAT(shot_id) FROM g5_1_cast_shot 
WHERE start_time > '2022-05-14 22:52:20'
  AND start_time <= '2022-05-14 23:07:20'



UPDATE `g5_1_cast_shot` SET end_time = '' WHERE csh_idx = 237307;
UPDATE `g5_1_cast_shot` SET end_time = NULL WHERE csh_idx = 237307;
UPDATE `g5_1_cast_shot` SET end_time = NULL WHERE end_time = '0000-00-00 00:00:00';

SELECT shot_id FROM g5_1_cast_shot
WHERE start_time >= '2022-06-01 13:33:14'
  AND start_time <= '2022-06-02 14:33:14'
  AND machine_id = 63


SELECT * FROM g5_1_cast_shot_sub
WHERE shot_id IN (
  SELECT shot_id FROM g5_1_cast_shot
  WHERE start_time >= '2022-06-02 13:33:14'
    AND start_time <= '2022-06-02 14:33:14'
    AND machine_id = 63
);
....
SELECT * FROM g5_1_cast_shot_sub
WHERE shot_id > 427436
....

create index idx_shot_id on g5_1_cast_shot_sub (shot_id);

SELECT * FROM g5_1_cast_shot_sub
WHERE shot_id IN (
  SELECT shot_id FROM g5_1_cast_shot
  WHERE start_time >= '2022-05-01 13:33:14'
    AND start_time <= '2022-05-31 14:33:14'
    AND machine_id = 63  
);




// get the last time of shot_sub data.
SELECT * FROM g5_1_cast_shot_sub ORDER BY event_time DESC LIMIT 1;
SELECT * FROM g5_1_cast_shot_sub ORDER BY css_idx DESC LIMIT 1;

// get the last time of shot data.
SELECT * FROM g5_1_cast_shot ORDER BY csh_idx DESC LIMIT 1;

SELECT machine_id FROM g5_1_cast_shot WHERE shot_id = '428514';

UPDATE g5_1_cast_shot_sub AS css SET
  machine_id = (SELECT machine_id FROM g5_1_cast_shot WHERE shot_id = css.shot_id )
WHERE event_time > '2022-06-04 04:51:26'
.....
UPDATE g5_1_cast_shot_sub AS css SET
  machine_id = IFNULL((SELECT machine_id FROM g5_1_cast_shot WHERE shot_id = css.shot_id),0)
WHERE event_time > '2022-05-01 00:00:00'
....
UPDATE g5_1_cast_shot_pressure AS csp SET
  machine_id = IFNULL((SELECT machine_id FROM g5_1_cast_shot WHERE shot_id = csp.shot_id),0)
WHERE event_time > '2022-05-01 00:00:00'
....
UPDATE g5_1_cast_shot_sub AS css SET
  shot_no = IFNULL((SELECT shot_no FROM g5_1_cast_shot WHERE shot_id = css.shot_id),0)
WHERE event_time > '2022-05-01 00:00:00'
....
UPDATE g5_1_cast_shot_pressure AS csp SET
shot_no = IFNULL((SELECT shot_no FROM g5_1_cast_shot WHERE shot_id = csp.shot_id),0)
WHERE event_time > '2022-05-01 00:00:00'
....


SELECT work_date, shot_no FROM g5_1_cast_shot
WHERE work_date = '2022-06-02'
ORDER BY shot_no DESC LIMIT 1


if data exists in the range of specific time.
....
SELECT * FROM g5_1_cast_shot_sub
WHERE event_time >= '2022-06-02 04:51:37' AND event_time <= '2022-06-03 04:51:37'
....
SELECT * FROM g5_1_cast_shot_sub
WHERE event_time >= '2022-06-02 04:51:37' AND event_time <= '2022-06-03 04:51:37'
GROUP BY machine_id
....
SELECT machine_id FROM g5_1_cast_shot_sub
WHERE event_time >= '2022-06-02 04:51:37' AND event_time <= '2022-06-03 04:51:37'
GROUP BY machine_id
....
SELECT machine_id FROM g5_1_cast_shot_sub
WHERE event_time >= '2022-06-02 04:51:37'
GROUP BY machine_id
....
postgress is fast....
........................................
SELECT machine_id, MAX(hold_temp) AS hold_temp_max, MAX(upper_heat) AS upper_heat_max, MAX(lower_heat) AS lower_heat_max
  , MAX(upper_1_temp) AS upper_1_temp_max, MAX(upper_2_temp) AS upper_2_temp_max, MAX(upper_3_temp) AS upper_3_temp_max, MAX(upper_4_temp) AS upper_4_temp_max, MAX(upper_5_temp) AS upper_5_temp_max, MAX(upper_6_temp) AS upper_6_temp_max
  , MAX(lower_1_temp) AS lower_1_temp_max, MAX(lower_2_temp) AS lower_2_temp_max, MAX(lower_3_temp) AS lower_3_temp_max
FROM g5_1_cast_shot_sub
WHERE event_time >= '2022-06-02 04:51:37'
GROUP BY machine_id
....
SELECT machine_id, MAX(hold_temp) AS hold_temp_max, MAX(upper_heat) AS upper_heat_max, MAX(lower_heat) AS lower_heat_max
  , MAX(upper_1_temp) AS upper_1_temp_max, MAX(upper_2_temp) AS upper_2_temp_max, MAX(upper_3_temp) AS upper_3_temp_max, MAX(upper_4_temp) AS upper_4_temp_max, MAX(upper_5_temp) AS upper_5_temp_max, MAX(upper_6_temp) AS upper_6_temp_max
  , MAX(lower_1_temp) AS lower_1_temp_max, MAX(lower_2_temp) AS lower_2_temp_max, MAX(lower_3_temp) AS lower_3_temp_max
FROM g5_1_cast_shot_sub
WHERE event_time >= '2022-06-02 04:51:37' AND machine_id = 45
GROUP BY machine_id
....
SELECT machine_id, MAX(detect_pressure) AS detect_pressure_max, MAX(target_pressure) AS target_pressure_max
  , MAX(control_pressure) AS control_pressure_max
  , MAX(deviation_pressure) AS deviation_pressure_max
FROM g5_1_cast_shot_pressure
WHERE event_time >= '2022-06-02 04:51:37' AND machine_id = 45
GROUP BY machine_id
....


SELECT machine_id, machine_no
FROM g5_1_cast_shot
WHERE start_time >= '2022-01-02 04:51:37'
GROUP BY machine_id, machine_no
....


hold_temp=보온로온도
upper_heat=상형히트
lower_heat=하형히트
upper_1_temp=상금형1
upper_2_temp=상금형2
upper_3_temp=상금형3
upper_4_temp=상금형4
upper_5_temp=상금형5
upper_6_temp=상금형6
lower_1_temp=하금형1
lower_2_temp=하금형2
lower_3_temp=하금형3
detect_pressure=검출압력
target_pressure=목표압력
control_pressure=조작압력
deviation_pressure=편차
temp_avg=평균온도
temp_max=온도최대
temp_min=온도최소
hum_avg=평균습도
hum_max=습도최대
hum_min=습도최소


how to program python.
1. 개발환경 vscode, pycharm?
2. 프로그램 백그라운드 실행? 
  현재 프로그램 실행중이 아닌 듯!!
3. 엣지1에 opcua-client 설치
  - GUI 버전!!
4. 


SELECT * FROM g5_1_cast_shot_sub WHERE shot_id IN ( SELECT shot_id FROM g5_1_cast_shot WHERE start_time >= '2022-06-10 19:46:31' AND start_time <= '2022-06-11 05:46:31' AND machine_id = '45' ) ORDER BY event_time ASC;
SELECT shot_id, start_time FROM g5_1_cast_shot WHERE start_time >= '2022-06-10 19:46:31' AND start_time <= '2022-06-11 05:46:31' AND machine_id = '45'
SELECT shot_id, start_time FROM g5_1_cast_shot WHERE start_time >= '2022-06-10 19:46:31' AND start_time <= '2022-06-11 05:46:31' AND machine_id = '45' ORDER BY start_time


ALTER TABLE g5_1_data_measure_58 ADD INDEX idx_type (dta_type);
ALTER TABLE g5_1_data_measure_58 DROP INDEX idx_type;
ALTER TABLE g5_1_data_measure_58 ADD INDEX idx_type_no (dta_type,dta_no);
ALTER TABLE g5_1_data_measure_58 DROP INDEX idx_type_no;

ALTER TABLE `g5_1_data_measure_59` ADD `dta_1` INT NOT NULL DEFAULT '0' COMMENT '추가정보1' AFTER `dta_value`, ADD `dta_2` INT NOT NULL DEFAULT '0' COMMENT '추가정보2' AFTER `dta_1`;
ALTER TABLE `g5_1_data_measure_60` ADD `dta_1` INT NOT NULL DEFAULT '0' COMMENT '추가정보1' AFTER `dta_value`, ADD `dta_2` INT NOT NULL DEFAULT '0' COMMENT '추가정보2' AFTER `dta_1`;
ALTER TABLE `g5_1_data_measure_61` ADD `dta_1` INT NOT NULL DEFAULT '0' COMMENT '추가정보1' AFTER `dta_value`, ADD `dta_2` INT NOT NULL DEFAULT '0' COMMENT '추가정보2' AFTER `dta_1`;
ALTER TABLE `g5_1_data_measure_62` ADD `dta_1` INT NOT NULL DEFAULT '0' COMMENT '추가정보1' AFTER `dta_value`, ADD `dta_2` INT NOT NULL DEFAULT '0' COMMENT '추가정보2' AFTER `dta_1`;
ALTER TABLE `g5_1_data_measure_63` ADD `dta_1` INT NOT NULL DEFAULT '0' COMMENT '추가정보1' AFTER `dta_value`, ADD `dta_2` INT NOT NULL DEFAULT '0' COMMENT '추가정보2' AFTER `dta_1`;
ALTER TABLE `g5_1_data_measure_64` ADD `dta_1` INT NOT NULL DEFAULT '0' COMMENT '추가정보1' AFTER `dta_value`, ADD `dta_2` INT NOT NULL DEFAULT '0' COMMENT '추가정보2' AFTER `dta_1`;

ALTER TABLE `g5_1_data_measure_58` ADD `dta_3` INT DEFAULT '0' COMMENT '추가정보3' AFTER `dta_2`;
ALTER TABLE `g5_1_data_measure_59` ADD `dta_3` INT DEFAULT '0' COMMENT '추가정보3' AFTER `dta_2`;
ALTER TABLE `g5_1_data_measure_60` ADD `dta_3` INT DEFAULT '0' COMMENT '추가정보3' AFTER `dta_2`;
ALTER TABLE `g5_1_data_measure_61` ADD `dta_3` INT DEFAULT '0' COMMENT '추가정보3' AFTER `dta_2`;
ALTER TABLE `g5_1_data_measure_62` ADD `dta_3` INT DEFAULT '0' COMMENT '추가정보3' AFTER `dta_2`;
ALTER TABLE `g5_1_data_measure_63` ADD `dta_3` INT DEFAULT '0' COMMENT '추가정보3' AFTER `dta_2`;
ALTER TABLE `g5_1_data_measure_64` ADD `dta_3` INT DEFAULT '0' COMMENT '추가정보3' AFTER `dta_2`;

DELETE FROM g5_1_cast_shot_pressure WHERE event_time > '2022-06-20 16:07:54';
DELETE FROM g5_1_cast_shot_sub WHERE event_time > '2022-06-20 16:07:54';

SELECT MIN(shot_id), MAX(shot_id) FROM MES_CAST_SHOT_SUB
WHERE EVENT_TIME >= '2022-06-20 20:08:33'

SELECT machine_id FROM g5_1_cast_shot
WHERE shot_id >= 437005
AND shot_id <= 437719
GROUP BY machine_id


- AAS(자산관리쉘) 도입을 통한 디지털 트윈 모델링
- 시계열 디비(TSDB)를 통한 고속 태그 정보 수집
- SCADA(실시간 설비 정보 표현)
- 현장용 엣지 서버 개발 & 클라우드 확장
- 기업 예산과 유지 관리 능력에 따른 단계별 데이터 저장 및 관리 시스템
- 예측 알고리즘을 탑재하여 분석할 수 있도록 플랫폼 개발
- 기계/설비/부품의 생애주기 관리 기능 설계 및 개발
- 고객 맞춤 알람(예지) 시스템 (단계별, 레벨별 메시징)
- 주요 지표의 통합 모니터링 및 분석 기능 설계, 구현
- 다양한 디바이스에서 표현하도록 하여 UI/UX 확장
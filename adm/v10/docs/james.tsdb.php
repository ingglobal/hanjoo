CREATE TABLE `g5_1_cast_shot` (
  `csh_idx` bigint(20) NOT NULL,
  `shot_id` int(11) NOT NULL COMMENT '샷ID',
  `work_date` date DEFAULT '0000-00-00' COMMENT '작업일',
  `work_shift` int(11) NOT NULL COMMENT '주(1)/야(2)',
  `start_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '시작시각',
  `end_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '종료시각',
  `elapsed_time` int(11) NOT NULL COMMENT '경과시간',
  `machine_id` double NOT NULL COMMENT '설비ID',
  `machine_no` double NOT NULL COMMENT '설비번호',
  `item_no` double NOT NULL COMMENT '금형번호',
  `item_name` double NOT NULL COMMENT '제품명',
  `mold_no` double NOT NULL COMMENT '금형번호',
  `shot_no` int(11) NOT NULL COMMENT '샷번호',
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
  `lower_3_temp` double NOT NULL COMMENT '하금형3'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE g5_1_cast_shot_sub (
  css_idx SERIAL,
  shot_id integer NOT NULL,
  event_time TIMESTAMPTZ NOT NULL,
  hold_temp DOUBLE PRECISION NULL,
  upper_heat DOUBLE PRECISION NULL,
  lower_heat DOUBLE PRECISION NULL,
  upper_1_temp DOUBLE PRECISION NULL,
  upper_2_temp DOUBLE PRECISION NULL,
  upper_3_temp DOUBLE PRECISION NULL,
  upper_4_temp DOUBLE PRECISION NULL,
  upper_5_temp DOUBLE PRECISION NULL,
  upper_6_temp DOUBLE PRECISION NULL,
  lower_1_temp DOUBLE PRECISION NULL,
  lower_2_temp DOUBLE PRECISION NULL,
  lower_3_temp DOUBLE PRECISION NULL
);
SELECT create_hypertable('g5_1_cast_shot_sub', 'event_time');

CREATE TABLE g5_1_cast_shot_pressure (
  csp_idx SERIAL,
  shot_id integer NOT NULL,
  event_time TIMESTAMPTZ NOT NULL,
  detect_pressure DOUBLE PRECISION NULL,
  target_pressure DOUBLE PRECISION NULL,
  control_pressure DOUBLE PRECISION NULL,
  deviation_pressure DOUBLE PRECISION NULL
);
SELECT create_hypertable('g5_1_cast_shot_pressure', 'event_time');

CREATE TABLE g5_1_factory_temphum (
  fct_idx SERIAL,
  work_date date NOT NULL,
  work_shift integer default 0 not null,
  event_time TIMESTAMPTZ NOT NULL,
  temp_avg DOUBLE PRECISION NULL,
  temp_max DOUBLE PRECISION NULL,
  temp_min DOUBLE PRECISION NULL,
  hum_avg DOUBLE PRECISION NULL,
  hum_max DOUBLE PRECISION NULL,
  hum_min DOUBLE PRECISION NULL
);
SELECT create_hypertable('g5_1_factory_temphum', 'event_time');


// make csv file from mysql
// You will not be able to download form the tool phpMyAdmin.
// You should do it form terminal.

mysql -u root -p
use hanjoo_test
............
SELECT * FROM g5_1_cast_shot_sub
INTO OUTFILE 'g5_1_cast_shot_sub.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';
....
SELECT * FROM g5_1_cast_shot_pressure
INTO OUTFILE 'g5_1_cast_shot_pressure.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';
....
SELECT * FROM g5_1_factory_temphum
INTO OUTFILE 'g5_1_factory_temphum.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';
....

// root account is able to accesss the mysql folder.
$ su -
$ cd /var/lib/mysql/hanjoo_test
$ ls -al g5_1_factory_temphum.csv
// You will see the status of making the csv file.
# mv g5_1_factory_temphum.csv /home/hanjoo/files/

// test for local mac file in pgAdmin.
# \COPY g5_1_cast_shot_sub FROM /Users/james/Downloads/g5_1_factory_temphum.csv WITH (FORMAT CSV, HEADER)

# sudo su - postgres
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_factory_temphum FROM /home/hanjoo/files/g5_1_factory_temphum.csv WITH (FORMAT CSV, HEADER)"
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_cast_shot_pressure FROM /home/hanjoo/files/g5_1_cast_shot_pressure.csv WITH (FORMAT CSV, HEADER)"

// test for new line. It should have popper serial for primary key of css_idx.
INSERT INTO "g5_1_cast_shot_sub" ("shot_id", "event_time", "hold_temp", "upper_heat", "lower_heat", "upper_1_temp", "upper_2_temp", "upper_3_temp", "upper_4_temp", "upper_5_temp", "upper_6_temp", "lower_1_temp", "lower_2_temp", "lower_3_temp")
VALUES ('2324', '2020-11-02 08:16:43', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2');

// css_idx = 3 ???
// You have set the value for the last number; It shoud be the lastNumber+1;
ALTER SEQUENCE g5_1_cast_shot_sub_css_idx_seq RESTART WITH 98347881;
ALTER SEQUENCE g5_1_cast_shot_pressure_csp_idx_seq RESTART WITH 137599094;
ALTER SEQUENCE g5_1_factory_temphum_fct_idx_seq RESTART WITH 137599094;

// Insert test again.
INSERT INTO "g5_1_cast_shot_sub" ("shot_id", "event_time", "hold_temp", "upper_heat", "lower_heat", "upper_1_temp", "upper_2_temp", "upper_3_temp", "upper_4_temp", "upper_5_temp", "upper_6_temp", "lower_1_temp", "lower_2_temp", "lower_3_temp")
VALUES ('2324', '2020-11-02 08:16:43', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2');
// OK! it is working now.

// Insert test and chech for the last number for PRIMARY KEY.
INSERT INTO "g5_1_factory_temphum" ("work_date", "work_shift", "event_time", "temp_avg", "temp_max", "temp_min", "hum_avg", "hum_max", "hum_min")
VALUES ('2022-05-30', '1', '2022-05-30 23:59:59', '26.582', '26.582', '26.582', '26.582', '26.582', '26.582');
....

// now delete the test record.
delete FROM g5_1_factory_temphum WHERE fct_idx = 1268462;


====================================================
CREATE TABLE g5_1_cast_shot (
  csh_idx SERIAL,
  shot_id integer NOT NULL,
  work_date date NOT NULL,
  work_shift integer default 0 not null,
  start_time TIMESTAMPTZ NOT NULL,
  end_time TIMESTAMPTZ NOT NULL,
  elapsed_time DOUBLE PRECISION NULL,
  machine_id integer default 0 not null,
  machine_no varchar(50) default '',
  item_no varchar(50) default '',
  item_name varchar(50) default '',
  mold_no integer NOT NULL default 0,
  shot_no integer default 0 not null,
  pv_cycletime DOUBLE PRECISION NULL,
  machine_cycletime DOUBLE PRECISION NULL,
  product_cycletime DOUBLE PRECISION NULL,
  hold_temp DOUBLE PRECISION NULL,
  upper_heat DOUBLE PRECISION NULL,
  lower_heat DOUBLE PRECISION NULL,
  upper_1_temp DOUBLE PRECISION NULL,
  upper_2_temp DOUBLE PRECISION NULL,
  upper_3_temp DOUBLE PRECISION NULL,
  upper_4_temp DOUBLE PRECISION NULL,
  upper_5_temp DOUBLE PRECISION NULL,
  upper_6_temp DOUBLE PRECISION NULL,
  lower_1_temp DOUBLE PRECISION NULL,
  lower_2_temp DOUBLE PRECISION NULL,
  lower_3_temp DOUBLE PRECISION NULL
);
SELECT create_hypertable('g5_1_cast_shot', 'start_time');

mysql -u root -p
use hanjoo_test
............
SELECT * FROM g5_1_cast_shot
INTO OUTFILE 'g5_1_cast_shot.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

exit (to hanjoo account)
and you have to go to root account.
$ su -
$ cd /var/lib/mysql/hanjoo_test
$ ls -al g5_1_cast_shot.csv
# mv g5_1_cast_shot.csv /home/hanjoo/files/

# sudo su - postgres
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_cast_shot FROM /home/hanjoo/files/g5_1_cast_shot.csv WITH (FORMAT CSV, HEADER)"


exit (go back to hanjoo account)
chck for the inserted data.
---------
SELECT * FROM g5_1_cast_shot ORDER BY start_time DESC LIMIT 100;
---------

copy the last PRIMARY KEY (csh_idx)
now reset the serial value for new count starting point.

// You have set the value for the last number; It shoud be the lastNumber+1;
// Just find it the value name in pgAdmin field property.
ALTER SEQUENCE g5_1_cast_shot_csh_idx_seq RESTART WITH 237340;


// Insert test and chech for the last number for PRIMARY KEY.
INSERT INTO "g5_1_cast_shot" ("shot_id", "work_date", "work_shift", "start_time", "end_time", "elapsed_time", "machine_id", "machine_no", "item_no", "item_name", "mold_no", "shot_no", "pv_cycletime", "machine_cycletime", "product_cycletime", "hold_temp", "upper_heat", "lower_heat", "upper_1_temp", "upper_2_temp", "upper_3_temp", "upper_4_temp", "upper_5_temp", "upper_6_temp", "lower_1_temp", "lower_2_temp", "lower_3_temp")
VALUES ('184426', '2022-05-30', '1', '2022-05-30 23:59:50', '2022-05-30 23:59:58', '232', '45', '0', '55451', '0', '2', '231', '245.8', '0', '0', '692', '365.55', '369.9', '0', '0', '0', '0', '321.425', '345.6', '407.7', '0', '0');

// now delete the test record.
delete FROM g5_1_cast_shot WHERE csh_idx = 237340;

now program for auto input.
====================================================



ALTER TABLE g5_1_cast_shot ALTER COLUMN item_no TYPE varchar(50);
ALTER TABLE g5_1_cast_shot ALTER COLUMN item_no SET DEFAULT '';
....
ALTER TABLE g5_1_cast_shot ALTER COLUMN item_name TYPE varchar(50);
ALTER TABLE g5_1_cast_shot ALTER COLUMN item_name SET DEFAULT '';
....
ALTER TABLE g5_1_cast_shot ALTER COLUMN mold_no TYPE varchar(50);
ALTER TABLE g5_1_cast_shot ALTER COLUMN mold_no SET DEFAULT '';

ALTER TABLE g5_1_cast_shot ALTER COLUMN mold_no TYPE integer;
ALTER TABLE g5_1_cast_shot ALTER COLUMN mold_no SET DEFAULT 0;
....

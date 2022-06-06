pgAdmin..
..................................................................................
SELECT * FROM g5_1_cast_shot_pressure ORDER BY event_time DESC LIMIT 100;
SELECT * FROM g5_1_cast_shot_sub ORDER BY event_time DESC LIMIT 100;


..................................................................................

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
use hanjoo_www
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
$ cd /var/lib/mysql/hanjoo_www
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
use hanjoo_www
............
SELECT * FROM g5_1_cast_shot
INTO OUTFILE 'g5_1_cast_shot.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

exit (to hanjoo account)
and you have to go to root account.
$ su -
$ cd /var/lib/mysql/hanjoo_www
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
====================================================
CREATE TABLE g5_1_xray_inspection (
  xry_idx SERIAL,
  work_date date NOT NULL,
  work_shift integer default 0 not null,
  start_time TIMESTAMPTZ NOT NULL,
  end_time TIMESTAMPTZ NOT NULL,
  qrcode varchar(50) default '',
  production_id integer default 0 not null,
  machine_id integer default 0 not null,
  machine_no varchar(50) default '',
  position_1 integer default 0,
  position_2 integer default 0,
  position_3 integer default 0,
  position_4 integer default 0,
  position_5 integer default 0,
  position_6 integer default 0,
  position_7 integer default 0,
  position_8 integer default 0,
  position_9 integer default 0,
  position_10 integer default 0,
  position_11 integer default 0,
  position_12 integer default 0,
  position_13 integer default 0,
  position_14 integer default 0,
  position_15 integer default 0,
  position_16 integer default 0,
  position_17 integer default 0,
  position_18 integer default 0
);
SELECT create_hypertable('g5_1_xray_inspection', 'start_time');

mysql -u root -p
use hanjoo_www
............
SELECT * FROM g5_1_xray_inspection
INTO OUTFILE 'g5_1_xray_inspection.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

exit (to hanjoo account)
and you have to go to root account.
$ su -
$ cd /var/lib/mysql/hanjoo_www
$ ls -al g5_1_xray_inspection.csv
# mv g5_1_xray_inspection.csv /home/hanjoo/files/

# sudo su - postgres
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_xray_inspection FROM /home/hanjoo/files/g5_1_xray_inspection.csv WITH (FORMAT CSV, HEADER)"


exit (go back to hanjoo account)
chck for the inserted data.
---------
SELECT * FROM g5_1_xray_inspection ORDER BY start_time DESC LIMIT 100;
---------

copy the last PRIMARY KEY (xry_idx)
now reset the serial value for new count starting point.

// You have set the value for the last number; It shoud be the lastNumber+1;
// Just find it the value name in pgAdmin field property.
ALTER SEQUENCE g5_1_xray_inspection_xry_idx_seq RESTART WITH 8978;


// Insert test and chech for the last number for PRIMARY KEY.
INSERT INTO "g5_1_xray_inspection" ("work_date", "work_shift", "start_time", "end_time", "qrcode", "production_id", "machine_id", "machine_no", "position_1", "position_2", "position_3", "position_4", "position_5", "position_6", "position_7", "position_8", "position_9", "position_10", "position_11", "position_12", "position_13", "position_14", "position_15", "position_16", "position_17", "position_18")
VALUES ('2022-05-31', '1', '2022-05-31 23:59:50', '2022-05-31 23:59:58', '22E30DRLH01131111', '430142', '45', 'ADR1호기', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO "g5_1_xray_inspection" ("work_date", "work_shift", "start_time", "end_time", "qrcode", "production_id", "machine_id", "machine_no", "position_1", "position_2", "position_3", "position_4", "position_5", "position_6", "position_7", "position_8", "position_9", "position_10", "position_11", "position_12", "position_13", "position_14", "position_15", "position_16", "position_17", "position_18")
VALUES ('2022-05-31', '1', '2022-05-31 23:59:50', '2022-05-31 23:59:58', '22E30DRLH01131112', '430142', '45', 'ADR1호기', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

SELECT * FROM g5_1_xray_inspection WHERE work_date = '2022-05-31' AND production_id = '430142';
SELECT * FROM g5_1_xray_inspection WHERE qrcode = '22E30DRLH01131111';

// now delete the test record.
delete FROM g5_1_xray_inspection WHERE xry_idx = 8980;
delete FROM g5_1_xray_inspection WHERE xry_idx = 8981;

now program for auto input.
====================================================
====================================================
CREATE TABLE g5_1_engrave_qrcode (
  eqr_idx SERIAL,
  work_date date NOT NULL,
  work_shift integer default 0 not null,
  event_time TIMESTAMPTZ NOT NULL,
  qrcode varchar(50) default '',
  production_id integer default 0 not null
);
SELECT create_hypertable('g5_1_engrave_qrcode', 'event_time');

mysql -u root -p
use hanjoo_www
............
SELECT * FROM g5_1_engrave_qrcode
INTO OUTFILE 'g5_1_engrave_qrcode.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

exit (to hanjoo account)
and you have to go to root account.
$ su -
$ cd /var/lib/mysql/hanjoo_www
$ ls -al g5_1_engrave_qrcode.csv
# mv g5_1_engrave_qrcode.csv /home/hanjoo/files/

# sudo su - postgres
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_engrave_qrcode FROM /home/hanjoo/files/g5_1_engrave_qrcode.csv WITH (FORMAT CSV, HEADER)"


exit (go back to hanjoo account)
chck for the inserted data.
---------
SELECT * FROM g5_1_engrave_qrcode ORDER BY event_time DESC LIMIT 100;
---------

copy the last PRIMARY KEY (eqr_idx)
now reset the serial value for new count starting point.

// You have set the value for the last number; It shoud be the lastNumber+1;
// Just find it the value name in pgAdmin field property.
# ALTER SEQUENCE g5_1_engrave_qrcode_eqr_idx_seq RESTART WITH 403142;


// Insert test and chech for the last number for PRIMARY KEY.
INSERT INTO "g5_1_engrave_qrcode" ("work_date", "work_shift", "event_time", "qrcode", "production_id")
VALUES ('2022-05-31', '1', '2022-05-31 23:59:50', '22E30DRLH01131112', '430142');

// now delete the test record.
delete FROM g5_1_engrave_qrcode WHERE eqr_idx = 403142;

now program for auto input.
====================================================
====================================================
CREATE TABLE g5_1_melting_temp (
  mlt_idx SERIAL,
  work_date date NOT NULL,
  work_shift integer default 0 not null,
  event_time TIMESTAMPTZ NOT NULL,
  temp_avg DOUBLE PRECISION NULL,
  temp_max DOUBLE PRECISION NULL,
  temp_min DOUBLE PRECISION NULL,
  alarm_min DOUBLE PRECISION NULL,
  alarm_max DOUBLE PRECISION NULL
);
SELECT create_hypertable('g5_1_melting_temp', 'event_time');

mysql -u root -p
use hanjoo_www
............
SELECT * FROM g5_1_melting_temp
INTO OUTFILE 'g5_1_melting_temp.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

exit (to hanjoo account)
and you have to go to root account.
$ su -
$ cd /var/lib/mysql/hanjoo_www
$ ls -al g5_1_melting_temp.csv
# mv g5_1_melting_temp.csv /home/hanjoo/files/

# sudo su - postgres
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_melting_temp FROM /home/hanjoo/files/g5_1_melting_temp.csv WITH (FORMAT CSV, HEADER)"


exit (go back to hanjoo account)
chck for the inserted data.
---------
SELECT * FROM g5_1_melting_temp ORDER BY event_time DESC LIMIT 100;
---------

copy the last PRIMARY KEY (mlt_idx)
now reset the serial value for new count starting point.

// You have set the value for the last number; It shoud be the lastNumber+1;
// Just find it the value name in pgAdmin field property.
ALTER SEQUENCE g5_1_melting_temp_mlt_idx_seq RESTART WITH 741821;


// Insert test and chech for the last number for PRIMARY KEY.
INSERT INTO "g5_1_melting_temp" ("work_date", "work_shift", "event_time", "temp_avg", "temp_max", "temp_min", "alarm_min", "alarm_max")
VALUES ('2022-05-31', '1', '2022-05-31 23:59:59', '26.582', '26.582', '26.582', '26.582', '26.582');

// now delete the test record.
delete FROM g5_1_melting_temp WHERE mlt_idx = 741821;

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


====================================================
CREATE TABLE g5_1_charge_out (
  cho_idx SERIAL,
  work_date date NOT NULL,
  work_shift integer default 0 not null,
  event_time TIMESTAMPTZ NOT NULL,
  weight_out integer default 0,
  temp_out integer default 0,
  temp_gbf integer default 0,
  machine_1_id integer default 0,
  machine_1_no varchar(50) default '',
  machine_2_id integer default 0,
  machine_2_no varchar(50) default '',
  machine_3_id integer default 0,
  machine_3_no varchar(50) default ''
);
SELECT create_hypertable('g5_1_charge_out', 'event_time');

mysql -u root -p
use hanjoo_www
............
SELECT * FROM g5_1_charge_out
INTO OUTFILE 'g5_1_charge_out.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

exit (to hanjoo account)
and you have to go to root account.
$ su -
$ cd /var/lib/mysql/hanjoo_www
$ ls -al g5_1_charge_out.csv
# mv g5_1_charge_out.csv /home/hanjoo/files/

# sudo su - postgres
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_charge_out FROM /home/hanjoo/files/g5_1_charge_out.csv WITH (FORMAT CSV, HEADER)"


exit (go back to hanjoo account)
chck for the inserted data.
---------
SELECT * FROM g5_1_charge_out ORDER BY event_time DESC LIMIT 100;
---------

copy the last PRIMARY KEY (cho_idx)
now reset the serial value for new count starting point.

// You have set the value for the last number; It shoud be the lastNumber+1;
// Just find it the value name in pgAdmin field property.
ALTER SEQUENCE g5_1_charge_out_cho_idx_seq RESTART WITH 42744;  (lastNumber+1)


// Insert test and chech for the last number for PRIMARY KEY.
INSERT INTO "g5_1_charge_out" ("work_date", "work_shift", "event_time", "weight_out", "temp_out", "temp_gbf", "machine_1_id", "machine_1_no", "machine_2_id", "machine_2_no", "machine_3_id", "machine_3_no")
VALUES ('2022-05-31', 1, '2022-05-31 23:59:59', 450, 740, 0, 1, 'LP01', 2, 'LP02', 0, 'LP02');


// now delete the test record.
delete FROM g5_1_charge_out WHERE cho_idx = 42744;

now program for auto input.
====================================================
====================================================
CREATE TABLE g5_1_charge_in (
  chi_idx SERIAL,
  work_date date NOT NULL,
  work_shift integer default 0 not null,
  event_time TIMESTAMPTZ NOT NULL,
  weight_total DOUBLE PRECISION NULL,
  weight_ingot DOUBLE PRECISION NULL,
  weight_scrap DOUBLE PRECISION NULL
);
SELECT create_hypertable('g5_1_charge_in', 'event_time');

mysql -u root -p
use hanjoo_www
............
SELECT * FROM g5_1_charge_in
INTO OUTFILE 'g5_1_charge_in.csv'
CHARACTER SET utf8
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';

exit (to hanjoo account)
and you have to go to root account.
$ su -
$ cd /var/lib/mysql/hanjoo_www
$ ls -al g5_1_charge_in.csv
# mv g5_1_charge_in.csv /home/hanjoo/files/

# sudo su - postgres
# psql -U postgres -d hanjoo_www -c "\COPY g5_1_charge_in FROM /home/hanjoo/files/g5_1_charge_in.csv WITH (FORMAT CSV, HEADER)"


exit (go back to hanjoo account)
chck for the inserted data.
---------
SELECT * FROM g5_1_charge_in ORDER BY event_time DESC LIMIT 100;
---------

copy the last PRIMARY KEY (chi_idx)
now reset the serial value for new count starting point.

// You have set the value for the last number; It shoud be the lastNumber+1;
// Just find it the value name in pgAdmin field property.
ALTER SEQUENCE g5_1_charge_in_chi_idx_seq RESTART WITH 34089;  (lastNumber+1)


// Insert test and chech for the last number for PRIMARY KEY.
INSERT INTO "g5_1_charge_in" ("work_date", "work_shift", "event_time", "weight_total", "weight_ingot", "weight_scrap")
VALUES ('2022-05-31', 1, '2022-05-31 23:59:59', 949, 922, 27);


// now delete the test record.
delete FROM g5_1_charge_in WHERE chi_idx = 34089;

now program for auto input.
====================================================

UPDATE g5_1_cast_shot_sub AS css SET
  machine_id = coalesce((SELECT machine_id FROM g5_1_cast_shot WHERE shot_id = css.shot_id),0)
WHERE event_time > '2022-05-01 00:00:00'
....
UPDATE g5_1_cast_shot_pressure AS csp SET
  machine_id = coalesce((SELECT machine_id FROM g5_1_cast_shot WHERE shot_id = csp.shot_id),0)
WHERE event_time > '2022-05-01 00:00:00'
....
delimiter $$
use `asmac`$$

delimiter $$
DROP TABLE IF EXISTS `schoolEducation`$$
CREATE TABLE `schoolEducation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beginTime` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `educational` varchar(255) DEFAULT NULL,
  `endTime` varchar(255) DEFAULT NULL,
  `schoolName` varchar(255) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8$$

-- add indexes to players
-- two ways
-- 1, CREATE INDEX index_name on table_name (col1, col2, col3, ...);
-- 2, ALTER TABLE `table_name` ADD INDEX `index_name` (`col1`)
-- e.g. ALTER TABLE `players0` ADD INDEX `experience` (`experience`)$$
-- e.g. CREATE INDEX idx_callingnumber ON itf_recordlog (callingnumber);

delimiter $$
DROP TABLE IF EXISTS `itf_recordlog`$$
create table `itf_recordlog`
  (
    `streamnumber` int(11) NOT NULL AUTO_INCREMENT ,
    `callingnumber` char(24) DEFAULT NULL,
    `calltime` char(14) DEFAULT NULL,
    `recordtimes` int(11) DEFAULT NULL,
    primary key (`streamnumber`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$
create index idx_callingnumber on itf_recordlog (callingnumber)$$
create index idx_calltime on itf_recordlog (calltime)$$

delimiter $$
drop table if exists `ser_inter_dbtblack`$$
create table `ser_inter_dbtblack`
  (
    `stream_number` int(11) NOT NULL AUTO_INCREMENT ,
    `commit_time`  varchar(14) not null ,
    `start_time`   varchar(14) not null ,
    `end_time`  varchar(14) not null ,
    `phone_number` varchar(21) not null ,
    `phone_type` smallint not null ,
    `illegal_reason` smallint not null ,
    `spe_phone_desc` varchar(100) default null ,
    `call_times`  int(11) default null ,
    `num_state` smallint not null ,
    `illegal_type` smallint default null ,
    `last_called` varchar(21) not null ,
    `susdesc` char(50) not null ,
    `sus_type_desc` varchar(50) default null ,
    `actperiod` int(11) not null ,
    `act_type` smallint not null ,
    `fe_id` int(11) not null ,
    `findsustimes` int(11) not null ,
    `ensure_time` char(14) default null ,
    `last_recordtime` char(14) default null ,
    `triger_area` char(6) default null ,
    `service_key` int(20) default null ,
     primary key (`stream_number`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$
create index idx_dbt_phone on ser_inter_dbtblack (phone_number)$$
create index idx_dbt_commit on ser_inter_dbtblack (commit_time)$$

delimiter $$
drop table if exists `ser_inter_black`$$
create table `ser_inter_black`
  (
    `stream_number` int(11) NOT NULL AUTO_INCREMENT ,
    `commit_time`  varchar(14) not null ,
    `phone_number` varchar(21) not null ,
    `phone_type` smallint not null ,
    `illegal_reason` smallint not null ,
    `reason_desc` varchar(100),
    `illegal_type` smallint,
    `intercept_times` int(10) default 0,
    `intercept_valid` varchar(14),
    `seg_flag` char(1) default '1',
    `triger_area` char(6) default null ,
    `service_key` int(20) default null ,
     primary key (`stream_number`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$
create index idx_phone_number on ser_inter_black (phone_number)$$
create index commit_time on ser_inter_black (commit_time)$$

delimiter $$
drop table if exists `itf_contralog`$$
create table `itf_contralog`
  (
    `streamnumber` int(11) NOT NULL AUTO_INCREMENT ,
    `servicekey` int(20) default null ,
    `callingnumber` char(24),
    `callednumber` char(24),
    `callingvlr` char(6),
    `callinghlr` char(6),
    `calledhlr` char(6),
    `ringtime` int,
    `callbegintime` char(14),
    `callendtime` char(14),
    `callduration` integer,
    `mscaddress` char(16),
    `call_result` smallint,
    `cause` char(5),
    primary key (`streamnumber`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$

delimiter $$
drop table if exists `itf_sysconfig`$$
create table `itf_sysconfig`
  (
    `servkey` smallint,
    `recordcount` smallint,
    primary key (`servkey`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$

delimiter $$
drop table if exists `cfg_itr_strategy`$$
create table `cfg_itr_strategy`
  (
    `strategy` integer,
    `desc` varchar(200),
    `value` integer,
    `strage_stream` integer,
    primary key (`strategy`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$

/*
delimiter $$
drop table if exists `map_spe_phone` $$
create table `map_spe_phone`
  (
  --`stream_number`  int(11) NOT NULL AUTO_INCREMENT ,
    `stream_number` serial not null ,
    `phone` char(21) not null ,
    `phone_type` smallint not null ,
    `name` char(100),
    `province` char(20),
    `city` char(50),
    `match_type` smallint not null ,
    `status` smallint not null,
    primary key (`phone`)  constraint  `map_spePhone`
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$
create index idx_seg_status on map_spe_phone (status) using btree $$
*/

delimiter $$
drop table if exists `map_spe_phone` $$
create table `map_spe_phone`
  (
  `stream_number`  int(11) NOT NULL AUTO_INCREMENT ,
    `phone` char(21) not null ,
    `phone_type` smallint not null ,
    `name` char(100),
    `province` char(20),
    `city` char(50),
    `match_type` smallint not null ,
    `status` smallint not null,
    primary key (`stream_number`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8$$
create index idx_seg_status on map_spe_phone (status) using btree $$


delimiter $$
drop table if exists `login_user` $$
CREATE TABLE `login_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT ,
  `user_name`varchar(20) default NULL,
  `nick_name` varchar(20) default NULL,
  `e_mail` varchar(50) default NULL,
  `gender` varchar(2) default NULL,
  `birthday` varchar(20) default NULL,
  `score` integer default NULL,
  `login_passwd` varchar(50) default NULL,
  `mapid` varchar(11) default NULL,
  `confirmed` char(1) default NULL,
  `account_level` varchar(10) default NULL,
  `write_off` char(1) default NULL,
  `freeze` char(1) default NULL,
  `image_url` varchar(100) default 'images/default/default.jpg',
  PRIMARY KEY  (`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8$$
ALTER TABLE `login_user` ADD INDEX `idx_user_id` (`user_id`)$$


delimiter $$
drop table if exists `ser_inter_called_info` $$
create table `ser_inter_called_info`
(
	  `stream_number` int(11) NOT NULL AUTO_INCREMENT ,
    `commit_time`  varchar(14) not null ,
    `phone_number` varchar(21) not null ,
    `called_number` varchar(21) not null ,
    primary key (`stream_number`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8$$
create index idx_phone on ser_inter_called_info (phone_number)$$
create index idx_commit on ser_inter_called_info (commit_time)$$

delimiter $$
drop table if exists `cfg_province_area` $$
create table `cfg_province_area`
(
	  `stream_number` int(11) NOT NULL AUTO_INCREMENT ,
    `province_name`  varchar(8) not null ,
    `area_code` varchar(4) not null ,
    primary key (`stream_number`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8$$
create index idx_area_code on cfg_province_area (area_code)$$

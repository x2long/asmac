delimiter $$
use asmac $$

LOCK TABLES `itf_recordlog` WRITE $$
insert into itf_recordlog(callingnumber,calltime,recordtimes) values('000571110','20140705101010',12)$$
insert into itf_recordlog(callingnumber,calltime,recordtimes) values('00057159552','20140709101010',30)$$
insert into itf_recordlog(callingnumber,calltime,recordtimes) values('010110','20140709101010',3)$$
insert into itf_recordlog(callingnumber,calltime,recordtimes) values('000933','20140709101010',5)$$
UNLOCK TABLES $$

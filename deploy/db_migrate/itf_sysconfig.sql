delimiter $$
use asmac $$

LOCK TABLES `itf_sysconfig` WRITE $$
insert into itf_sysconfig values(1,3)$$
insert into itf_sysconfig values(2,7)$$
insert into itf_sysconfig values(3,21)$$
UNLOCK TABLES $$

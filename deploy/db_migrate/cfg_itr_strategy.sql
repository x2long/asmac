delimiter $$
use asmac $$

LOCK TABLES `cfg_itr_strategy` WRITE $$
insert into cfg_itr_strategy values(1,'公众举报',20,30)$$
insert into cfg_itr_strategy values(2,'110尾号',11,3)$$
insert into cfg_itr_strategy values(3,'公检法号码',10,5)$$
insert into cfg_itr_strategy values(4,'特服尾号',10,5)$$
UNLOCK TABLES $$

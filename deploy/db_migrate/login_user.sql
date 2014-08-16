delimiter $$
use asmac $$

LOCK TABLES `login_user` WRITE $$
insert into login_user(user_name,gender,login_passwd) values('helloworld','男','123456')$$
insert into login_user(user_name,gender,login_passwd) values('test','女','123456')$$

UNLOCK TABLES $$

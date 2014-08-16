DROP DATABASE IF exists `asmac`;
CREATE DATABASE `asmac` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
grant all on asmac.* to 'root' identified by '123456';
flush privileges;
use `asmac`;
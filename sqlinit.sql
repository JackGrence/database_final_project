drop database if EXISTS final;
create database final
CHARACTER SET utf8;
use final;
create table 科系代碼表
(系碼 CHAR(4),
系名 CHAR(10) NOT NULL,
系主任 CHAR(4),
PRIMARY KEY(系碼)
);


create table 學生資料表
(學號 CHAR(5),
姓名 CHAR(4) NOT NULL,
系碼 CHAR(4),
PRIMARY KEY(學號),
FOREIGN KEY(系碼) REFERENCES 科系代碼表(系碼)
);


create table 課程資料表
(課號 CHAR(4),
課名 CHAR(10) NOT NULL,
學分數 INT,
PRIMARY KEY(課號)
);


create table 選課資料表
(學號 CHAR(5),
課號 CHAR(4) NOT NULL,
成績 INT,
PRIMARY KEY(學號,課號),
FOREIGN KEY(學號) REFERENCES 學生資料表(學號),
FOREIGN KEY(課號) REFERENCES 課程資料表(課號)
);


Insert Into 科系代碼表
Values('D001', '資工系', '李主任'),
('D002', '資管系', '林主任');


Insert Into 學生資料表
Values('S0001', '一心', 'D001'),
('S0002', '二聖', 'D001'),
('S0003', '三多', 'D002'),
('S0004', '四維', 'D002'),
('S0005', '五福', 'D002');


Insert Into 課程資料表
Values('C001', '資料庫系統', '4'),
('C002', '手機程式', '4'),
('C003', '機器人程式', '3'),
('C004', '物聯網技術', '4'),
('C005', '大數據分析', '3');


Insert Into 選課資料表
Values
('S0001', 'C001', NULL),
('S0001', 'C005', NULL),
('S0002', 'C002', NULL),
('S0002', 'C005', NULL);


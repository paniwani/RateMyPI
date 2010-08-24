CREATE TABLE users (
  uid tinyint(4) NOT NULL auto_increment,
  uname varchar(20) NOT NULL,
  upass varchar(32) default NULL,
  ukey varchar(32) default NULL,
  email varchar(30) NOT NULL,
  level varchar(6) NOT NULL,
  active tinyint(1) NOT NULL,
  PRIMARY KEY (uid)
);

INSERT INTO users VALUES(1,"paniwani","1a1dc91c907325c69271ddf0c944bc72","a5ea0ad9260b1550a14cc58d2c39b03d","paniwani@gmail.com","normal",1);
INSERT INTO users VALUES(2,"vpamulap","1a1dc91c907325c69271ddf0c944bc72","c81e728d9d4c2f636f067f89cc14862c","vpamulap@gmail.com","normal",1);

CREATE TABLE organizations (
  oid tinyint(4) NOT NULL auto_increment,
  name varchar(20) NOT NULL,
  city varchar(20) NOT NULL,
  region varchar(20) NOT NULL,
  PRIMARY KEY (oid)
);

INSERT INTO organizations VALUES (1,"NIH","Bethesda","MD");

CREATE TABLE ratings (
  rid tinyint(4) NOT NULL auto_increment,
  rdate date NOT NULL,
  pid tinyint(4) NOT NULL,
  oid tinyint(4) NOT NULL,
  easiness tinyint(1) NOT NULL,
  helpfulness tinyint(1) NOT NULL,
  clarity tinyint(1) NOT NULL,
  interest tinyint(1) NOT NULL,
  comment varchar(350) NOT NULL,
  PRIMARY KEY (rid)
);

INSERT INTO ratings VALUES (1,"2010-08-24",1,1,4,3,4,3,"He was cool.");

CREATE TABLE pis (
  pid tinyint(4) NOT NULL auto_increment,
  oid tinyint(4) NOT NULL,
  location varchar(20) NOT NULL,
  department varchar(20) NOT NULL,
  fname varchar(20) NOT NULL,
  lname varchar(20) NOT NULL,
  total_easiness float NOT NULL,
  total_helpfulness float NOT NULL,
  total_clarity float NOT NULL,
  nratings tinyint(4) NOT NULL,
  PRIMARY KEY (pid)
);

INSERT INTO pis VALUES (1,1,"Bethesda","BME","John","Doe","2.3","3.4","4.2","15");
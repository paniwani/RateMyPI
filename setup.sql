DROP TABLE organizations;
DROP TABLE pis;
DROP TABLE ratings;
DROP TABLE users;

CREATE TABLE users (
  uid tinyint(4) NOT NULL auto_increment,
  udate date NOT NULL,
  uname varchar(20) NOT NULL,
  upass varchar(32) default NULL,
  ukey varchar(32) default NULL,
  email varchar(30) NOT NULL,
  level varchar(6) NOT NULL,
  active tinyint(1) NOT NULL,
  PRIMARY KEY (uid)
);

INSERT INTO users VALUES(1,"2010-08-24","paniwani","1a1dc91c907325c69271ddf0c944bc72","a5ea0ad9260b1550a14cc58d2c39b03d","paniwani@gmail.com","admin",1);
INSERT INTO users VALUES(2,"2010-08-24","vpamulap","1a1dc91c907325c69271ddf0c944bc72","c81e728d9d4c2f636f067f89cc14862c","vpamulap@gmail.com","normal",1);

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
  uid tinyint(4) NOT NULL,
  pid tinyint(4) NOT NULL,
  oid tinyint(4) NOT NULL,
  easiness tinyint(1) NOT NULL,
  helpfulness tinyint(1) NOT NULL,
  clarity tinyint(1) NOT NULL,
  interest tinyint(1) NOT NULL,
  comment varchar(350) NOT NULL,
  active tinyint(1) NOT NULL,
  PRIMARY KEY (rid)
);

INSERT INTO ratings VALUES (1,"2010-08-24",1,1,1,4,3,4,3,"He was cool.",1);
INSERT INTO ratings VALUES (2,"2010-08-24",1,2,1,4,3,4,3,"He was not cool.",0);

CREATE TABLE pis (
  pid tinyint(4) NOT NULL auto_increment,
  pdate date NOT NULL,
  uid tinyint(4) NOT NULL,
  oid tinyint(4) NOT NULL,
  department varchar(20) NOT NULL,
  fname varchar(20) NOT NULL,
  lname varchar(20) NOT NULL,
  total_easiness float NOT NULL,
  total_helpfulness float NOT NULL,
  total_clarity float NOT NULL,
  nratings tinyint(4) NOT NULL,
  active tinyint(1) NOT NULL,
  PRIMARY KEY (pid)
);

INSERT INTO pis VALUES (1,"2010-08-24",1,1,"BME","John","Doe","2.3","3.4","4.2","15","1");
INSERT INTO pis VALUES (2,"2010-08-24",1,1,"ChE","Foo1","Bar","0","0","0","0","0");
INSERT INTO pis VALUES (3,"2010-08-24",1,1,"ChE","Foo2","Bar","0","0","0","0","0");
INSERT INTO pis VALUES (4,"2010-08-24",1,1,"ChE","Foo3","Bar","0","0","0","0","0");
INSERT INTO pis VALUES (5,"2010-08-24",1,1,"ChE","Foo4","Bar","0","0","0","0","0");
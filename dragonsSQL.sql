DROP TABLE IF EXISTS stuelement;
DROP TABLE IF EXISTS studentinfo;
DROP TABLE IF EXISTS academy;
DROP TABLE IF EXISTS elementlevel;

create table elementlevel (
	elementid		int(1) NOT NULL,
	elemname		char(5) NOT NULL,
		
	PRIMARY KEY(elementid)
);


INSERT INTO elementlevel (elementid,elemname) VALUES (1, "EARTH");
INSERT INTO elementlevel (elementid,elemname) VALUES (2, "WIND");
INSERT INTO elementlevel (elementid,elemname) VALUES (3, "FIRE");
INSERT INTO elementlevel (elementid,elemname) VALUES (4, "WATER");

create table academy (
	academyid	char(4),
	academy		char(15),
	
	PRIMARY KEY (academyid)
);


INSERT INTO academy VALUES ("EDI1", "EDINBURGH");
INSERT INTO academy VALUES ("PER1", "PERTH");

create table studentinfo (
  clientid    int(5)  NOT NULL auto_increment,
  academyid    char(4), 
  username    varchar(12) UNIQUE NOT NULL,
  userpassword  char(64) NOT NULL,
  salt      char(16) NOT NULL,
  forename    varchar(15),
  surname      varchar(15),
  dob        DATE NOT NULL,
  emailadd    char(60) NOT NULL,
  emercont    char(30),
  emernum      char(15),
  usertype    int(1) NOT NULL DEFAULT 2,
  tandc      int(1) NOT NULL,
  sessionid    varchar(64),
  
  FOREIGN KEY (academyid) references academy(academyid),
  PRIMARY KEY (clientid)
);ENGINE=InnoDB AUTO_INCREMENT=1000;

INSERT INTO studentinfo (username, userpassword, salt, forename, surname, dob, emailadd, usertype, tandc) VALUES ("Mark", "44ce2b13fb181306556265152403c422fc1d76e0ad0f56c3329ea9d78718c82d", "ZqtlUjrxOqaweySl","Mark","Smith","1980-01-29","mark1122334455@gmail.com",3,1);
INSERT INTO studentinfo (username, userpassword, salt, forename, surname, dob, emailadd, usertype, tandc) VALUES ("Hedge", "44ce2b13fb181306556265152403c422fc1d76e0ad0f56c3329ea9d78718c82d", "ZqtlUjrxOqaweySl","John","Hall","1980-01-29","hedge5@gmail.com",3,1);

create table stuelement (
	clientid		int(5),
	elementid		int(1),
	elemlevel		int(2),
	
	FOREIGN KEY(clientid) REFERENCES studentinfo(clientid),
	FOREIGN KEY(elementid) REFERENCES elementlevel(elementid),
	PRIMARY KEY(clientid, elementid)
);

INSERT INTO stuelement (clientid, elementid, elemlevel) VALUES
    ( (SELECT clientid from studentinfo where clientid = 1000),(SELECT elementid from elementlevel WHERE elemname='EARTH'),8);
INSERT INTO stuelement (clientid, elementid, elemlevel) VALUES
    ( (SELECT clientid from studentinfo where clientid = 1000),(SELECT elementid from elementlevel WHERE elemname='WATER'),7);
 INSERT INTO stuelement (clientid, elementid, elemlevel) VALUES
    ( (SELECT clientid from studentinfo where clientid = 1000),(SELECT elementid from elementlevel WHERE elemname='WIND'),9);   

	
**this select should return all students and elements with their respective level attained**

select studentinfo.username, stuelement.elementid,elementlevel.elemname, stuelement.elemlevel
from studentinfo, stuelement, elementlevel
  where (elementlevel.elementid = stuelement.elementid)
 
** this select will return data for specific student, in this case mark**

 select studentinfo.username, stuelement.elementid,elementlevel.elemname, stuelement.elemlevel
from studentinfo, stuelement, elementlevel
  where (elementlevel.elementid = stuelement.elementid)
  and (studentinfo.username = "mark")
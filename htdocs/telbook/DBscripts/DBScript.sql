CREATE TABLE PERSONS_TBL
   (
   ID INT(11) NOT NULL AUTO_INCREMENT,
   NAME VARCHAR(12),
   FAM VARCHAR(15),
   ADDRESS VARCHAR(33),
   PRIMARY KEY(ID)
   )ENGINE=MyISAM DEFAULT CHARSET='utf8' AUTO_INCREMENT=1;

CREATE TABLE TELTYPES_TBL
   (
   ID INT(11) NOT NULL AUTO_INCREMENT,
   TELTYPE VARCHAR(12),
   PRIMARY KEY(ID)
   )ENGINE=MyISAM DEFAULT CHARSET='utf8' AUTO_INCREMENT=1;

CREATE TABLE TELS_TBL
   (
   ID INT(11) NOT NULL AUTO_INCREMENT,
   PID INT(11) NOT NULL,
   TID INT(11) NOT NULL,
   NOMER VARCHAR(33),
   PRIMARY KEY(ID)
   )ENGINE=MyISAM DEFAULT CHARSET='utf8' AUTO_INCREMENT=1;

INSERT INTO PERSONS_TBL(ID, NAME, FAM, ADDRESS)
VALUES
   (1, 'Suljo', 'Puljov', 'ul. Evropejski sajus 44'),
   (2, 'Radka', 'Piratkova', 'ul. Karibska 11'),
   (3, 'Muncho', 'Veliki', '4-ti kilometar'),
   (4, 'Glupcho', 'Bezdanski', 'fdiba.tu-sofia.bg');

INSERT INTO TELTYPES_TBL(ID, TELTYPE)
VALUES
   (1, 'dienstlich'),
   (2, 'privat'),
   (3, 'handy'),
   (4, 'fax'),
   (5, 'email'),
   (6, 'facebook');

INSERT INTO TELS_TBL(ID, PID, TID, NOMER)
VALUES
   (1, 2, 3, '0885-231311'),
   (2, 1, 1, '222311'),
   (3, 2, 1, '23474374'),
   (4, 3, 5, 'mun@gmail.com'),
   (5, 4, 5, 'glupcho@fdiba.tu-sofia.com'),
   (6, 4, 4, '345543234'),
   (7, 2, 5, 'pirat@abv.bg');

   

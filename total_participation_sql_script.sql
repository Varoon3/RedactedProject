--
-- Group Members: Varoon Mathur, Barak Jacob, Lucas Zamprogno
--
-- This script will run on the initialization of the Database for our CPSC 304 Project
--
--
--
-- First drop any existing tables


drop table family_physician cascade constraints;
drop table specialist cascade constraints;
drop table health_care_record cascade constraints;
drop table has_appointment cascade constraints;
drop table waitlist cascade constraints;
drop table is_on cascade constraints;
drop table medication cascade constraints;
drop table takes cascade constraints;
drop table prescribes cascade constraints;
drop table health_care_provider cascade constraints;
drop table patient_registered cascade constraints;


-- Now we create the tables again
create table health_care_provider(
	hid number(9,0) primary key,
	name varchar2(30),
	location varchar2(100)
	);
create table family_physician(
    hid number(9,0) primary key,
    foreign key(hid) references health_care_provider
        ON DELETE cascade
    );
create table specialist(
    hid number(9,0) primary key,
    speciality varchar2(20),
    availability integer,
    foreign key(hid) references health_care_provider
         ON DELETE cascade
    );
create table patient_registered(
    carecardNum number(9,0) primary key,
    name varchar2(30),
    location varchar2(100),
    hid number(9,0),
    foreign key(hid) references family_physician(hid)
         ON DELETE SET NULL
    );
create table health_care_record(
    carecardNum number(9,0),
    rid integer,
    age integer,
    ethnicity varchar2(30),
    geneticHistory varchar2(250),
    insurance varchar2(50),
    primary key(carecardNum, rid),
    foreign key(carecardNum) references patient_registered
        ON DELETE cascade
        );
create table has_appointment(
    carecardNum number(9,0),
    hid number(9,0),
    dateAppointment varchar2(30),
    timeAppointment varchar2(30),
    primary key(carecardNum, hid),
    foreign key(carecardNum) references patient_registered
        ON DELETE cascade,
    foreign key(hid) references health_care_provider
        ON DELETE cascade
        );
create table waitlist(
    region varchar2(20),
    speciality varchar2(20),
    primary key(region, speciality)
    );
create table is_on(
    carecardNum number(9,0),
    speciality varchar2(20),
    region varchar2(20),
    patientPriorityNum integer,
    timeOfEntry varchar2(30),
    dateOfEntry varchar2(30),
    primary key(carecardNum, speciality, region),
    foreign key(carecardNum) references patient_registered
        ON DELETE cascade,
    foreign key(speciality, region) references waitlist
        );
create table medication(
    medName varchar2(30),
    dose integer,
    primary key(medName, dose)
    );
create table takes(
    carecardNum number(9,0),
    medName varchar2(30),
    dose integer,
    primary key(carecardNum, medName, dose),
    foreign key(carecardNum) references patient_registered
        ON DELETE cascade,
    foreign key(medName, dose) references medication
        ON DELETE cascade
        );
create table prescribes(
    hid number(9,0),
    medName varchar2(30),
    dose integer,
    primary key(hid, medName, dose),
    foreign key(hid) references specialist
        ON DELETE cascade,
    foreign key(medName, dose) references medication
        ON DELETE cascade
        );

insert into health_care_provider values (242518,'James Smith','Vancouver'); 
insert into health_care_provider values (141582,'Mary Johnson','Vancouver');
insert into health_care_provider values (811564,'John Williams','Vancouver'); 
insert into health_care_provider values (254099,'Patricia Jones','Montreal'); 
insert into health_care_provider values (911564,'Elizabeth Taylor','Montreal');
insert into health_care_provider values (356187,'Robert Brown','Edmonton');
insert into health_care_provider values (489456,'Linda Davis','Edmonton'); 
insert into health_care_provider values (287321,'Michael Miller','Toronto');
insert into health_care_provider values (248965,'Barbara Wilson','Toronto'); 
insert into health_care_provider values (159542,'William Moore','Toronto');
insert into health_care_provider values (486512,'David Anderson','Victoria'); 
insert into health_care_provider values (619023,'Jennifer Thomas','Ottawa'); 
insert into health_care_provider values (489221,'Richard Jackson','Winnipeg'); 
insert into health_care_provider values (548977,'Ulysses Teach','Regina'); 
insert into health_care_provider values (487552,'Barak Jacob','Victoria');
insert into health_care_provider values (334051,'Lucas Zamprogno','Ottawa');
insert into health_care_provider values (472122,'Vanessa Aeschbach','Regina');
insert into health_care_provider values (163784,'Varoon Mathur','Winnipeg');

insert into family_physician values (242518); 
insert into family_physician values (911564); 
insert into family_physician values (254099); 
insert into family_physician values (489456); 
insert into family_physician values (248965); 
insert into family_physician values (486512); 
insert into family_physician values (619023); 
insert into family_physician values (489221); 
insert into family_physician values (548977);

insert into specialist values (141582,'Mary Johnson',10);
insert into specialist values (356187,'Robert Brown',12);
insert into specialist values (287321,'Michael Miller',12);
insert into specialist values (159542,'William Moore',8);
insert into specialist values (487552,'Barak Jacob',2);
insert into specialist values (334051,'Lucas Zamprogno',0);
insert into specialist values (472122,'Vanessa Aeschbach',8);
insert into specialist values (163784,'Varoon Mathur',1);

insert into patient_registered values(160839453,'Charles Harris','Vancouver',242518 );
insert into patient_registered values(199354543,'Susan Martin','Montreal', 242518);
insert into patient_registered values(112348546,'Joseph Thompson','Vancouver',242518);
insert into patient_registered values(115987938,'Christopher Garcia','Edmonton',242518);
insert into patient_registered values(132977562,'Angela Martinez','Victoria',911564);
insert into patient_registered values(269734834,'Thomas Robinson','Toronto',911564);
insert into patient_registered values(280158572,'Margaret Clark','Toronto',486512);
insert into patient_registered values(301221823,'Juan Rodriguez','Regina',486512);
insert into patient_registered values(318548912,'Dorthy Lewis','Montreal',911564);
insert into patient_registered values(320874981,'Daniel Lee','Vancouver',242518);
insert into patient_registered values(322654189,'Lisa Walker','Vancouver',242518);
insert into patient_registered values(348121549,'Paul Hall','Winnipeg',548977);
insert into patient_registered values(351565322,'Nancy Allen','Vancouver',548977);
insert into patient_registered values(451519864,'Mark Young','Ottawa',486512);
insert into patient_registered values(455798411,'Luis Hernandez','Edmonton',486512);
insert into patient_registered values(462156489,'Donald King','Victoria',548977);
insert into patient_registered values(550156548,'George Wright','Toronto',548977);
insert into patient_registered values(552455318,'Ana Lopez','Edmonton',242518);
insert into patient_registered values(556784565,'Kenneth Hill','Winnipeg',548977);
insert into patient_registered values(567354612,'Karen Scott','Montreal',242518);
insert into patient_registered values(573284895,'Steven Green','Winnipeg',548977);
insert into patient_registered values(574489456,'Betty Adams','Vancouver',548977);
insert into patient_registered values(578875478,'Edward Baker','Ottawa',242518);

-- HEALTH CARE RECORD
-- IS ON

insert into has_appointment values (160839453,242518,'2016/23/11','13:00');
insert into has_appointment values (199354543,242518,'2016/25/12','15:00');
insert into has_appointment values (112348546,242518,'2016/21/11','17:00');
insert into has_appointment values (115987938,242518,'2017/01/01','09:00');
insert into has_appointment values (320874981,242518,'2017/29/11','11:30');
insert into has_appointment values (578875478,242518,'2017/03/04','12:15');
insert into has_appointment values (567354612,242518,'2016/04/11','18:30');
insert into has_appointment values (322654189,242518,'2017/21/02','13:45');
insert into has_appointment values (552455318,242518,'2017/15/07','20:00');
insert into has_appointment values (552455318,141582,'2017/15/07','20:00');


insert into waitlist values('Vancouver', 'Cardiology');
insert into waitlist values('Vancouver', 'Oncology');
insert into waitlist values('Vancouver', 'Podiatry');
insert into waitlist values('Vancouver', 'Radiology');
insert into waitlist values('Vancouver', 'Surgery');
insert into waitlist values('Edmonton', 'Cardiology');
insert into waitlist values('Edmonton', 'Oncology');
insert into waitlist values('Edmonton', 'Podiatry');
insert into waitlist values('Edmonton', 'Radiology');
insert into waitlist values('Edmonton', 'Surgery');
insert into waitlist values('Regina', 'Cardiology');
insert into waitlist values('Regina', 'Oncology');
insert into waitlist values('Regina', 'Podiatry');
insert into waitlist values('Regina', 'Radiology');
insert into waitlist values('Regina', 'Surgery');
insert into waitlist values('Winnipeg', 'Cardiology');
insert into waitlist values('Winnipeg', 'Oncology');
insert into waitlist values('Winnipeg', 'Podiatry');
insert into waitlist values('Winnipeg', 'Radiology');
insert into waitlist values('Winnipeg', 'Surgery');
insert into waitlist values('Toronto', 'Cardiology');
insert into waitlist values('Toronto', 'Oncology');
insert into waitlist values('Toronto', 'Podiatry');
insert into waitlist values('Toronto', 'Radiology');
insert into waitlist values('Toronto', 'Surgery');
insert into waitlist values('Montreal', 'Cardiology');
insert into waitlist values('Montreal', 'Oncology');
insert into waitlist values('Montreal', 'Podiatry');
insert into waitlist values('Montreal', 'Radiology');
insert into waitlist values('Montreal', 'Surgery');
insert into waitlist values('Victoria', 'Cardiology');
insert into waitlist values('Victoria', 'Oncology');
insert into waitlist values('Victoria', 'Podiatry');
insert into waitlist values('Victoria', 'Radiology');
insert into waitlist values('Victoria', 'Surgery');
insert into waitlist values('Ottowa', 'Cardiology');
insert into waitlist values('Ottowa', 'Oncology');
insert into waitlist values('Ottowa', 'Podiatry');
insert into waitlist values('Ottowa', 'Radiology');
insert into waitlist values('Ottowa', 'Surgery');

-- TAKES

insert into medication values ('Morpine', 80);
insert into medication values ('Statin', 80);
insert into medication values ('Abraxane', 80);
insert into medication values ('luliconazole', 80);
insert into medication values ('Gravol', 80);
insert into medication values ('Morpine', 100);
insert into medication values ('Statin', 100);
insert into medication values ('Abraxane', 100);
insert into medication values ('luliconazole', 100);
insert into medication values ('Gravol', 100);
insert into medication values ('Morpine', 120);
insert into medication values ('Statin', 120);
insert into medication values ('Abraxane', 120);
insert into medication values ('luliconazole', 120);
insert into medication values ('Gravol', 120);

-- PRESCRIBE
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
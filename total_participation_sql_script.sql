--
-- Group Members: Varoon Mathur, Barak Jacob, Lucas Zamprogno
--
-- This script will run on the initialization of the Database for our CPSC 304 Project
--
--
--
-- First drop any existing tables


drop table family_physician;
drop table specialist;
drop table health_care_record;
drop table has_appointment;
drop table waitlist;
drop table is_on;
drop table medication;
drop table takes;
drop table prescribes;
drop table health_care_provider;
drop table patient_registered;


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
    familyPhysician number(9,0),
    foreign key(familyPhysician) references family_physician(hid)
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



insert into patient_registered values(160839453,'Charles Harris','Vancouver');
insert into patient_registered values(199354543,'Susan Martin','Montreal');
insert into patient_registered values(112348546,'Joseph Thompson','Vancouver'));
insert into patient_registered values(115987938,'Christopher Garcia','Edmonton');
insert into patient_registered values(132977562,'Angela Martinez','Victoria');
insert into patient_registered values(269734834,'Thomas Robinson','Toronto');
insert into patient_registered values(280158572,'Margaret Clark','Toronto');
insert into patient_registered values(301221823,'Juan Rodriguez','Regina');
insert into patient_registered values(318548912,'Dorthy Lewis','Montreal');
insert into patient_registered values(320874981,'Daniel Lee','Vancouver'));
insert into patient_registered values(322654189,'Lisa Walker','Vancouver'));
insert into patient_registered values(348121549,'Paul Hall','Winnipeg');
insert into patient_registered values(351565322,'Nancy Allen','Vancouver'));
insert into patient_registered values(451519864,'Mark Young','Ottawa');
insert into patient_registered values(455798411,'Luis Hernandez','Edmonton');
insert into patient_registered values(462156489,'Donald King','Victoria');
insert into patient_registered values(550156548,'George Wright','Toronto');
insert into patient_registered values(552455318,'Ana Lopez','Edmonton');
insert into patient_registered values(556784565,'Kenneth Hill','Winnipeg');
insert into patient_registered values(567354612,'Karen Scott','Montreal');
insert into patient_registered values(573284895,'Steven Green','Winnipeg');
insert into patient_registered values(574489456,'Betty Adams','Vancouver'));
insert into patient_registered values(578875478,'Edward Baker','Ottawa');


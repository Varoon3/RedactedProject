--
-- Group Members: Varoon Mathur, Barak Jacob, Lucas Zamprogno
--
-- This script will run on the initialization of the Database for our CPSC 304 Project
--
--
--
-- First drop any existing tables

drop table family_physician ;





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
    availability boolean,
    foreign key(hid) references health_care_provider
         ON DELETE cascade
    );
create table patient_registered(
    carecardNum number(9,0) primary key,
    name varchar2(30),
    location varchar2(100)
         ON DELETE SET NULL
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


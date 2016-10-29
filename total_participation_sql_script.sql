/* Database Script for TOTAL PARTICIPATION
   
   Group Members: Varoon Mathur, Barak Jacob, Lucas Zamprogno

   This script will run on the initialization of the Database for our CPSC 304 Project

*/

-- First drop any existing tables
drop table health_care_provider cascade constraints;
drop table family_physician cascade constraints;
drop table specialist cascade constraints;
drop table patient_registered cascade constraints;
drop table health_care_record cascade constraints;
drop table has_appointment cascade constraints;
drop table is_on cascade constraints;
drop table waitlist cascade constraints;
drop table takes cascade constraints;
drop table medication cascade constraints;
drop table prescribes cascade constraints;

-- Now we create the tables again
create table health_care_provider(
	hid integer primary key,
	name char(30),
	location char(100)
	);
create table family_physician(
    hid integer primary key,
    foreign key(hid) references health_care_provider(hid)
        ON DELETE cascade
        ON UPDATE cascade
    );
create table specialist(
    hid integer primary key,
    speciality char(0),
    availability integer,
    foreign key(hid) references health_care_provider(hid)
         ON DELETE cascade
         ON UPDATE cascade
    );
create table patient_registered(
    carecardNum integer primary key,
    name char(30),
    location char(100)
         ON DELETE SET NULL
         ON UPDATE cascade
    );
create table health_care_record(
    carecardNum integer,
    rid integer,
    age integer,
    ethnicity char(20),
    geneticHistory(250),
    insruance char(50),
    medicalHistory char(250),
    primary key(carecardNum, rid),
    foreign key(hid) references health_care_provider(hid)
        ON DELETE cascade
        ON UPDATE cascade
    );
create table has_appointment(
    carecardNum integer,
    hid integer,
    date char(20),
    time char(20),
    primary key(carecardNum, hid),
    foreign key(carecardNum) references patient_registered(carecardNum)
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(hid) references health_care_provider(hid)
        ON DELETE cascade
        ON UPDATE cascade
    );
create table is_on(
    carecardNum integer,
    speciality char(20),
    region char(20),
    patientPrioritynum integer,
    timeOfEntry char(20),
    date char(20),
    primary key(carecardNum, speciality, region),
    foreign key(carecardNum) references patient_registered(carecardNum)
        ON DELETE cascade
        On UPDATE cascade,
    foreign key(speciality) references waitlist(speciality)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    foreign key(region) references waitlist(region)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
    );
create table waitlist(
    region char(20),
    speciality char(20),
    primary key(region, speciality)
    );
create table takes(
    carecardNum integer,
    medName char(20),
    dose integer,
    primary key(carecardNum, medName, dose)
    foreign key(carecardNum) references patient_registered(carecardNum)
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(medName) references medication(medName)
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(dose) references medication(dose)
        ON DELETE cascade
        ON UPDATE cascade
    );
create table medication(
    medName char(30),
    dose integer,
    primary key(name, dose)
    );
create table prescribes(
    hid integer,
    medName char(20)
    dose integer,
    primary key(hid, medName, dose),
    foreign key(hid) references health_care_provider(hid)
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(medName) references medication(medName)
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(dose) references medication(dose)
        ON DELETE cascade
        ON UPDATE cascade
    );

-- Now adding tuples

insert into health_care_provider values (242518,'James Smith','Vancouver'); --
insert into health_care_provider values (141582,'Mary Johnson','Vancouver');
insert into health_care_provider values (811564,'John Williams','Vancouver'); --
insert into health_care_provider values (254099,'Patricia Jones','Montreal'); --
insert into health_care_provider values (890873,'Elizabeth Taylor','Montreal');
insert into health_care_provider values (356187,'Robert Brown','Edmonton');
insert into health_care_provider values (489456,'Linda Davis','Edmonton'); --
insert into health_care_provider values (287321,'Michael Miller','Toronto');
insert into health_care_provider values (248965,'Barbara Wilson','Toronto'); --
insert into health_care_provider values (159542,'William Moore','Toronto');
insert into health_care_provider values (486512,'David Anderson','Victoria'); --
insert into health_care_provider values (619023,'Jennifer Thomas','Ottawa'); --
insert into health_care_provider values (489221,'Richard Jackson','Winnipeg'); --
insert into health_care_provider values (548977,'Ulysses Teach','Regina'); --
insert into health_care_provider values (487552,'Barak Jacob','Victoria');
insert into health_care_provider values (334051,'Lucas Zamprogno','Ottawa');
insert into health_care_provider values (472122,'Vanessa Aeschbach','Regina');
insert into health_care_provider values (163784,'Varoon Mathur','Winnipeg');

insert into family_physician values (242518,'James Smith','Vancouver'); --
insert into family_physician values (911564,'John Williams','Vancouver'); --
insert into family_physician values (254099,'Patricia Jones','Montreal'); --
insert into family_physician values (489456,'Linda Davis','Edmonton'); --
insert into family_physician values (248965,'Barbara Wilson','Toronto'); --
insert into family_physician values (486512,'David Anderson','Victoria'); --
insert into family_physician values (619023,'Jennifer Thomas','Ottawa'); --
insert into family_physician values (489221,'Richard Jackson','Winnipeg'); --
insert into family_physician values (548977,'Ulysses Teach','Regina');

insert into specialist values (141582,'Mary Johnson','Vancouver');
insert into specialist values (390873,'Elizabeth Taylor','Montreal');
insert into specialist values (356187,'Robert Brown','Edmonton');
insert into specialist values (287321,'Michael Miller','Toronto');
insert into specialist values (159542,'William Moore','Toronto');
insert into specialist values (487552,'Barak Jacob','Victoria');
insert into specialist values (334051,'Lucas Zamprogno','Ottawa');
insert into specialist values (472122,'Vanessa Aeschbach','Regina');
insert into specialist values (163784,'Varoon Mathur','Winnipeg');

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

-- HEALTH CARE RECORD
-- HAS APPOINTMENT
-- IS ON
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







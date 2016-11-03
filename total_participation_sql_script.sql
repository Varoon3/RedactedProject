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


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
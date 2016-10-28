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
	location, char(100)
	);
create table family_physician(
    hid integer, primary key,
    foreign key(hid) references health_care_provider
        ON DELETE cascade
        ON UPDATE cascade
    );
create table specialist(
    hid integer, primary key,
    speciality char(0),
    availability integer,
    foreign key(hid) references health_care_provider
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
    foreign key(hid) references health_care_provider
        ON DELETE cascade
        ON UPDATE cascade
    );
create table has_appointment(
    carecardNum integer,
    hid integer,
    date char(20),
    time char(20),
    primary key(carecardNum, hid),
    foreign key(carecardNum) references patient_registered
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(hid) references health_care_provider
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
    foreign key(carecardNum) references patient_registered
        ON DELETE cascade
        On UPDATE cascade,
    foreign key(speciality) references waitlist
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    foreign key(region) references waitlist
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
    foreign key(carecardNum) references patient_registered
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(medName) references medication
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(dose) references medication
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
    foreign key(hid) references health_care_provider
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(medName) references medication
        ON DELETE cascade
        ON UPDATE cascade,
    foreign key(dose) references medication
        ON DELETE cascade
        ON UPDATE cascade
    );

-- Now adding tuples








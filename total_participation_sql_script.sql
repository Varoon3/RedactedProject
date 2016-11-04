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
    insurance varchar2(50),
    geneticHistory varchar2(250),
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
insert into patient_registered values(199354543,'Susan Martin','Montreal', 254099);
insert into patient_registered values(112348546,'Joseph Thompson','Vancouver',242518);
insert into patient_registered values(115987938,'Christopher Garcia','Edmonton',356187);
insert into patient_registered values(132977562,'Angela Martinez','Victoria',486512);
insert into patient_registered values(269734834,'Thomas Robinson','Toronto',287321);
insert into patient_registered values(280158572,'Margaret Clark','Toronto',248965);
insert into patient_registered values(301221823,'Juan Rodriguez','Regina',548977);
insert into patient_registered values(318548912,'Dorthy Lewis','Montreal',254099);
insert into patient_registered values(320874981,'Daniel Lee','Vancouver',141582);
insert into patient_registered values(322654189,'Lisa Walker','Vancouver',141582);
insert into patient_registered values(348121549,'Paul Hall','Winnipeg',548977);
insert into patient_registered values(351565322,'Nancy Allen','Vancouver',811564);
insert into patient_registered values(451519864,'Mark Young','Ottawa',619023);
insert into patient_registered values(455798411,'Luis Hernandez','Edmonton',356187);
insert into patient_registered values(462156489,'Donald King','Victoria',487552);
insert into patient_registered values(550156548,'George Wright','Toronto',159542);
insert into patient_registered values(552455318,'Ana Lopez','Edmonton',489456);
insert into patient_registered values(556784565,'Kenneth Hill','Winnipeg',548977);
insert into patient_registered values(567354612,'Karen Scott','Montreal',911564);
insert into patient_registered values(573284895,'Steven Green','Winnipeg',548977);
insert into patient_registered values(574489456,'Betty Adams','Vancouver',811564);
insert into patient_registered values(578875478,'Edward Baker','Ottawa',334051);

insert into health_care_record values(160839453, 1, 80, 'Caucasian', 'Great West','ATAGCAAGACCCTGCCTCTCTATTGATGTCACGGCGAATGTCGGGGAGACAGCAGCGGCTGCAGACATCAGATCGGAGTAATACTAACGTGGGATAACTCCGTAACTGACTACGGCCTTCTCTAGACTTTACTTGACCAGATACGCTGTCTTTGGCACGTGGATGGTTTAGAGGAATCACATCCAAGACTGGCTAAGCACGAAGCAACTCTTGAGTGTAAAATTGTTGTCTCCTGTATTCGGGATGCGGG');
insert into health_care_record values(199354543, 2, 76, 'Hispanic',, 'Great West' 'TACTAGATGACTGCAGGGACTCCGACGTTAAGTACATTACCCCGTCATAGGCGCCGTTCAGGATCACGTTACCGCCATAAGATGGGAGCATGACTTCTTCTCCGCTGCGCCCACGCCAGTAGTGATTACTCCTATAACCCTTCTGAGAGTCCGGAGGCGGAAATCCGCCACGAATGAGAATGTATTTCCCCGACAATCATTATGGGGCGCTCCTAAGCTTTTCCACTCGGTTGAGCCGGCTAGGCCTCTC');
insert into health_care_record values(112348546, 3, 75, 'Caucasian', 'Manulife','TGCCCGGAGTTTCGACGGACTGCTGCCGACACCCGGGCATTGTTTTAGGGGGGTTATTCGAGGGCACTCGCAGCCAACTTGTCGGGACCAGCCGGGCTGGTCATCGGGCTTATATAGCGAAATGCCGAGGACCCGGCCCCACGCTATGGAACGTCTTTAGCTCCGGCAGGCAATTAAGGACAACGTAAGTATGGCGGATATAAACAGAGAAACGGGCGAATATACCTATTCGTATCGTATCGGTAAATAG');
insert into health_care_record values(115987938, 4, 72, 'Asian', 'Blue Cross','CCTCGCGGAGGCATGTGCCATGCTAGCCTGCGGAGCACTCTAGTTATGCATATGGTCCACAGGACACTCGTCGCTTTCGGATTTGCCCTCTATGTGACGGTTTTTAGGCGCACTTATGCTCAGCACCGTTTAAACCAGACCGACACTAGATCTATAAGGTCCGCCACGCAGACGAGAGCGCACGGAGATCACCGAGCGATCTATCTGATCGGCGACCATTTGTGTGGTACTGGGGCCGAGAGGTAACTAC');
insert into health_care_record values(132977562, 5, 69, 'Arabic', 'Manulife','GGTGCCGCTAACAACCTCTCGGTCGTCGCTGACGTTTGTAGTCTAGTCTCATTATGATCGTACGCTATTCAGGGATTGACTGATACCGGAAGACATCTCAGTTGAAGTGGTGTATACGACAGAGACCGTGCACCTACCAAACCTCCTTAGTCTAAGTTCAGACCAATTGGTAGTTTGTCCAGAACTCAGATTTTATCACCAGAGGACGCACGCTCTACCTTTATGATCCATTGATGTCCCTGAGGCTGCA');
insert into health_care_record values(269734834, 6, 67, 'Caucasian', 'Great West','ATACATGCAACCAGGCAGTCTTCGCGGTAAGTCCTAGTGCAATGGGGCTTTTTTTCCTTGGTCCTCGAGAAGAGGAGACGTCAGTCCAGATATCTTTAATGTGGTAATTGGAAGGACTCTTGGCCCTCCACCCTTAGGCAGTGTATACTCTTCCATAAACGGGCTATTAGTTATGGGGTCCGAAGATTGAAAAAGGTGAGCGAACTCGGCCGAACCGGAAAGACGGGCTTCAAAGCAACCTGACCACGGT');
insert into health_care_record values(280158572, 7, 62, 'Caucasian', 'Manulife','TGCGCGTCCGTATCAAGATCCTCTTAATAAGCCCCCGTCACTGTTGGTTGTAGAGCCCAGGACGGGTTGGCCAGATGTGCGACTATATCGCTTAGTGGCTCTTGGGCCGCGGTGCGTTACCTTGCAGGAATTGAGGCCGTCCGTTAATTTCCCTTGCATACATATTGCGTTTTTTTGTCCTTTTATCCGCTCACTTAGAAAAGAGACAGATAGCTTCTTACCGGTGCGCCTCCGTACGCAGTACGATCGC');
insert into health_care_record values(301221823, 8, 58, 'Indigenous', 'Great West','ACGCCCCATGAGAACGATAGGTAAACCTGGTGTCCTGTGAGCGACAAAAGCTTAAATGGGAAATACGCGGCCATAAGTCGGTGCGAATACGGGTCGTAGCAATGTTGGTCTGACTATGATCTACATATTACAGGCGGTACGTCTGCTCTGGTCAGCCTCTAATGGCTCGTAAGATAGTGCAGCCGCTGGTGATCACTCGATGACCTCGGCTCCCCATTGCTACTACGGCGATTCTTGGAGAGCCAGCTGC');
insert into health_care_record values(318548912, 9, 52, 'Asian', 'Blue Cross','GTTCGCTAATGTGAGGACAGTGTAGTATTAGCAAACGATAAGTCCCCAACTGGTTGTGGCCTATCGAAAAGTGAACTTCATAACACATGCTGTCCCACGCACATGGATGATTTGGACAAATTTGATTCGAGTCTGATCAACCTTCACACAGATCTAGAATCGAAAGCAGTGATCTCCCGGGTGCGAAATAAAAATACTAGGTAACTAGAGGGTCTGCGACGTTCTAAACGTTGGTCCGTCTGAACCGCCA');
insert into health_care_record values(320874981, 10, 49, 'Indigenous', 'Blue Cross','TCCGGGGCCAAAGACAACCAGCATCTCGCGTCTTGCCTAACCCCCCTACATGCTGTTATAGAGAATCAGTGGAAACCCGGTGCCAGGCGATGGAATGTCCTTAACTCTGGCAGGAAATTAAAGGGAACGTATATACAACGCAAAGAAGCTGGAAAATTGGCGAGGGAATCCTGTTTCTGTCTATCCAAGAATGGGCATGAGGTGGCAACCGTCGTGCTAGCGTACAGGGTGCACTTTGTAACCATTTGGG');
insert into health_care_record values(322654189, 11, 47, 'Caucasian', 'Great West','ACACCGGACACTCGCTGTTTTCGAAATTACCCTTTAAGCGCGGGTATTGAACCAGGCTTATGCCCAAGATCGTAGCAAGCAGACTCAAACAAGATATATTTTGCCCGCCTTACAGACGAAACTAGTTGGAGGTTATGGAGCATACTATCACGTGGGCGGCCACTGGTGAGTTACTACACCCCAGGGGCAACGTTGATGCTCCTAAAAAACTCTGGCTGGACGCAAGCCGTAACACCCGTGTCACTTCATA');
insert into health_care_record values(348121549, 12, 42, 'Caucasian', 'Manulife','ATCGTTTGCAATTCAGGGCTTGATCTACACTGGATTGCCATTCTCTCAAAGTATTATGCAGGACGGCGTGCGCGTTCCATGTAAACCTGTCATAACTTACCTGAGACTAGTTGGAAGTGTGGCTAGATCTTTGCTCACGCATCTAGTCGGTCCACGTTTGGTTTTTAAGATCCAATGATCTTCAAAACGCTGCAAGATTCTCAACCTGCTTTACTAAGCGCTGGGTCCTACTCCAGCGGGATTTTTTATC');
insert into health_care_record values(351565322, 13, 37, 'Arabic', 'Blue Cross','TAAAGACGATGAGAGGAGTATTCGTCAGACCACATAGCTTTCATGTCCTGATCGGAAGGATCGTTGGCGCCCGACCCTCAGACTCTGTAGTGAGTTCTATGTCCGAGCCATTGCATGCGAGATCGGTAGATTGATAGGGGATACAGAATATCCCTGGATGCAATAGACGGACAGCTTGGTATCCTAAGCGTAGTCGCGCGTCCGAACCCAGCTCTACTTTAGAGGCCTCGGATTCTGGTGCCCGCAGGCC');
insert into health_care_record values(451519864, 14, 35, 'Asian', 'Blue Cross','GCAGAACCGATTAGGGGCATGTACAACAATATTTATTAGTCACCTTTGAGACACGATCTCCCACCTCACTGGAATTTAGTTCCTGCTATAATTAGCCTTCCTCATAAGTTGCATTACTTCAGCGTCCCAACTGCACCCTTACCACGAAGACAGGTTTGTCCATTCCCATACTGCGGCGTTGGCAGGGGGTTCGCATGTCCCACGCGAAACGTTGCTGAAGGCTCAGGTTTCTGAGCGACAAAAGCTTTAA');
insert into health_care_record values(455798411, 15, 32, 'Hispanic', 'Great West','ACGCGAGTTCCCGCTCATAACTTGGTCCGAATGCGGGTTCTTGCATCGTTCCACTGAGTTTGTTTCATGTAGGACGGGCGCAAAGTATACTTAGTTCAATCTTCAATACCTTGTATTATTGTACACCTACCGGTCACCAGCCAACAATGTGCGGACGGCGTTGCAACTTCCAGGGCCTAATCTGACCGTCCTAGATACGGCACTGTGGGCAATACGAGGTAATGGCAGACACCCAGTGTCGAACAACACC');
insert into health_care_record values(462156489, 16, 28, 'Arabic', 'Manulife','TGACCTAACGGTAAGAGAGTCACATAATGCCTCCGGCCGCGTGCCCAGGGTATATTTGGTCAGTATCGAATGGACTGAGATGAATCTTTACACCGAAGCGGAAACGGGTGCGTGGACTAGCCAGGAGCAAACGAAAAATCCTGGCCTGCTTGATGTCTCGTAACGTTCTTAGAGATGGACGAAATGTTTCACGACCTAGGAAAAGGTCGCCCTACAAAATAGATTTGTGCTACTCTCCTCATAAGGAGTC');
insert into health_care_record values(550156548, 17, 23, 'Indigenous', 'Blue Cross','CGGTGTACCGAAAGAACAAGGCGAGCCTAGGTAGCAACCGCCGGCTACGGGGGTAAGGTATCACTCAAGAAGCAGGCTCGGTAACACACGGTCTAGCTGACTGTCTATCGCCTAGGTCATATAGGGACCTTTGATATCTGCATGTCCAGCCTTAGAATTCACTTCAGCGCGCAGGTTTGGGTCGAGATAAAATCACCAGTACCCAAGACCAGGGGGGCTCGGCGCGTTGGCTAATCCTGGTACATCTTGT');
insert into health_care_record values(552455318, 18, 21, 'Caucasian', 'Manulife','TATGAATATTCAGTAGAAAATCTGTGTTAGAGGGACGAGTCACCATGTACCAAAAGCGATATTAATCGGTGGGAGTATTCATCGTGGTGAAGACGCTGGGTTTACGTGGGAAAGGTGCTTGTGTCCCAACAGGCTAGGATATAATGCTGAAACCGTCCCCCAAGCGTTCAGGGTGGGGTTTGCTACAACTTCCGAGTCCAATGTGTCCGTGTTCATGATATATATGCTCAAGGGCGAGAATTGGACCTAG');
insert into health_care_record values(556784565, 19, 17, 'Asian', 'Blue Cross','CTTTCGTGTTAGTACGTAGCATGGTGACACAAGCACAGTAGATCCTGCCCGCGTATCCTATATATTAAGTTAATTCTTATGGAATATAATAACATGTGGATGGCCAGTGGTCGGTTGTTACACGCCTACCGCGATGCTGAATGACCCGGACTAGAGTGGCGAAATTTATGGCGTGTGACCCGTTATGCTCCATTTCGGTCAGTGGGTCATTGCTAGTAGTCGATTGCATTGCCATTCTCCGAGTGATTTA');
insert into health_care_record values(567354612, 20, 13, 'Hispanic', 'Great West','GCGTGACAGCCGCAGGGAACCCATAAAATGCAATCGTAGTCCACCTGATCGTACTTAGAAATGAGGGTCCCCTTTTGCCCACGCACCTGTTCGCTCGTCGTTTGCTTTTAAGAACCGCACGAACCACAGAGCATAAAGAGAACCTCTAGCTCCTTTACAAAGTACTGGTTCCCTTTCCAGCGGGATGCCTTATCTAAACGCAATGACAGACGTATTCCTCAGGCCACATCGCTTCCTACTTCCGCTGGGA');
insert into health_care_record values(573284895, 21, 9, 'Indigenous', 'Blue Cross','TCCATCATTGGCGGCCGAAGCCGCCATTCCATAGTGAGTCCTTCGTCTGTGTCTTTCTGTGCCAGATCGTCTAGCAAATTGCCGATCCAGTTTATCTCACGAAACTATAGTCGTACAGACCGAAATCTTAAGTCAAATCACGCGACTAGGCTCAGCTCTATTTTAGTGGTCATGGGTTTTGGTCCGCCCGAGCGGTGCAACCGATTAGGACCATGTAAAACATTTGTTACAAGTCTTCTTTTAAACACAA');
insert into health_care_record values(574489456, 22, 6, 'Caucasian', 'Blue Cross','TCTTCCTGCTCAGTGGCGCATGATTATCGTTGTTGCTAGCCAGCGTGGTAAGTAACAGCACCACTGCGAGCCTAATGTGCCCTTTCCACGAACACAGGGCTGTCCGATCCTATATTAGGACTCCGCAATGGGGTTAGCAAGTCGCACCCTAAACGATGTTGAAGACTCGCGATGTACATGCTCTGGTACAATACATACGTGTTCCGGCTGTTATCCTGCATCGGAACCTCAATCATGCATCGCACCAGCG');
insert into health_care_record values(578875478, 23, 3, 'Asian', 'Blue Cross','TATTCGTGTCATCTAGGAGGGGCGCGTAGGATAAATAATTCAATTAAGATGTCGTTATGCTAGTATACGCCTACCCGTCACCGGCCATCTGTGTGCAGATGGGGCGACGAGTTACTGGCCCTGATTTCTCCGCTTCTAATACCACACACTGGGCAATACGAGCTCAAGCCAGTCTCGCAGTAACGCTCATCAGCTAACGAAAGAGTTAGAGGCTCGCTAATTCGCACTGTCGGGGTCCCTTGGGTGTTTT');

-- IS ON (cc#, region, specialty, pos, date, time)
insert into is_on values (160839453, 'Vancouver', 'Cardiology', 1, '2011/03/01', '09:00');
insert into is_on values (112348546, 'Vancouver', 'Cardiology', 2, '2012/27/04', '13:00');
insert into is_on values (320874981, 'Vancouver', 'Cardiology', 3, '2015/13/11', '13:45');
insert into is_on values (160839453, 'Vancouver', 'Oncology', 1, '2012/19/12', '20:00');
insert into is_on values (322654189, 'Vancouver', 'Oncology', 2, '2013/06/13', '11:30');
insert into is_on values (351565322, 'Vancouver', 'Oncology', 3,'2014/28/07' , '17:00');
insert into is_on values (115987938, 'Edmonton', 'Cardiology', 1, '2013/14/11', '18:30');
insert into is_on values (556784565, 'Winnipeg', 'Radiology', 1, '2015/19/03', '15:00');
insert into is_on values (578875478, 'Ottawa', 'Podiatry', 1, '2013/01/02', '15:00');
insert into is_on values (578875478, 'Winnipeg', 'Podiatry', 2, '2015/08/10', '13:00');
insert into is_on values (574489456, 'Vancouver', 'Podiatry', 1, '2013/19/01', '09:00');
insert into is_on values (573284895, 'Winnipeg', 'Podiatry', 1, '2015/23/08', '11:30');
insert into is_on values (301221823, 'Regina', 'Surgery', 1, '2014/23/09', '20:00');
insert into is_on values (462156489, 'Victoria', 'Oncology', 1, '2015/27/03', '13:00');
insert into is_on values (301221823, 'Regina', 'Cardiology', 1, '2012/30/11', '13:45');
insert into is_on values (462156489, 'Victoria', 'Surgery', 1, '2014/04/06', '09:00');
insert into is_on values (567354612, 'Montreal', 'Surgery', 1, '2015/13/08', '18:30');
insert into is_on values (199354543, 'Montreal', 'Radiology', 1, '2015/15/01', '13:00');
insert into is_on values (451519864, 'Ottawa', 'Surgery', 1, '2014/19/07', '17:00');

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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
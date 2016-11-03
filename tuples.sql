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
-- HAS APPOINTMENT
-- IS ON

insert into has_appointment values (160839453,242518,'23/11/2016','13:00');
insert into has_appointment values (199354543,242518,'25/12/2016','15:00');
insert into has_appointment values (112348546,242518,'21/11/2016','17:00');
insert into has_appointment values (115987938,242518,'01/01/2017','09:00');
insert into has_appointment values (320874981,242518,'29/11/2017','11:30');
insert into has_appointment values (578875478,242518,'03/04/2017','12:15');
insert into has_appointment values (567354612,242518,'04/11/2016','18:30');
insert into has_appointment values (322654189,242518,'21/02/2017','13:45');
insert into has_appointment values (552455318,242518,'15/07/2017','20:00');
insert into has_appointment values (552455318,141582,'15/07/2017','20:00');


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
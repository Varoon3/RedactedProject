insert into health_care_provider values (242518,'James Smith','Vancouver'); 
insert into health_care_provider values (141582,'Mary Johnson','Vancouver');
insert into health_care_provider values (811564,'John Williams','Vancouver'); 
insert into health_care_provider values (254099,'Patricia Jones','Montreal'); 
insert into health_care_provider values (890873,'Elizabeth Taylor','Montreal');
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

insert into family_physician values (242518,'James Smith','Vancouver'); 
insert into family_physician values (911564,'John Williams','Vancouver'); 
insert into family_physician values (254099,'Patricia Jones','Montreal'); 
insert into family_physician values (489456,'Linda Davis','Edmonton'); 
insert into family_physician values (248965,'Barbara Wilson','Toronto'); 
insert into family_physician values (486512,'David Anderson','Victoria'); 
insert into family_physician values (619023,'Jennifer Thomas','Ottawa'); 
insert into family_physician values (489221,'Richard Jackson','Winnipeg'); 
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
insert into patient_registered values(112348546,'Joseph Thompson','Vancouver');
insert into patient_registered values(115987938,'Christopher Garcia','Edmonton');
insert into patient_registered values(132977562,'Angela Martinez','Victoria');
insert into patient_registered values(269734834,'Thomas Robinson','Toronto');
insert into patient_registered values(280158572,'Margaret Clark','Toronto');
insert into patient_registered values(301221823,'Juan Rodriguez','Regina');
insert into patient_registered values(318548912,'Dorthy Lewis','Montreal');
insert into patient_registered values(320874981,'Daniel Lee','Vancouver');
insert into patient_registered values(322654189,'Lisa Walker','Vancouver');
insert into patient_registered values(348121549,'Paul Hall','Winnipeg');
insert into patient_registered values(351565322,'Nancy Allen','Vancouver');
insert into patient_registered values(451519864,'Mark Young','Ottawa');
insert into patient_registered values(455798411,'Luis Hernandez','Edmonton');
insert into patient_registered values(462156489,'Donald King','Victoria');
insert into patient_registered values(550156548,'George Wright','Toronto');
insert into patient_registered values(552455318,'Ana Lopez','Edmonton');
insert into patient_registered values(556784565,'Kenneth Hill','Winnipeg');
insert into patient_registered values(567354612,'Karen Scott','Montreal');
insert into patient_registered values(573284895,'Steven Green','Winnipeg');
insert into patient_registered values(574489456,'Betty Adams','Vancouver');
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

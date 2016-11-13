-- HCP
	-- Get patient HCR
	SELECT *
	FROM health_care_record
	WHERE carecardNum = CCN_HERE
	ORDER BY carecardNum;

	-- Update patient medical history
	UPDATE health_care_record
	SET -- We need to decide what's being updated...
	WHERE carecardNum = CCN_HERE;

	-- Create appointment
	insert into has_appointment values (CCN_HERE, HID_HERE,'DATE_HERE','TIME_HERE');

	-- Remove appointment
	DELETE FROM has_appointment
	WHERE carecardNum = CCN_HERE AND hid = HID_HERE;

	-- Find all patients with related genome substring
	SELECT p.name, p.carecardNum
	FROM patient_registered p, health_care_record h
	WHERE p.carecardNum = h.carecardNum AND h.geneticHistory LIKE '%SUBSTRING_HERE%'
	ORDER BY p.carecardNum;

-- Family physician
	-- Get all patients registered with
	SELECT DISTINCT p.name, p.carecardNum
	FROM patient_registered p
	WHERE p.hid = HID_HERE
	ORDER BY p.carecardNum;

	-- Add patient to waitlist
	UPDATE is_on
	SET patientPriorityNum = patientPriorityNum + 1
	WHERE patientPriorityNum >= PRIORITY_HERE AND region = 'REGION_HERE' AND speciality = 'SPEC_HERE';
		-- then do 
	insert into is_on values(CCN_HERE, 'REGION_HERE', 'SPEC_HERE', PRIORITY_HERE, 'DATE_HERE', 'TIME_HERE');

	-- Register with patient
	UPDATE patient_registered
	SET hid = HID_HERE
	WHERE carecardNum = CCN_HERE;


-- Specialist
	-- Deletion of specific Patient
	DELETE FROM is_on
	WHERE carecardNum = CCN_HERE AND region = 'REGION_HERE' AND speciality = "SPEC_HERE";
		-- then do
	UPDATE is_on
	SET patientPriorityNum = patientPriorityNum - 1
	WHERE patientPriorityNum >= PRIORITY_HERE AND region = 'REGION_HERE' AND speciality = 'SPEC_HERE';

	-- Take the top priority patient off a waitlist
		-- Pull top priority patient from waitlist (to make an appointment with or something)
	SELECT p.carecardNum, p.name
	FROM patient p, is_on w -- w for "waitlist"
	WHERE p.carecardNum = w.carecardNum AND w.patientPriorityNum = 1 AND w.region = 'REGION_HERE' AND w.speciality = 'SPEC_HERE';
		-- then do
	DELETE FROM is_on
	WHERE carecardNum = CCN_HERE AND region = 'REGION_HERE' AND speciality = "SPEC_HERE";
		-- then do
	UPDATE is_on
	SET patientPriorityNum = patientPriorityNum - 1
	WHERE patientPriorityNum >= 1 AND region = 'REGION_HERE' AND speciality = 'SPEC_HERE';

	-- Create prescription
	insert into prescribes values (HID_HERE, 'DRUG_HERE', DOSE_HERE);

	-- Create new patient and HCR
	insert into patient_registered values(CCN_HERE,'NAME_HERE','LOC_HERE', NULL);
	insert into health_care_record values(CCN_HERE, RID_HERE, 0, 'ETH_HERE', 'INSURANCE_HERE', 'GENOME_HERE');
		-- Could we automate the genome? That would be sweet.

	-- Get the next RID to use
	SELECT MAX(RID) + 1 as nextRID
	FROM (SELECT RID FROM health_care_record);


-- Patient
	-- View medical history
	SELECT *
	FROM health_care_record
	WHERE carecardNum = ENTER_HERE;

	-- Retreive registered physician
	SELECT f.name
	FROM patient_registered p, family_physician f
	WHERE p.carecardNum = CCN_HERE AND p.hid = f.hid;

	-- View their prescriptions
	SELECT medName, dose
	FROM takes
	WHERE carecardNum = CCN_HERE;

	-- Get Priority # for patient on waitlist
	SELECT patientPriorityNum
	FROM is_on
	WHERE carecardNum = CCN_HERE AND region = 'REGION_HERE' AND speciality = 'SPEC_HERE';

-- Aggregate - general
	-- Find all patients taking each type of medications (will need to change tuples so someone does)
	SELECT p.name, p.carecardNum
	FROM patient_registered p
	WHERE NOT EXISTS ((SELECT DISTINCT medName FROM medication)
	MINUS
	(SELECT DISTINCT m.medName
	 FROM medication m, takes t
	 WHERE t.carecardNum = p.carecardNum AND m.medName = t.medName));

	-- Find medication with lowest dose
	SELECT medName, MAX(dose)
	FROM medication
	GROUP BY medName
	HAVING MAX(dose) = (SELECT MAX(dose) FROM medication);

	-- Find medication with highest dose
	SELECT medName, MIN(dose)
	FROM medication
	GROUP BY medName
	HAVING MIN(dose) = (SELECT MIN(dose) FROM medication);

	-- Number of patients by ethnicity
	SELECT ethnicity, COUNT(*)
	FROM health_care_record
	GROUP BY ethnicity
	ORDER BY COUNT(*);

	-- Average age of patients by ethnicity
	SELECT ethnicity, AVG(age)
	FROM health_care_record
	GROUP BY ethnicity
	ORDER BY AVG(age);
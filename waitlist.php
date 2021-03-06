<html>
 <head>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);
ul {
	/* list-style-type removes all bullet points from the list*/
	/* margin and padding removes default browser settings*/
	list-style-type: none;
	overflow: hidden;
	margin: 0;
	padding: 0;
	background-color: #00cccc ;
	font-family: "Roboto", sans-serif;
}

.item{
	float: left;
}

/* for each menu item/link */
.item a{
	color: white;
	/* make the whole area clickable, not just the text */
    display: block;
	/* spacing between each item*/
	padding: 6px;
	text-align: center;
	    text-decoration: none;
}

/* when hovering over an item */
.item a:hover{
	background-color:  #0028cc;
}

#logout{
	float:right;
}

#note{
	color:red;
}

table {
		margin: 25px auto;
		border-collapse: collapse;
		border: 1px solid #eee;
		border-bottom: 2px solid #00cccc;
		box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1), 0px 10px 20px rgba(0, 0, 0, 0.05), 0px 20px 20px rgba(0, 0, 0, 0.05), 0px 30px 20px rgba(0, 0, 0, 0.05);
	}
	table tr:hover {
		background: #f4f4f4;
	}
	table tr:hover td {
		color: #555;
	}
	table th, table td {
		color: #999;
		border: 1px solid #eee;
		padding: 12px 35px;
		border-collapse: collapse;
	}
	table th {
		background: #00cccc;
		color: #fff;
		text-transform: uppercase;
		font-size: 12px;
	}
	table th.last {
		border-right: none;
	}
	body{
		font-family: "Roboto", sans-serif;
	}

</style>
<body>

<p>



<hr>
<?php



echo "<ul>";
echo "<li class = \"item\"><a href=\"index.php\">My Appointments</a></li>";

if($_COOKIE["tbl"] == "patient_registered") {
    $tbl = "patient_registered";
	$field = "carecardNum";
	echo "<li class = \"item\"><a href=\"record.php\">My HCR</a></li>";
} else if ($_COOKIE["tbl"] == "family_physician") {
	$tbl = "Health_Care_Provider";
	$field = "hid";
	echo "<li class = \"item\"><a href=\"fp_view_two.php\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"analytics.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	echo "<li class = \"item\"><a href=\"allPrescriptions.php\">All Prescriptions</a></li>";
} else {
	$tbl = "Health_Care_Provider";
	$field = "hid";
	echo "<li class = \"item\"><a href=\"analytics.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	echo "<li class = \"item\"><a href=\"prescribe.php\">File Prescription</a></li>";
	echo "<li class = \"item\"><a href=\"allPrescriptions.php\">All Prescriptions</a></li>";
}
	
echo "<li class = \"item\" id = \"logout\"><a href=\"logout.php\">Log Out</a></li>";
echo "</ul>";

if($_COOKIE['tbl'] == "family_physician")
	createFormPhysician();
else
	$_POST['view'] = true;
echo "</br>";
$db_conn = OCILogon("ora_b2k0b", "a33405151", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){
	if(isset($_POST['modify'])){
		if($_COOKIE['tbl'] == "family_physician"){
			$id = $_POST['carecard'];
			$priority = $_POST['priority'];
			$region = $_COOKIE['region'];
			$speciality = $_COOKIE['speciality'];
			date_default_timezone_set("America/Vancouver");
			$date = date("Y/d/m");
			$time = date("H:i");
			//adding a patient to a certain waitlist, need to validate input before
			if(checkInput($id,$priority,$speciality,$region)){
				$result1 = executePlainSQL("UPDATE is_on SET patientPriorityNum = patientPriorityNum + 1 WHERE patientPriorityNum >= $priority AND region = '$region' AND speciality = '$speciality'");
				$result2 = executePlainSQL("insert into is_on values ($id,'$region', '$speciality', $priority ,'$date', '$time')");
				echo "<h4>Patient added successfuly to waitlist of " .$speciality. " in " .$region. " <h4>";
			}
			else{
				echo "Either this carecard number is not one of your patients or they are already on this list.";
			}
		} else {
			$region = $_COOKIE['region'];
			$speciality = $_COOKIE['speciality'];
			//SQL QUERIES - GETTING THE FIRST PRIORITY PATIENT OFF WAITLIST AND SCHEDULING AN APPOINTMENT WITH HIM/HER
			$result1 = executePlainSQL("SELECT p.carecardNum, p.name FROM patient_registered p, is_on w WHERE p.carecardNum = w.carecardNum AND w.patientPriorityNum = 1 AND w.region = '$region' AND w.speciality = '$speciality'");
			$result1After = executePlainSQL("SELECT p.carecardNum, p.name FROM patient_registered p, is_on w WHERE p.carecardNum = w.carecardNum AND w.patientPriorityNum = 1 AND w.region = '$region' AND w.speciality = '$speciality'");
			//need to validate that there is a person with first priority in this waitlist
				
				//need to save carecardNum and Name in order to book an appointment on a different page (cookie)
				$careCardNum = saveNameReturnId($result1After);
				$result2 = executePlainSQL("DELETE FROM is_on WHERE carecardNum = $careCardNum AND region = '$region' AND speciality = '$speciality'");
				$result3 = executePlainSQL("UPDATE is_on SET patientPriorityNum = patientPriorityNum - 1 WHERE patientPriorityNum >= 1 AND region = '$region' AND speciality = '$speciality'");
				OCICommit($db_conn);
				OCILogoff($db_conn);
			    header("Location:bookAppointment.php");
			
			
		}
	}
	else if(array_key_exists('view',$_POST)){
		if($_COOKIE['tbl'] == "family_physician"){
			$speciality = $_POST['speciality'];
			$region = $_POST['region'];
		}
		else{
			$speciality = getSpeciality();
			$region = getRegion();
		}
			
	
		
		setcookie('speciality', $speciality);
		setcookie('region', $region);
		$result = executePlainSQL("select i.carecardNum, p.name, i.patientPriorityNum, i.dateOfEntry, i.timeOfEntry from is_on i, patient_registered p where i.speciality = '$speciality' AND i.region='$region' AND i.careCardNum = p.careCardNum ORDER BY patientPriorityNum");
		$resultAfter = executePlainSQL("select i.carecardNum, p.name, i.patientPriorityNum, i.dateOfEntry, i.timeOfEntry from is_on i, patient_registered p where i.speciality = '$speciality' AND i.region='$region' AND i.careCardNum = p.careCardNum ORDER BY patientPriorityNum");	
		echo "</br>";
		if(validateResult($result)){
			printWaitlist($resultAfter, $speciality, $region);
			if($_COOKIE['tbl'] == "specialist") {
				echo "<h4> Remove patient </h4>";
				echo "<form method = \"POST\" action=\"waitlist.php\">";
				echo "<input type=\"submit\" value=\"Book an appointment\" name=\"modify\" >";
				echo "</form>";
			}
		}
		else
				echo "Waitlist is currently empty.";
		
		if($_COOKIE['tbl'] == "family_physician") {
			echo "<h4> Add patient </h4>";
			echo "<p id=\"note\"> Note: You can only add patients who are registerd with you </p>";
			echo "<form method = \"POST\" action=\"waitlist.php\">";
			echo "Care Card Number: <input type=\"text\" name=\"carecard\">";
			echo "</br>";
			echo "Priority Number: <input type=\"text\" name=\"priority\">";
			echo "</br>";
			echo "<input type=\"submit\" value=\"add\" name=\"modify\" >";
			echo "</form>";
		}
		
		
	}
	OCICommit($db_conn);
		OCILogoff($db_conn);
}
else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
function createFormPhysician(){
	echo "<h1> Waitlist</h1>";
	echo "<h4> View waitlist </h4>";
	echo "<form method = \"POST\" action=\"waitlist.php\">";

	echo "Select Specialty: <select name=\"speciality\">
	  <option value=\"Cardiology\">Cardiology</option>
	  <option value=\"Oncology\">Oncology</option>
	  <option value=\"Podiatry\">Podiatry</option>
	  <option value=\"Surgery\">Surgery</option>
	  <option value=\"Radiology\">Radiology</option>
	</select>";
	echo "</br>";
	echo "Select Region: <select name=\"region\">
	  <option value=\"Vancouver\">Vancouver</option>
	  <option value=\"Edmonton\">Edmonton</option>
	  <option value=\"Regina\">Regina</option>
	  <option value=\"Winnipeg\">Winnipeg</option>
	  <option value=\"Toronto\">Toronto</option>
	  <option value=\"Montreal\">Montreal</option>
	  <option value=\"Victoria\">Victoria</option>
	  <option value=\"Ottawa\">Ottawa</option>
	</select>";
	echo "</br>";
        echo "<input type=\"submit\" value=\"view\" name=\"view\" >";
        echo "</form>";
}
function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work
	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}
	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		$success = False;
	} 
	return $statement;
}
function printWelcome($result) { //prints results from a select statement
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo $row["NAME"]; //want to extract last name later
	}
}
function printWaitlist($result, $speciality, $region) { //prints results from a select statement
	echo "<br>Here is the waitlist for " . $speciality . " in " . $region . ": <br>";
	echo "<table>";
	echo "<tr><th>Care Card Number</th><th>Name</th><th>Patient Priority Number</th><th>Date added</th><th>Time added</th></tr>";
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["PATIENTPRIORITYNUM"] . "</td><td>" . $row["DATEOFENTRY"] . "</td><td>" . $row["TIMEOFENTRY"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function validateResultPriority($result) { //validates that there is exactly one person with first priority
	$count = 0;
	while($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		$count++;
	}
	if($count != 1)
		return false;
	else
		return true;
}

function validateResult($result) {
	if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
			return false;
	}
	return true;
}

function saveNameReturnId($result){
	$row = OCI_Fetch_Array($result, OCI_BOTH);
	setcookie('name', $row['NAME']);
	setcookie('carecardNum', $row['CARECARDNUM']);
	return $row['CARECARDNUM'];
	
}

function getSpeciality(){
	$id = $_COOKIE['id'];
	$result = executePlainSQL("select speciality from specialist where hid=$id");
	$row = OCI_Fetch_Array($result, OCI_BOTH);
	return $row[0];
}

function getRegion(){
	$id = $_COOKIE['id'];
	$result = executePlainSQL("select location from health_care_provider where hid=$id");
	$row = OCI_Fetch_Array($result, OCI_BOTH);
    return $row[0];
	
	
}

function checkInput($id,$priority, $spec, $reg){
	if($priority <= 0)
		return false;
	$hid = $_COOKIE['id'];
	$someQuery = executePlainSQL("SELECT * FROM patient_registered WHERE carecardNum=$id AND hid=$hid");
	if(!$row = OCI_Fetch_Array($someQuery, OCI_BOTH)) {
		return false;
	}
	$onList = executePlainSQL("SELECT * FROM is_on WHERE carecardNum=$id AND speciality='$spec' AND region='$reg'");
	if($row = OCI_Fetch_Array($onList, OCI_BOTH)) {
		return false;
	}
	return true;
}


  
?>

</body>
</head>
</html>

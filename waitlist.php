<html>
 <head>
<style>
ul {
	/* list-style-type removes all bullet points from the list*/
	/* margin and padding removes default browser settings*/
	list-style-type: none;
	overflow: hidden;
	margin: 0;
	padding: 0;
	background-color:  #ee3a13  ;
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
	background-color:  #555;
}

#logout{
	float:right;
}
</style>
<body>

<p>



<hr>
<?php



echo "<ul>";
echo "<li class = \"item\"><a href=\"index.php?tbl=family_physician\">My Appointments</a></li>";
	
	echo "<li class = \"item\"><a href=\"fp_view_two.php\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	
	
echo "<li class = \"item\" id = \"logout\"><a href=\"homepage.php\">Log Out</a></li>";
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
			$result1 = executePlainSQL("UPDATE is_on SET patientPriorityNum = patientPriorityNum + 1 WHERE patientPriorityNum >= $priority AND region = '$region' AND speciality = '$speciality'");
			$result2 = executePlainSQL("insert into is_on values ($id,'$region', '$speciality', $priority ,'$date', '$time')");
			echo "<h4>Patient added successfuly to waitlist of " .$speciality. " in " .$region. " <h4>";
		} else {
			$region = $_COOKIE['region'];
			$speciality = $_COOKIE['speciality'];
			//SQL QUERIES - GETTING THE FIRST PRIORITY PATIENT OFF WAITLIST AND SCHEDULING AN APPOINTMENT WITH HIM/HER
			$result1 = executePlainSQL("SELECT p.carecardNum, p.name FROM patient_registered p, is_on w WHERE p.carecardNum = w.carecardNum AND w.patientPriorityNum = 1 AND w.region = '$region' AND w.speciality = '$speciality'");
			$result1After = executePlainSQL("SELECT p.carecardNum, p.name FROM patient_registered p, is_on w WHERE p.carecardNum = w.carecardNum AND w.patientPriorityNum = 1 AND w.region = '$region' AND w.speciality = '$speciality'");
			//need to validate that there is a person with first priority in this waitlist
			if(validateResult($result1)){
				//need to save carecardNum and Name in order to book an appointment on a different page (cookie)
				$careCardNum = saveNameReturnId($result1After);
				$result2 = executePlainSQL("DELETE FROM is_on WHERE carecardNum = $careCardNum AND region = '$region' AND speciality = '$speciality'");
				$result3 = executePlainSQL("UPDATE is_on SET patientPriorityNum = patientPriorityNum - 1 WHERE patientPriorityNum >= 1 AND region = '$region' AND speciality = '$speciality'");
				OCICommit($db_conn);
				OCILogoff($db_conn);
			    	header("Location:bookAppointment.php");
			}
			
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
		printWaitlist($resultAfter, $speciality, $region);
		if($_COOKIE['tbl'] == "family_physician") {
			echo "<h4> Add patient </h4>";
			echo "<form method = \"POST\" action=\"waitlist.php\">";
			echo "Care Card Number: <input type=\"text\" name=\"carecard\">";
			echo "</br>";
			echo "Priority Number: <input type=\"text\" name=\"priority\">";
			echo "</br>";
			echo "<input type=\"submit\" value=\"add\" name=\"modify\" >";
			echo "</form>";
		}else{
			echo "<h4> Remove patient </h4>";
			echo "<form method = \"POST\" action=\"waitlist.php\">";
			echo "<input type=\"submit\" value=\"Book an appointment\" name=\"modify\" >";
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
	echo "<h1> waitlist</h1>";
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
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	} else {
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

function validateResult($result) { //validates that there is exactly one person with first priority
	$count = 0;
	while($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		$count++;
	}
	if($count != 1)
		return false;
	else
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



  
?>

</body>
</head>
</html>

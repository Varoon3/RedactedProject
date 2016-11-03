<html>
<p>INDEX<hr><br><br>
<?php
if($_GET["tbl"] == "family_physician"){
	$id = 242518;
	$tbl = "Health_Care_Provider";
	$field = "hid";

}
else if($_GET["tbl"] == "patient_registered"){
	$id = 160839453;
    $tbl = "patient_registered";
	$field = "carecardNum";
}
//must be specialist
else{
	$id = 141582;
	$tbl = "Health_Care_Provider";
	$field = "hid";
}


	$db_conn = OCILogon("ora_d1l0b", "a57303159", "dbhost.ugrad.cs.ubc.ca:1522/ug");
	$success = true;
	if($db_conn){

		$result = executePlainSQL("select NAME from $tbl where $field = $id");
		if($tbl == "Health_Care_Provider")
			echo "<p> Hello Dr. ";
		else
			echo "<p> Hello ";
		printWelcome($result);
		echo "</p>";
		
		//want to present list of patients if provider
		if($tbl == "Health_Care_Provider"){
			$appointments = executePlainSQL("select h.carecardNum, p.name, h.dateAppointment, h.timeAppointment from patient_registered p, has_appointment h where h.carecardNum = p.carecardNum AND h.hid = $id");
			printAppointments($appointments);
		}
		else{
			$myAppointments = executePlainSQL("select r.name, h.dateAppointment, h.timeAppointment from has_appointment h, Health_Care_Provider r where h.carecardNum = $id AND r.hid = h.hid");
			printMyAppointments($myAppointments);
		}
		
		OCICommit($db_conn);
		
	OCILogoff($db_conn);
	}
	else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
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

function printAppointments($result) { //prints results from a select statement
	echo "<br>Here are your upcoming appointments: <br>";
	echo "<table>";
	echo "<tr><th>Care Card Number</th><th>Name</th><th>Date</th><th>Time</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["DATEAPPOINTMENT"] . "</td><td>" . $row["TIMEAPPOINTMENT"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}

function printMyAppointments($result) { //prints results from a select statement
	echo "<br>Here are your upcoming appointments: <br>";
	echo "<table>";
	echo "<tr><th>Name</th><th>Date</th><th>Time</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["DATEAPPOINTMENT"] . "</td><td>" . $row["TIMEAPPOINTMENT"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}




  
?>

</html>

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


$db_conn = OCILogon("ora_c7n0b", "a40860158", "dbhost.ugrad.cs.ubc.ca:1522/ug");
	$success = true;
	if($db_conn){

		$result = executePlainSQL("select NAME from $tbl where $field = $id");
		if($tbl == "Health_Care_Provider")
			echo "<p> Hello Dr. ";
		else
			echo "<p> Hello ";
		printWelcome($result);
		echo "</p>";
		
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


  
?>

</html>

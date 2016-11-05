<html>
<p>Get Medical Records<hr><br><br>
<form method="POST" action="fp_view_one.php">
<td>
   Search: <input type="number" value="" name="ccNumber">
   </td>
<p><input type="submit" value="Search" name="search" ></p>
</form>
<?php
$db_conn = OCILogon("ora_d1l0b", "a57303159", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){

    $pased = $_GET["carenum"];
    $count = 0;
    if($count == 0 and !($pased == null)){
    	$resultQuery = executePlainSQL("select p.name, p.location, h.carecardnum, h.rid, h.age, h.ethnicity, h.genetichistory, h.insurance from health_care_record h, patient_registered p where h.carecardnum=$pased and p.carecardnum=$pased");

    	$resultQueryAfter = executePlainSQL("select p.name, p.location, h.carecardnum, h.rid, h.age, h.ethnicity, h.genetichistory, h.insurance from health_care_record h, patient_registered p where h.carecardnum=$pased and p.carecardnum=$pased");

    	validateResult($resultQuery, $resultQueryAfter);

    }

	if(array_key_exists('search',$_POST)){
	   $search = $_POST['ccNumber'];
	   $resultQuery = executePlainSQL("select p.name, p.location, h.carecardnum, h.rid, h.age, h.ethnicity, h.genetichistory, h.insurance from health_care_record h, patient_registered p where h.carecardnum=$search and p.carecardnum=$search");

       $resultQueryAfter = executePlainSQL("select p.name, p.location, h.carecardnum, h.rid, h.age, h.ethnicity, h.genetichistory, h.insurance from health_care_record h, patient_registered p where h.carecardnum=$search and p.carecardnum=$search");
       validateResult($resultQuery, $resultQueryAfter);
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


function validateResult($result, $resultNext) { //Checks if the Query is Empty, then sends a copy of the result to print

	if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "Error: Health Care Record does not Exist!";
	}
	else{
		printRecord($resultNext);
	}
}

function printRecord($result){
	echo "<br> Health Care Record retrieved: <br>";
	echo "<table>";
	echo "<tr><th>Name</th><th>Location</th><th>Care Card Number</th><th>Record ID</th><th>Age</th><th>Ethnicity</th><th>Genetic History</th><th>Insurance</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["LOCATION"] . "</td><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["RID"] . "</td><td>" . $row["AGE"] . "</td><td>" . $row["ETHNICITY"] . "</td><td>" . $row["GENETICHISTORY"] . "</td><td>" . $row["INSURANCE"] . "</td></tr>"; 
	}
	echo "</table>";  
}

?>

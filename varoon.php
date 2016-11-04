<html>
<p>Get Medical Records<hr><br><br>
<form method="POST" action="varoon.php">
<td>
   Search: <input type="number" value="" name="ccNumber">
   </td>
<p><input type="submit" value="Search" name="search" ></p>
</form>
<?php

$db_conn = OCILogon("ora_d1l0b", "a57303159", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){

	if(array_key_exists('search',$_POST)){
	   $search = $_POST['ccNumber'];
	   $resultQuery = executePlainSQL("select * from health_care_record where carecardNum = $search");
		printRecord($resultQuery);

	OCICommit($db_conn);

OCILogoff($db_conn);
}
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

function printRecord($result){
	$tbl_string = "";
	$tbl_string .= "<br> Health Care Record retrieved: <br>";
	$tbl_string .= "<table>";
	$tbl_string .= "<tr><th>Care Card Number</th><th>Record ID</th><th>Age</th><th>Ethnicity</th><th>Genetic History</th><th>Insurance</th></tr>";
	$count = 0;
	
	while($row = OCI_Fetch_Array($result, OCI_BOTH)){
		$count++;
		$tbl_string .= "<tr><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["RID"] . "</td><td>" . $row["AGE"] . "</td><td>" . $row["ETHNICITY"] . "</td><td>" . $row["GENETICHISTORY"] . "</td><td>" . $row["INSURANCE"] . "</td></tr>"; 
		
	}
	$tbl_string .= "</table>";
	if ($count == 0) {
		echo "error";
	} else{
		echo $tbl_string;
	}
	
}



?>
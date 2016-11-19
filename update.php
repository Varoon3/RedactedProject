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

.fixed{
	background-color : #d1d1d1; 
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




	
	
	echo "<li class = \"item\"><a href=\"fp_view_two.php?tbl=family_physician\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Waitlist</a></li>";
	

echo "<li class = \"item\" id = \"logout\"><a href=\"homepage.php\">Log Out</a></li>";
echo "</ul>";


$db_conn = OCILogon("ora_c7n0b", "a40860158", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){
	$id = $_GET["carecardNum"];
	$result = executePlainSQL("select * from health_care_record where carecardnum = $id");
	$resultAfter = executePlainSQL("select * from health_care_record where carecardnum = $id");
	validateResult($result, $resultAfter);
	if(array_key_exists('update_2',$_POST)){
		$insurance = $_POST['ins'];
		$result = executePlainSQL("UPDATE health_care_record SET insurance='$insurance' WHERE carecardNum=$id");
		echo "Updated Health Care Record Successfully!";
	}
	//want to present list of patients if provider

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
		echo "<br>Error: No Patients!</br>";
	}
	else{
		printHCR($resultNext);
	}
}


function printHCR($result) { //prints results from a select statement
	echo "<br>You can only update insurance details: <br>";
	echo "<br>";
	
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<form method=\"POST\" action=\"update.php?carecardNum=" .$row["CARECARDNUM"]. "\">";
		echo "Care card Number: <input class=\"fixed\" type=\"text\" value=\"" .$row["CARECARDNUM"]. "\" disabled>";
		echo "<br>";
		echo "Record ID: <input class=\"fixed\" type=\"text\" value=\"" .$row["RID"]. "\" disabled>";
		echo "<br>";
		echo "Age: <input class=\"fixed\" type=\"text\" value=\"" .$row["AGE"]. "\" disabled>";
		echo "<br>";
		echo "Ethnicity: <input class=\"fixed\" type=\"text\" value=\"" .$row["ETHNICITY"]. "\" disabled>";
		echo "<br>";
		echo "Insurance: <input type=\"text\" value=\"" .$row["INSURANCE"]. "\" name=\"ins\">";
		echo "<br>";
		echo "Genetic History: <input class=\"fixed\" type=\"text\" value=\"" .$row["GENETICHISTORY"]. "\" disabled>";
		echo "<br>";
		echo "<input type=\"submit\" value=\"Update\" name=\"update_2\" >";
		echo "</form>";
		//echo "<tr><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["RID"] . "</td><td>" . $row["AGE"] . "</td><td>" . $row["ETHNICITY"] . "</td><td>" . $row["INSURANCE"] . "</td><td>" . $row["GENETICHISTORY"] . "</td></tr>"; //or just use "echo $row[0]" 
		//bug here
	
	
	}
	//echo "</table>";
}
?>

</body>
</head>
</html>
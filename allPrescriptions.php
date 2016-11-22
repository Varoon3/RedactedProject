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


if($_COOKIE["tbl"] != "family_physician" && $_COOKIE["tbl"] != "specialist") {
   	header("Location:logout.php");
} else if ($_COOKIE["tbl"] == "family_physician") {
	echo "<li class = \"item\"><a href=\"fp_view_two.php\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"analytics.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	echo "<li class = \"item\"><a href=\"allPrescriptions.php\">All Prescriptions</a></li>";
} else {
	echo "<li class = \"item\"><a href=\"analytics.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	echo "<li class = \"item\"><a href=\"prescribe.php\">File Prescription</a></li>";
	echo "<li class = \"item\"><a href=\"allPrescriptions.php\">All Prescriptions</a></li>";

}
	
echo "<li class = \"item\" id = \"logout\"><a href=\"logout.php\">Log Out</a></li>";
echo "</ul>";

$db_conn = OCILogon("ora_b2k0b", "a33405151", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){
	$result = executePlainSQL("select * from takes");
	$resultAfter = executePlainSQL("select * from takes");
	if(validateResult($result)){
		printPrescriptions($resultAfter);
	}
	else{
		echo "No prescriptions are assigned.";
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

function printPrescriptions($result) { //prints results from a select statement
	echo "<table>";
	echo "<tr><th>Care Card Number</th><th>Medication Name</th><th>Dose</th></tr>";
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["MEDNAME"] . "</td><td>" . $row["DOSE"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function validateResult($result) { //prints results from a select statement
	//if the result query is empty, so invalid username/password
	if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
			return false;
	}
	return true;
}
  
?>

</body>
</head>
</html>

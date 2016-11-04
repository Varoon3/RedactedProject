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
</head>
<body>

<p>



<hr>

<?php


echo "<ul>";
echo "<li class = \"item\"><a href=\"index.php?tbl=" .$_GET["tbl"]. "\">My Appointments</a></li>";
//family_physician
if($_GET["tbl"] == "family_physician"){
	$id = 242518;
}
//must be specialist since patients have no access
else{
	$id = 141582;
}

$tbl = "patient_registered";
echo "<li class = \"item\"><a href=\"patients.php?tbl=" .$_GET["tbl"]. "\">My Patients</a></li>";
echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
echo "<li class = \"item\"><a href=\"homepage.php\">Waitlist</a></li>";
	

	
echo "<li class = \"item\" id = \"logout\"><a href=\"homepage.php\">Log Out</a></li>";
echo "</ul>";


$db_conn = OCILogon("ora_d1l0b", "a57303159", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;

if($db_conn){

	$result = executePlainSQL("select p.carecardNum, p.name, p.location from patient_registered p where p.hid = $id");
	printPatients($result);
	
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
function printPatients($result) { //prints results from a select statement
	echo "<br>Here are the patients registered with you: <br>";
	echo "<table>";
	echo "<tr><th>Care Card Number</th><th>Name</th><th>Location</th></tr>";
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["LOCATION"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}
  
 
?>



</html>
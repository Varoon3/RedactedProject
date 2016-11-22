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
	background-color:  #555;
}

#logout{
	float:right;
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



$db_conn = OCILogon("ora_c7n0b", "a40860158", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){
	if (isset($_POST['fccn'])) { // From physician form with hidden fields
		$carecard = $_POST['fccn'];
		$name = $_POST['fname'];
		$hid = $_COOKIE['id'];
	} else {
		$carecard = $_COOKIE['carecardNum'];
		$name = $_COOKIE['name'];
		$hid = $_COOKIE['id'];
	}
	$result = executePlainSQL("select * from has_appointment where carecardNum = $carecard AND hid = $hid");
	if(!validateResult($result)) {
		//generating random date
		date_default_timezone_set("America/Vancouver");
		$date = randomDate(date("Y/d/m"));
		$time = date("H:i");
		$result = executePlainSQL("INSERT INTO has_appointment values ($carecard,$hid,'$date','$time')");
		echo "<h4> Appointment with $name was booked for $date at $time </h4>";
		echo "<h4> We will add this appointment to your list of appointments. </h4>";	
	} else {
		echo "<h4> You already have your next appointment with " . $name ." booked. It can be found in your list of appointments. </h4>";	
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
	echo "<tr><th>Doctor</th><th>Date</th><th>Time</th><th>Location</th></tr>";
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["DATEAPPOINTMENT"] . "</td><td>" . $row["TIMEAPPOINTMENT"] . "</td><td>" . $row["LOCATION"] . "</td></tr>"; //or just use "echo $row[0]" 
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
function randomDate($start_date)
{
    //lower bound, unix time for today's date
    $min = 1480627247;
    $max = $min + 15000000;

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y/d/m', $val);
}
  
?>

</body>
</head>
</html>

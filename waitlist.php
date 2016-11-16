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
	
	echo "<li class = \"item\"><a href=\"fp_view_two.php?tbl=" .$_GET["tbl"]. "\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	
	
echo "<li class = \"item\" id = \"logout\"><a href=\"homepage.php\">Log Out</a></li>";
echo "</ul>";

createForm();

$db_conn = OCILogon("ora_d1l0b", "a57303159", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){
echo "000000000000000000000";
	if(isset($_POST['add'])){
		echo "llllll";
		$id = $_POST['carecard'];
		$region = $_GET['region'];
		$speciality = $_GET['speciality'];
		echo $id;
		$result = executePlainSQL("insert into is_on values ($id,'$region', '$speciality', 1 ,'date of today', 'time right now')");
		echo "33333333333333333";
	}
	else if(array_key_exists('view',$_POST)){
	echo "11111111111111111";
		$speciality = $_POST['speciality'];
		$region = $_POST['region'];
		$result = executePlainSQL("select i.carecardNum, p.name, i.patientPriorityNum, i.dateOfEntry, i.timeOfEntry from is_on i, patient_registered p where i.speciality = '$speciality' AND i.region='$region' AND i.careCardNum = 	               p.careCardNum");
		$resultAfter = executePlainSQL("select i.carecardNum, p.name, i.patientPriorityNum, i.dateOfEntry, i.timeOfEntry from is_on i, patient_registered p where i.speciality = '$speciality' AND i.region='$region' AND i.careCardNum = p.careCardNum");	
		if(validateResult($result,$resultAfter,$speciality,$region)){
			echo "<h4> Add patient </h4>";
			echo "<form method = \"POST\" action=\"waitlist.php\">";
			echo "Care Card Number: <input type=\"text\" name=\"carecard\">";
			echo "<input type=\"submit\" value=\"add\" name=\"add\" >";
			echo "</form>";
			echo "ehlplppppp|";
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
function createForm(){
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


function validateResult($result, $resultNext, $speciality, $region) { //Checks if the Query is Empty, then sends a copy of the result to print
	if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<br>Error: Waitlist doesnt exist!</br>";
		return false;
	}
	else{
		printWaitlist($resultNext, $speciality, $region);
		return true;
	}
}
  
?>

</body>
</head>
</html>

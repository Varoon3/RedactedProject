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
echo "<li class = \"item\"><a href=\"index.php\">My Appointments</a></li>";

if($_COOKIE["tbl"] == "patient_registered"){
    $tbl = "patient_registered";
	$field = "carecardNum";
	echo "<li class = \"item\"><a href=\"homepage.php\">My HCR</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">My HCP</a></li>";
}


else{
	$tbl = "Health_Care_Provider";
	$field = "hid";
	
	echo "<li class = \"item\"><a href=\"fp_view_two.php\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	echo "<li class = \"item\"><a href=\"presribe.php\">File Prescription</a></li>";
	
}
	
echo "<li class = \"item\" id = \"logout\"><a href=\"logout.php\">Log Out</a></li>";
echo "</ul>";

makePrescribeForm();

$db_conn = OCILogon("ora_b2k0b", "a33405151", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){
	$id = $_COOKIE["id"];
	if(array_key_exists('submit',$_POST)){
		$carecardNum = $_POST['ccn'];
		$dose = $_POST['dose'];
		$medName = $_POST['medName'];
		$result = executePlainSQL("select name from patient_registered where carecardNum = $carecardNum");
		$resultAfter = executePlainSQL("select name from patient_registered where carecardNum = $carecardNum");
		if (validateResult($result)) {
			$row = OCI_Fetch_Array($resultAfter, OCI_BOTH);
			$name = $row['NAME'];
			executePlainSQL("insert into prescribes values ($id, '$medName', $dose)");
			executePlainSQL("insert into takes values ($carecardNum, '$medName', $dose)");
			echo "Added perscription: " . $dose . "mg of " . $medName . " for " . $name . "\n";
		} else {
			echo "Carecard Number not found, please try again.";
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

function makePrescribeForm() {
	echo "<h4> Make a prescription: </h4>";
	echo "<form method = \"POST\" action=\"prescribe.php\">";

	echo "What are you prescribing?: <select name=\"medName\">
	  <option value=\"Morpine\">Morpine</option>
	  <option value=\"Statin\">Statin</option>
	  <option value=\"Abraxane\">Abraxane</option>
	  <option value=\"luliconazole\">luliconazole</option>
	  <option value=\"Gravol\">Gravol</option>
	</select>";
	echo "</br>";
	echo "To whom?: <input type=\"text\" name=\"ccn\">";
	echo "</br>";
	echo "How much (mg)?: <select name=\"dose\">
		  <option value=\"60\">60</option>
		  <option value=\"80\">80</option>
		  <option value=\"100\">100</option>
		  <option value=\"120\">120</option>
		  <option value=\"140\">140</option>
		  </select>";
	echo "</br>";
    echo "<input type=\"submit\" value=\"submit\" name=\"submit\" >";
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

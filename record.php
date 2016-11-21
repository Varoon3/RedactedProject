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

if($_COOKIE["tbl"] == "patient_registered") {
    $tbl = "patient_registered";
	$field = "carecardNum";
	echo "<li class = \"item\"><a href=\"record.php\">My HCR</a></li>";
} else if ($_COOKIE["tbl"] == "family_physician") {
	$tbl = "Health_Care_Provider";
	$field = "hid";
	echo "<li class = \"item\"><a href=\"fp_view_two.php\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
} else {
	$tbl = "Health_Care_Provider";
	$field = "hid";
	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
	echo "<li class = \"item\"><a href=\"waitlist.php\">Waitlist</a></li>";
	echo "<li class = \"item\"><a href=\"prescribe.php\">File Prescription</a></li>";
}
	
echo "<li class = \"item\" id = \"logout\"><a href=\"logout.php\">Log Out</a></li>";
echo "</ul>";

$db_conn = OCILogon("ora_b2k0b", "a33405151", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;
if($db_conn){
	$id = $_COOKIE['id'];
	if(array_key_exists('modify',$_POST)){
		$hcp = $_POST['hcp'];
		executePlainSQL("update health_care_record set insurance = '$hcp' where carecardNum = $id");
		echo "Thank you, your information will be update shortly";
	} else {
		makeHCRBox($id);
		echo "<h4> Insurance changed? </h4>";
		echo "<form method = \"POST\" action=\"record.php\">";
		echo "Enter your new provider: <input type=\"text\" name=\"hcp\">";
		echo "</br>";
		echo "Enter your plan number: <input type=\"text\" name=\"ignored\">";
		echo "</br>";
		echo "<input type=\"submit\" value=\"Update\" name=\"modify\" >";
		echo "</form>";
	}
	
	OCICommit($db_conn);
	
OCILogoff($db_conn);
}
else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

function makeHCRBox($id){
	$resultQuery = executePlainSQL("select p.name, p.location, h.carecardnum, h.rid, h.age, h.ethnicity, h.insurance, h.genetichistory from health_care_record h, patient_registered p where h.carecardnum=p.carecardNum and p.carecardnum=$id");
	printHCR($resultQuery);
	
	
}
	
	
function printHCR($result){
	echo "<div id=\"des\" class = \"description\" >";
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
	    echo "<p class = \"title\">Your Health Care Record:\n</p>";
		echo "Care Card #: " .$row["CARECARDNUM"]. "";
		echo "<br>";
		echo "Location: " .$row["LOCATION"]. "";
		echo "<br>";
		echo "Record ID: " .$row["RID"]. "";
		echo "<br>";
		echo "Age: " .$row["AGE"]. "";
		echo "<br>";
		echo "Ethnicity: " .$row["ETHNICITY"]. "";
		echo "<br>";
		echo "Insurance: " .$row["INSURANCE"]. "";
		echo "<br>";
		echo "Genetic History: " .printGeneticHistory($row["GENETICHISTORY"]). "";
		echo "<br>";
	}
	echo "</div>";
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

function printGeneticHistory($gh){
	$str = "";
	$strlen = strlen($gh);
	for($i=0;$i<$strlen;$i++){
		if($i%50 == 0){
			$str .= "<br>";
		}
		
		$char = substr( $gh, $i, 1 );
		$str .= $char;
		
	}
	return $str;
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

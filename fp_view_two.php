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

table {
		font-family: 'Arial';
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

.description {
position:absolute;
    left: 362px;
    display:none;
    border:1px solid #000;
    width:555px;
    height:275px;
}

.title{
	font-weight: bold;
	text-decoration: underline;
}




</style>
<body>

<p>
<hr>

<?php
echo "<ul>";
echo "<li class = \"item\"><a href=\"index.php?tbl=" .$_GET["tbl"]. "\">My Appointments</a></li>";

if($_GET["tbl"] == "family_physician"){
	$id = 242518;
	$tbl = "Health_Care_Provider";
	$field = "hid";

	echo "<li class = \"item\"><a href=\"patients.php?tbl=" .$_GET["tbl"]. "\">My Patients</a></li>";
	echo "<li class = \"item\"><a href=\"fp_view_one.php?tbl=" .$_GET["tbl"]. "\">Grab Health Care Record</a></li>";
 	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
 	echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
 	echo "<li class = \"item\"><a href=\"homepage.php\">Waitlist</a></li>";
}
else{ //Must be a Specialist
	$id = 141582;
	$tbl = "Health_Care_Provider";
	$field = "hid";

    echo "<li class = \"item\"><a href=\"patients.php?tbl=" .$_GET["tbl"]. "\">My Patients</a></li>";
 	echo "<li class = \"item\"><a href=\"homepage.php\">Analytics</a></li>";
 	echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
 	echo "<li class = \"item\"><a href=\"homepage.php\">Waitlist</a></li>";
}
	
	
echo "<li class = \"item\" id = \"logout\"><a href=\"homepage.php\">Log Out</a></li>";
echo "</ul>";

$db_conn = OCILogon("ora_d1l0b", "a57303159", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$success = true;


if($db_conn){

	$result = executePlainSQL("select carecardNum, name, location from patient_registered where hid = $id order by carecardNum");
	$resultAfter = executePlainSQL("select carecardNum, name, location from patient_registered where hid = $id order by carecardNum");

	validateResult($result, $resultAfter);


	OCICommit($db_conn);
	
OCILogoff($db_conn);
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
		printAllMyPatients($resultNext);
	}
}

function printAllMyPatients($result){
	$arr = array();
	echo "<table>";
	echo "<thead>";    
	echo "<tr><th>Care Card Number</th><th>Name</th><th>Location</th></tr></thead>";  
	echo "<tbody>";
	$count = 0;
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
		echo "<tr id=\"try" .$count. "\" class=\"trying\"><td>" . $row["CARECARDNUM"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["LOCATION"] . "</td></tr>";
		$arr[$count] = $row["CARECARDNUM"];
		$count++;		
	}
		sendCountToJs($count);
    echo "</tbody>";
    echo "</table>";	
	makeHCRBox($arr);
	
	
}

function makeHCRBox($arr){
	for($i=0;$i<count($arr);$i++){
		$resultQuery = executePlainSQL("select p.name, p.location, h.carecardnum, h.rid, h.age, h.ethnicity, h.genetichistory, h.insurance from health_care_record h, patient_registered p where h.carecardnum=p.carecardNum and p.carecardnum=$arr[$i]");
		printHCR($resultQuery,$i);
	}
}
	
	
function printHCR($result,$count){
echo "<div id=\"des" .$count. "\" class = \"description\" >";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
	    echo "<p class = \"title\">Health Care Record for patient " .$row["NAME"]."</p>";
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
		echo "Genetic History: " .printGeneticHistory($row["GENETICHISTORY"]). "";
		echo "<br>";
	}
echo "</div>";
}

function sendCountToJs($count){
	echo "<div id=\"dom-target\" style=\"display: none;\">";
    echo htmlspecialchars($count); /* You have to escape because the result
                                           will not be valid HTML otherwise. */
   echo "</div>";
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
	
	?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>

 var div = document.getElementById("dom-target");
var count = div.textContent;


for(var i=0;i<count;i++){
$("#try0").mouseover(function() {
    $("#des0").show();
}).mouseout(function() {
    $("#des0").hide();
});
$("#try1").mouseover(function() {
    $("#des1").show();
}).mouseout(function() {
    $("#des1").hide();
});
}


</script>
</body>
</head>
</html>
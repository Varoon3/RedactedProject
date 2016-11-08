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

	.try2 {
    background:#ccc;
	position:fixed;
    border: 1px #333 solid;
    padding:5px;
    width:100px;
	height: 500px;
}
.description {
position:relative;
left:500px;
    display:none;
    border:1px solid #000;
    width:600px;
    height:250px;
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
	echo "<table>";
	echo "<thead>";    
	echo "<tr><th>Care Card Number</th><th>Name</th><th>Location</th></tr></thead>";  
	echo "<tbody>";
	$count = 0;
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
		echo "<tr height=100px><td><a  id=\"try" .$count. "\" class=\"trying\" href=\"fp_view_one.php?carenum=" .$row["CARECARDNUM"]. "\">" . $row["CARECARDNUM"] . "</a></td><td>" . $row["NAME"] . "</td><td>" . $row["LOCATION"] . "</td></tr>";
		makeHCRBox($row["CARECARDNUM"],$count);
		$count++;		
	}
		sendCountToJs($count);
    echo "</tbody>";
    echo "</table>";	
	
	
}

function makeHCRBox($id,$count){
	$resultQuery = executePlainSQL("select p.name, p.location, h.carecardnum, h.rid, h.age, h.ethnicity, h.genetichistory, h.insurance from health_care_record h, patient_registered p where h.carecardnum=p.carecardNum and p.carecardnum=$id");
	printHCR($resultQuery,$count);
}
	
	
function printHCR($result,$count){
echo "<div id=\"des" .$count. "\" class = \"description\" >";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo $row["NAME"];
		echo "<br>";
		echo $row["LOCATION"];
		echo "<br>";
		echo $row["CARECARDNUM"];
		echo "<br>";
		echo $row["RID"];
		echo "<br>";
		echo $row["AGE"];
		echo "<br>";
		echo $row["NAME"];
		echo "<br>";
		echo $row["ETHNICITY"];
		echo "<br>";
		echo $row["GENETICHISTORY"];
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
	
	?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>

 var div = document.getElementById("dom-target");
var count = div.textContent;
alert(count);



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


</script>
</body>
</head>
</html>
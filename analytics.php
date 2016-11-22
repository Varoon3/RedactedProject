<html>
	<head>
	<meta charset="utf-8" />
	<title> Analytics </title>
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
body{
		font-family: "Roboto", sans-serif;
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


		</style>
<body>
		<p>
			<hr>
			<?php
			echo "<ul>";
			echo "<li class = \"item\"><a href=\"index.php\">My Appointments</a></li>";
			if($_COOKIE["tbl"] == "patient_registered") {
				echo "<li class = \"item\"><a href=\"record.php\">My HCR</a></li>";
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
			echo "<li class = \"item\" id = \"logout\"><a href=\"homepage.php\">Log Out</a></li>";
			echo "</ul>";
			?>
		</p>
		
	</head>
	
		<form method="POST" action="analytics.php">
	    <b><small> Disease Analytics Modifier: &nbsp </small></b>
	    <select name="disease">
	    	<option value="SSSS"</option>
  			<option value="AGCT">Type 2 Diabetes</option>
  			<option value="TAGA">Cardiovascular Disease</option>
  			<option value="GCGC">Neurodegeneration</option>
  			<option value="CGCG">Viral Epidemics</option>
  			<option value="AAAA">Repiratory Infections</option>
  			<option value="TATA">Bacterial Infections</option>
		</select> 
		<br>
		<br>
		<b><small>Custom Nucleotide Sequence: &nbsp </small></b><input type="text" value="" name="other">
		</br>
		</br>
  		 <input type="submit" value="Analyze" name="view" >
  		</form>


		<?php
		$db_conn = OCILogon("ora_b2k0b", "a33405151", "dbhost.ugrad.cs.ubc.ca:1522/ug");
		$success = true;
		$edmontonTotal = 0;
		$montrealTotal = 0;
		$ottawaTotal = 0;
		$reginaTotal = 0;
		$torontoTotal = 0;
		$vancouverTotal = 0;
		$victoriaTotal = 0;
		$winnipegTotal = 0;
		$arabicTwo = array();
		$arabicTwo[] = 0;
		$arabicTwo[] = 0;
		$arabicTwo[] = 0;
		$arabicTwo[] = 0;
		$arabicTwo[] = 0;
		$arabicTwo[] = 0;
		$arabicTwo[] = 0;
		$arabicTwo[] = 0;
		$asianTwo = array();
		$asianTwo[] = 0;
		$asianTwo[] = 0;
		$asianTwo[] = 0;
		$asianTwo[] = 0;
		$asianTwo[] = 0;
		$asianTwo[] = 0;
		$asianTwo[] = 0;
		$asianTwo[] = 0;
		$caucasianTwo = array();
		$caucasianTwo[] = 0;
		$caucasianTwo[] = 0;
		$caucasianTwo[] = 0;
		$caucasianTwo[] = 0;
		$caucasianTwo[] = 0;
		$caucasianTwo[] = 0;
		$caucasianTwo[] = 0;
		$caucasianTwo[] = 0;
		$hispanicTwo = array();
		$hispanicTwo[] = 0;
		$hispanicTwo[] = 0;
		$hispanicTwo[] = 0;
		$hispanicTwo[] = 0;
		$hispanicTwo[] = 0;
		$hispanicTwo[] = 0;
		$hispanicTwo[] = 0;
		$hispanicTwo[] = 0;
		$indigenousTwo = array();
		$indigenousTwo[] = 0;
		$indigenousTwo[] = 0;
		$indigenousTwo[] = 0;
		$indigenousTwo[] = 0;
		$indigenousTwo[] = 0;
		$indigenousTwo[] = 0;
		$indigenousTwo[] = 0;
		$indigenousTwo[] = 0;
		if ($db_conn){
			if(array_key_exists('view', $_POST)) {
				$sequence = $_POST['other'];
				if ($sequence == NULL){
					$sequence = $_POST['disease'];
				}
				displayTitle($sequence);
				$graphONE = executePlainSQL("select p.location, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by p.location order by p.location");
				$graphONETWO = executePlainSQL("select p.location, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by p.location order by p.location");
				$graphTWO = executePlainSQL("select p.location, h.ethnicity, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by (p.location, h.ethnicity) order by p.location");
				$graphTWOTWO = executePlainSQL("select p.location, h.ethnicity, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by (p.location, h.ethnicity) order by p.location");
				validateResultONE($graphONE, $graphONETWO);
				validateResultTWO($graphTWO, $graphTWOTWO);
				$allPatients = executePlainSQL("select p.name, p.location, p.carecardnum from patient_registered p where not exists ((select distinct medName from medication) minus (select distinct m.medName from medication m, takes t where t.carecardnum = p.carecardnum and m.medName = t.medName))");
				$allPatients2 = executePlainSQL("select p.name, p.location,  p.carecardnum from patient_registered p where not exists ((select distinct medName from medication) minus (select distinct m.medName from medication m, takes t where t.carecardnum = p.carecardnum and m.medName = t.medName))");
				$lowestDose = executePlainSQL("select medName, min(dose) from medication group by medName having max(dose) = (select max(dose) from medication)");
				$lowestDose2 = executePlainSQL("select medName, min(dose) from medication group by medName having max(dose) = (select max(dose) from medication)");
				$highestDose = executePlainSQL("select medName, max(dose) from medication group by medName having min(dose) = (select min(dose) from medication)");
				$highestDose2 = executePlainSQL("select medName, max(dose) from medication group by medName having min(dose) = (select min(dose) from medication)");
				$patientsEthnicity = executePlainSQL("select ethnicity, count(*), avg(age) from health_care_record group by ethnicity order by count(*)");
				$patientsEthnicity2 = executePlainSQL("select ethnicity, count(*), avg(age) from health_care_record group by ethnicity order by count(*)");
			}
			OCICommit($db_conn);
		OCILogoff($db_conn);
		}
		else {
			echo "cannot connect";
			$e = OCI_Error(); // For OCILogon errors pass no handle
			echo htmlentities($e['message']);
		}
		function displayTitle($sequence) {
			if($sequence == "AGCT") {
				echo "<b><small> Geographic Distribution of Patients at risk of: Type 2 Diabetes </small></b><br></br>";
			} else if ($sequence == "TAGA") {
				echo "<b><small> Geographic Distribution of Patients at risk of: Cardiovascular Disease </small></b><br></br>";
			} else if ($sequence == "GCGC") {
				echo "<b><small> Geographic Distribution of Patients at risk of: Neurodegenerative Disease </small></b><br></br>";
			} else if ($sequence == "CGCG") {
				echo "<b><small> Geographic Distribution of Patients at risk of: Viral Epidemics </small></b><br></br>";
			} else if ($sequence == "AAAA") {
				echo "<b><small> Geographic Distribution of Patients at risk of: Repiratory Infections </small></b><br></br>";
			} else if ($sequence == "TATA") {
				echo "<b><small> Geographic Distribution of Patients at risk of: Bacterial Infections </small></b><br></br>";
			} else if ($sequence == $_POST['other']) {
				echo "<b><small> Custom Sequence: $sequence </small></b><br></br>";
			}
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
		function arrayDecoderGraphOne($result) {
			global $edmontonTotal, $montrealTotal, $ottawaTotal, $reginaTotal, $torontoTotal, $vancouverTotal, $victoriaTotal, $winnipegTotal; 
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				if($row["LOCATION"] == "Edmonton") {
					$edmontonTotal = $row["COUNT(H.CARECARDNUM)"];
				} elseif ($row["LOCATION"] == "Montreal") {
					$montrealTotal = $row["COUNT(H.CARECARDNUM)"];
				} elseif ($row["LOCATION"] == "Regina") {
					$reginaTotal = $row["COUNT(H.CARECARDNUM)"];
				} elseif ($row["LOCATION"] == "Toronto") {
					$torontoTotal = $row["COUNT(H.CARECARDNUM)"];
				} elseif ($row["LOCATION"] == "Vancouver") {
					$vancouverTotal = $row["COUNT(H.CARECARDNUM)"];
				} elseif ($row["LOCATION"] == "Victoria") {
					$victoriaTotal = $row["COUNT(H.CARECARDNUM)"];
				} elseif ($row["LOCATION"] == "Winnipeg") {
					$winnipegTotal = $row["COUNT(H.CARECARDNUM)"];
				} 
			}
		}
		function arrayDecoderGraphTwo($result, &$arabicTwo, &$asianTwo, &$caucasianTwo, &$hispanicTwo, &$indigenousTwo){
			global $arabicTwo, $asianTwo, $caucasianTwo, $hispanicTwo, $indigenousTwo;
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
				if ($row["LOCATION"] == "Edmonton"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[0] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[0] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[0] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[0] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[0] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
				else if ($row["LOCATION"] == "Montreal"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[1] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[1] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[1] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[1] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[1] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
				else if ($row["LOCATION"] == "Ottawa"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[2] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[2] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[2] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[2] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[2] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
				else if ($row["LOCATION"] == "Regina"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[3] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[3] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[3] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[3] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[3] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
				else if ($row["LOCATION"] == "Toronto"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[4] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[4] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[4] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[4] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[4] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
				else if ($row["LOCATION"] == "Vancouver"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
				else if ($row["LOCATION"] == "Victoria"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[6] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[6] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[6] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[6] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[6] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
				else if ($row["LOCATION"] == "Indigenous"){
					if ($row["ETHNICITY"] == "Arabic"){
						$arabicTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Asian"){
						$asianTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Caucasian"){
						$caucasianTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Hispanic"){
						$hispanicTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					} elseif ($row["ETHNICITY"] == "Indigenous"){
						$indigenousTwo[5] = $row["COUNT(H.CARECARDNUM)"];
					}
				}
			}
		}
		function validateResultONE($result, $resultNext) { //Checks if the Query is Empty, then sends a copy of the result to print
			if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
				return false;
			}
			else{
				arrayDecoderGraphOne($resultNext);
			}
		}
		function validateResultTWO($result, $resultNext) { //Checks if the Query is Empty, then sends a copy of the result to print
			if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "Error: Data does not Exist!";
			}
			else{
				arrayDecoderGraphTwo($resultNext, $arabicTwo, $asianTwo, $caucasianTwo, $hispanicTwo, $indigenousTwo);
			}
		}
		function validateResult3($result, $resultNext) { //Checks if the Query is Empty, then sends a copy of the result to print
			if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<b><small> None. </small></b>";
			}
			else{
				printResult3($resultNext);
			}
		}
		function printResult3($result){
			echo "<table>";
			echo "<tr><th>Name</th><th>Location</th><th>Care Card Number</th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
				echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["LOCATION"] . "</td><td>" . $row["CARECARDNUM"] . "</td></tr>"; 
			}
			echo "</table>";  
		}
		function validateResult4($result, $resultNext) { //Checks if the Query is Empty, then sends a copy of the result to print
			if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<b><small> No Dose on Record. </small></b>";
			}
			else{
				printResult4($resultNext);
			}
		}
		function printResult4($result){
			echo "<table>";
			echo "<tr><th><small>Medication</small></b></th><th><b><small> Dose </small></b></th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
				echo "<tr><td><small>" . $row["MEDNAME"] . "</small></td><td><small>" . $row["MIN(DOSE)"] . "</small></td></tr>"; 
			}
			echo "</table>";  
		}
		function validateResult5($result, $resultNext) { //Checks if the Query is Empty, then sends a copy of the result to print
			if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<b><small> No Dose on Record. </small></b>";
			}
			else{
				printResult5($resultNext);
			}
		}
		function printResult5($result){
			echo "<table>";
			echo "<tr><th><small>Medication</small></b></th><th><b><small> Dose </small></b></th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
				echo "<tr><td><small>" . $row["MEDNAME"] . "</small></td><td><small>" . $row["MAX(DOSE)"] . "</small></td></tr>"; 
			}
			echo "</table>";  
		}
		function validateResult6($result, $resultNext) { //Checks if the Query is Empty, then sends a copy of the result to print
			if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "";
			}
			else{
				printResult6($resultNext);
			}
		}
		function printResult6($result){
			echo "<table>";
			echo "<tr><th><small>Ethnicity</small></b></th><th><b><small>Number of Patients</small></b></th><th><b><small>Average Age</small></b></th>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
				echo "<tr><td><small>" . $row["ETHNICITY"] . "</small></td><td><small>" . $row["COUNT(*)"] . "</small></td><td><small>" . round($row["AVG(AGE)"],2) . "</small></td></tr>"; 
			}
			echo "</table>";  
		}
		?>


		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('upcoming', {'packages':['geochart']});
			google.charts.setOnLoadCallback(drawRegionsMap);
			var ab = <?php echo json_encode($edmontonTotal) ?>;
			var va = <?php echo json_encode($vancouverTotal) ?>;
			var vi = <?php echo json_encode($victoriaTotal) ?>;
			var sa = <?php echo json_encode($reginaTotal) ?>;
			var ma = <?php echo json_encode($winnipegTotal) ?>;
			
			var to = <?php echo json_encode($torontoTotal) ?>;
			var ot = <?php echo json_encode($ottawaTotal) ?>;
			var qe = <?php echo json_encode($montrealTotal) ?>;
			var bc = parseInt(va) + parseInt(vi);
			var on = parseInt(to) + parseInt(ot);
			function drawRegionsMap() {
				var data = google.visualization.arrayToDataTable([
					['Province', 'Patients'],
					['British Columbia', bc],
					['Alberta', ab],
					['Saskatchewan', sa],
					['Manitoba', ma],
					['Ontario', on],
					['Quebec', qe],
					['Yukon', 0],
					['NorthWest Territories', 0],
					['Prince Edward Island', 0],
					['New Brunswick', 0],
					['Nunavut', 0],
					['Newfoundland and Labrador', 0],
					['Nova Scotia', 0],
					]);
				var options = {
					region: 'CA',
					resolution: 'provinces',
					displayMode: 'region',
					colorAxis: {colors: ['#F2EFAC', '#ECBA62', '#EC7062']},
					backgroundColor: '#ffffff',
					datalessRegionColor: '#eeffff',
					defaultColor: '#f5f5f5',
				};
				var chart = new google.visualization.GeoChart(document.getElementById('geochart-colors'));
				chart.draw(data, options);
			};
		</script>

		<div id="geochart-colors" style="width: 700px; height: 400px;"></div>


    	<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js' type='text/javascript'></script>
		<script src='Chart.Bar.js' type='text/javascript'></script>
		<canvas id="mycanvas" width="700" height="200"></canvas>
   		<div id="js-legend" class="chart-legend"></div>

		<script type='text/javascript'>
		var chrt = document.getElementById("mycanvas").getContext("2d");
		var arabic = <?php echo json_encode($arabicTwo) ?>;
		var asian = <?php echo json_encode($asianTwo) ?>;
		var caucasian = <?php echo json_encode($caucasianTwo) ?>;
		var hispanic = <?php echo json_encode($hispanicTwo) ?>;
		var indigenous = <?php echo json_encode($indigenousTwo) ?>;
		        
		var data = {
		    labels: ["Edmonton", "Montreal", "Ottawa", "Regina", "Toronto", "Vancouver", "Victoria", "Winnipeg"], //x-axis
		    datasets: [
		        {
		            label: "Arabic", //optional
		            fillColor: "rgba(140,152,225,0.8)",
		            strokeColor: "rgba(220,220,220,0.75)",
		            highlightFill: "rgba(140,152,225,0.8)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: arabic // y-axis
		        },
				{
		            label: "Asian", //optional
		            fillColor: "rgba(100,138,222,0.8)",
		            strokeColor: "rgba(220,220,220,0.75)",
		            highlightFill: "rgba(100,138,222,0.8)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: asian //y-axis
		        },
		        {
		            label: "Caucasian",
		            fillColor: "rgba(74,121,219,0.8)",
		            strokeColor: "rgba(220,220,220,0.75",
		            highlightFill: "rgba(74,121,219,0.8)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: caucasian // y-axis
		        },
		        {
		            label: "Hispanic",
		            fillColor: "rgba(43,108,220,0.8)",
		            strokeColor: "rgba(220,220,220,0.75)",
		            highlightFill: "rgba(43,108,220,0.8)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: hispanic // y-axis
		        },
		        {
		            label: "Indigenous",
		            fillColor: "rgba(0,80,219,0.8)",
		            strokeColor: "rgba(220,220,220,0.75)",
		            highlightFill: "rgba(0,80,219,0.8)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: indigenous // y-axis
		        }
		    ]
		};
		var options = {
		  multiTooltipTemplate: "<%=datasetLabel%> : <%= value %>",
		  scales: {
		  	xAxes: [{
		  		gridlines: {
		  			display: false
		  		}
		  	}]
		  },
		}
		var myFirstChart = new Chart(chrt).Bar(data, options);
		</script>

		<?php
		echo "<br></br><b><small> Number of Patients by Ethnicity and Average Age in Health System: </small></b>";
		echo "<p></p>";
		validateResult6($patientsEthnicity, $patientsEthnicity2);
		echo "<br></br><b><small> Patient Prescription Analytics: </small></b>";
		echo "<p></p>";
		echo "<small> Patients prescribed all available medications: </small>";
		validateResult3($allPatients, $allPatients2);
		echo "<br></br>";
		echo "<small> Lowest prescribed Dose of all prescriptions: </small>";
		validateResult4($lowestDose, $lowestDose2);
		echo "<br></br>";
		echo "<small> Highest prescribed Dose of all prescriptions: </small>";
		validateResult5($highestDose, $highestDose);
		?>

	</body>
</html>
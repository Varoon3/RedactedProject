<html>
	<head>
	<meta charset="utf-8" />
	<title> Analytics </title>
		<style>
			ul {
				/* list-style-type removes all bullet points from the list*/
				/* margin and padding removes default browser settings*/
				list-style-type: none;
				font-family: 'Arial';
				overflow: hidden;
				margin: 0;
				padding: 0;
				background-color: #00cccc;
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

		<p>
			<hr>
			<?php
			echo "<ul>";
			echo "<li class = \"item\"><a href=\"index.php?tbl=" .$_GET["tbl"]. "\">My Appointments</a></li>";
			if($_GET["tbl"] == "patient_registered"){
				$id = 160839453;
				$tbl = "patient_registered";
				$field = "carecardNum";
				echo "<li class = \"item\"><a href=\"homepage.php\">My HCR</a></li>";
				echo "<li class = \"item\"><a href=\"homepage.php\">My HCP</a></li>";
			}
			else if($_GET["tbl"] == "family_physician"){
				$id = 242518;
				$tbl = "Health_Care_Provider";
				$field = "hid";

				echo "<li class = \"item\"><a href=\"fp_view_two.php?tbl=" .$_GET["tbl"]. "\">My Patients</a></li>";
				echo "<li class = \"item\"><a href=\"fp_view_one.php?tbl=" .$_GET["tbl"]. "\">Grab Health Care Record</a></li>";
				echo "<li class = \"item\"><a href=\"analytics.php\">Analytics</a></li>";
				echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
				echo "<li class = \"item\"><a href=\"homepage.php\">Waitlist</a></li>";
			}
			else{ //Must be a Specialist
				$id = 141582;
				$tbl = "Health_Care_Provider";
				$field = "hid";

				echo "<li class = \"item\"><a href=\"fp_view_two.php?tbl=" .$_GET["tbl"]. "\">My Patients</a></li>";
				echo "<li class = \"item\"><a href=\"analytics.php\">Analytics</a></li>";
				echo "<li class = \"item\"><a href=\"homepage.php\">Create Appointment</a></li>";
				echo "<li class = \"item\"><a href=\"homepage.php\">Waitlist</a></li>";
			}


			echo "<li class = \"item\" id = \"logout\"><a href=\"homepage.php\">Log Out</a></li>";
			echo "</ul>";
			?>
		</p>
		
	</head>
	<body>
		<form method="POST" action="analytics.php">
	    <b><small><font face="Arial"> Disease Analytics Modifier: &nbsp </font></small></b>
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
		<b><small><font face="Arial">Custom Nucleotide Sequence: &nbsp </font></small></b><input type="text" value="" name="other">
		</br>
		</br>
  		 <input type="submit" value="Analyze" name="view" >
  		</form>


		<?php
		$db_conn = OCILogon("ora_d1l0b", "a57303159", "dbhost.ugrad.cs.ubc.ca:1522/ug");
		$success = true;

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

				$graphONE = executePlainSQL("select p.location, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by p.location order by p.location");

				$graphONETWO = executePlainSQL("select p.location, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by p.location order by p.location");

				$graphTWO = executePlainSQL("select p.location, h.ethnicity, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by (p.location, h.ethnicity) order by p.location");

				$graphTWOTWO = executePlainSQL("select p.location, h.ethnicity, count(h.carecardnum) from patient_registered p, health_care_record h where p.carecardnum = h.carecardnum and h.genetichistory like '%$sequence%' group by (p.location, h.ethnicity) order by p.location");

				validateResultONE($graphONE, $graphONETWO);
				validateResultTWO($graphTWO, $graphTWOTWO);

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
				printRecordONE($resultNext);
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

		function printRecordONE($result){
			echo "<br> Graph One Retrieved: <br>";
			echo "<table>";
			echo "<tr><th>Location</th><th>Number of Patients</th></tr>";

			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<tr><td>" . $row["LOCATION"] . "</td><td>" . $row["COUNT(H.CARECARDNUM)"] . "</td></tr>";
			}
			echo "</table>";  
		}

		?>

		<style>

			.chart-legend ul {
				list-style-type: none;
				background: white;
				color: black;
			}

			.chart-legend li span{
				display: inline-block;
				width: 12px;
				height: 12px;
				margin-right: 10px;
    		}

    	</style>

    	<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js' type='text/javascript'></script>
		<script src='Chart.Bar.js' type='text/javascript'></script>
		<canvas id="mycanvas" width="1000" height="200"></canvas>
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
		  legend : '<ul>'
		                +'<% for (var i=0; i<datasets.length; i++) { %>'
		                  +'<li>'
		                    +'<span style=\"background-color:<%=datasets[i].lineColor%>\"></span>'
		                    +'<% if (datasets[i].label) { %><%= datasets[i].label %><% } %>'
		                  +'</li>'
		                +'<% } %>'
		            +'</ul>'
		}


		var myFirstChart = new Chart(chrt).Bar(data, options);

		document.getElementById('js-legend').innerHTML = myFirstChart.generateLegend();

		</script>
	</body>
</html>
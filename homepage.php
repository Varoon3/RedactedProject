<html>
<head>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}

.users {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
  position: relative;
  text-align: center;
  max-width: 360px;
  z-index: 1;
}

  .header4 {
  text-align: left;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}

.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #00cccc;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #0028cc;
}


body {
  background: #00cccc; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #00cccc, #00cccc);
  background: -moz-linear-gradient(right, #00cccc, #00cccc);
  background: -o-linear-gradient(right, #00cccc, #00ccccF);
  background: linear-gradient(to left, #00cccc, #00cccc);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
</style>
</head>
<body>
<div class="login-page">
  <div class="form">
   
    <form class="login-form" method="POST" action="homepage.php">
      <input type="text" placeholder="ID" name="id"/>
      <input type="password" placeholder="password" name="password"/>
      <button name="log_in">login</button>
    </form>
  </div>
</div>

<div class="users">
  <h4> Sample Users </h4>
  <p class="header4"> Family Physician View: </p>
  <p>ID: 242518 </p>
  <p>Password: 1234 </p>
  </br>
  <p class="header4"> Specialist View: </p>
  <p>ID: 141582 </p>
  <p>Password: 1234 </p>
  </br>
  <p class="header4"> Patient View: </p>
  <p>ID: 160839453 </p>
  <p>Password: 1234 </p>
</div>
<?php
$db_conn = OCILogon("ora_c7n0b", "a40860158", "dbhost.ugrad.cs.ubc.ca:1522/ug");
	$success = true;
	if($db_conn){
		executePlainSQL("Drop table log_In_Tbl");
		executePlainSQL("create table log_In_Tbl (id number, password varchar2(30), tbl varChar(30))");
		executePlainSQL("insert into log_In_Tbl values(242518, '1234', 'family_physician')");
		executePlainSQL("insert into log_In_Tbl values(160839453, '1234', 'patient_registered')");
		executePlainSQL("insert into log_In_Tbl values(141582, '1234', 'specialist')");
		if(array_key_exists('log_in',$_POST)){
			$id = $_POST['id'];
			$pass = $_POST['password'];
			login($id, $pass);
			//$result = executePlainSQL("select tbl from log_In_Tbl where id=$id AND password='$pass'");
			//validateResult($result,$id);
			OCICommit($db_conn);
		}
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
function login($id, $pass) {
	$patientResult = executePlainSQL("select * from login_patient where id=$id AND pass=$pass");
	validateResult($patientResult, $id, "patient_registered");
	$physicianResult = executePlainSQL("select * from login_physician where id=$id AND pass=$pass");
	validateResult($physicianResult, $id, "family_physician");
	$specialistResult = executePlainSQL("select * from login_specialist where id=$id AND pass=$pass");
	validateResult($specialistResult, $id, "specialist");
}

function validateResult($result,$id,$table) { //prints results from a select statement
	//if the result query is empty, so invalid username/password
	if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
			echo "error";
	}
	else{
		setcookie('tbl', $table);
		setcookie('id', $id);
		//echo "HERE ARE MY VALUES: " . $_COOKIE["tbl"] . "";
		header("Location:index.php");
	}
}
?>
</body>
</html>
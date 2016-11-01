<html>
<p>Homepage<hr><br><br>
<p>Login</p>
<form method="POST" action="homepage.php">
<td>
   Username: <input type="text" value="" name="username"><br>
   Password: <input type="password" value="" name="password">
   </td>
<p><input type="submit" value="Log in" name="log_in" ></p>
</form>
<?php
	$db_conn = OCILogon("ora_c7n0b", "a40860158", "dbhost.ugrad.cs.ubc.ca:1522/ug");
	$success = true;
	if($db_conn){
		executePlainSQL("Drop table log_In_Tbl");
		executePlainSQL("create table log_In_Tbl (username varchar2(30), password varchar2(30), tbl varChar(30))");
		executePlainSQL("insert into log_In_Tbl values('familyphysician', '1234', 'family_physician')");
		executePlainSQL("insert into log_In_Tbl values('patient', '1234', 'patient_registered')");
		executePlainSQL("insert into log_In_Tbl values('specialist', '1234', 'specialist')");

		if(array_key_exists('log_in',$_POST)){
			$uname = $_POST['username'];
			$pass = $_POST['password'];
			$result = executePlainSQL("select tbl from log_In_Tbl where username='$uname' AND password='$pass'");
			validateResult($result);
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

function validateResult($result) { //prints results from a select statement
	//if the result query is empty, so invalid username/password
	if(!$row = OCI_Fetch_Array($result, OCI_BOTH)) {
			echo "error";
	}
	else{
		header("Location:index.php?tbl=$row[0]");
	}

}
?>

</html>
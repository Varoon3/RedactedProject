<?php

//resetting all cookies
setcookie("id" , '' , time()-50000, '/');
setcookie("tbl" , '' , time()-50000, '/');
setcookie("region" , '' , time()-50000, '/');
setcookie("speciality" , '' , time()-50000, '/');
setcookie("carecardNum" , '' , time()-50000, '/');
setcookie("name" , '' , time()-50000, '/');
header("Location:homepage.php");
exit();

?>
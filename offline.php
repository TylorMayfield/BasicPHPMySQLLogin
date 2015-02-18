Server is currently offline. Try Back later.

<?php

error_reporting(E_ERROR | E_PARSE);

$time = date("His");
$servername = "localhost";
$username = "admin_user";
$password = "treestump";
$dbname = "admin_user";

if($conn = mysqli_connect($servername, $username, $password, $dbname))
{
header("Location: index.php");
}
else
{

}

?>
<META http-equiv="refresh" content="5;">

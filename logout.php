<?php
$debuggy = "yes";


error_reporting(E_ERROR | E_PARSE);
$time = date("His");
$servername = "localhost";
$username = "admin_user";
$password = "treestump";
$dbname = "admin_user";
$userC = $_COOKIE['user'];
$hashC = $_COOKIE['hash'];

if($conn = mysqli_connect($servername, $username, $password, $dbname))
{
  if ($debuggy == "yes")
  {
    echo "connected <p>";
  }

}
else
{
  header("Location: offline.php");
}
if(!isset($_COOKIE["user"]))
{
  echo "Cookie not found";
} else
{
    $sql =("SELECT * FROM tblUser WHERE fldUser = '$userC' AND fldHash = '$hashC'");
    if ($debuggy == "yes")
    {
    echo "$sql <p>";
    }
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
      {
        echo "logged in";
        $loggedIn = "true";
        $query = "UPDATE tblUser SET fldHash = '{0}' WHERE `fldUser` = '$userC'";
        mysqli_query($conn, $query);
        header("Location: index.php");
      }
      else
      {
        echo "Not logged in";
        $loggedIn = "false";
        header("Location: index.php");
      }
}
?>

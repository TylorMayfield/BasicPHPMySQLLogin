<?php
//Admin page

$debuggy = "no";


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
if (isset($_POST["btnLogin"]))
{

  $userName = htmlentities($_POST["userName"], ENT_QUOTES, "UTF-8");
  $pass = htmlentities($_POST["pass"], ENT_QUOTES, "UTF-8");
  $sql =("SELECT * FROM tblUser WHERE fldUser = '$userName'");
  $result = mysqli_query($conn, $sql);
  $hash = $time + $userName + $pass;
  $hash = sha1($hash);

  if(mysqli_num_rows($result) > 0)
    {
      $userName = htmlentities($_POST["userName"], ENT_QUOTES, "UTF-8");
      $pass = htmlentities($_POST["pass"], ENT_QUOTES, "UTF-8");
      $sql =("SELECT * FROM tblUser WHERE fldUser = '$userName' AND fldPass = '$pass'");
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0)
        {
          echo "User Found hash is $hash";
          setcookie("user", $userName, time() + (86400 * 30), "/"); // 86400 = 1 day
          setcookie("hash", $hash, time() + (86400 * 30), "/"); // 86400 = 1 day
          $query = "UPDATE tblUser SET fldHash = '{$hash}' WHERE `fldUser` = '{$userName}'";
          mysqli_query($conn, $query);
          $userC = $_COOKIE['user'];
          $hashC = $_COOKIE['hash'];
          echo "<p> $userC <p>";
          echo "$hashC <p>";
          $loggedIn = "true";
          header("Location: chklogin.php");

          //header("Location: index.php");
        }
        else
        {
          echo "Incorrect Password";
        }
    }
    else
    {
      echo "User Not Found";
    }

}

if(!isset($_COOKIE["user"]))
{
  echo "Cookie not found";
  $loggedIn = "false";
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

        $loggedIn = "true";
      }
      else
      {
        $loggedIn = "false";
      }
}

?>

<?php
if($loggedIn == "false")
{
?>
<form class="form-signin" action="<?php print "index.php"; ?>" method="post" id="frmRegister">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="Username" name="userName" autofocus>
        <p>
        <input type="password" class="form-control" placeholder="Password" name="pass">

        <button class="btn btn-lg btn-primary btn-block" name="btnLogin" type="submit">Sign in</button>
</form>
<?php
}
?>

<?php
if($loggedIn == "true")
{
  ?> <a href="logout.php">Logout</a> <?php
  echo "logged in";
}
?>

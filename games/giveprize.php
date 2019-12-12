<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once '../db.php';
    include '../nav.php';
    if (!isset($_SESSION)){
      session_start();
    }
    if ($conn== false){
      die("Database failed. " . mysqli_error($conn));
    } else {
      $query= "SELECT * FROM users INNER JOIN inventory ON users.ID = inventory.ID AND inventory.coins > 0 ORDER BY inventory.coins DESC;";
      $result = mysqli_query($conn, $query);
      $resultCheck = mysqli_num_rows($result);
    }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="../style.css" rel="stylesheet" type="text/css">
    <?php
    if (!isset($_COOKIE['prize']) || $_COOKIE['prize'] == "\"\""){
      echo "<title>Not Allowed</title>";
      die ("<h2>You're not supposed to be here...</h2>");
    } else {
      echo "<title>You Won " . $_COOKIE['prize'] . " Bananaz</title>";
    }
     ?>
  </head>
  <body>
    <section id="main">
      <?php
      echo "<h1>You won <i class=\"em em-banana\" aria-role=\"presentation\" aria-label=\"BANANAZ\"></i>" . $_COOKIE['prize'] . "!</h1>\n<p>You can spin again tomorrow.</p>";
      date_default_timezone_set("America/New_York");
      $nowNow= date("Y-m-d h:i:sa");
      $uID= $_SESSION['ID'];
      $prize= (int)$_COOKIE['prize'];

      $query= "UPDATE users SET spunwheel= '$nowNow' WHERE ID= '$uID';";
      $result = mysqli_query($conn, $query);
      $query= "UPDATE inventory SET coins= coins + $prize WHERE ID= '$uID';";
      $result = mysqli_query($conn, $query);
       ?>
    <script type="text/javascript">
    function eraseCookie(name) {
          document.cookie = name+'="";-1; path=/';
      }
      eraseCookie("prize");
    </script>
    <?php
    var_dump($_COOKIE);
    // header( "refresh:3; url=/bot_site/index.php" );
     ?>
   </section>
  </body>
</html>

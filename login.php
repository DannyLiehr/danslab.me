<?php
include_once 'db.php';
include 'nav.php';
if (!isset($_SESSION)){
  session_start();
}
if (isset($_POST['login'])){
  $tag= $_POST['username'];
  $pass= base64_encode(hash('sha256', $_POST['passcode'], true));
  $query = "SELECT * FROM users INNER JOIN inventory ON users.ID=inventory.ID AND tag= '$tag' AND password ='$pass'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
      $_SESSION['username'] = $row['user_name'];
      $_SESSION['coins'] = $row['coins'];
      $_SESSION['ID'] = $row['ID'];
      header("Location: index.php");
    }
  } else if ($tag='' || $pass=''){
    echo "<h2>Either a password or a username wasn't entered.</h2>";
  } else {
    echo "<h2>Either your password or a username wasn't right. No, I won't tell you. It's me, guys. It's me who puts this evil into the world. I'm the one who does this.</h2>";
  }
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<link href="./style.css" rel="stylesheet" type="text/css">
  <head>
    <meta charset="utf-8">
    <title>Login- Super Beta By the way</title>
  </head>
  <body>
    <section id="main">
    <form method="POST" name="login">
      <span>Tag, no spaces between the # and numbers. (Name#1234):</span><br/><input type="text" name="username">
      <hr/>
      <span>Passcode:</span><br/><input type="password" name="passcode">
      <input type="submit" name="login" value="Login (Or Try To)">
      <input type="reset" name="cancel" value="Reset">
    </form>
  </section>
  </body>
</html>

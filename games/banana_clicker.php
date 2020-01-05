<?php
  include_once '../db.php';
  include '../nav.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Nanner Clicker</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>
  <body>

    <!-- Might need js for this bad boy. -->
    <?php

      $uID= $_SESSION['ID'];
      $query = "SELECT * FROM clickergame WHERE ID= '$uID'";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) = 0){
        mysqli_query($conn, "INSERT INTO clickergame (ID, coin) VALUES ('$uID', 0)");
      }
      // Let's use cookies to transfer things between languages I guess!

     ?>
     <script type="text/javascript">
     function createCookie(name, value, days) {
       var expires;
       if (days) {
         var date = new Date();
         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
         expires = "; expires=" + date.toGMTString();
       }
       else {
         expires = "";
       }
       document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
     }
     </script>
  </body>
</html>

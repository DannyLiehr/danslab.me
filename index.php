<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once 'db.php';
    include 'nav.php';
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
    <link href="./style.css" rel="stylesheet" type="text/css">
    <title>Dan's Bots</title>
  </head>
  <body>
    <p>Bananaz Leaderboard- Danny's Bots</p>
    <hr/>
    <?php
    if ($resultCheck > 0){
      echo "<table>
            <th>
              <tr><td>User</td>
              <td>Bananaz</td></tr>
            </th>";
      while($row = mysqli_fetch_assoc($result)){
        echo "<tr><td>" . $row['user_name'] . "</td><td>" . $row['coins'] . " </td></tr>";
      }
      echo "</table>";
    }

     ?>
  </body>
</html>

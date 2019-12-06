<?php
$currentFileInfo = pathinfo(__FILE__);
$requestInfo = pathinfo($_SERVER['REQUEST_URI']);
if($currentFileInfo['basename'] == $requestInfo['basename']){
  die();
}
if (!isset($_SESSION)){
  session_start();
}
?>
<nav>
  <ul>
    <?php
        if (isset($_SESSION['ID'])){
          $uID= $_SESSION['ID'];
          $query = "SELECT * FROM users INNER JOIN inventory ON users.ID=inventory.ID AND users.ID='$uID'";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
              $bananaz= $row['coins'];
            }
          }
          echo "<li><a href=\"logout.php\">Logout</a></li>";
          echo "<li>Bananaz: " . $bananaz . "</li>";
        } else {
          echo "<li><a href=\"login.php\">Login</a></li>";
        }
     ?>
  </ul>
</nav>

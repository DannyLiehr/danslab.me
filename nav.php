<head>
  <link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">
</head>
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
  <div class="navwrapper">
<nav>
  <ul>
    <?php
        echo "<li><a class=\"command\" href=\"/bot_site/index.php\">Home</a></li>";
        if (isset($_SESSION['ID'])){
          $uID= $_SESSION['ID'];
          $query = "SELECT * FROM users INNER JOIN inventory ON users.ID=inventory.ID AND users.ID='$uID'";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
              $bananaz= $row['coins'];
              $usern= $row['user_name'];
            }
          }
          echo "<li><a class=\"command\" href=\"/bot_site/logout.php\">Logout</a></li>";
          echo "<li><a class=\"command\" href=\"/bot_site/profile.php\">Profile</a></li>";
          echo "<li><a class=\"command\" href=\"/bot_site/games/wheel.php\">Wheel-of-fortune</a></li>";
          echo "<li>Hello, " . $usern ."</li>";
          echo "<li><i class=\"em em-banana\" aria-role=\"presentation\" aria-label=\"BANANAZ\"></i> " . $bananaz . "</li>";
          echo "<i class=\"em em-mostly_sunny hide-text\" aria-role=\"presentation\" aria-label=\"mostly sunny\"><a href=\"/bot_site/weather.php\">☁️</a></i>";
        } else {
          echo "<li><a class=\"command\" href=\"/bot_site/login.php\">Login</a></li>";
        }
     ?>
</nav>
</ul>
</div>

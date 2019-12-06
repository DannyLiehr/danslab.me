<?php
  if (!isset($_SESSION)){
    session_start();
  }
  include_once './db.php';
  include './nav.php';
  // Are they logged in?
  if (!isset($_SESSION['ID'])){
    // Uhh. No.
    header("Location: login.php");
  } else {
    $uID= $_SESSION['ID'];
    $query = "SELECT * FROM users INNER JOIN inventory ON users.ID = inventory.ID WHERE users.ID='$uID'";
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="./style.css" rel="stylesheet" type="text/css">
    <title>Edit Your Profile</title>
  </head>
  <body>
    <section id="main">
      <?php
    }
    if ($_SERVER['REQUEST_METHOD']=='POST'){
      // Did they change their password? Check that first.
      $uID= $_SESSION['ID'];
      $pCheck= $_POST['password'];
      $fieldsUpdated= 0;
      if ($pCheck != ''){
        // Yeah, they filled in their password field.
        $pass= base64_encode(hash('sha256', $_POST['password'], true));
        $cPass= base64_encode(hash('sha256', $_POST['conf-password'], true));
        // Compare the two.
        if ($pass == $cPass){
          mysqli_query($conn, "UPDATE users SET password='$pass' WHERE ID='$uID';");
          $fieldsUpdated += 1;
        } else {
          echo "<h3>Your passwords didn't match.</h3>";
        }
      }

      if ($_POST['displayName'] != '' || $_POST['displayName'] != $row['user_name']){
        $nick= $_POST['displayName'];
        mysqli_query($conn, "UPDATE users SET user_name='$nick' WHERE ID='$uID';");
        $fieldsUpdated += 1;
      }

      if ($_POST['mood'] != '' || $_POST['mood'] != $row['mood']){
        $mood= $_POST['mood'];
        mysqli_query($conn, "UPDATE users SET mood='$mood' WHERE ID='$uID';");
        $fieldsUpdated += 1;
      }

      if ($_POST['bio'] != '' || $_POST['bio'] != $row['bio']){
        $bio= $_POST['bio'];
        mysqli_query($conn, "UPDATE users SET bio='$bio' WHERE ID='$uID';");
        $fieldsUpdated += 1;
      }

      if ($fieldsUpdated > 1){
        echo "<section><h3>Your profile has been updated.</h3><hr/></section>";
      }
      // End Profile Editing.
    }

       ?>
      <h2>Edit Profile</h2>
    <form method="POST" name="profile">
      <span>Display Name<input type="text" name="displayName" value="<?php echo $row['user_name'] ?>"></span>
      <span>Mood<input type="text" name="mood" value="<?php echo $row['mood'] ?>"></span>
      <span>Main Pronoun<select style="width: 130px;">
        <option value="they">They/Them</option>
        <option value="she">She/Her</option>
        <option value="he">He/Him</option>
        <option value="it">It/Its</option>
        <option value="xe">Xe/Xem</option>
        <option value="xir">xir/xirs</option>
      </select></span><small>This will have multi pronoun support later.</small>
      <span>Bio<textarea rows="4" cols="17" name="bio"><?php echo $row['bio'] ?></textarea></span>
      <hr/>
      <span>Change Password<input type="password" name="password"></span>
      <span>Confirm Password<input type="password" name="conf-password"></span>
      <input type="submit" name="ok" value="Update Your Profile" style="position: absolute; left:0; right: 0;">
    </form>
    </section>
  </body>
</html>

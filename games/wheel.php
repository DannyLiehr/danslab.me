<?php
include_once '../db.php';
include '../nav.php';
?>
<!DOCTYPE html>
<html>
<html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
        <title>Daily Prize</title>
        <link href="../style.css" rel="stylesheet" type="text/css">
         <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
        <script src='../Winwheel.js'></script>
        <style>
        body
        {
            font-family: arial;
        }

        /* Sets the background image for the wheel */
        td.the_wheel
        {
            background-image: url(./wheel_back.png);
            background-position: center;
            background-repeat: none;
        }

        /* Do some css reset on selected elements */
        h1, p
        {
            margin: 0;
        }

        div.power_controls
        {
            margin-right:70px;
        }

        div.html5_logo
        {
            margin-left:70px;
        }

        /* Styles for the power selection controls */
        table.power
        {
            background-color: #cccccc;
            cursor: pointer;
            border:1px solid #333333;
        }

        table.power th
        {
            background-color: white;
            cursor: default;
        }

        td.pw1
        {
            background-color: #6fe8f0;
        }

        td.pw2
        {
            background-color: #86ef6f;
        }

        td.pw3
        {
            background-color: #ef6f6f;
        }

        /* Style applied to the spin button once a power has been selected */
        .clickable
        {
            cursor: pointer;
        }

        /* Other misc styles */
        .margin_bottom
        {
            margin-bottom: 5px;
        }
        </style>
    </head>
    <body>
      <?php
      date_default_timezone_set("America/New_York");
      $uID = $_SESSION['ID'];
      $query = "SELECT * FROM users INNER JOIN inventory ON users.ID=inventory.ID AND users.ID= '$uID'";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
          $spunW= date('m/d', strtotime($row['spunwheel']));
          }
        }
        $today= date('m/d');
        if ($spunW == $today){
          die ("<h2>You already spun the wheel for prizes today. Try again tomorrow.</h2>");
        }
       ?>
        <div align="center">
          <h1>Daily Prize</h1>
          <p><i class="em em-arrow_down_small" aria-role="presentation" aria-label="DOWN-POINTING SMALL RED TRIANGLE"></i></p>
            <!-- Always set canvas to largest desired size, i.e. desktop PC size, it will be scaled down for smaller devices but never scaled up -->
            <canvas id="canvas" width="500" height="500" style="background-color: transparent;" data-responsiveMinWidth="180" data-responsiveScaleHeight="true" onClick="startSpin();">
                <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
            </canvas>
            <br /><br />
        </div>
        <script>
            // Create winwheel as per normal.
            let theWheel = new Winwheel({
                'numSegments'  : 23,     // Specify number of segments.
                'textFontSize' : 28,    // Set font size as desired.
                'responsive'   : true,  // This wheel is responsive!
                'segments'     :        // Define segments including colour and text.
                [
                    {'fillStyle' : '#eae56f', 'text' : '20'},
                    {'fillStyle' : '#89f26e', 'text' : '7'},
                    {'fillStyle' : '#7de6ef', 'text' : '5'},
                    {'fillStyle' : '#e7706f', 'text' : '2'},
                    {'fillStyle' : '#eae56f', 'text' : '20'},
                    {'fillStyle' : '#89f26e', 'text' : '7'},
                    {'fillStyle' : '#7de6ef', 'text' : '5'},
                    {'fillStyle' : '#e7706f', 'text' : '2'},
                    {'fillStyle' : '#eae56f', 'text' : '20'},
                    {'fillStyle' : '#89f26e', 'text' : '7'},
                    {'fillStyle' : '#7de6ef', 'text' : '5'},
                    {'fillStyle' : '#4d78e3', 'text' : '100'},
                    {'fillStyle' : '#eae56f', 'text' : '20'},
                    {'fillStyle' : '#89f26e', 'text' : '7'},
                    {'fillStyle' : '#7de6ef', 'text' : '5'},
                    {'fillStyle' : '#e7706f', 'text' : '2'},
                    {'fillStyle' : '#eae56f', 'text' : '20'},
                    {'fillStyle' : '#89f26e', 'text' : '7'},
                    {'fillStyle' : '#7de6ef', 'text' : '5'},
                    {'fillStyle' : '#e7706f', 'text' : '2'},
                    {'fillStyle' : '#eae56f', 'text' : '20'},
                    {'fillStyle' : '#89f26e', 'text' : '7'},
                    {'fillStyle' : '#7de6ef', 'text' : '5'},
                ],
                'pins' :
                {
                    'outerRadius': 6,
                    'responsive' : true, // This must be set to true if pin size is to be responsive, if not just location is.
                },
                'animation' :           // Specify the animation to use.
                {
                    'type'     : 'spinToStop',
                    'duration' : 7,     // Duration in seconds.
                    'spins'    : 16,     // Number of complete spins.
                    'callbackFinished' : alertPrize
                }
            });
            // -----------------------------------------------------------------
            // Called by the onClick of the canvas, starts the spinning.


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

            function startSpin()
            {
                // Stop any current animation.
                theWheel.stopAnimation(false);
                // Reset the rotation angle to less than or equal to 360 so spinning again
                // works as expected. Setting to modulus (%) 360 keeps the current position.
                theWheel.rotationAngle = theWheel.rotationAngle % 360;
                // Start animation.
                theWheel.startAnimation();
            }
            function alertPrize(indicatedSegment){
              // alert(`You got 🍌${indicatedSegment.text}.`);
              createCookie("prize",indicatedSegment.text, "1");
              // $directory= $_SERVER["HTTP_HOST"];
              // if ($_SERVER['HTTP_HOST']=='localhost'){
              //   $directory= $directory . "/bot_site";
              // }
              var host = window.location.hostname;
              var directory = host;
              if (host == 'localhost'){
                directory = directory + "/bot_site";
              }
              window.location.href = "//"+ directory + "/games/giveprize.php";
            }
        </script>
    </body>
</html>

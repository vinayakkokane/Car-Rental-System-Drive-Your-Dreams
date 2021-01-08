<?php
session_start();
include('Includes/server.php');
if (!isset($_SESSION['username'])) {
  echo "<script type = \"text/javascript\">
                  alert(\"You must login first\");
                window.location = (\"index.php\")
      </script>";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script src="https://kit.fontawesome.com/3695790714.js" crossorigin="anonymous"></script>
    <title>Payment Done</title>
    <link rel="icon" href="images/favicon-16x16.png">
	<link rel="stylesheet" href="CSS/styles.css">
  </head>
  <body>
    
    <header>
      <?php
      include('Includes/header.php');
      ?>
    </header>
    <div class="container text-center" style="margin-top: 150px;">
      <div class="alert-box">
        <div class="alert alert-success">
          <div class="alert-icon text-center">
            <i class="fa fa-check-square-o  fa-3x" aria-hidden="true"></i>
          </div>
          <div class="alert-message text-center">
            <strong>Payment Successful!</strong> <br><br>
            <h4>You will receive the confirmation from us shortly. Thank you!</h4>
          </div>
        </div>
        <p style="float: right; font-style:italic; font-weight:bold; font-size:18px"  class="text-danger">Check your booking status in My Bookings section!</p>

      </div>
    </div>
    <?php
		$_SESSION['id'] = "";
		$_SESSION['amount'] = "";
		?>
    <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

  </body>
</html>
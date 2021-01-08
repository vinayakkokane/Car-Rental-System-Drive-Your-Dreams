<?php
session_start();
include('Includes/server.php');
if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: index.php');
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
    <title>Drive Your Dreams</title>
    <link rel="icon" href="images/favicon-16x16.png">
  </head>
  <body>
    <?php
      $username = $_SESSION['username'];
      if (isset($_POST['submit'])) {
        $qtype = $_POST['type'];
        $qmsg = $_POST['ask'];

      $sql1 = "INSERT INTO query (username, q_type, q_messege) VALUES('$username','$qtype','$qmsg')";
      mysqli_query($db,$sql1);
    }
    ?>
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
            <strong>Success!</strong> <h4>Your Query has been sent.</h4>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="icon" href="images/favicon-16x16.png">
  <link rel="stylesheet" href="CSS/styles.css">
  <title>My Bookings</title>
  <style>
    td {
      font-size: 18px;
      font-weight: bold
    }

    th {
      font-size: 18px;
    }

    .image:hover {
      transform: scale(1.2);
    }

    .bookings {
      border: 2px solid black;
      border-radius: 2em;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <!-- navbar -->
  <?php
  include('Includes/header.php');
  ?>

  <h1 style="text-align:center; color:Brown; margin-top: 100px; font-weight:bold; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;"> My Bookings Section </h1>

  <?php
  include('./Includes/config.php');
  $username = $_SESSION['username'];
  $sel = "SELECT * FROM clients where username='$username'";
  $rs1 = $dbh->query($sel);
  if (mysqli_num_rows($rs1)) {
  ?>
    <div class="container bookings">
      <table class="table" style="margin-top: 20px;">
        <thead class="thead-dark">
          <tr>
            <th class="text-center">Booking Id</th>
            <th class="text-center">Car Image</th>
            <th class="text-center">Car Id</th>
            <th class="text-center">Booking Status</th>
            <th class="text-center"></th>
            <th class="text-center"></th>
          </tr>
        </thead>

        <?php
        $_SESSION['id'] = '';
        $_SESSION['amount'] = '';
        $username = $_SESSION['username'];
        $sel = "SELECT * FROM clients where username='$username'";
        $rs1 = $dbh->query($sel);

        ?>
        <tbody>
          <?php
          while ($rws = $rs1->fetch_assoc()) {
          ?>
            <tr>
              <td style="vertical-align:middle; font-size:20px;" align="center"><?php echo $rws['id']; ?></td>
              <?php
              $cid = $rws['carid'];
              $car = "SELECT car_type,image FROM cars where car_id='$cid'";
              $cardetails = $dbh->query($car);
              $c_rws = $cardetails->fetch_assoc();
              ?>

              <td> <img class="image" style="border-radius: 6px; height: 140px; width: 250px;" src="./Cars/<?php echo $c_rws['car_type']; ?>/<?php echo $c_rws['image']; ?>" alt=""></td>
              <td style="vertical-align:middle;" align="center"><?php echo $rws['carid']; ?></td>
              <?php if ($rws['status'] == 'Pending') {
              ?>
                <form action="pay.php" method="POST">
                  <td style="vertical-align:middle" align="center" class="text-danger">Pending</td>
                  <td style="vertical-align:middle" align="center"> <button class="btn btn-dark text-light btn-outline-success" style="font-size: 15px; font-weight:bold" name="cont_booking" value="<?php echo $rws['id']; ?>">Continue Booking</button>
                  </td>
                </form>

              <?php
              } elseif ($rws['status'] == 'Paid') {
              ?>
                <td style="vertical-align:middle" align="center" class="text-secondary">Not yet Approved</td>
                <td></td>
              <?php
              } elseif ($rws['status'] == 'Approved') {
              ?>
                <td style="vertical-align:middle" align="center" class="text-success">Approved</td>
                <td></td>
              <?php
              } else {
              ?>
                <td style="vertical-align:middle" align="center" class="text-danger"><?php echo $rws['status'] ?></td>
              <?php
              }
              if ($rws['status'] == 'Cancelled' || $rws['status'] == 'Cancel Pending' || $rws['status'] == 'Rejected' || $rws['status'] == 'Approved') {
              ?>
              <?php
              } else {
              ?>
                <form action="cancel_booking.php" method="POST">
                  <td style="vertical-align:middle" align="center"> <button class="btn btn-dark text-light btn-outline-danger" style="font-size: 15px; font-weight:bold" name="cancel_booking" value="<?php echo $rws['id']; ?>">Cancel Booking</button>
                  </td>
                </form>
              <?php
              }
              ?>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php
  } else {
  ?>
    <div class="text-danger">
      <h2 style="text-align:center; color:maroon; margin-top:25px">You don't have any bookings! Start your wonderful journey.</h2>
    </div>
  <?php
  }
  ?>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>
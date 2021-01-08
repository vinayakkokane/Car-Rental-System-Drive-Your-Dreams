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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://kit.fontawesome.com/3695790714.js" crossorigin="anonymous"></script>
  <link rel="icon" href="images/favicon-16x16.png">
  <link rel="stylesheet" href="CSS/styles.css">

  <title>My Profile</title>
  <style>
    html,
    body {
      max-width: 100%;
      overflow-x: hidden;
    }

    label {
      font-size: 20px;
      color: brown;
    }

    input,
    select {
      font-size: 18px;
    }

  </style>
</head>

<body>
  <header>
    <?php
    include('Includes/header.php');
    ?>
  </header>

  <div class="container" style="margin-top: 100px; margin-left: 32%;">
    <div class="row">
      <!-- edit form column -->
      <div class="col-md-9">
        <h2 style="color:sienna; font-weight:bold;">Personal Details</h3><br>
        <?php
        $username = $_SESSION['username'];
        $qr = "SELECT * FROM users WHERE username = '$username'";
        $res = $db->query($qr);
        $rws = $res->fetch_assoc();
        ?>

        <?php
        $id=$rws['id'];
        $qr = "SELECT * FROM userprofile WHERE id = '$id'";
        $res1 = $db->query($qr);
        $rws1 = $res1->fetch_assoc();
        ?>
        <form action="profile.php" class="form-horizontal" role="form" method="POST">
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" value="<?php echo $rws['email'] ?>" name="email" id="email" type="email" required readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Username :</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="uname" value="<?php echo $rws['username'] ?>" required readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">First name :</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="<?php if($rws1) echo $rws1['fname'] ?>" name="fname" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name :</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="<?php if($rws1) echo $rws1['lname']?>"  name="lname" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Time Zone :</label>
            <div class="col-lg-8">
              <div class="ui-select">
                <select id="user_time_zone" name="time" class="form-control" required>
                  <option value="" selected="selected">Please select your time-zone</option>
                  <option value="Hawaii">(GMT-10:00) Hawaii</option>
                  <option value="Alaska">(GMT-09:00) Alaska</option>
                  <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                  <option value="Arizona">(GMT-07:00) Arizona</option>
                  <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                  <option value="Central Time (US &amp; Canada)">(GMT-06:00) Central Time (US &amp; Canada)</option>
                  <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                  <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Date of Birth :</label>
            <div class="col-md-8">
              <input class="form-control" type="text" placeholder="dd/mm/yyyy" name="dob" type="text" value="<?php if($rws1) echo $rws1['dob'] ?>"  required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Phone Number : </label>
            <div class="col-md-8">
              <input class="form-control" type="number" name="mob" value="<?php if($rws1) echo $rws1['mob']?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Your Address : </label>
            <div class="col-md-8">
              <input class="form-control" name="address" type="text" value="<?php if($rws1) echo $rws1['address']?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Country : </label>
            <div class="col-md-8">
              <input class="form-control" id="country" name="country" value="<?php if($rws1) echo $rws1['country']?>" type="text" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">City : </label>
            <div class="col-md-8">
              <input class="form-control" id="city" name="city" value="<?php if($rws1) echo $rws1['city']?>" type="text" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-outline-success text-light btn-dark" name="updtprof" style="float: right;" value="Update Profile">
            </div>
          </div>
        </form>


      </div>
    </div>
  </div>

  <?php
  if (isset($_POST['updtprof'])) {
    $id = $rws['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $mob = $_POST['mob'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    if ($rws1['id']==NULL) {
        $insert_qry = "INSERT INTO userprofile (id,fname,lname,dob,mob,country,city,address)
          VALUES('$id','$fname','$lname','$dob','$mob','$country','$city','$address')";
        $result = $db->query($insert_qry);
    }

    else{
      $updt_qry = "UPDATE userprofile SET fname='$fname',lname='$lname',dob='$dob',mob='$mob',country='$country',city='$city',address='$address' WHERE id='$id'";
    $result = $db->query($updt_qry);
    }

    if ($result == TRUE) {
      echo "<script type = \"text/javascript\">
                  alert(\"Profile updated Successfully...\");
                  window.location = (\"profile.php\")
                  </script>";
    } else {
      echo "<script type = \"text/javascript\">
                  alert(\"Something went wrong.. Please Try Again\");
                  window.location = (\"profile.php\")
                  </script>";
    }
  }
  ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
<!-- $qry = "INSERT INTO userprofile (id,fname,lname,dob,mob,country,city,address)
          VALUES('$id','$fname','$lname','$dob','$mob','$country','$city','$address')";
     -->
</html>
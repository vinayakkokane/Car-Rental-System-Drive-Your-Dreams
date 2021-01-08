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

    <title>Cancel Booking</title>
    <style>
        .header {
            width: 50%;
            margin: 100px auto 0px;
            text-align: center;
            padding: 20px;
          }
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        label {
            font-size: 20px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color: brown;
        }

        input,
        select {
            font-size: 18px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        form {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            border: none;
        }

        .form-container {
            margin-left: 32%;
        }

        .image:hover {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST['cancel'])) {
        $b_id = $_POST['b_id'];

        $qr = "UPDATE clients SET status='Cancel Pending' WHERE id = '$b_id'";
        mysqli_query($db, $qr);

        //sending cancellation mail
        $user = "SELECT username FROM clients WHERE id='$id'";
        $res = $db->query($user);
        $rws = $res->fetch_assoc();
        $username = $rws['username'];
        $qr = "SELECT email FROM users WHERE username='$username'";
        $res = $db->query($qr);
        $rws = $res->fetch_assoc();

        $receiver = $rws['email'];
        $subject = "Regarding Booking cancellation!";
        $message = "
 
 Dear $username,
    Your Booking with Booking ID $id has been requested for cancellation.   
 
    We are sad to see you go! We understand there can be multiple reasons of cancelling the booking.
   
    For any further queries feel free to contact-us.

    Thanks & Regards!

    Drive your Dreams";

        $sender = "From: vinayaklkokane2001@gmail.com";
        mail($receiver, $subject, $message, $sender);

        echo "<script type = \"text/javascript\">
                alert(\"Booking Cancellation Requested Successfully!\")
                window.location = (\"mybookings.php\")
            </script>";
    }
    ?>

        <?php
        include('Includes/header.php');?>
        
    <div class="header">
        <h2>Confirm Booking Details </h2>
    </div>
    <form action="" class="form-horizontal form-container" method="POST" enctype="multipart/form-data">

        <div class="form-group">


            <?php
            $bid = $_POST['cancel_booking'];
            $qr1 = "SELECT * FROM clients WHERE id = '$bid'";
            $res1 = $db->query($qr1);
            $rws1 = $res1->fetch_assoc();

            $carid = $rws1['carid'];
            $qr2 = "SELECT * FROM cars WHERE car_id = '$carid'";
            $res2 = $db->query($qr2);
            $rws2 = $res2->fetch_assoc();
            ?>

            <div class="form-group">
                <label class="col-md-3 control-label">Booking Id : </label>
                <div class="col-md-8">
                    <input class="form-control" name="b_id" value="<?php echo $rws1['id'] ?>" type="text" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Car Image : </label>
                <div class="col-md-8 mx-auto">
                    <img class="image " style="border-radius: 6px; height: 140px; width: 250px;" src="./Cars/<?php echo $rws2['car_type']; ?>/<?php echo $rws2['image']; ?>"> </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Car Id : </label>
                <div class="col-md-8">
                    <input class="form-control" name="car_id" value="<?php echo $rws2['car_id'] ?>" type="text" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Car Name : </label>
                <div class="col-md-8">
                    <input class="form-control" name="car_name" value="<?php echo $rws2['car_name'] ?>" type="text" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Booking status : </label>
                <div class="col-md-8">
                    <input class="form-control" name="status" value="<?php echo $rws1['status'] ?>" type="text" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8 mx-auto">
                    <button class="btn btn-dark btn-outline-danger text-light" name="cancel" type="submit">Cancel Booking</button><br><br>
                </div>
            </div>
    </form>
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
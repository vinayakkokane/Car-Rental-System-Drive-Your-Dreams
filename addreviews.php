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
    <link rel="icon" href="images/favicon-16x16.png">
    <link rel="stylesheet" href="CSS/styles.css">
    <title>Queries</title>
    <style media="screen">
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

        input,
        select {
            font-size: 18px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .formcontainer {
            width: 50%;
            margin-top: 40px;
            margin-left: 32%;
            font-size: 20px;
        }

        .queries {
            width: 75%;
            margin: 20px auto;
            margin-bottom: 20px;
        }

        td {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php

    if (isset($_POST['submit'])) {
        $username = $_SESSION['username'];
        $bid = $_POST['bid'];
        $cid = $_POST['cid'];
        $rev = $_POST['review'];

        $qry = "INSERT INTO reviews (username, b_id,car_id, review) VALUES('$username','$bid','$cid','$rev')";
        mysqli_query($db, $qry);

        //sending mail
        $username = $_SESSION['username'];
        $qr = "SELECT email FROM users WHERE username='$username'";
        $res = $db->query($qr);
        $rws = $res->fetch_assoc();

        $receiver = $rws['email'];
        $subject = "Review submitted successfully";
        $message = "
 
 Dear $username,  
   Thanks for sharing your valuable experience with us. 
   
   Your review for Booking ID $bid has successfully been submitted. 
   Your feedback helps us to improve user experience. 
   Thanks & Regards!
   Drive your Dreams";

        $sender = "From: vinayaklkokane2001@gmail.com";
        mail($receiver, $subject, $message, $sender);

        echo "<script type = \"text/javascript\">
                  alert(\"Your review has been submitted successfully\");
                window.location = (\"post_testimonal.php\")
      </script>";
    }
    //booking details
    $id = $_POST['add_review'];
    $qr1 = "SELECT * FROM clients WHERE id = '$id'";
    $res1 = $db->query($qr1);
    $rws1 = $res1->fetch_assoc();

    //car details
    $cid = $rws1['carid'];
    $qr2 = "SELECT * FROM cars WHERE car_id = '$cid'";
    $res2 = $db->query($qr2);
    $rws2 = $res2->fetch_assoc();

    include('Includes/header.php');
    ?>

    <h1 style="text-align:center; color:Brown; margin-top: 100px; font-weight:bold; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Post your reviews here!</h1>

    <form action="" method="POST" class="formcontainer">
        <div class="form-group">
            <label class="col-md-3 control-label">Car Image : </label>
            <div class="col-md-8 mx-auto">
                <img class="image " style="border-radius: 6px; height: 140px; width: 250px;" src="./Cars/<?php echo $rws2['car_type']; ?>/<?php echo $rws2['image']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Booking ID : </label>
            <div class="col-md-8">
                <input class="form-control" name="bid" value="<?php echo $rws1['id'] ?>" type="text" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Car ID : </label>
            <div class="col-md-8">
                <input class="form-control" name="cid" value="<?php echo $rws1['carid'] ?>" type="text" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Write a review : </label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="review" placeholder="Describe your experience" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8 mx-auto">
                <input type="submit" class="btn btn-dark" name="submit" value="Submit Review"><br><br>
            </div>
        </div>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>
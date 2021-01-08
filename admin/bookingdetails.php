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
    <style>
        .bookings {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .container {
            border: 2px solid brown;
            border-radius: 3em;
            display: flex;
            justify-content: space-around;
            padding: 10px;
        }

        .items {
            margin: 4px;
            padding: 10px;
            align-items: center;
        }


        h3 {
            color: brown;
            font-weight: bold;
        }

        form {
            display: block;
        }

        .header {
            width: 50%;
            margin: 50px auto 0px;
            text-align: center;
            padding: 20px;
        }

        .header h2 {
            color: rgb(235, 68, 62);
            font-weight: bold;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            border-radius: 3em;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    include('../Includes/config.php');
    if (strlen($_SESSION['uname']) == 0) {
        header('location:index.php');
    } else {
        include('includes/navbar.php');
    }
    ?>

    <?php
    //Approve booking
    if (isset($_POST['approve'])) {
        $id = $_POST['approve'];
        $qr = "UPDATE clients SET status = 'Approved' WHERE id='$id'";
        mysqli_query($dbh, $qr);

        $user = "SELECT username FROM clients WHERE id='$id'";
        $res = $dbh->query($user);
        $rws = $res->fetch_assoc();

        //Updating Car status
        $carid = $rws['carid'];
        $upd = "UPDATE cars SET status='Available' WHERE car_id='$carid'";
        mysqli_query($dbh, $upd);

        //sending mail
        $username = $rws['username'];
        $qr = "SELECT email FROM users WHERE username='$username'";
        $res = $dbh->query($qr);
        $rws = $res->fetch_assoc();

        $receiver = $rws['email'];
        $subject = "Booking Confirmed";
        $message = "
 
 Dear $username,  
   Congratulations! Your Booking having Booking ID $id has been Approved.
   
   Start your wonderful journey. We wish you a happy & safe driving!

   Thanks & Regards!

   Drive your Dreams";

        $sender = "From: vinayaklkokane2001@gmail.com";
        mail($receiver, $subject, $message, $sender);

        echo "<script type = \"text/javascript\">
        alert(\"Booking has been Approved Successfully!\")
        window.location = (\"bookings.php\")
  </script>";
    }
    //Cancel booking
    if (isset($_POST['cancel'])) {
        $id = $_POST['cancel'];
        $qr = "UPDATE clients SET status = 'Cancelled' WHERE id='$id'";
        mysqli_query($dbh, $qr);


        $user = "SELECT username FROM clients WHERE id='$id'";
        $res = $dbh->query($user);
        $rws = $res->fetch_assoc();

        //Updating Car status
        $carid = $rws['carid'];
        $upd = "UPDATE cars SET status='Available' WHERE car_id='$carid'";
        mysqli_query($dbh, $upd);

        //sending mail
        $username = $rws['username'];
        $qr = "SELECT email FROM users WHERE username='$username'";
        $res = $dbh->query($qr);
        $rws = $res->fetch_assoc();

        $receiver = $rws['email'];
        $subject = "Booking Cancelled";
        $message = "
 
 Dear $username,  
    As per your request, Your Booking having Booking ID $id has been Cancelled successfully.
   
    Your refund will be initiated within 10-15 buisness days.
    
    For any further queries feel free to contact-us.

   Thanks & Regards!

   Drive your Dreams";

        $sender = "From: vinayaklkokane2001@gmail.com";
        mail($receiver, $subject, $message, $sender);
        echo "<script type = \"text/javascript\">
        alert(\"Booking has been Cancelled Successfully!\")
        window.location = (\"bookings.php\")
  </script>";
    }
    //Reject booking
    if (isset($_POST['reject'])) {
        $id = $_POST['reject'];
        $qr = "UPDATE clients SET status = 'Rejected' WHERE id='$id'";
        mysqli_query($dbh, $qr);

        //sending mail
        $user = "SELECT username FROM clients WHERE id='$id'";
        $res = $dbh->query($user);
        $rws = $res->fetch_assoc();
        $username = $rws['username'];
        $qr = "SELECT email FROM users WHERE username='$username'";
        $res = $dbh->query($qr);
        $rws = $res->fetch_assoc();

        $receiver = $rws['email'];
        $subject = "Booking Rejected";
        $message = "
 
 Dear $username,  
    Your Booking having Booking ID $id has been Rejected.
   
    There can be severel reasons why the booking gets rejected. One of them is providing fake id documents. 
    
    Your refund will be initiated within 10-15 buisness days.
    
    For any further queries feel free to contact-us.

   Thanks & Regards!

   Drive your Dreams";

        $sender = "From: vinayaklkokane2001@gmail.com";
        mail($receiver, $subject, $message, $sender);

        echo "<script type = \"text/javascript\">
        alert(\"Booking has been Rejected Successfully!\")
        window.location = (\"bookings.php\")
  </script>";
    }
    ?>

    <div class="header">
        <h2>Client Booking Details!</h2>
    </div>

    <?php
    if (isset($_POST['details'])) {
        //Booking details
        $b_id = $_POST['details'];
        $bookings = "SELECT * FROM clients WHERE id='$b_id'";
        $res = $dbh->query($bookings);
        $rws1 = $res->fetch_assoc();
        //User details
        $user = $rws1['username'];
        $u_details = "SELECT id,username,email FROM users WHERE username='$user'";
        $u_res = $dbh->query($u_details);
        $rws2 = $u_res->fetch_assoc();
        //Profile details
        $user_id = $rws2['id'];
        $userprofile = "SELECT * FROM userprofile WHERE id='$user_id'";
        $prof_res = $dbh->query($userprofile);
        $rws3 = $prof_res->fetch_assoc();
    }
    ?>
    <div class="container bookings">
        <div class="items">
            <h3>Booking Details : </h3>
            <div style="margin-top: 20px;">
                <div>
                    <p>Booking ID : <?php echo $b_id; ?></p>
                    <p>Client Username : <?php echo $rws1['username']; ?></p>
                    <p>Booked Car ID : <?php echo $rws1['carid']; ?></p>
                    <p>Staus : <?php echo $rws1['status']; ?></p>
                    <?php if ($rws1['status'] == 'Paid') {
                    ?>
                        <p>Amount Paid : <?php echo $rws1['amount']; ?></p>
                    <?php } else { ?>
                        <p>Amount to be Paid : <?php echo $rws1['amount']; ?></p>
                    <?php } ?>
                </div>
            </div>
            <h3>Documents Uploaded: </h3>
            <p style="margin-top: 20px;">Document-type : <?php echo $rws1['doc_type']; ?></p>
            <img class="image" style="border:2px solid black;: 6px; height: 140px; width: 250px; padding:2px" src="bookings/<?php echo $rws1['doc_name']; ?>" alt="">
        </div>
        <div class="items">
            <h3>Client Details : </h3>
            <div style="margin-top: 20px;">
                <p>Client ID : <?php echo $rws2['id']; ?></p>
                <p>Username : <?php echo $rws2['username']; ?></p>
                <p>Name : <?php echo $rws3['fname'], " ", $rws3['lname']; ?></p>
                <p>Date-of-Birth : <?php echo $rws3['dob']; ?></p>
            </div>
            <div style="margin-top: 20px;">
                <h3>Contact Details : </h3>
                <p>Mobile Number : <?php echo $rws3['mob']; ?></p>
                <p>Email : <?php echo $rws2['email']; ?></p>
                <p>Address : <?php echo $rws3['address']; ?></p>
                <p>City : <?php echo $rws3['city']; ?></p>
                <p>Country : <?php echo $rws3['country']; ?></p>
            </div>
        </div>

        <?php if ($rws1['status'] == 'Pending') {
        ?>
            <div class="items">
                <form action="" method="POST">
                    <p class="text-danger" style="font-weight: bold; font-style:italic;">This booking has not been completed yet!</p>
                    <div><a href="bookings.php" class="buttons btn btn-dark text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;">Go Back</a></div>
                </form>
            </div>
        <?php
        } ?>

        <?php if ($rws1['status'] == 'Approved') {
        ?>
            <div class="items">
                <p class="text-success" style="font-weight: bold; font-style:italic;">This booking has been Approved!</p>
                <div><a href="bookings.php" class="buttons btn btn-dark text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;">Go Back</a></div>
            </div>
        <?php
        } ?>
        <?php if ($rws1['status'] == 'Cancel Pending') {
        ?>
            <div class="items">
                <form action="" method="POST">
                    <p class="text-danger" style="font-weight: bold; font-style:italic;">Booking cancellation requested by user!</p>
                    <div><button class="buttons btn btn-dark btn-outline-danger text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;" type="submit" name="cancel" value="<?php echo $rws1['id']; ?>">Cancel Booking</button></div>
                    <div><a href="bookings.php" class="buttons btn btn-dark text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;">Go Back</a></div>
                </form>
            </div>
        <?php
        } ?>
        <?php if ($rws1['status'] == 'Cancelled') {
        ?>
            <div class="items">
                <p class="text-danger" style="font-weight: bold; font-style:italic;">This booking has been cancelled by the user!</p>
                <div><a href="bookings.php" class="buttons btn btn-dark text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;">Go Back</a></div>
            </div>
        <?php
        } ?>
        <?php if ($rws1['status'] == 'Rejected') {
        ?>
            <div class="items">
                <p class="text-danger" style="font-weight: bold; font-style:italic;">This booking has been rejected!</p>
                <div><a href="bookings.php" class="buttons btn btn-dark text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;">Go Back</a></div>
            </div>
        <?php
        } ?>

        <?php if ($rws1['status'] == 'Paid') {
        ?>
            <div class="items">
                <form action="" method="POST">
                    <div><button class="buttons btn btn-dark btn-outline-success text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;" type="submit" name="approve" value="<?php echo $rws1['id']; ?>">Approve Booking</button></div>
                    <div><button class="buttons btn btn-dark btn-outline-danger text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;" type="submit" name="reject" value="<?php echo $rws1['id']; ?>">Reject Booking</button></div>
                    <div><a href="bookings.php" class="buttons btn btn-dark text-light" style="font-size: 15px; font-weight:bold; margin-top:20px;">Go Back</a></div>
                </form>
            </div>
        <?php
        } ?>
    </div>

</body>

</html>
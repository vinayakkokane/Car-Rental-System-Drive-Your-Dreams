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
    <title>Post testimonal</title>
    <style>
        td {
            font-size: 18px;
            font-weight: bold;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
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
            margin-top: 50px;
        }
        .reviews {
      width: 75%;
      margin: 20px auto;
      margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php
    include('Includes/header.php');
    ?>

    <h1 style="text-align:center; color:Brown; margin-top: 100px; font-weight:bold; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Testimonal Section </h1>
    <?php
    include('./Includes/config.php');
    $sel = "SELECT * FROM clients where status='Approved'";
    $rs1 = $dbh->query($sel);
    if (mysqli_num_rows($rs1)) {
    ?>

    <div class="container bookings">
        <table class="table" style="margin-top: 20px;">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Booking Id</th>
                    <th class="text-center">Car Id</th>
                    <th class="text-center">Car Image</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rws = $rs1->fetch_assoc()) {
                ?>
                    <tr>
                        <?php
                        $cid = $rws['carid'];
                        $car = "SELECT car_type,image FROM cars where car_id='$cid'";
                        $cardetails = $dbh->query($car);
                        $c_rws = $cardetails->fetch_assoc();
                        ?>

                        <td style="vertical-align:middle; font-size:20px;" align="center"><?php echo $rws['id']; ?></td>
                        <td style="vertical-align:middle;" align="center"><?php echo $rws['carid']; ?></td>
                        <td style="vertical-align:middle;" align="center"> <img class="image" style="border-radius: 6px; height: 140px; width: 250px;" src="./Cars/<?php echo $c_rws['car_type']; ?>/<?php echo $c_rws['image']; ?>" alt=""></td>

                        <form action="addreviews.php" method="POST">
                            <td style="vertical-align:middle" align="center"> <button class="btn btn-dark text-light btn-outline-success" style="font-size: 15px; font-weight:bold" name="add_review" value="<?php echo $rws['id']; ?>">Add Review</button>
                            </td>
                        </form>

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
            <h2 style="text-align:center; color:maroon; margin-top:25px">You don't have any Approved bookings yet! </h2>
        </div>
    <?php
    }
    ?>
<hr><hr>
    <div class="reviews">
        <?php
        $username = $_SESSION['username'];
        $qry = "SELECT * FROM reviews WHERE username='$username'";
        $res = $dbh->query($qry);
        if (mysqli_num_rows($res) > 0) { ?>

            <hr>
            <h2 style="text-align:center; color:maroon;">Your Submitted Reviews !</h2>
            <hr>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center" style="vertical-align:middle;" align="center">ID</th>
                        <th class="text-center" style="vertical-align:middle;" align="center">Booking ID</th>
                        <th class="text-center" style="vertical-align:middle;" align="center">Car Id</th>
                        <th class="text-center" style="vertical-align:middle;" align="center">Your Experience</th>
                        <th></th>
                    </tr>
                </thead>

                <?php
                $username = $_SESSION['username'];
                $qry = "SELECT * FROM reviews WHERE username='$username'";
                $res = $dbh->query($qry);
                while ($rws = $res->fetch_assoc()) {
                ?>
                    <tr>
                        <td style="vertical-align:middle;" align="center"><?php echo $rws['id']; ?></td>
                        <td style="vertical-align:middle;" align="center"><?php echo $rws['b_id']; ?></td>
                        <td style="vertical-align:middle;" align="center"><?php echo $rws['car_id']; ?></td>
                        <td style="vertical-align:middle;" align="center"><?php echo $rws['review']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        } else {
        ?>
            <div class="text-danger">
                <h2 style="text-align:center; color:maroon;">You have not posted any reviews yet!</h2>
            </div>
        <?php
        } ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>
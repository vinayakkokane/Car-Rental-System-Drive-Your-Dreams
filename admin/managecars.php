<?php
session_start();

include('../admin/Includes/config.php');
if (strlen($_SESSION['uname']) == 0) {
    header('location:index.php');
} else {
    include('../admin/Includes/navbar.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/3695790714.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../images/favicon-16x16.png">
    <title>Manage cars</title>
    <style>
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .btn {
            padding: 10px;
            font-size: 15px;
            color: white;
            background: #5F9EA0;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }

        p {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 18px;
            color: black;
        }

        form {
            border: none;
        }

        .image:hover {
            transform: scale(1.2);
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

        .btns {
            display: flex;
            flex-direction: column;
            text-align: center;
            justify-content: space-between;
        }
    </style>
</head>

<body>

    <!-- heading -->

    <div class="header">
        <h2> Manage your all cars here!</h2>
    </div><br>
    <hr>

    <?php
    include('../Includes/config.php');
    $sel = "SELECT * FROM Cars";
    $rs = $dbh->query($sel);
    ?>

    <div class="container-explore mb-5" style="text-align: center;">
        <div class="row">

            <?php
            while ($rws = $rs->fetch_assoc()) {
            ?>
                <div class="col-lg-3">
                    <img class="image" style="border-radius: 6px; height: 140px; width: 250px;" src="../Cars/<?php echo $rws['car_type']; ?>/<?php echo $rws['image']; ?>" alt="">
                    <p>
                        <p>Car Id : <?php echo $rws['car_id']; ?></p>
                        <p>Car Name : <?php echo $rws['car_name']; ?></p>
                        <p>Car Type : <?php echo $rws['car_type']; ?> </p>
                        <p>Hire Cost : <?php echo $rws['hire_cost']; ?></p>
                    </p>

                    <div class="btns">
                        <div>
                            <form action="modify.php" method="POST">
                                <button class="btn btn-outline-success" style="font-size: 15px; font-weight:bold" name="modify" value="<?php echo $rws['car_id']; ?>">Modify</button>
                            </form>
                        </div>
                        <div>
                            <form action="delete.php" method="POST" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-outline-danger" style="font-size: 15px; font-weight:bold" name="delete" value="<?php echo $rws['car_id']; ?>">Delete</a>
                            </form>
                        </div>
                    </div>


                    <br>
                    <hr><br>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


</body>

</html>

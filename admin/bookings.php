<?php
session_start();

include('./Includes/config.php');
if (strlen($_SESSION['uname']) == 0) {
    header('location:index.php');
} else {
    include('./includes/navbar.php');
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
    <link rel="icon" href="../images/favicon-16x16.png">
    <link rel="stylesheet" href="./includes/styles.css">
    <style>
        .bookings {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Manage Client Bookings!</h2>
    </div>

    <?php
    include('../Includes/config.php');
    $sel = "SELECT * FROM clients";
    $rs = $dbh->query($sel);
    ?>

    <div class="container-explore mb-5" style="text-align: center;">
        <div class="row">
            <div class="container bookings">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Booking Id</th>
                            <th class="text-center">Client Username</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Car Id</th>
                            <th class="text-center">Booking Status</th>

                        </tr>
                    </thead>

                    <?php
                    include('../Includes/config.php');
                    $sel = "SELECT * FROM clients";
                    $rs1 = $dbh->query($sel);

                    ?>
                    <tbody>
                        <?php
                        while ($rws = $rs1->fetch_assoc()) {
                        ?>
                            <tr>
                                <td style="vertical-align:middle; " align="center"><?php echo $rws['id']; ?></td>
                                <td style="vertical-align:middle;" align="center"><?php echo $rws['username']; ?></td>
                                <td style="vertical-align:middle" align="center" class="text-secondary"><?php echo $rws['amount']; ?></td>
                                <td style="vertical-align:middle" align="center" class="text-secondary"><?php echo $rws['carid']; ?></td>

                                <?php if ($rws['status'] == 'Paid') {
                                ?>
                                    <td style="vertical-align:middle; font-weight:bold;" align="center" class="text-success"><?php echo $rws['status']; ?></td>
                                <?php
                                } elseif ($rws['status'] == 'Approved') {
                                ?> <td style="vertical-align:middle; font-weight:bold;" align="center" class="text-secondary"><?php echo $rws['status']; ?></td>
                                <?php
                                } else {
                                ?>
                                    <td style="vertical-align:middle; font-weight:bold;" align="center" class="text-danger"><?php echo $rws['status']; ?></td>

                                <?php
                                } ?>
                                <form action="bookingdetails.php" method="POST">
                                    <td style="vertical-align:middle" align="center"> <button class="btn btn-dark text-light" style="font-size: 15px; font-weight:bold" type="submit" name="details" value="<?php echo $rws['id']; ?>">View Details</button>
                                </form>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    </div>
</body>

</html>

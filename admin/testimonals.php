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
    <link rel="stylesheet" href="./includes/styles.css">
    <style>
        .reviews {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 18px;
        }

        .header h2 {
            color: brown;
            font-weight: bold;
        }

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }
    </style>
</head>

<body>

    <?php
    session_start();

    include('./Includes/config.php');
    if (strlen($_SESSION['uname']) == 0) {
        header('location:index.php');
    } else {
        include('includes/navbar.php');
    }
    ?>

    <div class="header">
        <h2>User Reviews!</h2>
    </div>

    <div class="container-explore mb-5" style="text-align: center;">
        <div class="row">
            <div class="container reviews">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Review Id</th>
                            <th class="text-center">Client Username</th>
                            <th class="text-center">Booking ID</th>
                            <th class="text-center">Car Id</th>
                            <th class="text-center">User Review</th>
                        </tr>
                    </thead>

                    <?php
                    include('./Includes/config.php');
                    $sel = "SELECT * FROM reviews";
                    $rs = $dbh->query($sel);
                    ?>
                    <tbody>
                        <?php
                        while ($rws = $rs->fetch_assoc()) {
                        ?>
                            <tr>
                                <td style="vertical-align:middle; " align="center"><?php echo $rws['id']; ?></td>
                                <td style="vertical-align:middle;" align="center"><?php echo $rws['username']; ?></td>
                                <td style="vertical-align:middle;" align="center"><?php echo $rws['b_id']; ?></td>
                                <td style="vertical-align:middle" align="center"><?php echo $rws['car_id']; ?></td>
                                <td style="vertical-align:middle" align="center"><?php echo $rws['review']; ?></td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>

</html>
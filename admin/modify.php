<?php
session_start();

include('../Includes/config.php');
if (strlen($_SESSION['uname']) == 0) {
    header('location:index.php');
} else {
    include('includes/navbar.php');
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
        form {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            border: none;
        }

        .form-container{
            margin-left: 32%;
        }
        .image:hover {
            transform: scale(1.2);
        }
    </style>
</head>

<body>

<?php
if(isset($_POST['updt'])){
    $cname=$_POST['car_name'];
    $car_id=$_POST['car_id'];
    $cost=$_POST['car_cost'];
    $cap=$_POST['capacity'];
    $qr="UPDATE cars SET car_name='$cname',hire_cost='$cost',capacity='$cap' WHERE car_id = '$car_id'";
    mysqli_query($dbh, $qr);

    echo "<script type = \"text/javascript\">
    alert(\"Car Details modified Successfully!\")
    window.location = (\"managecars.php\")
</script>";
}
?>


    <div class="header">
        <h2>Update Car Details here!</h2>
    </div>

    <form action="" class="form-horizontal form-container" method="POST" enctype="multipart/form-data">

        <div class="form-group">


            <?php
            $carid = $_POST['modify'];
            $qr = "SELECT * FROM cars WHERE car_id = '$carid'";
            $res = $dbh->query($qr);
            $rws = $res->fetch_assoc();
            ?>

            <div class="form-group">
                <label class="col-md-3 control-label">Car Image : </label>
                <div class="col-md-8 mx-auto">
                    <img class="image " style="border-radius: 6px; height: 140px; width: 250px;" src="../Cars/<?php echo $rws['car_type']; ?>/<?php echo $rws['image']; ?>"> </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Car Id : </label>
                <div class="col-md-8">
                    <input class="form-control" name="car_id" value="<?php echo $rws['car_id'] ?>" type="text" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Car Name : </label>
                <div class="col-md-8">
                    <input class="form-control" name="car_name" value="<?php echo $rws['car_name'] ?>" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Hire Cost : </label>
                <div class="col-md-8">
                    <input class="form-control" name="car_cost" value="<?php echo $rws['hire_cost'] ?>" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Capacity : </label>
                <div class="col-md-8">
                    <input class="form-control" name="capacity" value="<?php echo $rws['capacity'] ?>" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8 mx-auto">
                    <button class="btn btn-dark" name="updt" type="submit">Update Details</button><br><br>
                </div>
            </div>
    </form>
</body>

</html>

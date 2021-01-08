<?php
session_start();

include('../admin/Includes/config.php');
if (strlen($_SESSION['uname']) == 0) {
    header('location:index.php');
} else {
    include('includes/navbar.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="icon" href="../images/favicon-16x16.png">
    <title>Manage Query</title>
    <style media="screen">
    .head{
      margin-top: 40px;
      margin-bottom: 10px;
    }
    </style>
  </head>
  <body>
    <?php
      include('../Includes/config.php');

      if (isset($_POST['submit'])) {
          $id = $_POST['submit'];
          $ans = $_POST['answer'];
          $qtype = $_POST['type'];
          $query = $_POST['query'];

          $updt = "UPDATE queries SET status='Closed',qr_answer='$ans' WHERE id='$id'";
          mysqli_query($dbh, $updt);

          $username = $_POST['user'];
          $qr = "SELECT email FROM users WHERE username='$username'";
          $res = $dbh->query($qr);
          $rws = $res->fetch_assoc();
          
          $receiver = $rws['email'];
          $subject = "Regarding Query having id $id";
          $message = "Your query has been answered!

    Query Details are as follows :

    Query ID : $id
    Query type : $qtype
    Query : $query
    Answer : $ans
            
    We hope your query has been resolved. If you still have any questions, feel free to post them.
        
    Thanks & Regards!

    Drive your Dreams";
        
          $sender = "From: vinayaklkokane2001@gmail.com";
          mail($receiver, $subject, $message, $sender);

          echo "<script type = \"text/javascript\">
                      alert(\"This Query has been answered successfully!\");
                      window.location = (\"admin.php\")
                  </script>";
      }

      session_start();

      include('includes/config.php');
      if (strlen($_SESSION['uname']) == 0) {
          header('location:index.php');
      } else {
          include('includes/navbar.php');
      }


      if (isset($_POST['mng_qrs'])) {
          $id = $_POST['mng_qrs'];

          $qry = "SELECT * FROM queries WHERE id='$id'";
          $res = $dbh->query($qry);
          $rws = $res->fetch_assoc();
      }


    ?>
    <div class="header">
        <h2>Answer user queries here!</h2>
    </div>

    <form action="" method="POST">
        <div class="form-group">
            <label class="col-md-3 control-label">Query Id : </label>
            <div class="col-md-8">
                <input class="form-control" type="text" value="<?php echo $rws['id'] ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Username of user : </label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="user" value="<?php echo $rws['username'] ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Type of query : </label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="type" value="<?php echo $rws['qr_type'] ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Query : </label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="query" value="<?php echo $rws['qr_message'] ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Answer here : </label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="answer" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8 mx-auto">
                <button type="submit" class="btn btn-dark btn-outline-success text-light" name="submit" value="<?php echo $rws['id'] ?>">Submit Answer</button>
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


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
    <title>Queries</title>
    <style media="screen">
      .head{
        margin-top: 90px;
        margin-bottom: 10px;
      }
      .pic{
        margin-left: 80px;
        margin-bottom: 40px;
        height: 800px;
      }
    </style>
  </head>
  <body>
    <!-- navbar -->
    <?php
      session_start();
      include('Includes/header.php');
    ?>
    <h2 class="text-center head">Ask your Queries here, we will try to answer them as soon as posssible!</h2>
    <img class="pic img-fluid" src="images/query.jpg" alt="query">

    <form class="" action="querySuccess.php" method="post" style="margin-left: 80px; margin-bottom: 50px;">
      <div class="form-group row" >
        <label class="col-sm-2 col-form-label"><b>Type of query: </b></label>
        <div class="col-auto my-1">
          <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Select</label>
          <select class="custom-select mr-sm-2" name="type" id="inlineFormCustomSelect">
            <option selected>Choose...</option>
            <option value="booking">Bookings related</option>
            <option value="Car">Car related</option>
            <option value="Charges">About charges and fares</option>
            <option value="Cancellation">About booking-cancellation</option>
            <option value="Payments">Payments related</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label"><b>Ask you query: </b></label>
        <input type="text" name="ask" placeholder="Enter your query" required>
      </div>
      <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" name="submit" class="btn btn-outline-dark">Ask Query</button>
        </div>
      </div>
    </form>

    <?php
      include('Includes/server.php');

    ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <footer>
      <?php
        include('includes/footer.php');
      ?>
    </footer>
  </body>
</html>

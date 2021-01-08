<?php
	session_start();
	include('Includes/server.php');
	if (!isset($_SESSION['username'])) {
		echo "<script type = \"text/javascript\">
						alert(\"You must login first\");
						window.location = (\"index.php\")
				</script>";

	if($_SESSION['prof_cmpl']!=100){
		echo "<script type = \"text/javascript\">
					alert(\"Please complete your profile\");
					window.location = (\"profile.php\")
				</script>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Car Rental</title>
	<meta charset="utf-8">
	<meta name="author" content="pixelhint.com">
	<meta name="description" content="La casa free real state fully responsive html5/css3 home page website template" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
	<script src="https://kit.fontawesome.com/3695790714.js" crossorigin="anonymous"></script>
	<link rel="icon" href="images/favicon-16x16.png">
	<link rel="stylesheet" href="CSS/styles.css">
	<style>
		.caption {
			margin-top: 100px;
		}

		.caption h2 {
			color: black;
			position: relative;
			display: block;
			font-weight: bold;
		}

		.caption h3 {
			color: black;
			font-family: "lato-regular", Helvetica, Arial, sans-serif;
			font-size: 14px;
			left: 1px;
		}

		.formcontainer {
			margin-left: 32%;
			font-size: 20px;
		}

		html,
		body {
			max-width: 100%;
			overflow-x: hidden;
		}

		h4 {
			font-weight: bold;
			font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
		}

		.image:hover {
			transform: scale(1.2);
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

		.Image-Preview {
			width: 300px;
			min-height: 100px;
			border: 2px solid black;
			border-radius: 5px;
			margin-top: 10px;
			display: flex;
			justify-content: center;
			align-items: center;
			font-weight: bold;
			color: #cccccc;
		}

		.Image-Preview__image {
			display: none;
			width: 100%;
		}
	</style>

</head>

<body>
	<?php
	if (isset($_POST['p2p'])) {
		$target_path = "./admin/bookings/";
		$target_path = $target_path . basename($_FILES['image']['name']);
		if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
			$id = mt_rand(100000, 999999);
			$carid = $_POST['car_id'];
			$days = $_POST['days'];
			$cost = $_POST['car_cost'];
			$username = $_POST['username'];
			$doc_name = basename($_FILES['image']['name']);
			$doc_type = $_POST['doc_type'];
			$amount = $days * $cost;
			$qry = "INSERT INTO clients (id,carid,days,username,doc_name,doc_type,status,amount)
				VALUES('$id','$carid','$days','$username','$doc_name','$doc_type','Pending','$amount')";

			$result = $db->query($qry);


			if ($result == true) {
				$_SESSION['amount'] = "$amount";
				$_SESSION['id'] = "$id";

				$upd = "UPDATE cars SET status='Unavailable' WHERE car_id='$carid'";
				mysqli_query($db, $upd);

				$username = $_SESSION['username'];
			$qr = "SELECT email FROM users WHERE username='$username'";
			$res = $db->query($qr);
			$rws = $res->fetch_assoc();

			$receiver = $rws['email'];
			$subject = "New Booking Registered";
			$message = "
	
	Dear $username,  
	Congratulations! Your New booking is registered successfully.
	
	Your New Booking ID is $id. Note this Id for future references 

	Make your Payment & Complete your booking.

	Thanks & Regards!

	Drive your Dreams";

			$sender = "From: vinayaklkokane2001@gmail.com";
			mail($receiver, $subject, $message, $sender);

				echo "<script type = \"text/javascript\">
											window.location = (\"pay.php\")
											</script>";
			} else {
				echo "<script type = \"text/javascript\">
											alert(\"Registration Failed. Try Again\");
											window.location = (\"carvarieties.php\")
											</script>";
			}
		} else 'Failed';
	}
	?>

	<!-- navbar -->
	<?php
		include('Includes/header.php');
	?>
	<section class="caption">
		<h2 class="caption" style="text-align: center; color:sienna;">Find Your Dream Cars For Hire!</h2>
		<h3 style="text-align: center; ">Range Rovers - Mercedes Benz - Landcruisers</h3>
	</section>

	<div class="container formcontainer" style="margin-top: 50px;">
		<div class="row">
			<div class="col-md-9">
				<form action="" class="form-horizontal" method="POST" enctype="multipart/form-data">

					<?php
					$carid = $_POST['car'];
					$qr = "SELECT * FROM cars WHERE car_id = '$carid'";
					$res = $db->query($qr);
					$rws = $res->fetch_assoc();
					?>

					<h4>Confirm Car Details : </h4><br>
					<div class="form-group">
						<label class="col-md-3 control-label">Car Image : </label>
						<div class="col-md-8 mx-auto">
							<img class="image " style="border-radius: 6px; height: 140px; width: 250px;" src="./Cars/<?php echo $rws['car_type']; ?>/<?php echo $rws['image']; ?>"> </div>
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
							<input class="form-control" name="car_name" value="<?php echo $rws['car_name'] ?>" type="text" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Hire Cost : </label>
						<div class="col-md-8">
							<input class="form-control" name="car_cost" value="<?php echo $rws['hire_cost'] ?>" type="text" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Capacity : </label>
						<div class="col-md-8">
							<input class="form-control" name="capacity" value="<?php echo $rws['capacity'] ?>" type="text" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Time-Span : </label>
						<div class="col-md-8">
							<input class="form-control" name="days" type="text" placeholder="(No of days car is required)" required>
						</div>
					</div>

					<?php

					$username = $_SESSION['username'];
					$qr = "SELECT * FROM users WHERE username = '$username'";
					$res = $db->query($qr);
					$rws = $res->fetch_assoc();

					$id = $rws['id'];
					$qr = "SELECT * FROM userprofile WHERE id = '$id'";
					$res1 = $db->query($qr);
					$rws1 = $res1->fetch_assoc();
					?>
					<br>
					<h4>Confirm Personal Details : </h4>
					<h5 style="font-size: 16px; font-weight: bold; font-style:italic;" class="text-danger text-center">(Make sure, your profile is updated!)</h5>
					<br>
					<div class="form-group">
						<label class="col-lg-3 control-label">Email : </label>
						<div class="col-lg-8">
							<input class="form-control" value=" <?php echo $rws['email']; ?>" name="email" type="email" required readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Username :</label>
						<div class="col-md-8">
							<input class="form-control" type="text" name="username" value="<?php echo $rws['username']; ?>" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label">Name : </label>
						<div class="col-lg-8">
							<input class="form-control" type="text" value="<?php if ($rws1) echo $rws1['fname'], " ", $rws1['lname'] ?>" name="name" required readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Date of Birth : </label>
						<div class="col-md-8">
							<input class="form-control" type="text" name="dob" placeholder="dd/mm/yyyy" value="<?php if ($rws1) echo $rws1['dob'] ?>" id="birth-date" type="text" required readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Mobile Number : </label>
						<div class="col-md-8">
							<input class="form-control" type="number" name="mob" value="<?php if ($rws1) echo $rws1['mob'] ?>" required readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Your Address : </label>
						<div class="col-md-8">
							<input class="form-control" name="address" type="text" value="<?php if ($rws1) echo $rws1['address'] ?>" required readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Country : </label>
						<div class="col-md-8">
							<input class="form-control" id="country" name="country" value="<?php if ($rws1) echo $rws1['country'] ?>" type="text" required readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Location : </label>
						<div class="col-md-8">
							<input class="form-control" id="city" name="location" type="text" value="<?php if ($rws1) echo $rws1['city'] ?>" required readonly>
						</div>
					</div><br>
					<h4>Document verification : </h4><br>
					<div class="form-group">
						<div class="col-md-8">
							<div class="ui-select">
								<label>Select Document to upload : </label>
								<select id="documents" class="form-control" name="doc_type" required>
									<option value="" selected="selected">Select Document type</option>
									<option value="Aadhar Card">Aadhar Card</option>
									<option value="PAN Card">PAN Card</option>
									<option value="Driving License">Driving Lisence</option>
									<option value="Voter ID">Voter ID</option>
									<option value="Passport">Passport</option>
								</select>
							</div><br>
							<input type="file" src="#" accept="image/*" name="image" id="image" width="150px" required>
						</div><br>

						<div class="Image-Preview" id="Image-Preview">
							<img src="" alt="Image Preview" class="Image-Preview__image">
							<span class="Image-Preview__default-text">Image Preview</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-8">
							<input type="submit" class="btn btn-dark" style="float: right;" name="p2p" value="Proceed to Pay"><br><br>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		const inpFile = document.getElementById("image");
		const previewContainer = document.getElementById("Image-Preview");
		const previewImage = previewContainer.querySelector(".Image-Preview__image");
		const previewdeftext = previewContainer.querySelector(".Image-Preview__default-text");

		inpFile.addEventListener("change", function() {
			const file = this.files[0];

			if (file) {
				const reader = new FileReader();

				previewdeftext.style.display = "none";
				previewImage.style.display = "block";

				reader.addEventListener("load", function() {
					previewImage.setAttribute("src", this.result);
				});
				reader.readAsDataURL(file);
			} else {
				previewdeftext.style.display = "null";
				previewImage.style.display = "null";
				previewImage.setAttribute("src", "");
			}
		});
	</script>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>

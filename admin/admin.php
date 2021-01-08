<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<!-- FontAwesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://kit.fontawesome.com/3695790714.js" crossorigin="anonymous"></script>
	<link rel="icon" href="../images/favicon-16x16.png">
	<link rel="stylesheet" href="./includes/styles.css">

	<style>
		.dashboard {
			display: flex;
			margin-top: 30px;
			align-items: center;
			padding: 4px;
			justify-content: space-between;
		}

		.items {
			height: 125px;
			margin: 0px auto;
			flex-basis: 30%;
			background-color: lightskyblue;
			color: black;
			font-weight: bold;
			border: 2px solid brown;
			border-radius: 3em;
		}

		.users {
			display: inline;
		}

		.details {
			width: 45%;
			margin: 0px auto;
			margin-top: 20px;
			color: black;
			padding: 4px;
			justify-content: space-between;
		}

		td {
			font-weight: bold
		}
	</style>
</head>


<?php
session_start();

include('./includes/config.php');
if (strlen($_SESSION['uname']) == 0) {
	header('location:index.php');
} else {
	include('./includes/navbar.php');
}
?>

<div class="container dashboard">
	<div class="items">
		<p class="text-center" style="font-size: 40px;">
			<?php
			$qry = "SELECT id FROM users";
			$res = $dbh->query($qry);
			echo mysqli_num_rows($res);
			?>
		</p>
		<p class="text-center" style="font-size: 25px;">Total Users</p>
	</div>
	<div class="items">
		<p class="text-center" style="font-size: 40px;">
			<?php
			$qry = "SELECT id FROM clients";
			$res = $dbh->query($qry);
			echo mysqli_num_rows($res);
			?>
		</p>
		<p class="text-center" style="font-size: 25px;">Total Bookings</p>
	</div>
	<div class="items">
		<p class="text-center" style="font-size: 40px;">
			<?php
			$qry = "SELECT DISTINCT car_type FROM cars";
			$res = $dbh->query($qry);
			echo mysqli_num_rows($res);
			?>
		</p>
		<p class="text-center" style="font-size: 25px;">Total Car Domains</p>
	</div>
</div>

<div class="container users">
	<div class="details" style="float: left; margin-left:30px;">
		<hr>
		<h2 style="text-align:center; color:maroon;">Registered User Details</h2>
		<hr>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th class="text-center" style="vertical-align:middle;" align="center">User ID</th>
					<th class="text-center" style="vertical-align:middle;" align="center">Username</th>
					<th class="text-center" style="vertical-align:middle;" align="center">Email-Id</th>
					<th class="text-center" style="vertical-align:middle;" align="center">Status</th>
				</tr>
			</thead>

			<?php
			$qry = "SELECT * FROM users";
			$res = $dbh->query($qry);
			while ($rows = $res->fetch_assoc()) {
			?>
				<tr>
					<td style="vertical-align:middle;" align="center"><?php echo $rows["id"]; ?></td>
					<td style="vertical-align:middle;" align="center"><?php echo $rows["username"]; ?></td>
					<td style="vertical-align:middle;" align="center"><?php echo $rows["email"]; ?></td>
					<?php if ($rows["status"] == 'verified') { ?>
						<td class="text-success" style="vertical-align:middle;" align="center"><?php echo $rows["status"]; ?></td>
					<?php } else {
					?>
						<td class="text-danger" style="vertical-align:middle;" align="center"><?php echo $rows["status"]; ?></td>
					<?php
					} ?>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
	<div class="details" style="float: right; margin-right:30px;">
		<hr>
		<h2 style="text-align:center; color:maroon;">Manage User Queries</h2>
		<hr>

		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th class="text-center" style="vertical-align:middle;" align="center">ID</th>
					<th class="text-center" style="vertical-align:middle;" align="center">Query type</th>
					<th class="text-center" style="vertical-align:middle;" align="center">Query </th>
					<th class="text-center" style="vertical-align:middle;" align="center">Status</th>
					<th></th>
				</tr>
			</thead>

			<?php
			$qry = "SELECT * FROM queries";
			$res = $dbh->query($qry);
			while ($rws = $res->fetch_assoc()) {
			?>
				<tr>
					<td style="vertical-align:middle;" align="center"><?php echo $rws['id']; ?></td>
					<td style="vertical-align:middle;" align="center"><?php echo $rws['qr_type']; ?></td>
					<td style="vertical-align:middle;" align="center"><?php echo $rws['qr_message']; ?></td>
					<?php if ($rws['status'] == 'Open') { ?>
						<td class="text-danger" style="vertical-align:middle; font-weight: bold;" align="center"><?php echo $rws['status']; ?></td>
					<?php } else {
					?>
						<td class="text-success" style="vertical-align:middle; font-weight: bold;" align="center"><?php echo $rws['status']; ?></td>
					<?php
					} ?>
					<?php if ($rws['status'] == 'Open') { ?>
						<form action="" method="POST">
							<td style="vertical-align:middle" align="center"> <button class="btn btn-dark text-light btn-outline-success" style="font-size: 15px; font-weight:bold" type="submit" name="mng_qrs" value="<?php echo $rws['id']; ?>">Manage Queries</button>
						</form>
					<?php }
					?>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
</div>
</body>

</html>

<?php
session_start();
include_once 'includes/dbconnect.php';
$id = addslashes($_SESSION['usr_id']);
?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          
        <link rel="stylesheet" type="text/css" href="vendors/css/normalize.css">
         <link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
        <link rel="stylesheet" type="text/css" href="resources/css/style.css">
         <link rel="stylesheet" type="text/css" href="vendors/css/ionicons.min.css">
         <link rel="stylesheet" type="text/css" href="vendors/css/animate.css">
         <link rel="stylesheet" type="text/css" href="resources/css/queries.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">BESU Bank</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['usr_id'])) { ?>

				<li><a href="logout.php">Log Out</a></li>
				<?php } else { ?>
				<li><a href="login.php">Login</a></li>

				<?php } ?>
			</ul>
		</div>
	</div>
</nav>
<div style="color: blue;" class="container-fluid">

<h3>Welcome, <?php echo $_SESSION['usr_name']; ?></h3>
</div>

<div style="width: 50px; height: 50px;"></div>
<div class="col-lg-2">
	<ul class="navbar navbar-default nav" style="height: 650px;">

		<li><a href="accountdetails.php"><span style="margin-left: 25px; margin-top:20px; font-size: 20px;"><b>Account details</b></span></a></li>
		<li><a href="transactions.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>My Transactions</b></span></a></li>
		<li><a href="transfer.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Transfer Amount</b></span></a></li>
		<li><a href="loanpayment.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Pay loans</b></span></a></li>
		<li><a href="loantransactions.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Loan payments</b></span></a></li>
		<li><a href="customerloans.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Loan info</b></span></a></li>
		</ul>
		</div>
<div class="container">
	<article class="row">
		<section class="col-lg-8">
			<div class="page-header">
				<h2>Loan payments</h2>
			</div>
				<table class="table table-bordered">
				   		<thead>
				   			<th>Loan type</th>
				   			<th>Amount</th>
				   			<th>Transaction date</th>
				   			</thead>
	<?php

		$in_sql = "SELECT * FROM accounts WHERE id = $id";
		$ru_sql = mysqli_query($con, $in_sql);

		$rows = mysqli_fetch_array($ru_sql);
		$accno = $rows['accno'];

		$ins_sql = "SELECT * FROM `loanpayment` WHERE from_acc = '$accno'";
		$run_sql = mysqli_query($con, $ins_sql);
		while($rows = mysqli_fetch_array($run_sql)){

			echo '

				<tbody>
					      <tr>
					        <td>'.$rows['loantype'].'</td>
					        <td>'.$rows['amount'].'</td>
					        <td>'.$rows['payment_date'].'</td>
					      </tr>
					    </tbody>

			';

		}
	?>
	</table></section></article></div>

 <footer>
            <div class="row">
                <div class="col span-1-of-2">
                    <ul class="footer-nav">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Ios App</a></li>
                        <li><a href="#">Android App</a></li>
                    </ul>
                </div>
                <div class="col span-1-of-2">
                    <ul class="social-links">
                        <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                        <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                        <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <p>
                    Copyright &copy; 2019 by BESU. All rights reserved.
                </p>
            </div>
</footer>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

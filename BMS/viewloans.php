<?php
session_start();
include_once 'includes/dbconnect.php';
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
			<a class="navbar-brand" href="admin.php">Admin Dashboard</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['usr_id'])) { ?>

				<li><a href="logout.php">Log Out</a></li>
				<?php } else { ?>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Sign Up</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>

<div class="row">
    <div class="col span-1-of-2">
    <ul class="navbar navbar-default nav" style="height: 650px;">

		<li><a href="addaccount.php"><span style="margin-left: 25px; margin-top:20px; font-size: 20px;"><b>Add an account</b></span></a></li>
		<li><a href="deleteaccount.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Close an account</b></span></a></li>
		<li><a href="grantloan.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Grant Loan</b></span></a></li>
		<li><a href="viewaccounts.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>View accounts</b></span></a></li>
		<li><a href="depositmoney.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Deposit money</b></span></a></li>
		<li><a href="withdrawmoney.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Withdraw Money</b></span></a></li>
		<li><a href="viewloans.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>View loans</b></span></a></li>
		</ul>
    </div>
    
    <div class="col span-1-of-2">
    <div class="page-header">
				<h2>Loans information</h2>
			</div>
			<table class="table table-bordered">
				   		<thead>
				   			<th>Account no</th>
				   			<th>Loan Amount</th>
				   			<th>Intrest</th>
				   			<th>Issued date</th>
				   			<th>Recent payment date</th>
				   			</thead>
			<?php

				$ins_sql = "SELECT * FROM loan";
				$run_sql = mysqli_query($con, $ins_sql);

				while($rows = mysqli_fetch_array($run_sql)){
					$date_now = date('y-m-d');
				//	$date_now = "2019-12-6";
					$date_recent=$rows['recentdate'];
					$diff=(strtotime($date_now)-strtotime($date_recent))/60/60/24;
					$intrest=round(0.025*$diff*$rows['loanamt']/30);
					echo '
					    <tbody>
					      <tr>
					        <td>'.$rows['accno'].'</td>
					        <td>'.$rows['loanamt'].'</td>
					        <td>'.$intrest.'</td>
					        <td>'.$rows['startdate'].'</td>
					        <td>'.$rows['recentdate'].'</td>
					      </tr>
					    </tbody>


					';
				}
				?>
				 </table>
    </div>
    
</div>



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
</body>
</html>

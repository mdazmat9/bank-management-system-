<?php
session_start();
include 'includes/dbconnect.php';

	$success = "";

	if(isset($_POST['submit'])){

			$accno = $_POST['accno'];


			$in_sql = "SELECT * FROM accounts WHERE accno = '$accno'";
			$ru_sql = mysqli_query($con, $in_sql);

			$temp = mysqli_affected_rows($con);
			if($temp){
				$rows = mysqli_fetch_array($ru_sql);

				$balance = $rows['accbalance'];
				$amount = $_POST['amount'];

				if($amount>0){

					if($balance>=$amount){
						$total = $balance - $amount;


						$ins_sql = "UPDATE accounts
								SET accbalance = $total
								WHERE accno = '$accno'";

						$run_sql = mysqli_query($con, $ins_sql);

						$cnt = "SELECT * FROM transactions";
						$cnt1 = mysqli_query($con, $cnt);
						$cnt2 = mysqli_num_rows($cnt1);
						$cnt2++;
						$one=999;
						$date=date('y-m-d');

						$sql5 = "INSERT INTO transactions(transactionid, paymentdate, payeeid,receiveid,amount) VALUES('".$cnt2."', '".$date."','".$accno."', '".$one."','".$amount."')";
						$run5 = mysqli_query($con, $sql5);

						$success = "Money withdrawn successfully!";
					}else{

						$success = "You don't have enough balance!";
					}
				}else{

					$success = "Amount cannot be negative";
				}
			}else{

				$success = "Account doesn't exist!";
			}
	}



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
				<h2>Withdraw money</h2>
			</div>
			<form class="form-horizontal" action="withdrawmoney.php" method="post" role="form">
				<div class="form-group">
					<label for="number" class="col-sm-3 control-label">Account number *</label>
						<div class="col-sm-8">
							<input type="text" name="accno" class="form-control" placeholder="Enter account number" id="accnumber" required>
						</div>
				</div>

				<div class="form-group">
					<label for="number" class="col-sm-3 control-label">Amount *</label>
						<div class="col-sm-8">
							<input type="text" name="amount" class="form-control" placeholder="Enter amount you want to Withdraw" id="amount" required>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-8">
					<input type="submit" id="submit" name="submit" value = "Submit" class="btn btn-block btn-primary">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-8">
					<h4><?php echo $success ?></h4>
					</div>
				</div>



</form>
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

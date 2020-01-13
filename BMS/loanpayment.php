<?php
session_start();
include 'includes/dbconnect.php';
	$id = $_SESSION['usr_id'];

	$success = "";
	if(isset($_POST['submit'])){


			$sql1 = "SELECT * FROM accounts WHERE accno = $id";
			$run1 = mysqli_query($con, $sql1);
			$rows = mysqli_fetch_array($run1);

			$accno = $rows['accno'];
			$owner_balance = $rows['accbalance'];
			$amount = $_POST['loanamount'];

			if($amount>0){

				if($owner_balance>=$amount){

				$sql4 = "SELECT * FROM loan WHERE accno = '$accno'";
				$run4 = mysqli_query($con, $sql4);

				$temp = mysqli_affected_rows($con);

				if($temp>0){

					$rows = mysqli_fetch_array($run4);

					$loan=$rows['loanamt'];
					$date_now = date('y:m:d');
				//	$date_now = "2019-12-6";
					$date_recent=$rows['recentdate'];
					$diff=(strtotime($date_now)-strtotime($date_recent))/60/60/24;
					$intrest=round(0.025*$diff*$rows['loanamt']/30);


					if($loan+$intrest>=$amount){


					$sql5 = "UPDATE loan
								SET loanamt = $loan-($amount-$intrest)
								WHERE accno = '$accno'";
					$run5 = mysqli_query($con, $sql5);

					if($amount>=$intrest){
					$sql5 = "UPDATE loan
								SET intrest = 0
								WHERE accno = '$accno'";
					$run5 = mysqli_query($con, $sql5);
				}else{

				$sql5 = "UPDATE loan
							SET intrest = -($amount-$intrest)
							WHERE accno = '$accno'";
							$newloanamt=$loanamt-($amount-$intrest);
				$run5 = mysqli_query($con, $sql5);
				$sql5 = "UPDATE loan
							SET loanamt = $newloanamt
							WHERE accno = '$accno'";
				$run5 = mysqli_query($con, $sql5);
				}




					$date = $date_now;
					$sql5 = "UPDATE loan
								SET recentdate = 	'$date'
								WHERE accno = '$accno'";
					$run5 = mysqli_query($con, $sql5);

					$total = $owner_balance - $amount;
					$sql2 = "UPDATE accounts
								SET accbalance = $total
								WHERE accno = '$accno'";

					$run2 = mysqli_query($con, $sql2);

					$cnt = "SELECT * FROM transactions";
					$cnt1 = mysqli_query($con, $cnt);
					$cnt2 = mysqli_num_rows($cnt1);
					$cnt2++;
					$one=1;
					$sql5 = "INSERT INTO transactions(transactionid, paymentdate, payeeid,receiveid,amount) VALUES('".$cnt2."', '".$date."','".$accno."', '".$one."','".$amount."')";
					$run5 = mysqli_query($con, $sql5);

					$success = "Loan payment successful!";

				}
				else{
					$success = " Amount greater than loan!";
				}
				}else{

					$success = " you don't have a loan!";
				}
				}else{

					$success = "You don't have enough balance!";
				}


		}else{

				$success = "Amount cannot be negative!";
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
			<a class="navbar-brand" href="index.php">BESU Bank</a>
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
<div  class="container-fluid">

<h3>Welcome, <?php echo $_SESSION['usr_name']; ?></h3>
</div>

<div class="row">
    <div class="col span-1-of-2">
        <ul class="navbar navbar-default nav" style="height: 650px;">

		<li><a href="accountdetails.php"><span style="margin-left: 25px; margin-top:20px; font-size: 20px;"><b>Account details</b></span></a></li>
		<li><a href="transactions.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>My Transactions</b></span></a></li>
		<li><a href="transfer.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Transfer Amount</b></span></a></li>
		<li><a href="loanpayment.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Pay loans</b></span></a></li>
		<li><a href="customerloans.php"><span style="margin-left: 25px; margin-top: 20px; font-size: 20px;"><b>Loan info</b></span></a></li>
		</ul>
    </div>
    
    <div class="col span-1-of-2">
    <div class="page-header">
				<h2>Pay loans</h2>
			</div>

	<form class="form-horizontal" action="loanpayment.php" method="post" role="form">
				<div class="form-group">
					<label for="number" class="col-sm-3 control-label">Amount *</label>
						<div class="col-sm-8">
							<input type="text" name="loanamount" class="form-control" placeholder="Enter the amount" id="loanamount" required>
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

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

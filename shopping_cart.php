<!DOCTYPE HTML>
<?php
include("dbconnect.php");
    $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
    $paypal_id = 'gruop2.business@gmail.com'; //Business Email
?>
<html>
	<head>
		<title>Project</title>
		<link href="styles/style.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src=" jquery-1.6.min.js"></script>
		<script type="text/javascript" src="scripts/a.js"></script>
	</head>

	<body>
		<div id="container"> <!-----container class starts------->
		  <header>
			<nav>
			  <ul id="nav">
				<li><a href="index.php" class="current">Home</a></li>
				<li><a href="#">Contact</a></li>
			  </ul>
			</nav>

			<div>
			  <h1 class="title">Auto.com</h1>
			</div>
		  </header>


		  <div class="wrapper" > <!---------wrapper class starts------->
			<br><br>

			<div class="left">
				  <h1>Login</h1>
				  <form class = "form-signin" role = "form" action = "" method = "post">
					<h4 class = "form-signin-heading"></h4>
					<input type = "text" class = "form-control" name = "username" placeholder = "Enter your user name" required autofocus>
					</br>
					  <input type = "password" class = "form-control" name = "password" placeholder = "Enter your password" required>
					  </br>
					<br>
					<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Login</button>
				 </form>

				 <br>New customer? <a href="signup.php">Sign up</a> here.
		    </div>


			<div class="right">

				<table align="center">
					<tr>

					<?php
					$conn = new mysqli($hn, $un, $pw, $db);
					$id=intval($_GET['id']);
					//echo $id;

					if ($conn->connect_error) die($conn->connect_error);

					  $query  = "SELECT * FROM Allparts where PartID='$id'";
					  $result = $conn->query($query);
					  if (!$result) die ("Database access failed: " . $conn->error);

					  $rows = $result->num_rows;


					  for ($j = 0 ; $j < $rows ; ++$j)
					  {
						$result->data_seek($j);
						$row = $result->fetch_array(MYSQLI_NUM);

					?>

						<td align="center" width="40%">

							<img src="image/<?php echo $row[13]; ?>" style="width: 200px; height: 200px;" /> <br/>
							<?php echo $row[1];?><br/>

							<form action="<?php echo $paypal_url; ?>" method="post">

								<!-- Identify your business so that you can collect the payments. -->
								<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">

								<!-- Specify a Buy Now button. -->
								<input type="hidden" name="cmd" value="_xclick">

								<!-- Specify details about the item that buyers will purchase. -->
								<input type="hidden" name="item_name" value="<?php echo $row[1]; ?>">
								<input type="hidden" name="amount" value="<?php echo $row[12]; ?>">
								<input type="hidden" name="currency_code" value="USD">

								<!-- Specify URLs -->
								<input type='hidden' name='return' value='http://cs5339.cs.utep.edu/Team02/success.php'>

								<!-- Display the payment button. -->
								<br/><input type="submit" class="proceed" value="Proceed to checkout" name="submit" border="0" >

							</form>
						</td>

						<td align="left" width="30%">
						<b>Order Summary</b><br><br><br>
						Items:	<br>
						Shipping & handling:<br>
						<div class="border"></div>
						<b>Order Total =</b>
						</td>

					    <td align="left" width="10%">
						<br><br><br>
						$<?php echo $row[12]; ?> <br>
						<!-- Shipping Price -->
						$<?php
							  $query2  = "SELECT * FROM Accounts where acct_type=1";
							  $result2 = $conn->query($query2);
							  if (!$result2) die ("Database access failed: " . $conn->error);

							  $rows2 = $result2->num_rows;

							  for ($j = 0 ; $j < $rows2 ; ++$j)
							  {
								$result2->data_seek($j);
								$row2 = $result2->fetch_array(MYSQLI_NUM);
							  }

							  $a = substr($row2[8], 0, 3);
							  echo $a;
							  echo "<br>";



							  $query3  = "SELECT * FROM ZiptoZone where HighZip='$a'";
							  $result3 = $conn->query($query3);
							  if (!$result3) die ("Database access failed: " . $conn->error);

							  $rows3 = $result3->num_rows;

							  for ($j = 0 ; $j < $rows3 ; ++$j)
							  {
								$result3->data_seek($j);
								$row3 = $result3->fetch_array(MYSQLI_NUM);
							  }
							  //echo $row3[2];
							  //echo "<br>";


							  $query4  = "SELECT * FROM UPSGroundWeightZonePrice where Weight=$row[18]";
							  $result4 = $conn->query($query4);
							  if (!$result4) die ("Database access failed: " . $conn->error);

							  $rows4 = $result4->num_rows;

							  for ($j = 0 ; $j < $rows4 ; ++$j)
							  {
								$result4->data_seek($j);
								$row4 = $result4->fetch_array(MYSQLI_NUM);
							  }
							  $b = $row4[2];
							  echo $b;

						?> <br>
						<div class="border"></div>
						<b>$<?php echo $b+$row[12]; ?></b>
						</td>
					<?php
					}
					?>
					</tr>
				</table>
			</div>

		</div>	<!---------------wrapper class ends----------------->

	</div>    <!-----------container class ends------------->
	</body>

</html>

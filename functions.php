<?php
	require("db.php");
function cats(){
		$query = mysqli_query($conn, "SELECT * FROM `pcategories`") or die (mysqli_error());
		  echo "<select name ='category'>";
		  echo "<option>Select Category</option>";
		while($row = mysqli_fetch_array($query)){

				echo "<option value='".$row['categoryid']."'>".$row['categoryname']."</option>";
		}
				echo "</select>";
}
//shows the add to watchlist option--------

	function watsnew(){
		$query = mysqli_query("SELECT * FROM products WHERE status = 0 ORDER BY productid DESC LIMIT 0,1") or die (mysqli_error());
		while($row = mysqli_fetch_array($query)){
		echo
			'<div class="border_box">
				<div class="product_title"><a href="details.php?id='.$row['productid'].'">'.$row['prodname'].'</a></div>
				<div class="product_img"><img src="administrator/images/products/'.$row['prodimage'].'" width="94" height="92" alt="" border="0" /></div>
				<div class="prod_price"></div>
			</div>';
		}
	}

 //shows categories--------

function categories(){
			require("db.php");
      	$query = mysqli_query($conn, "SELECT * FROM `pcategories`") or die (mysqli_error());
		while($row = mysqli_fetch_array($query)){
				echo "<li class = 'even'><a href ='showprod.php?id=".$row['categoryid']."'>".$row['categoryname']."</a></li>";
			}
		echo "</ul>";
	}

//shows categories--------

	function categorylist(){
		require("db.php");
      	$query = mysqli_query($conn, "SELECT * FROM pcategories") or die (mysqli_error());
		while($row = mysqli_fetch_array($query))
		{
			echo "<div class='prod_box'>";
				echo "<div class='top_prod_box'></div>";
				echo "<div class='center_prod_box'>";
				echo "<div class='product_title'><a href='showprod.php?id=".$row['categoryid']."'>".$row['categoryname']."</a></div>";
				echo "<div class='product_img'><a href='showprod.php?id=".$row['categoryid']."'><img src='administrator/images/category/".$row['catimage']."' width='94' height='92' alt='' border='0' /></a></div>";
				echo "<div class='prod_price'><span class='price'>".$row['categorydes']."</span></div>";
			echo "</div>";
			echo "<div class='bottom_prod_box'></div>";
			echo "<div class='prod_details_tab'>click to view products in category</div>";
			echo "</div>";
		}
	  }

//shows latest products-----

	function latest(){
		require("db.php");
		$query = mysqli_query($conn, "SELECT * FROM products WHERE status = 0 ORDER BY productid DESC LIMIT 0,6") or die (mysqli_error());

		while($row = mysqli_fetch_array($query))
		{
			$prodid = $row['productid'];
			$prodsbid = $row['startingbid'];
			//for displaying highest bid and no of bidders
			$query2 = mysqli_query($conn, "SELECT * FROM bidreport WHERE productid = '$prodid'") or die (mysqli_error());
			$noofbidders = mysqli_num_rows($query2);
			$highbid = $prodsbid;
			while($highonthis = mysqli_fetch_array($query2)){
				$checkthis = $highonthis['bidamount'];
				if($checkthis > $highbid){
					$highbid = $checkthis;
				}
			}
			$highestbidder = mysqli_query($conn, "SELECT * FROM bidreport WHERE bidamount = '$highbid'")or die(mysqli_error());
			$highestbiddera = mysqli_fetch_array($highestbidder);
			$hibidder = isset($highestbiddera['bidder']);
			$name = mysqli_query($conn, "SELECT * FROM member WHERE memberid = '$hibidder'")or die(mysqli_error());
			$namea = mysqli_fetch_array($name);
			$highname = isset($namea['userid']);
			echo "<div class='prod_box'>";
				echo "<div class='top_prod_box'></div>";
				echo "<div class='center_prod_box'>";
					echo "<div class='product_title'><a href='details.php?id=".$row['productid']."'>".$row['prodname']."</a></div>";
				echo "<div class='product_img'><a href='details.php?id=".$row['productid']."'><img src='administrator/images/products/".$row['prodimage']."' width='94' height='92' alt='' border='0' /></a></div>";
				echo "<div class='prod_price'><span>Start Bid at: </span> <span class='price'>CFA ".$row['startingbid']."</span><br />
				<span>Highest Bidder: </span> <span class='price'>".$highname."</span>
				</div>";
			echo "</div>";
			echo "<div class='bottom_prod_box'></div>";
			echo "<div class='prod_details_tab'><a href='details.php?id=".$row['productid']."' class='prod_details' title='header=[Click to Bid] body=[&nbsp;] fade=[on]'>Bid Now</a> </div>";
			echo "</div>";
		}
	  }
//shows products on a category-----

function showprod(){
	require("db.php");
	$id = $_GET['id'];
	$query = mysqli_query($conn, "SELECT * FROM products WHERE categoryid = '$id' AND status = 0") or die (mysql_error());
	$res = mysqli_num_rows($query);
	if($res == 0){
		echo "<div class='prod_box'>";
			echo "<div class='top_prod_box'></div>";
			echo "<div class='center_prod_box'>";
				echo "<div class='product_title'>There is no available product on this category</div>";
			echo "<div class='product_img'><img src='administrator/images/products/nocateg.jpg' width='94' height='92' alt='' border='0' /></div>";
			echo "<div class='prod_price'></div>";
		echo "</div>";
		echo "<div class='bottom_prod_box'></div>";
		echo "<div class='prod_details_tab'><a href='details.php' class='prod_details'>details</a> </div>";
		echo "</div>";
	}else{
	while($row = mysqli_fetch_array($query))
	{
		$prodid = $row['productid'];
		$prodsbid = $row['startingbid'];
		//for displaying highest bid and no of bidders
		$query2 = mysqli_query($conn, "SELECT * FROM bidreport WHERE productid = '$prodid'") or die (mysqli_error());
		$noofbidders = mysqli_num_rows($query2);
		$highbid = $prodsbid;
		while($highonthis = mysqli_fetch_array($query2)){
			$checkthis = $highonthis['bidamount'];
			if($checkthis > $highbid){
				$highbid = $checkthis;
			}
		}
		$highestbidder = mysqli_query($conn, "SELECT * FROM bidreport WHERE bidamount = '$highbid'")or die(mysqli_error());
		$highestbiddera = mysqli_fetch_array($highestbidder);
		$hibidder = isset($highestbiddera['bidder']);
		$name = mysqli_query($conn, "SELECT * FROM member WHERE memberid = '$hibidder'")or die(mysqli_error());
		$namea = mysqli_fetch_array($name);
		$highname = isset($namea['userid']);
		echo "<div class='prod_box'>";
			echo "<div class='top_prod_box'></div>";
			echo "<div class='center_prod_box'>";
				echo "<div class='product_title'><a href='details.php?id=".$row['productid']."'>".$row['prodname']."</a></div>";
			echo "<div class='product_img'><a href='details.php?id=".$row['productid']."'><img src='administrator/images/products/".$row['prodimage']."' width='94' height='92' alt='' border='0' /></a></div>";
			echo "<div class='prod_price'><span>Start Bid at: </span> <span class='price'>CFA ".$row['startingbid']."</span><br />
			<span>Highest Bidder: </span> <span class='price'>".$highname."</span>
			</div>";
		echo "</div>";
		echo "<div class='bottom_prod_box'></div>";
		echo "<div class='prod_details_tab'><a href='details.php?id=".$row['productid']."' class='prod_details' title='header=[Click to Bid] body=[&nbsp;] fade=[on]'>Bid Now</a> </div>";
		echo "</div>";
	}
	}
}

//shows the products on watch--------
 function onwatch(){
	 require("db.php");
		$who_u = $_SESSION['logged'];
		$query1 = mysqli_query($conn, "SELECT * FROM watchlist WHERE memberid = '$who_u'");
		while($row1 = mysqli_fetch_array($query1)){
			$prod = $row1['productid'];
			$query = mysqli_query($conn, "SELECT * FROM products WHERE productid = '$prod'");
			while($row = mysqli_fetch_array($query)){
				echo "<div class='prod_box'>";
					echo "<div class='top_prod_box'></div>";
					echo "<div class='center_prod_box'>";
						echo "<div class='product_title'><a href='details.php?id=".$row['productid']."'>".$row['prodname']."</a></div>";
					echo "<div class='product_img'><a href='details.php?id=".$row['productid']."'><img src='administrator/images/products/".$row['prodimage']."' width='94' height='92' alt='' border='0' /></a></div>";
					echo "<div class='prod_price'><span class='reduce'>".$row['regularprice']."$</span> <span class='price'>".$row['startingbid']."$</span></div>";
				echo "</div>";
				echo "<div class='bottom_prod_box'></div>";
				echo "<div class='prod_details_tab'><a href='details.php' class='prod_details' title='header=[Click for Details] body=[&nbsp;] fade=[on]'>Details</a> </div>";
				echo "</div>";
			}
		}
	  }
//shows the account--------
function account(){
	require("db.php");
	if ($_SESSION['logged'] != 'guest'){
			echo '<li><a href="logout.php" class="nav3">Log-Out</a></li>
		<li><a href="myaccount.php" class="nav3">View Account</a></li>
		<li><a class="nav4">Account</a></li>';
	}else{
		echo '<li><a href="login.php" class="nav4">Log-in or Register</a></li>';
	}
}
function logform(){
		require("db.php");
	if ($_SESSION['logged'] == 'guest'){
	echo '<div class="title_box">Welcome</div>
			  <div class="border_box">
					<br />
						<strong>User: </strong>Guest<br /><br />
						<strong>Account Status:</strong> Not Active<br /><br />
						<strong>Bid Counter:</strong> Not Available<br /><br />
						<strong>Items Acquired:</strong> Not Available<br /><br />
						<strong>Feedbacks:</strong> Not Available<br /><br />
						<ul></ul>
			</div>';
	}elseif($_SESSION['logged'] == 'notactive'){
		$hisid = $_SESSION['logged'];
		$query = mysqli_query($conn, "SELECT * FROM member WHERE memberid = '$hisid' ");
		While($rows = mysqli_fetch_array($query)){
			echo '<div class="title_box">Welcome</div>
					<div class="border_box">
						<br />
							<strong>Username:</strong> '.$rows['userid'].'<br /><br />
							<strong>Account Status</strong>Not Active<br /><br />
							<strong>Bid Counter:</strong> Not Available<br /><br />
							<strong>Items Acquired:</strong> Not Available<br /><br />
							<strong>Feedbacks:</strong> Not Available<br /><br />
							<ul></ul>
						</form>
				</div>';
			}
	}else{
		$hisid = $_SESSION['logged'];
		$query = mysqli_query($conn, "SELECT * FROM member WHERE memberid = '$hisid' ");
		While($rows = mysqli_fetch_array($query)){
			echo '<div class="title_box">Welcome</div>
					<div class="border_box">
							<br />
							<strong>Username:</strong> '.$rows['userid'].'<br /><br />
							<strong>Account Status: </strong> Active<br /><br />
							<strong>Bid Counter:</strong> 0<br /><br />
							<strong>Items Acquired:</strong> 0<br /><br />
							<strong>Feedbacks:</strong> 0<br /><br />
							<ul></ul>
						</form>
				</div>';
			}
		}
	}
?>

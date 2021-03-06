<!DOCTYPE html>
<?php 

require ('dbconn.php');

$query="SELECT b.emailAddress, b.bookingID, b.bookername, b.contactNumber, d.deptName , b.datevisit, b.noofPersons, b.purpose, b.comment FROM booking b
Join department d
ON d.departmentID=b.departmentTo
WHERE status = 'pending' ORDER BY b.bookingID DESC";
$result= $conn->query($query);

?>

<html> 
	<head>
		<link rel="stylesheet" href="css/maxcdn.bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/uscbooking.css">
	    <script src="js/ajax.googleapis.jquery.min.js"></script>
	    <script src="js/maxcdn.bootstrap.min.js"></script>
	    <style>
	    	.usertab {
			    font-size: 15px;
			}

			a.vpaabutton {
			    float: left;
			}
			.nav>li>a {
   				 position: relative;
    			 display: block;
    			 padding: 0.5px 2px;
			}		
			@media print
			{
				body * { visibility: hidden; }
				#qrcodeprint { visibility: visible; }
			}
			.h3{
  				font-size: 30px;
   				font-family: auto;
			}
			.accept{
				float: left;
			    margin-top: -17px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 54px;
			    font-size: 20px;
			    margin-left: 170px;
			}
			.reject{
    			float: left;
			    margin-top: 4px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 130px;
			    font-size: 20px;
			    margin-left: 65px;
			}
			.query{
    			float: left;
			    margin-top: 4px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 137px;
			    font-size: 20px;
			    margin-left: 66px;
			}
		</style>
		</style>
	</head>
		<body>
			<center> <br> <br> <br> 
			<img src="images/usctc.png" alt="USC LOGO">
			<div class = "bookingFOrm" style="background-color:#FFFFFF; padding-top:20px;color:black;border-radius:5px;margin-bottom: 20px;margin-top:15px;width: 75%">
				<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px">

			<?php
				require ('loginheader.php');
				if($_SESSION['utype'] != 1 ) {
					header('Location: index.php');
					}
			?>

			<br>
			<div class = "headerbutton">
				<a class="vpaabutton btn btn-warning btn-md" href="vpaapage.php">Home</a>
				<a class="vpaabutton btn btn-primary btn-md" href="acceptvpaa.php">Approved</a>
				<a class="vpaabutton btn btn-success btn-md" href="queryvpaa.php">Pending</a>
				<a class="vpaabutton btn btn-danger btn-md" href="rejectvpaa.php">Rejected</a>
				<a class="vpaabutton btn btn-info btn-md" data-toggle="modal" data-target="#qrcode" data-id="1">QR Code Generator</a>
			</div> <br> 

			<div id="qrcode" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
				      	</div>
				      	<center> <br> 
				     	<div class="modal-body">
				      		<img id="qrcodeprint" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=2&choe=UTF-8"/>
				      		<input type="text" id="numberss">
				      		<button onclick="myFunction()">Print this page</button>
				      	</div>
			  		</div>
			  	</div>
  			</div>
			</div> <br> <br>

			<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px"> PENDING BOOKINGS </h3> <br> <br>   
			<div class="container"> 
				<ul class="nav nav-tabs">
					 <li class="active">
				</ul> 
			<table class="usertab">
				<thead>
		            <tr>
		                <th class='usertab'>Booking ID</th>
		                <th class='usertab'>Booker's Name</th>
		                <th class='usertab'>Date of Visit</th>
		                <th class='usertab'>No. of Persons</th>
		                <th class='usertab'>Department To</th>
		                <th class='usertab'>Comment</th>
		                <th class='usertab'>Accept </th>
		                <th class='usertab'>Decline </th>
		            </tr>
		        </thead>
			
			<?php 
				while($row=mysqli_fetch_assoc($result)){
					echo "<tbody>";
					echo "<td class='usertab'><b>".$row['bookingID']."</td></p>";
					echo "<td class='usertab'>".$row['bookername']."</td>";
					echo "<td class='usertab'>".$row['datevisit']."</td>";
					echo "<td class='usertab'>".$row['noofPersons']."</td>";
					echo "<td class='usertab'>".$row['deptName']."</td>";
					echo "<td class='usertab'>".$row['comment']."</td>";
					echo "<td class='usertab'><input type='submit' class='btn btn-primary btn-md' id='accept-button' value='Accept' data-toggle='modal' data-target='#acceptmodal' data-id='".$row['bookingID']."' data-email='".$row['emailAddress']."'></td> ";
					echo "<td class='usertab'><input type='submit' class='btn btn-danger btn-md' id='reject-button' value='Decline' data-toggle='modal' data-target='#rejectmodal' data-id='".$row['bookingID']."' data-email='".$row['emailAddress']."'></td>";
					echo "</tbody>";
				}
			?>
			</table>
			</center>

			<div id="acceptmodal" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-body">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <div class="h3">
				      		<center> <h3>Confirm Request</h3> </center>
				      	</div>
				      </div>
				      	<center><h4>Continue accepting the request?</h4> </center>
				        <form action="booking.php" method="post" class="bookingInput">
				        	<input type="text" name="email" class="email" style="visibility: hidden">
					        <input type="text" name="operation" value="accept" style="visibility: hidden">
					        <input type="text" name="bookingId" id="acceptbookingid" style="visibility: hidden">
					    	<input type="submit" class="btn btn-primary btn-md accept" value="Accept Request"> <br> <br> <br> <br> 
					    </form>
			  		</div>
			  	</div>
  			</div>

  			<div id="rejectmodal" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <center>
				      	<div class="h3">
				        	<h3>Reject Request</h3>
				      </div>
				      <div class="modal-body">
				        <form action="booking.php" method="post" class="bookingInput">
				        	<input type="text" name="email" class="email" style="visibility: hidden">
					        <input type="text" name="operation" value="reject" style="visibility: hidden">
					        <input type="text" name="bookingId" id="rejectbookingid" style="visibility: hidden">
					        <textarea rows="5" cols="62" class="booking" type="text" name="rejectreason" placeholder="Reject Reason :" required></textarea><br>
					    	<input type="submit" class="btn btn-danger btn-md reject" value="Submit Reason"> <br> <br> <br> <br> 
					    </form>
						</center>
				      </div>
			  		</div>
			  	</div>
  			</div>

  			<div id="querymodal" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h3>Write Message Here</h3>
				      </div>
				      <div class="modal-body">
				        <form action="booking.php" method="post" class="bookingInput">
					        <input type="text" name="operation" value="query" style="visibility: hidden">
					        <input type="text" name="bookingId" id="querybookingid" style="visibility: hidden">
					        <textarea rows="5" cols="62" class="booking" type="text" name="query" placeholder="Query Here.This will be sent as email body" required> </textarea><br>
					    	<input type="submit" class="accept" value="Send">
					    </form>
				      </div>
			  		</div>
			  	</div>
  			</div>
		</body>

		<script type="text/javascript">
	    	$(document).ready(function(){
		       	$("#acceptmodal").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var eaddress = $(e.relatedTarget).data('email');
					$('#acceptbookingid').val(id);
					$('.email').val(eaddress);
				});

		        $("#rejectmodal").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var eaddress = $(e.relatedTarget).data('email');
					$('#rejectbookingid').val(id);
					$('.email').val(eaddress);
				});

		        $("#querymodal").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var eaddress = $(e.relatedTarget).data('email');
					$('#querybookingid').val(id);
					$('.email').val(eaddress);
				});
	    	});
	    </script>
</html>
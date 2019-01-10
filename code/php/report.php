<!DOCTYPE html>
<html>
<head>
	<title>Apk Monitor</title>
	<style>
		body{
			font-family: "Times New Roman", Times, serif;
			font-size: 17px;
		}
		.tb {
			margin-top: 70px;
			border-collapse: collapse;
			width: 100%;
			color: black;
			text-align: left;
			table-layout: fixed;
			word-wrap: break-word;
			height: 25px;
		}
		.tb th {
			background-color: #d96459;
			color: black;
			height: 30px;

		}
		#header{
			padding: 40px;
			margin-bottom: 10px;
			background-color: #d96459;
			font: 400 60px/0.8 'Great Vibes', Helvetica, sans-serif;
  			color: #fff;
  			text-shadow: 4px 4px 3px rgba(0,0,0,0.1); 
  			font-weight: bold;
  
		}
		.lCPN{
			text-align: center;
			padding: 20px;
			margin-bottom: 70px;
			background-color: #000000;
			font: 400 40px/0.8 'Great Vibes', Helvetica, sans-serif;
  			color: #fff;
  			text-shadow: 4px 4px 3px rgba(0,0,0,0.1); 
  			font-weight: bold;
		}

		#info{
			padding-top: 90px;
			font-size: 20px;
			margin-left: 50px;
		}
		#appinfo{
			font-size: 50px;
			width: 300px;
			padding: 40px;
			margin-left: 60px;
		}
		.line1{
			display: inline-block;		
		}
		#per, #LOC, #PI{
			margin-top: 70px;
		}
		#LOFinfo, #PER, #fooder{
			margin-left: 50px;
			font-size: 25px;
			font-style: italic;
		}
		#fooder{
			text-align: center;
			margin-bottom: 70px;
		}
		.other{
			text-align: center;
		}
		.name{
			text-align: left;
		}
		.tb tr:nth-child(odd) {background-color: #f2f2f2}
		.tb tr:hover {background-color: hsla(0, 100%, 70%, 0.3);}
	</style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<p id="header" align="center">Apk Detailed Report</p>
	<div class="row">
		<div class="col-sm-4" id="appinfo"><img src="inforicon.jpg" alt="Information icon" style="width:250px;height:250px;"></div>
		<div id="info" class="col-sm-8">
			<?php
			$ID = $_GET['ID'];

			$conn = mysqli_connect("localhost", "root", "", "ANDROID_APP_LIST");
			if ($conn-> connect_error){
				die("Connection failed:". $conn-> connect_error);
			}
			$sql = "SELECT AppID, AppName, MD5, SHA1, SHA256 from App Where AppID='$ID';";
			$result = $conn-> query($sql);

			if($result-> num_rows >0){
				echo "<table>";
				while ($row = $result-> fetch_assoc()) {
					echo "<tr><th>ID:</th><td>". $row["AppID"] ."</td></tr>";
					echo "<tr><th>Name:</th><td>". $row["AppName"] ."</td></tr>";
					echo "<tr><th>MD5:</th><td>". $row["MD5"] ."</td></tr>";
					echo "<tr><th>SHA1:</th><td>". $row["SHA1"] ."</td></tr>";
					echo "<tr><th>SHA256:  </th><td>". $row["SHA256"] ."</td></tr>";
				}
			}
				echo "</table>";
			?>
		</div>
	</div>
	<p class="lCPN">List of Common Functions</p>
	<div>
		<?php
			require 'piechart.php';
			
			echo "<table class=tb><tr>";
			echo "<th width=". 10 ."% class=other>ID</th>";
			echo "<th width=". 80 ."% class=name>Name</th>";
			echo "<th width=". 20 ."% class=other>sendBroadcast</th>";
			echo "<th width=". 20 ."% class=other>onReceive</th>";
			echo "<th width=". 20 ."% class=other>startService</th>";
			echo "<th width=". 20 ."% class=other>onHandleIntent</th>";
			echo "<th width=". 20 ."% class=other>startActivity</th>";
			echo "<th width=". 20 ."% class=other>getIntent</th></tr>";

			$sql = "SELECT AppID, AppName, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent from App Where AppID='$ID';";
			$result = $conn-> query($sql);
			if($result-> num_rows >0){
			while ($row = $result-> fetch_assoc()) {
				echo "<tr><td align=center>". $row["AppID"] ."</td><td>". $row["AppName"] ."</td><td align=center>". $row["sendBroadcast"] ."</td><td align=center>". $row[
				"onReceive"] ."</td><td align=center>". $row["startService"] ."</td><td align=center>". $row["onHandleIntent"] ."</td><td align=center>". $row[
				"startActivity"] ."</td><td align=center>". $row["getIntent"] ."</td></tr>";
			}
		}
		else{
			echo "0 result";
		}
		echo "</table>";
		?>
		</div>
		<div>
			<p class="lCPN" id="LOC">List of Components</p>
			<?php
				echo "<div id=LOFinfo>"; 
				echo "Total unique activities in app: ";
				$sql = "SELECT COUNT(DISTINCT ComponentName) AS ncount FROM Component WHERE AppID='$ID';";
				$result = $conn-> query($sql);
				if($result = $conn-> query($sql)){
					while ($row = $result-> fetch_assoc()) {
						echo $row["ncount"];
					}
				}

				echo "<br>";
				echo "Total export statuses are TRUE in app: ";
				$sql = "SELECT COUNT(ExportStatus) AS ncount FROM Component WHERE AppID='$ID' AND ExportStatus='true';";
				$result = $conn-> query($sql);
				if($result = $conn-> query($sql)){
					while ($row = $result-> fetch_assoc()) {
						echo $row["ncount"];
					}
				}
				echo "</div>";
				echo "<table  class=tb><tr>";
				echo "<th width=". 10 ."% class=other>ID</th>";
				echo "<th width=". 50 ."% class=name>Name</th>";
				echo "<th width=". 40 ."% class=other>Type</th>";
				echo "<th width=". 30 ."% class=other>Export Status</th></tr>";

				$sql = "SELECT AppID, ComponentName, ComponentType, ExportStatus FROM Component WHERE AppID='$ID';";
				$result = $conn-> query($sql);
				if($result-> num_rows >0){
					while ($row = $result-> fetch_assoc()) {
						if($row["ExportStatus"] == "true")
							echo "<tr style=color:yellow;background-color:red><td align=center>". $row["AppID"] ."</td><td>". $row["ComponentName"] ."</td><td align=center>". $row["ComponentType"] ."</td><td align=center>". $row[
							"ExportStatus"] ."</td></tr>";
						else
							echo "<tr><td align=center>". $row["AppID"] ."</td><td>". $row["ComponentName"] ."</td><td align=center>". $row["ComponentType"] ."</td><td align=center>". $row[
							"ExportStatus"] ."</td></tr>";

					}
				}
				else{
					echo "0 result";
				}
				echo "</table>";
			 ?>
		</div>
		<div>
			<p class="lCPN" id="per">List of Permissons</p>
			<?php 
				echo "<div id=PER>";
				echo "Total permissons in app: ";
				$sql = "SELECT COUNT(DISTINCT PermissionName) AS ncount FROM Permission WHERE AppID='$ID';";
				$result = $conn-> query($sql);
				if($result = $conn-> query($sql)){
					while ($row = $result-> fetch_assoc()) {
						echo $row["ncount"];
					}
				}
				
				echo "<br>";
				echo "Total dangerous permissons in app: ";
				$sql = "SELECT COUNT(PermissionName) AS ncount FROM Permission WHERE AppID='$ID' AND EXISTS (SELECT PermissionName FROM DangerousPermission WHERE SUBSTRING(Permission.PermissionName,20,LENGTH(Permission.PermissionName)) = DangerousPermission.PermissionName);";
				$result = $conn-> query($sql);
				if($result = $conn-> query($sql)){
					while ($row = $result-> fetch_assoc()) {
						echo $row["ncount"];
					}
				}
				echo "</div>";
				echo "<table class=tb><tr>";
				echo "<th width=". 50 ."% class=other>ID</th>";
				echo "<th width=". 50 ."% class=name>Name</th></tr>";

				$sql = "SELECT AppID, PermissionName FROM Permission WHERE AppID='$ID';";
				$result = $conn-> query($sql);
				if($result-> num_rows >0){
					while ($row = $result-> fetch_assoc()) {
						$temp = substr($row["PermissionName"],19);
						$sql = "SELECT 1 FROM DangerousPermission WHERE PermissionName='$temp';";
						$highlight = $conn-> query($sql);
						if($highlight-> num_rows >0)
							echo "<tr style=color:yellow;background-color:red><td align=center>". $row["AppID"] ."</td><td>". $row["PermissionName"] ."</td></tr>";
						else
							echo "<tr><td align=center>". $row["AppID"] ."</td><td>". $row["PermissionName"] ."</td></tr>";							
					}
				}
				else{
					echo "0 result";
				}
				echo "</table>";
			 ?>
		</div>
		<p class="lCPN", id="PI">Project Information</p>
		<div id="fooder">
			<p>UNIVERSITY OF INFORMATION TECHNOLOGY<br>Supervisor: Mr. Nguyen Tan Cam<br>Student 1: Tang Duc Bao - 15520043<br>Student 2: Khuu Ngoc Anh - 15520017</p>
		</div>
</body>
</html>
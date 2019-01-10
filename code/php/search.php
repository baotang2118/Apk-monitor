<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Apk Monitor</title>
	<style>
		body{
			font-family: "Times New Roman", Times, serif;
			font-size: 17px;
		}
		table{
			margin-top: 10px;
			border-collapse: collapse;
			width: 100%;
			color: black;
			text-align: left;
			table-layout: fixed;
			word-wrap: break-word;
			height: 25px;
		}
		th{
			background-color: #d96459;
			color: black;
			text-align: center;
			height: 30px;
		}
		#from{
			margin-left: 40px;
			width:30%;
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
		#textbox{
			height: 30px;
			width: 250px;
		}
		.other{
			text-align: center;
		}
		#name{
			text-align: left;
		}
		.page:hover{
			 background-color: #555555;
  			color: white;
		}
		tr:nth-child(odd) {background-color: #f2f2f2}
		tr:hover {background-color: hsla(0, 100%, 70%, 0.3);}
	</style>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<p id="header" align="center">Search result</p>
	<div id="from">
		<form action="search.php" method="get">
			<input type="text" name="searchApp" id="textbox">
			<input type="submit" class="page">
		</form>
	</div>
	<div>

		<?php
		echo "<table><tr>";
		echo "<th width=". 10 ."% class=other>ID</th>";
		echo "<th width=". 80 ."% id=name>Name</th>";
		echo "<th width=". 20 ."% class=other>sendBroadcast</th>";
		echo "<th width=". 20 ."% class=other>onReceive</th>";
		echo "<th width=". 20 ."% class=other>startService</th>";
		echo "<th width=". 20 ."% class=other>onHandleIntent</th>";
		echo "<th width=". 20 ."% class=other>startActivity</th>";
		echo "<th width=". 20 ."% class=other>getIntent</th></tr>";

		$searchApp = $_GET['searchApp'];
		$conn = mysqli_connect("localhost", "root", "", "ANDROID_APP_LIST");
		if ($conn-> connect_error){
			die("Connection failed:". $conn-> connect_error);
		}
		$sql = "SELECT AppID, AppName, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent FROM App WHERE AppID='$searchApp' OR AppName='$searchApp' OR MD5='$searchApp' OR SHA1='$searchApp' OR SHA256='$searchApp';";
		$result = $conn-> query($sql);
		if($result-> num_rows >0){
			while ($row = $result-> fetch_assoc()) {
				echo "<tr><td align=center>". $row["AppID"] ."</td><td><a href=report.php?ID=".$row["AppID"].">". $row["AppName"] ."</a></td><td align=center>". $row["sendBroadcast"] ."</td><td align=center>". $row[
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
</body>
</html>

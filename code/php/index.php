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
		table {
			margin-top: 10px;
			border-collapse: collapse;
			width: 100%;
			color: black;
			text-align: left;
			table-layout: fixed;
			word-wrap: break-word;
			height: 25px;
		}
		th {
			background-color: #d96459;
			color: black;
			height: 30px;

		}
		.other{
			text-align: center;
		}
		#name{
			text-align: left;
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
		#page{
			margin-left: 550px;
			width: 25%;
		}
		#from{
			margin-left: 40px;
			width:30%;
		}
		.page{
			height: 30px;
			width: 150px;
			display: inline-block;
		}
		.page:hover{
			 background-color: #555555;
  			color: white;
		}
		#page, #from{
			display: inline-block;
		}
		#textbox{
			height: 30px;
			width: 250px;
		}
		tr:nth-child(odd) {background-color: #f2f2f2}
		tr:hover {background-color: hsla(0, 100%, 70%, 0.3);}
	</style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
  <script>
  $(document).ready(function(){
  		var offsetTable = 0;
  		$("#next").click(function(){
  			offsetTable = offsetTable +10;
  			$("#loadtb").load("load-table.php",{
  				offsetNewTable: offsetTable
  			});
  		});
  		$("#previous").click(function(){
  			offsetTable = offsetTable -10;
  			$("#loadtb").load("load-table.php",{
  				offsetNewTable: offsetTable
  			});
  		});		
  });
  </script>
</head>
<body>
	<div id=header>
		<p align="center">Apk File List</p>
	</div>
	<div class="narbar">
		<div id="from">
			<form action="search.php" method="get">
				<input type="text" name="searchApp" id=textbox>
				<input type="submit" value="Search" class="page">
			</form>
		</div>
		<div id="page">
			<button class="page" id="previous">Previous page</button>
			<button class="page" id="next">Next page</button>
		</div>
	</div>
	<div id="loadtb">

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

		$conn = mysqli_connect("localhost", "root", "", "ANDROID_APP_LIST");
		if ($conn-> connect_error){
			die("Connection failed:". $conn-> connect_error);
		}
		$sql = "SELECT AppID, AppName, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent FROM App LIMIT 10 offset 0";
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
</body>
</html>

<?php
	echo "<table><tr>";
	echo "<th width=". 10 ."%>ID</th>";
	echo "<th width=". 80 ."%>Name</th>";
	echo "<th width=". 20 ."%>sendBroadcast</th>";
	echo "<th width=". 20 ."%>onReceive</th>";
	echo "<th width=". 20 ."%>startService</th>";
	echo "<th width=". 20 ."%>onHandleIntent</th>";
	echo "<th width=". 20 ."%>startActivity</th>";
	echo "<th width=". 20 ."%>getIntent</th></tr>";

	$offsetNewTable = $_POST['offsetNewTable'];

	$conn = mysqli_connect("localhost", "root", "", "ANDROID_APP_LIST");
	if ($conn-> connect_error){
		die("Connection failed:". $conn-> connect_error);
	}
	$sql = "SELECT AppID, AppName, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent FROM App LIMIT 10 offset $offsetNewTable";
	$result = $conn-> query($sql);
	if($result-> num_rows >0){
		while ($row = $result-> fetch_assoc()) {
			echo "<tr><td align=center>". $row["AppID"] ."</td><td>". $row["AppName"] ."</td><td align=center>". $row["sendBroadcast"] ."</td><td align=center>". $row["onReceive"] ."</td><td align=center>". $row["startService"] ."</td><td align=center>". $row["onHandleIntent"] ."</td><td align=center>". $row["startActivity"] ."</td><td align=center>". $row["getIntent"] ."</td></tr>";
			}
	}
	else{
		echo "0 result";
	}
?>
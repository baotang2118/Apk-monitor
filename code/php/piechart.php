<?php
 $ID=$_GET['ID'];
 $conn = mysqli_connect("localhost", "root", "", "ANDROID_APP_LIST");
	if ($conn-> connect_error){
		die("Connection failed:". $conn-> connect_error);
	}
	$sql = "SELECT AppID, AppName, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent from App Where AppID='$ID';";
	$result = $conn-> query($sql);
	if($result-> num_rows >0){
		while ($row = $result-> fetch_assoc()) {
			$sendBroadcast = $row['sendBroadcast'];
			$onReceive = $row['onReceive'];
			$startService = $row['startService'];
			$onHandleIntent = $row['onHandleIntent'];
			$startActivity = $row['startActivity'];
			$getIntent = $row['getIntent'];
		}
	}

$all = $sendBroadcast+$onReceive+$startService+$onHandleIntent+$startActivity+$getIntent;
$PsendBroadcast = ($sendBroadcast/$all)*100;
$PonReceive = ($onReceive/$all)*100;
$PstartService = ($startService/$all)*100;
$PonHandleIntent = ($onHandleIntent/$all)*100;
$PstartActivity = ($startActivity/$all)*100;
$PgetIntent = ($getIntent/$all)*100;

$dataPoints = array( 
	array("label"=>"sendBroadcast", "y"=>$PsendBroadcast),
	array("label"=>"onReceive", "y"=>$PonReceive),
	array("label"=>"startService", "y"=>$PstartService),
	array("label"=>"onHandleIntent", "y"=>$PonHandleIntent),
	array("label"=>"startActivity", "y"=>$PstartActivity),
	array("label"=>"getIntent", "y"=>$PgetIntent)
)
 
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: ""
	},
	subtitles: [{
		text: "December 2018"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
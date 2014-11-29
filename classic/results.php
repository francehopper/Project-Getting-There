<!doctype html>
<html>
<head>
	<title>Next Scheduled Arrivals</title>
</head>
<body>
<?php
// http://www3.septa.org/hackathon/BusSchedules/?req1=17842&req2=17&req3=i&req6=7&callback=?
// Parms(s): ?req1=stop_id req2=route (optional) req3=(i or o) (for inbound/outbound)optional req=6 number of results(optional)
// fetch stop ID, route, and results limit
$stopID = $_GET['stopID'];
$routeNo = $_GET['routeNo'];
$arrivalsLimit = $_GET['arrivalsLimit'];
// build JSON URL
$fetchThis = 'http://www3.septa.org/hackathon/BusSchedules/?req1='.$stopID.'&req2='.$routeNo.'&req6='.$arrivalsLimit;
// connect to SEPTA API
$json = file_get_contents($fetchThis);
// get data from JSON feed
$data = json_decode($json, true);
// parse results
foreach ($data[''.$routeNo.''] as $line) { 
    $name = $line['StopName']; // get name of the stop
    $route =  $line['Route']; // get route number
    $when = $line['DateCalender']; // get when it will arrive
    $message = '<li>Route '.$route.' is expected to arrive at '.$name.' at '.$when.'.</li>';
    echo $message; // return the status
}
echo '<a href="index.html">Return home</a>';
?>
</body>
</html>
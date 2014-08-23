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
$fetchSched = 'http://www3.septa.org/hackathon/BusSchedules/?req1='.$stopID.'&req2='.$routeNo.'&req6='.$arrivalsLimit;
// connect to SEPTA API
$schedJSON = file_get_contents($fetchSched);
// get data from JSON feed
$schedData = json_decode($schedJSON, true);
// parse results
foreach ($schedData[''.$routeNo.''] as $line) { 
    $name = $line['StopName']; // get name of the stop
    $route =  $line['Route']; // get route number
    $when = $line['DateCalender']; // get when it will arrive
    $message = '<li>Route '.$route.' is expected to arrive at '.$name.' at '.$when.'.</li>';
    echo $message; // return the status
}
// check for disruptions
// http://www3.septa.org/hackathon/Alerts/get_alert_data.php?req1=bus_route_<number>
$fetchAlerts = 'http://www3.septa.org/hackathon/Alerts/get_alert_data.php?req1=bus_route_'.$routeNo;
// connect to SEPTA API
$alertsJSON = file_get_contents($fetchAlerts);
// read data
$alertsData = json_decode($alertsJSON, true);
// check if there is an alert
$alertCheck = $alertsData['0']['advisory_message'];
if ($alertCheck !== '') {
	echo '<h1><p>Heads up! There are disruptions on this route:</p></h1>';
	// parse alerts
	foreach ($alertsData as $line) {
		$disruptedRoute = $line['route_name']; // get disrupted route number
		$advisoryMsg = $line['advisory_message']; // get advisory
		$detourMsg = $line['detour_message']; // get detour
		$detourLocStart = $line['detour_start_location']; // get start location
		$detourStartsOn = $line['detour_start_date_time']; // get start 
		$detourEndsOn = $line['detour_end_date_time']; // get end
		$reason = $line['detour_reason']; // get why
		$lastUpdate = $line['last_updated']; // get as of
		// build messages for advisories and detours
		// advisory present
		if ($advisoryMsg !== '') {
			$advisory = '<p>As of '.$lastUpdate.', the following advisory is in effect for route '.$disruptedRoute.': '.$advisoryMsg.'</p><br />';
			echo $advisory;
			// as WHEN, the following advisory is in effect for route ROUTE: ADVISORY
		}
		// detour present
		if ($detourMsg !== '') {
			// build message for detour
			$detour = '<p>As of '.$lastUpdate.', from '.$detourStartsOn.' until '.$detourEndsOn.', route '.$disruptedRoute.' will be detoured starting at '.$detourLocStart.' due to '.$reason.'.</p><p> The detour will be: '.$detourMsg.'.</p><p>'.$advisoryMsg.'</p><br />';
			echo $detour;
			// as of WHEN, from START until END, route ROUTE will be detoured starting at LOCATION due to REASON. The detour will be MESSAGE. ADVISORY
		}
	}
}

echo '<a href="index.html">Return home</a>';
?>
</body>
</html>
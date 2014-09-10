<!DOCTYPE HTML>
<!--
	Helios by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Helios by HTML5 UP</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.onvisible.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
			<link rel="stylesheet" href="css/style-noscript.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body class="homepage">
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
    echo '<div class="wrapper style2">';
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
echo '</div>';
?>

		<!-- Header -->
			<div id="header">
						
				<!-- Inner -->
<!-- 					<div class="inner">
						<header>
							<h1><a href="index.html" id="logo">Project Getting There</a></h1>
							<hr />
							<p>Find Your Bus</p>
						</header>
						<footer>
							<a href="#banner" class="button circled scrolly">Start</a>
						</footer>
					</div> -->
				
				<!-- Nav -->
<!-- 					<nav id="nav">
						<ul>
							<li><a href="index.html">Home</a></li>
							<li>
								<a href="">Dropdown</a>
								<ul>
									<li><a href="#">Lorem ipsum dolor</a></li>
									<li><a href="#">Magna phasellus</a></li>
									<li><a href="#">Etiam dolore nisl</a></li>
									<li>
										<a href="">And a submenu &hellip;</a>
										<ul>
											<li><a href="#">Lorem ipsum dolor</a></li>
											<li><a href="#">Phasellus consequat</a></li>
											<li><a href="#">Magna phasellus</a></li>
											<li><a href="#">Etiam dolore nisl</a></li>
										</ul>
									</li>
									<li><a href="#">Veroeros feugiat</a></li>
								</ul>
							</li>
							<li><a href="left-sidebar.html">Left Sidebar</a></li>
							<li><a href="right-sidebar.html">Right Sidebar</a></li>
							<li><a href="no-sidebar.html">No Sidebar</a></li>
						</ul>
					</nav> -->

			<!-- </div> -->
			
		<!-- Banner -->
<!-- 			<section id="banner">
				<header>
					<h2>Let's Get Started.</h2>
					<p>
						<form action="results.php" name="input"> -->
		<!-- <p class="search">SEPTA Schedule Lookup</p>  -->
<!-- 		<p>Enter your Stop ID: <input type="text" name="stopID" class="input"><br /></p>
		<p>Enter your route number: <input type="text" name="routeNo" class="input"><br /></p>
		<p>How many results would you like? <input type="text" name="arrivalsLimit" class="input"><br /></p>
		<p><input type="submit" value="Search" method="GET" formaction="results.php" /></p>
		<p><a href="http://www3.septa.org/stops/">Can't Find Your Stop ID?</a></p>
	</form> -->
<!-- 					</p>
				</header>
			</section> -->

		<!-- Carousel -->
		<!-- 	<section class="carousel">
				<div class="reel">

					<article>
						<a href="#" class="image featured"><img src="images/pic01.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Pulvinar sagittis congue</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic02.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Fermentum sagittis proin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic03.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Sed quis rhoncus placerat</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic04.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Ultrices urna sit lobortis</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic05.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Varius magnis sollicitudin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic01.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Pulvinar sagittis congue</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic02.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Fermentum sagittis proin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic03.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Sed quis rhoncus placerat</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic04.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Ultrices urna sit lobortis</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>
				
					<article>
						<a href="#" class="image featured"><img src="images/pic05.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Varius magnis sollicitudin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>							
					</article>

				</div>
			</section> -->
			
		<!-- Main -->
<!-- 			<div class="wrapper style2">

				<article id="main" class="container special">
					<a href="#" class="image featured"><img src="images/pic06.jpg" alt="" /></a>
					<header>
						<h2><a href="#">Sed massa imperdiet magnis</a></h2>
						<p>
							Sociis aenean eu aenean mollis mollis facilisis primis ornare penatibus aenean. Cursus ac enim 
							pulvinar curabitur morbi convallis. Lectus malesuada sed fermentum dolore amet.
						</p>
					</header>
					<p>
						Commodo id natoque malesuada sollicitudin elit suscipit. Curae suspendisse mauris posuere accumsan massa 
						posuere lacus convallis tellus interdum. Amet nullam fringilla nibh nulla convallis ut venenatis purus 
						sit arcu sociis. Nunc fermentum adipiscing tempor cursus nascetur adipiscing adipiscing. Primis aliquam 
						mus lacinia lobortis phasellus suscipit. Fermentum lobortis non tristique ante proin sociis accumsan 
						lobortis. Auctor etiam porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum 
						consequat integer interdum integer purus sapien. Nibh eleifend nulla nascetur pharetra commodo mi augue 
						interdum tellus. Ornare cursus augue feugiat sodales velit lorem. Semper elementum ullamcorper lacinia 
						natoque aenean scelerisque.
					</p>
					<footer>
						<a href="#" class="button">Continue Reading</a>
					</footer>
				</article>

			</div> -->

		<!-- Features -->
			<!-- <div class="wrapper style1">
				
				<section id="features" class="container special">
					<header>
						<h2>Morbi ullamcorper et varius leo lacus</h2>
						<p>Ipsum volutpat consectetur orci metus consequat imperdiet duis integer semper magna.</p>
					</header>
					<div class="row">
						<article class="4u special">
							<a href="#" class="image featured"><img src="images/pic07.jpg" alt="" /></a>
							<header>
								<h3><a href="#">Gravida aliquam penatibus</a></h3>
							</header>
							<p>
								Amet nullam fringilla nibh nulla convallis tique ante proin sociis accumsan lobortis. Auctor etiam
								porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum consequat integer interdum.
							</p>
						</article>
						<article class="4u special">
							<a href="#" class="image featured"><img src="images/pic08.jpg" alt="" /></a>
							<header>
								<h3><a href="#">Sed quis rhoncus placerat</a></h3>
							</header>
							<p>
								Amet nullam fringilla nibh nulla convallis tique ante proin sociis accumsan lobortis. Auctor etiam
								porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum consequat integer interdum.
							</p>
						</article>
						<article class="4u special">
							<a href="#" class="image featured"><img src="images/pic09.jpg" alt="" /></a>
							<header>
								<h3><a href="#">Magna laoreet et aliquam</a></h3>
							</header>
							<p>
								Amet nullam fringilla nibh nulla convallis tique ante proin sociis accumsan lobortis. Auctor etiam
								porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum consequat integer interdum.
							</p>
						</article>
					</div>
				</section> -->

			</div>

		<!-- Footer -->
<!-- 			<div id="footer">
				<div class="container">
					<div class="row"> -->
						
						<!-- Tweets -->
							<!-- <section class="4u">
								<header>
									<h2 class="icon fa-twitter circled"><span class="label">Tweets</span></h2>
								</header>
								<ul class="divided">
									<li>
										<article class="tweet">
											Amet nullam fringilla nibh nulla convallis tique ante sociis accumsan.
											<span class="timestamp">5 minutes ago</span>
										</article>
									</li>
									<li>
										<article class="tweet">
											Hendrerit rutrum quisque.
											<span class="timestamp">30 minutes ago</span>
										</article>
									</li>
									<li>
										<article class="tweet">
											Curabitur donec nulla massa laoreet nibh. Lorem praesent montes.
											<span class="timestamp">3 hours ago</span>
										</article>
									</li>
									<li>
										<article class="tweet">
											Lacus natoque cras rhoncus curae dignissim ultricies. Convallis orci aliquet.
											<span class="timestamp">5 hours ago</span>
										</article>
									</li>
								</ul>
							</section> -->

						<!-- Posts -->
<!-- 							<section class="4u">
								<header>
									<h2 class="icon fa-file circled"><span class="label">Posts</span></h2>
								</header>
								<ul class="divided">
									<li>
										<article class="post stub">
											<header>
												<h3><a href="#">Nisl fermentum integer</a></h3>
											</header>
											<span class="timestamp">3 hours ago</span>
										</article>
									</li>
									<li>
										<article class="post stub">
											<header>
												<h3><a href="#">Phasellus portitor lorem</a></h3>
											</header>
											<span class="timestamp">6 hours ago</span>
										</article>
									</li>
									<li>
										<article class="post stub">
											<header>
												<h3><a href="#">Magna tempus consequat</a></h3>
											</header>
											<span class="timestamp">Yesterday</span>
										</article>
									</li>
									<li>
										<article class="post stub">
											<header>
												<h3><a href="#">Feugiat lorem ipsum</a></h3>
											</header>
											<span class="timestamp">2 days ago</span>
										</article>
									</li>
								</ul>
							</section> -->

						<!-- Photos -->
							<!-- <section class="4u">
								<header>
									<h2 class="icon fa-camera circled"><span class="label">Photos</span></h2>
								</header>
								<div class="row quarter no-collapse">
									<div class="6u">
										<a href="#" class="image fit"><img src="images/pic10.jpg" alt="" /></a>
									</div>
									<div class="6u">
										<a href="#" class="image fit"><img src="images/pic11.jpg" alt="" /></a>
									</div>
								</div>
								<div class="row quarter no-collapse">
									<div class="6u">
										<a href="#" class="image fit"><img src="images/pic12.jpg" alt="" /></a>
									</div>
									<div class="6u">
										<a href="#" class="image fit"><img src="images/pic13.jpg" alt="" /></a>
									</div>
								</div>
								<div class="row quarter no-collapse">
									<div class="6u">
										<a href="#" class="image fit"><img src="images/pic14.jpg" alt="" /></a>
									</div>
									<div class="6u">
										<a href="#" class="image fit"><img src="images/pic15.jpg" alt="" /></a>
									</div>
								</div>
							</section>

					</div>
					<hr />
					<div class="row">
						<div class="12u"> -->
							
							<!-- Contact -->
								<!-- <section class="contact">
									<header>
										<h3>Nisl turpis nascetur interdum?</h3>
									</header>
									<p>Urna nisl non quis interdum mus ornare ridiculus egestas ridiculus lobortis vivamus tempor aliquet.</p>
									<ul class="icons">
										<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon fa-pinterest"><span class="label">Pinterest</span></a></li>
										<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
										<li><a href="#" class="icon fa-linkedin"><span class="label">Linkedin</span></a></li>
									</ul>
								</section> -->
							
							<!-- Copyright -->
								<!-- <div class="copyright">
									<ul class="menu">
										<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
									</ul>
								</div> -->
							
						</div>
					
					</div>
				</div>
			</div>

	</body>
</html>
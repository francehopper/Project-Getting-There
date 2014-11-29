<!DOCTYPE HTML>
<!--
	Helios by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Next Scheduled Arrivals | Next</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Find the next scheduled arrivals for your SEPTA bus." />
		<meta name="keywords" content="SEPTA, Philadelphia, schedules, lookup, find, bus, transit" />
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
	<body class="no-sidebar">

		<!-- Header -->
			<div id="header">

				<!-- Inner -->
					<div class="inner">
						<header>
							<h1><a href="index.html" id="logo">Project Getting There | Next Preview</a></h1>
						</header>
					</div>
				
				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="index.html">Home</a></li>
							<li><a href="http://septa.org">SEPTA Home</a></li>
							<li><a href="http://fhnwrk.com">The France Hopper Network</a></li>
						</ul>
					</nav>

			</div>
			
		<!-- Main -->
			<div class="wrapper style1">

				<div class="container">
					<article id="main" class="special">
<!-- 						<header>
						<!-- This is where the content header goes -->
							<!-- <h2>Let's find your bus.</h2>
							<p>
								We'll do this using your StopID, route number, and how many results you'd like.
							</p>
						</header>
						<section> -->
						<!-- This is where the content goes -->
						<!-- Starting PHP -->
						<?php
							$stopID = $_GET['stopID'];
							$routeNo = $_GET['routeNo'];
							$arrivalsLimit = $_GET['arrivalsLimit'];
							echo "<header>";
							echo "<h2>Next " . $arrivalsLimit . " scheduled arrivals for route " . $routeNo . ":</h2>";
							echo "</header>";
							echo "<section>";
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
							echo "<a href=\"index-debug.html\">Start a new search</a>";
							echo "</section>";
						?>
						<!-- Ending PHP -->


						<!-- </section> -->
					</article>
					<!-- End of primary content -->
<!--  					<hr />
				<div class="row">
						<article class="4u special">
							<header>
								<h3>What's a StopID?</h3>
							</header>
							<p>
								A StopID uniquely identifies a bus stop on the SEPTA system. It's how we know where you are and what direction you're traveling in. Most bus stops will have it located at the bottom of the stop sign. If your stop is missing one, you can <a href="http://www3.septa.org/stops/" target="_blank">find it here.</a> You can also <a href="http://twitter.com/septa_social" target="_blank">let SEPTA know.</a>
							</p>
						</article>
						<article class="4u special">	
							<header>
								<h3>What's a route number?</h3>
							</header>
							<p>
								<a href="index-debug.html">Start a new search</a>
							</p>
						</article>
						<article class="4u special">
							
							<header>
								<h3>What do mean by "results"?</h3>
							</header>
							<p>
								Results means how many results from the timetable you want. If you just want the next bus, enter "1". For the next three, enter "3".
							</p>
						</article>
					</div> -->  
				</div>

			</div>

		<!-- Footer -->
			<div id="footer">
				<div class="container">
					<div class="row">
						<div class="12u">
							<!-- Contact -->
								<section class="contact">
									<header>
										<h3>A better SEPTA starts with you.</h3>
									</header>
									<p>This project was built with the SEPTA API. Like the API, <a href="https://github.com/francehopper/Project-Getting-There" target="_blank">it is free for anyone to build on.</a></p>
									<ul>
									<li><a href="http://fhnwrk.com/projects" target="_blank">Want to see what else I've done?</a></li>
									<li><a href="https://twitter.com/francehopper" target="_blank">Tweet at me.</a></li>
									<li><a href="http://twitter.com/septa_social" target="_blank">Tweet at SEPTA too.</a></li>
									<li><a href="tel:+12155807800">Need to call SEPTA?</a></li>
									</ul>
								</section>
							
							<!-- Copyright -->
								<div class="copyright">
									<ul class="menu">
										<li>&copy; 2014 ai|transit, <a href="http://fhnwrk.com/about/company/" target="_blank">an ai|company</a>. Some rights reserved.</li><li>Page template by <a href="http://html5up.net">HTML5 UP</a></li>
									</ul>
								</div>
							
						</div>
					
					</div>
				</div>
			</div>

	</body>
</html>
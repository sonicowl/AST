<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>AST - Home</title>
	<!-- Date: 2012-03-19 -->
	<style>
		body {font-family: Helvetica}
		#header {float:right; font-size:0.9em; margin-bottom:5px; margin-right:5px}
		a{text-decoration:none; color:#757373}
		h1{font:bold 24px Helvetica;}
		#current_reading {border-radius: 5px;border:1px solid #474747}
		.current_title {text-transform:UPPERCASE; 
			background:-webkit-gradient(linear,0 0,0 100%,from(#858585),to(#1d1d1d),color-stop(0.05,#454545));
			color:#FFF; padding:0.7em; font-size:0.8em; }
		.book_title {color:#1d1d1d; font-size:1.4em; font-family:BryantMedium, sans-serif;}
		.book_autor {color:#474747; font-size:1.1em; font-family:BryantMedium, sans-serif;}
		.current_body{padding:15px}
		#book_pos {float:left; width:100px}
		#user_stats {float:left; width:150px; margin-left:15px}
		.label_user {font-size:1.1em; color:#757373; margin-bottom:5px}
		.stats_result {font-size:1.0em; margin-bottom:10px}
		.continue {font-size:1.3em; display:block; margin-top:15px; text-align:center; padding:5px; color:#FFF; background:-webkit-gradient(linear,0 0,0 100%,from(#858585),to(#1d1d1d),color-stop(0.05,#454545)); border-radius: 5px;border:1px solid #474747}
	</style>
</head>
<body>
	<div id="header">
		Hello John. <a href="#">Your account </a>  • <a href="#">Sign out</a>
	</div>
	<div style="clear:right"></div>
	
	<div id="current_reading">
		<div class="current_title">Currently Reading</div>
		<div class="current_body">
			<div class="book_title">Practical Demonkeeping</div>
			<div class="book_autor">Christopher Moore </div>
			<hr/>
			<div id="book_pos">
				<a href="index.php"><img src="MSRThumb.jpg" border="0 "/></a>
			</div>
			<div id="user_stats">
				<div class="label_user">Progress</div>
				<div class="stats_result"> 37% </div>
				
				<div class="label_user">Bookmarks</div>
				<div class="stats_result"> 0</div>
			</div>
			<div style="clear:both"></div>
			<a class="continue" href="index.php">Continue Reading</a>
		</div>
	</div>
</body>
</html>

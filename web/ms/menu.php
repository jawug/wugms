	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo "<a class='navbar-brand' >" . $ShortName . "-" . $WShortSiteName . "</a>"; ?>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="/">Home</a></li>
					<?php include($_SERVER['DOCUMENT_ROOT'].'/public.php'); ?>
					<?php include($_SERVER['DOCUMENT_ROOT'].'/dashboard.php'); ?>
					<li><a href="/gettingstarted">Getting Started</a></li>
					<li><a href="/contact">Contact us</a></li>
					<li><a href="/about">About</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION["display_name"] ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/ms/user/profile">Profile</a></li>
							<li><a href="/ms/user/history">History</a></li>
						</ul>
					</li>
					<li><a href="/auth/logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>


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

					<li class="active"><a href="/gettingstarted">Getting Started</a></li>
					<li><a href="/contact">Contact us</a></li>
					<li><a href="/about">About</a></li>
				</ul>
				<?php include($_SERVER['DOCUMENT_ROOT'].'/user.php'); ?>		  
			</div>
		</div>
	</div>



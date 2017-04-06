<?php 
	$sn = "";
	if(isset($_GET['sn'])){ $sn = $_GET['sn']; }
	if ( $sn == NULL )
		{

		}
	/* If there is a serial number */
	else
		{
		$_SESSION['rb_sel']=sn;
		}
?>
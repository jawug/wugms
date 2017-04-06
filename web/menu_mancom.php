<?php
if (isset($_SESSION["username"])) {
	if ( isValueInRoleArray($_SESSION["roles"], "mancom")) { 
	echo "					<li class='dropdown' class='active'>";
	echo "						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>MANCOM<span class='caret'></span></a>";
	echo "						<ul class='dropdown-menu' role='menu'>";
	echo "							<li><a href='/ms/mancom/ua'>User accounts</a></li>";
	echo "							<li><a href='/ms/mancom/up'>Payments</a></li>";
	echo "						</ul>";
	echo "					</li>";
	} else {
	}
} 
?>
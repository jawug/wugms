<?php
if (!isset($_SESSION["username"])) {
    /* If there is no username then show the menu to login or register */
} else {
    echo "					<li class='dropdown' class='active'>";
    echo "						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Sites<span class='caret'></span></a>";
    echo "						<ul class='dropdown-menu' role='menu'>";
    echo "							<li><a href='/sites/map' target='_blank'>Live Map</a></li>";
    echo "							<li><a href='/sites/ssid'>SSID</a></li>";	
    echo "							<li><a href='/sites/kml'>Download KML</a></li>";
    echo "						</ul>";
    echo "					</li>";
}
?>
<?php
if (isset($_SESSION["username"])) {
    echo "					<li id='ms' class='dropdown'>";
    echo "						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Managed Services<span class='caret'></span></a>";
    echo "						<ul class='dropdown-menu' role='menu'>";
    echo "							<li id='usr_dash' ><a href='/ms/user/dashboard'>My Dashboards</a></li>";
    echo "							<li id='usr_rb_man' ><a href='/ms/user/rbman'>My RouterBoard management</a></li>";
    echo "							<li id='usr_scr_man' ><a href='/ms/user/scrman'>My Script management</a></li>";
    echo "							<li id='usr_sites' ><a href='/ms/user/sites'>My Sites</a></li>";
	echo "							<li class='divider'></li>";	
    echo "							<li id='gen_map' ><a href='/sites/map' target='_blank'>Live Map</a></li>";
    echo "							<li id='gen_ssid' ><a href='/sites/ssid'>SSID</a></li>";	
    echo "							<li id='gen_kml' ><a href='/sites/kml'>Download KML</a></li>";
	if ( isValueInRoleArray($_SESSION["roles"], "admin")) { 
	echo "							<li class='divider'></li>";
    echo "							<li id='adm_dash' ><a href='/ms/admin/dashboard'>Dashboards</a></li>";
    echo "							<li id='adm_rb_man' ><a href='/ms/admin/rbman'>RouterBoard Management</a></li>";
    echo "							<li id='adm_scr_man' ><a href='/ms/admin/scrman'>Script(s) deployment</a></li>";
    echo "							<li id='adm_sites' ><a href='/ms/admin/siteman'>Site Administration</a></li>";
	echo "							<li id='adm_users' ><a href='/ms/admin/usrman'>User Administration</a></li>";
	}
	if ( isValueInRoleArray($_SESSION["roles"], "beta")) { 
	echo "							<li class='divider'></li>";
    echo "							<li id='beta_dash' ><a href='/ms/beta/dashboard'>BETA My Dashboards</a></li>";
    echo "							<li id='beta_rb_man' ><a href='/ms/beta/rbman'>BETA My RouterBoard management</a></li>";
    echo "							<li id='beta_scr_man' ><a href='/ms/beta/scrman'>BETA Script management</a></li>";
    echo "							<li id='beta_sites' ><a href='/ms/beta/sites'>BETA Sites</a></li>";

	}	
	if ( isValueInRoleArray($_SESSION["roles"], "mancom")) { 
	echo "							<li class='divider'></li>";
	echo "							<li id='mancom' ><a href='/ms/mancom'>MANCOM</a></li>";
	}
	
    echo "						</ul>";
    echo "					</li>";
} 
?>
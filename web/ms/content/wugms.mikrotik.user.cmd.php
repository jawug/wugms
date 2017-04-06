<?php

/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/wugms.mikrotik.api.php');

if (!empty($_POST) && isset($_SESSION["id"])) {
    /* variables*/
    $iserror   = false;
    $errorcode = "";
    
    /* Set defaults */
    $rb_cmd      = "";
    $rb_host     = "";
    $rb_password = "";
    $rb_user     = "";
	$rb_remIP    = "";
	$rb_ud       = "no";
    
    /* Check that a host was supplied */
    if (empty($_POST['rb_host'])) {
        // Set the error flag as we do not want the process to run further
        $iserror   = true;
        // Set the error code
        $errorcode = "isBlankHost";
    } else {
		$rb_host = $_POST['rb_host'];
	}
    
    /* Check that a username was supplied */
    if (empty($_POST['rb_user']) && !$iserror) {
        // Set the error flag as we do not want the process to run further
        $iserror   = true;
        // Set the error code
        $errorcode = "isBlankUserName";
    } else {
		$rb_user = $_POST['rb_user'];	
	}

    /* Check that a host was supplied */
    if (empty($_POST['rb_password'])) {
        // Set the error flag as we do not want the process to run further
        //$iserror   = true;
        // Set the error code
        //$errorcode = "isBlankHost";
    } else {
		$rb_password = $_POST['rb_password'];
	}
    
    /* Check that a username was supplied */
    if (empty($_POST['rb_cmd']) && !$iserror) {
        // Set the error flag as we do not want the process to run further
        $iserror   = true;
        // Set the error code
        $errorcode = "isBlankCMD";
    } else {
		$rb_cmd = $_POST['rb_cmd'];
		if ((($rb_cmd == "rbcmd3") or ($rb_cmd == "rbcmd4")) && empty($_POST['rb_remadd'])) {
			$iserror   = true;
        // Set the error code
			$errorcode = "isBlankHostIP";
		} else {
			$rb_remIP    = $_POST['rb_remadd'];
		}
	}
	
	if (!empty($_POST['rb_ud'])) {
		if ($_POST['rb_ud']) {
			$rb_ud = "yes";	
		}
	
	}
	
    
    /* Seeing as there is no error then run the command */
    if ($iserror === false) {
		/* Init the API*/
        $API = new routeros_api();
        /* Set the debug flag */
        $API->debug = false;
        /* Try and connect */
/*		echo $rb_host;
		echo "<br>";
		echo $rb_user;
		echo "<br>";
		echo $rb_password;
		echo "<br>";
		echo $rb_cmd; */
		if ($API->connect($rb_host, $rb_user, $rb_password)) {
        
            if ($rb_cmd == "rbcmd1") {
                $ARRAY = $API->comm("/system/resource/print");
                $first   = $ARRAY['0'];
                $memperc = ($first['free-memory'] / $first['total-memory']);
                $hddperc = ($first['free-hdd-space'] / $first['total-hdd-space']);
                $mem     = ($memperc * 100);
                $hdd     = ($hddperc * 100);

				echo "<div class='panel panel-success'>";
				echo "	<div class='panel-heading'><h3 class='panel-title'>Result(s)</h3></div>";
                echo "<table class='table table-hover table-striped' width='100%'>";
                echo "<tr><th>Platform, board name and Ros version is:</th><td>" . $first['platform'] . " - " . $first['board-name'] . " - " . $first['version'] . " - " . $first['architecture-name'] . "</td></tr>";
                echo "<tr><th>Cpu and available cores:</th><td>" . $first['cpu'] . " at " . $first['cpu-frequency'] . " Mhz with " . $first['cpu-count'] . " core(s) " . "</td></tr>";
                echo "<tr><th>Uptime is:</th><td>" . $first['uptime'] . " (hh/mm/ss)" . "</td></tr>";
                echo "<tr><th>Cpu Load is:</th><td>" . $first['cpu-load'] . " %" . "</td></tr>";
                echo "<tr><th>Total, free memory and memory % is:</th><td>" . number_format($first['total-memory'], 0, ',', ' ') . "Kb - " . number_format($first['free-memory'], 0, ',', ' ') . "Kb - " . number_format($mem, 2) . "% </td></tr>";
                echo "<tr><th>Total, free disk and disk % is:</th><td>" . number_format($first['total-hdd-space'], 0, ',', ' ') . "Kb - " . number_format($first['free-hdd-space'], 0, ',', ' ') . "Kb - " . number_format($hdd, 2) . "% </td></tr>";
                echo "</table>";
                echo "</div>";
                
            } else if ($rb_cmd == "rbcmd2") {
				$API->comm("/system/reboot");
				echo "<div class='alert alert-success' role='alert'><b>Command sent!</b></div>";
			} else if ($rb_cmd == "rbcmd3") {
				$ARRAY = $API->comm("/ping", array(
					"address"     => $rb_remIP,
					"count" => "4"));
					
/*					if (array_key_exists('size', $ARRAY)) {
    echo "The 'first' element is in the array";
} */
				echo "<div class='panel panel-success'>";
				echo "	<div class='panel-heading'><h3 class='panel-title'>Result(s)</h3></div>";
				echo "<table class='table table-hover table-striped' width='100%'>";
				echo "<thead>";
				echo "		<tr>";
				echo "			<th>Seq</th>";
				echo "			<th>Host</th>";
				echo "			<th>Size</th>";
				echo "			<th>TTL</th>";
				echo "			<th>Time</th>";
				echo "			<th>Sent</th>";
				echo "			<th>Received</th>";
				echo "			<th>Packet Loss</th>";
				echo "			<th>min-rtt</th>";
				echo "			<th>avg-rtt</th>";
				echo "			<th>max-rtt</th>";
				echo "		</tr>";
				echo "</thead>";
				echo "<tbody>";
				$icount =0;
				foreach ($ARRAY as $item) {
					++$icount;
					echo "		<tr>";
					if (array_key_exists('size', $item)) {
						echo "			<td>" . $item['seq'] . "</td>";
						echo "			<td>" . $item['host'] . "</td>";
						echo "			<td>" . $item['size'] . "</td>";
						echo "			<td>" . $item['ttl'] . "</td>";
						echo "			<td>" . $item['time'] . "</td>";
						echo "			<td>" . $item['sent'] . "</td>";
						echo "			<td>" . $item['received'] . "</td>";
						echo "			<td>" . $item['packet-loss'] . "</td>";
						echo "			<td>" . $item['min-rtt'] . "</td>";
						echo "			<td>" . $item['avg-rtt'] . "</td>";
						echo "			<td>" . $item['max-rtt'] . "</td>";
					} else {
						echo "			<td colspan='11'>Timed out</td>";
					}
					echo "		</tr>";
				}
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
				
				/* } else {
					echo "<div class='panel panel-warning'>";
				    echo "<div class='panel-heading'><h4 class='text-center'>Unable to ping $var</h4></div>";
			        echo "</div>";
				/tool traceroute address=8.8.8.8 use-dns=no

				}*/
				//	print_r($ARRAY);
				//echo "This is meant to ping";
			} else if ($rb_cmd == "rbcmd4") {
				$ARRAY = $API->comm("/tool/traceroute", array(
					"address"     => $rb_remIP,
					"count"     => "1",
					"use-dns" => $rb_ud));
				/*	print_r($ARRAY);*/
				echo "<div class='panel panel-success'>";
				echo "	<div class='panel-heading'><h3 class='panel-title'>Result(s)</h3></div>";
				/*echo "		<div class='panel-body'>";*/
				
				echo "<table class='table table-hover table-striped' width='100%'>";
				echo "<thead>";
				echo "		<tr>";
				echo "			<th>address</th>";
				echo "			<th>loss</th>";
				echo "			<th>sent</th>";
				echo "			<th>last</th>";
				echo "			<th>avg</th>";
				echo "			<th>best</th>";
				echo "			<th>worst</th>";
				echo "			<th>std-dev</th>";
				echo "			<th>status</th>";
				echo "		</tr>";
				echo "</thead>";
				echo "<tbody>";
				$icount =0;
				foreach ($ARRAY as $item) {
					++$icount;
					echo "		<tr>";
					if (array_key_exists('avg', $item)) {
						echo "			<td>" . $item['address'] . "</td>";
						echo "			<td>" . $item['loss'] . "</td>";
						echo "			<td>" . $item['sent'] . "</td>";
						echo "			<td>" . $item['last'] . "</td>";
						echo "			<td>" . $item['avg'] . "</td>";
						echo "			<td>" . $item['best'] . "</td>";
						echo "			<td>" . $item['worst'] . "</td>";
						echo "			<td>" . $item['std-dev'] . "</td>";
						echo "			<td>" . $item['status'] . "</td>";
					} else {
						/*echo "			<td colspan='9'>Timed out</td>";*/
					}
					echo "		</tr>";
				}
				echo "</tbody>";
				echo "</table>";
				/*echo "	</div>";*/
				echo "</div>";
/*print_r($ARRAY);*/
				
			} else if ($rb_cmd == "rbcmd5") {
				$ARRAY = $API->comm("/log/print");
				//print_r($ARRAY);
				echo "<div class='panel panel-success'>";
				echo "	<div class='panel-heading'><h3 class='panel-title'>Result(s)</h3></div>";
				echo "<table class='table table-hover table-striped' width='100%'>";
				echo "<thead>";
				echo "		<tr>";
				echo "			<th>count</th>";
				echo "			<th>time</th>";
				echo "			<th>topics</th>";
				echo "			<th>message</th>";
				echo "		</tr>";
				echo "</thead>";
				echo "<tbody>";
				$icount =0;
				foreach ($ARRAY as $item) {
					++$icount;
					echo "		<tr>";
					if (array_key_exists('time', $item)) {
						echo "			<td>" . $icount . "</td>";
						echo "			<td>" . $item['time'] . "</td>";
						echo "			<td>" . $item['topics'] . "</td>";
						echo "			<td>" . $item['message'] . "</td>";
					} else {
						echo "			<td colspan='4'>Timed out</td>";
					}
					echo "		</tr>";
				}
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
			//	echo "This is meant to get the log entries";
			} else if ($rb_cmd == "rbcmd6") {
				$ARRAY = $API->comm("/ip/neighbor/print");
				/* Check the size of the returned array */
				if (sizeof($ARRAY) < 1) {
					/* Seeing as there is no results just tell the users that */
					echo "<div class='alert alert-warning' role='alert'>No results returned from command</div>";
				} else {
					/* Display the results */
					echo "<div class='panel panel-success'>";
					echo "	<div class='panel-heading'><h3 class='panel-title'>Result(s)</h3></div>";
					echo "<table class='table table-striped'>";
					echo "<thead>";
					echo "		<tr>";
					echo "			<th>On Interface</th>";
					echo "			<th>IP Address</th>";
					echo "			<th>Remote MAC</th>";
					echo "			<th>Identity</th>";
					echo "			<th>Platform</th>";
					echo "          <th>Model</th>";
					echo "			<th>Version</th>";
					echo "			<th>Remote Interface</th>";
					echo "		</tr>";
					echo "</thead>";
					echo "<tbody>";
					$icount =0;
					foreach ($ARRAY as $item) {
						++$icount;
						echo "		<tr>";
						if (array_key_exists('.id', $item)) {
							echo "			<td>" . $item['interface'] . "</td>";
							if (array_key_exists('address4', $item)) {
								echo "			<td>" . $item['address4'] . "</td>";   
							} else {
								echo "			<td>N/A</td>";
							}
							echo "			<td>" . $item['mac-address'] . "</td>";
							echo "			<td>" . $item['identity'] . "</td>";
							echo "			<td>" . $item['platform'] . "</td>";   
							if (array_key_exists('board', $item)) {
								echo "			<td>" . $item['board'] . "</td>";   
							} else {
								echo "			<td>N/A</td>";
							}
							echo "			<td>" . mb_strimwidth($item['version'],0,15) . "</td>";
							echo "			<td>" . $item['interface-name'] . "</td>";
						} 
						echo "		</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					echo "</div>";
				}
			} else if ($rb_cmd == "rbcmd7") {
				$ARRAY = $API->comm("/interface/wireless/registration-table/print");
				/* Check the size of the returned array */
					//print sizeof($ARRAY);
					//print "----";
					//print count($ARRAY);
					//print_r($ARRAY);
					//print json_encode($ARRAY, JSON_NUMERIC_CHECK);

				if (sizeof($ARRAY) < 1) {
					/* Seeing as there is no results just tell the users that */
					echo "<div class='alert alert-info' role='alert'>No results returned from command.</div>";
				} else {
					/* Display the results */
					if (array_key_exists('!trap', $ARRAY)) { 
						echo "<div class='alert alert-danger' role='alert'>Failed to return results. Reason: <b> " . $ARRAY['!trap'][0]['message'] . "</b></div>";
					} else {
						echo "<div class='panel panel-success'>";
						echo "	<div class='panel-heading'><h3 class='panel-title'>Result(s)</h3></div>";
						echo "<table class='table table-striped'>";
						echo "<thead>";
						echo "		<tr>";
						echo "			<th>On Interface</th>";
						echo "			<th>Is Local AP</th>";
						echo "			<th>Remote Radio Name</th>";
						echo "			<th>TX Rate</th>";
						echo "			<th>RX Rate</th>";
						echo "          <th>Uptime</th>";
						echo "			<th>Signal Strength</th>";
						echo "			<th>Signal to Noise</th>";
						echo "			<th>TX-CCQ</th>";
						echo "			<th>RX-CCQ</th>";
						echo "		</tr>";
						echo "</thead>";
						echo "<tbody>";
						$icount =0;
						foreach ($ARRAY as $item) {
							++$icount;
							echo "		<tr>";
							if (array_key_exists('.id', $item)) {
								echo "			<td>" . $item['interface'] . "</td>";
								if ($item['ap'] == "true") {
									echo "			<td><span style='color: rgb(153, 0, 0);'>No</span></td>";   
								} else {
									echo "			<td><span style='color: rgb(0, 153, 0);'>Yes</span></td>";
								}
								echo "			<td>" . $item['radio-name'] . "</td>";   
								echo "			<td>" . $item['tx-rate'] . "</td>";
								echo "			<td>" . $item['rx-rate'] . "</td>";   
								echo "			<td>" . $item['uptime'] . "</td>";   
								echo "			<td>" . $item['signal-strength'] . "</td>";
								echo "			<td>" . $item['signal-to-noise'] . "</td>";
								echo "			<td>" . $item['tx-ccq'] . "</td>";
								echo "			<td>" . $item['rx-ccq'] . "</td>";
							}
							echo "		</tr>";
						}
						echo "</tbody>";
						echo "</table>";
						echo "</div>";	
					}
				} /* else { 
						echo "<div class='alert alert-warning' role='alert'>No results returned from command</div>";}
					}*/
				}  else {
				/* No valid command was sent */
				echo "nothing!";
			}
			$API->disconnect();
        }
    } else {
		echo $errorcode;
	}
}
?>
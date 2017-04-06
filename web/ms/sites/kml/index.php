<?php
/* Include the validation checker */
include($_SERVER['DOCUMENT_ROOT'] . '/auth/validate.php');
include($_SERVER['DOCUMENT_ROOT'] . '/content/functions.php');

wugmsaudit("user", "KML", "file_download", $_SESSION["irc_nick"] . " (" . $_SESSION["id"] . ") Requested latest version of the KML file. ");

if (!isValueInRoleArray($_SESSION["roles"], "readonly")) {

header('Content-type: text/kml');
header('Content-Disposition: attachment; filename="jawug.kml"');
/* This is required for custom branding */
require($_SERVER['DOCUMENT_ROOT'] . '/content/branding.php');
require($_SERVER['DOCUMENT_ROOT'] . '/kml/kml_header.php');

/* MAP Query */
/* "ACTIVE" */

$wugms_map_all_sites_row  = '';
$wugms_map_user_sites_row = '';
$wugms_map_2ghz_link_row  = '';
$wugms_map_5ghz_link_row  = '';
$wugms_map_bgp_link_row   = '';

$outp = '';

$wugms_map_all_sites_query = "
SELECT x.ae_siteID,
       m.identity,
       m.File_Date,
       m.equipment_owner,
       m.stats,
       o.sitename,
       o.longitude,
       o.latitude,
       o.height,
       o.site_owner,
       o.site_owner_id
  FROM tbl_ae_sites_rbs x,
       (SELECT b.siteID,
               b.Name 'sitename',
               b.longitude,
               b.latitude,
               b.height,
               a.irc_nick 'site_owner',
               b.idSite_Owner 'site_owner_id'
          FROM tbl_base_sites b, tbl_base_user a
         WHERE b.idSite_Owner = a.idtbl_base_user) AS o,
       (SELECT c.RB_identity 'identity',
               c.Serial_Number,
               c.File_Date,
               a.irc_nick 'equipment_owner',
               if(
                  c.File_Date > DATE_SUB(now(), INTERVAL 168 HOUR),
                  'active',
                  if(c.File_Date < DATE_SUB(now(), INTERVAL 336 HOUR),
                     'lost',
                     'down'))
                  'stats',
               c.siteID
          FROM tbl_base_rb_routerboard c, tbl_base_user a
         WHERE c.idSite_Owner = a.idtbl_base_user) AS m
 WHERE     x.ae_siteID = o.siteID
       AND x.ae_Serial_Number = m.Serial_Number
       AND o.site_owner_id <> :user_id
GROUP BY x.ae_siteID
ORDER BY m.File_Date";

$wugms_map_all_sites_params = array(
    ':user_id' => $_SESSION['id']
);
$wugms_map_all_sites_stmt   = $db->prepare($wugms_map_all_sites_query);
if ($wugms_map_all_sites_stmt->execute($wugms_map_all_sites_params)) {
    $wugms_map_all_sites_row = $wugms_map_all_sites_stmt->fetchAll();
}

/* User's sites */
$wugms_map_user_sites_query = "
SELECT f.siteID,
       f.sitename,
       f.longitude,
       f.latitude,
       f.height,
       f.site_owner,
       f.site_owner_id,
       f.identity,
       f.Serial_Number,
       ifnull(f.File_Date, 'N/A') 'File_Date',
       f.equipment_owner,
       ifnull(f.stats, 'planning') 'stats'
  FROM (SELECT o.siteID,
               o.sitename,
               o.longitude,
               o.latitude,
               o.height,
               o.site_owner,
               o.site_owner_id,
               e.identity,
               e.Serial_Number,
               e.File_Date,
               e.equipment_owner,
               e.stats
          /*       e.siteID*/
          FROM (SELECT b.siteID,
                       b.Name 'sitename',
                       b.longitude,
                       b.latitude,
                       b.height,
                       a.irc_nick 'site_owner',
                       b.idSite_Owner 'site_owner_id'
                  FROM tbl_base_sites b, tbl_base_user a
                 WHERE     b.idSite_Owner = a.idtbl_base_user
                       AND b.idSite_Owner = :user_id) AS o
               LEFT JOIN
               (SELECT c.RB_identity 'identity',
                       c.Serial_Number,
                       c.File_Date,
                       a.irc_nick 'equipment_owner',
                       if(
                          c.File_Date > DATE_SUB(now(), INTERVAL 168 HOUR),
                          'active',
                          if(
                             c.File_Date < DATE_SUB(now(), INTERVAL 336 HOUR),
                             'lost',
                             'down'))
                          'stats',
                       c.siteID
                  FROM tbl_base_rb_routerboard c, tbl_base_user a
                 WHERE c.idSite_Owner = a.idtbl_base_user
                ORDER BY c.File_Date) AS e
                  ON o.siteID = e.siteID
        GROUP BY o.siteID) AS f;";

$wugms_map_user_sites_params = array(
    ':user_id' => $_SESSION['id']
);
$wugms_map_user_sites_stmt   = $db->prepare($wugms_map_user_sites_query);
if ($wugms_map_user_sites_stmt->execute($wugms_map_user_sites_params)) {
    $wugms_map_user_sites_row = $wugms_map_user_sites_stmt->fetchAll();
}


/* "LINKS 2.4" */
$map_2ghz_link_query = "SELECT a.client_sn,
       a.client_freq,
       a.client_rn,
       a.client_ssid,
       a.client_lat,
       a.client_long,
       a.client_id,
       a.hs_sn,
       a.hs_freq,
       a.hs_rn,
       a.hs_ssid,
       a.hs_lat,
       a.hs_long,
       a.hs_id
  FROM view_wifi_links a
  WHERE a.hs_freq <5000  
ORDER BY a.hs_ssid;";
$map_2ghz_link_stmt  = $db->prepare($map_2ghz_link_query);
if ($map_2ghz_link_stmt->execute()) {
    $wugms_map_2ghz_link_row = $map_2ghz_link_stmt->fetchAll();
}

/* "LINKS 5" */
$map_5ghz_link_query = "SELECT a.client_sn,
       a.client_freq,
       a.client_rn,
       a.client_ssid,
       a.client_lat,
       a.client_long,
       a.client_id,
       a.hs_sn,
       a.hs_freq,
       a.hs_rn,
       a.hs_ssid,
       a.hs_lat,
       a.hs_long,
       a.hs_id
  FROM view_wifi_links a
  WHERE a.hs_freq >5000
ORDER BY a.hs_ssid;";
$map_5ghz_link_stmt  = $db->prepare($map_5ghz_link_query);
if ($map_5ghz_link_stmt->execute()) {
    $wugms_map_5ghz_link_row = $map_5ghz_link_stmt->fetchAll();
}

/* "LINKS BGP" */
$map_bgp_link_query = "
SELECT oas.start_sn,
       oas.org_as,
       oas.org_identity,
       oas.org_lat,
       oas.org_long,
       oas.org_height,
       oas.org_sitename,
       tas.org_sn,
       tas.rem_as,
       tas.rem_identity,
       tas.rem_sitename,
       tas.rem_lat,
       tas.rem_long,
       tas.rem_height
  FROM (SELECT a.Serial_Number 'start_sn',
               a.as_value 'org_as',
               r.RB_identity 'org_identity',
               r.latitude 'org_lat',
               r.longitude 'org_long',
               r.height 'org_height',
               r.SiteName 'org_sitename'
          FROM tbl_base_rb_routing_bgp_instance_config a,
               tbl_base_rb_ipv4_config b,
               tbl_base_rb_routerboard r
         WHERE     upper(b.interface_name) = 'LO0'
               AND b.disabled = 0
               AND a.Serial_Number = b.Serial_Number
               AND a.Serial_Number = r.Serial_Number) AS oas,
       (SELECT a.Serial_Number 'org_sn',
               a.remote_as 'rem_as',
               x.RB_identity 'rem_identity',
               x.SiteName 'rem_sitename',
               x.latitude 'rem_lat',
               x.longitude 'rem_long',
               x.height 'rem_height'
          FROM tbl_base_rb_routing_bgp_peer_config a,
               (SELECT b.Serial_Number 'remote_sn',
                       b.as_value,
                       c.RB_identity,
                       c.latitude,
                       c.longitude,
                       c.height,
                       c.SiteName
                  FROM tbl_base_rb_routing_bgp_instance_config b,
                       tbl_base_rb_routerboard c
                 WHERE b.Serial_Number = c.Serial_Number) AS x
         WHERE a.remote_as = x.as_value
        GROUP BY a.Serial_Number) AS tas
 WHERE oas.start_sn = tas.org_sn
ORDER BY oas.org_as;";
$map_bgp_link_stmt  = $db->prepare($map_bgp_link_query);
if ($map_bgp_link_stmt->execute()) {
    $wugms_map_bgp_link_row = $map_bgp_link_stmt->fetchAll();
}


/* Display the logged in user's sites, regardless of their status */
echo "<Folder>";
echo "<name>My sites</name>";
echo "<description>These sites are the ones that are allocated to the logged in user.</description>";
echo "<open>0</open>";
if ($wugms_map_user_sites_row) {
    foreach ($wugms_map_user_sites_row as $x) {
        echo "<Placemark>";
        echo "<name>" . $x['sitename'] . "</name>";
        echo "<description>Location owner: &lt;b&gt;" . $x['site_owner'] . "&lt;/b&gt;&lt;br&gt; Last seen (RBCP): &lt;b&gt;" . $x['File_Date'] . "&lt;/b&gt;&lt;br&gt;  Status: &lt;b&gt;" . $x['stats'] . "&lt;/b&gt;&lt;br&gt; </description>";
        if ($x['stats'] === 'active') {
            echo "<styleUrl>msn_grn-blank</styleUrl>";
        } elseif ($x['stats'] === 'down') {
            echo "<styleUrl>msn_orange-blank</styleUrl>";
        } elseif ($x['stats'] === 'lost') {
            echo "<styleUrl>msn_red-blank</styleUrl>";
        } elseif ($x['stats'] === 'planning') {
            echo "<styleUrl>msn_purple-blank</styleUrl>";
        }
        echo "<Point> <coordinates>" . $x['longitude'] . "," . $x['latitude'] . "," . $x['height'] . "</coordinates> </Point>";
        echo "</Placemark>";
    }
}
echo "</Folder>";


/* Start of sites data */
echo "<Folder>";
echo "<name>Sites</name>";
echo "<open>0</open>";

/* Display the active sites */
echo "<Folder>
		<name>Active</name>
		<description>Site(s) that have been seen with in the last 7 days</description>
		<open>0</open>";
if ($wugms_map_all_sites_row) {
    foreach ($wugms_map_all_sites_row as $x) {
        if ($x['stats'] === 'active') {
            echo "<Placemark>";
            echo "<name>" . $x['sitename'] . "</name>";
            echo "<description>Location owner: &lt;b&gt;" . $x['site_owner'] . "&lt;/b&gt;&lt;br&gt; Last seen (RBCP): &lt;b&gt;" . $x['File_Date'] . "&lt;/b&gt;&lt;br&gt; </description>";
            echo "<styleUrl>msn_grn-blank</styleUrl>";
            echo "<Point> <coordinates>" . $x['longitude'] . "," . $x['latitude'] . "," . $x['height'] . "</coordinates> </Point>";
            echo "</Placemark>";
        }
    }
}
echo "</Folder>";

/* Display the down sites */
echo "<Folder>
		<name>Down</name>
		<description>Site(s) that have been seen between 7 and 14 days</description>
		<open>0</open>";
if ($wugms_map_all_sites_row) {
    foreach ($wugms_map_all_sites_row as $x) {
        if ($x['stats'] === 'down') {
            echo "<Placemark>";
            echo "<name>" . $x['sitename'] . "</name>";
            echo "<description>Location owner: &lt;b&gt;" . $x['site_owner'] . "&lt;/b&gt;&lt;br&gt; Last seen (RBCP): &lt;b&gt;" . $x['File_Date'] . "&lt;/b&gt;&lt;br&gt;</description>";
            echo "<styleUrl>msn_orange-blank</styleUrl>";
            echo "<Point> <coordinates>" . $x['longitude'] . "," . $x['latitude'] . "," . $x['height'] . "</coordinates> </Point>";
            echo "</Placemark>";
        }
    }
}
echo "</Folder>";

/* Display the lost sites */
echo "<Folder>
		<name>Lost</name>
		<description>Site(s) that have been not been seen in over 14 days</description>
		<open>0</open>";
if ($wugms_map_all_sites_row) {
    foreach ($wugms_map_all_sites_row as $x) {
        if ($x['stats'] === 'lost') {
            echo "<Placemark>";
            echo "<name>" . $x['sitename'] . "</name>";
            echo "<description>Location owner: &lt;b&gt;" . $x['site_owner'] . "&lt;/b&gt;&lt;br&gt; Last seen (RBCP): &lt;b&gt;" . $x['File_Date'] . "&lt;/b&gt;&lt;br&gt;</description>";
            echo "<styleUrl>msn_red-blank</styleUrl>";
            echo "<Point> <coordinates>" . $x['longitude'] . "," . $x['latitude'] . "," . $x['height'] . "</coordinates> </Point>";
            echo "</Placemark>";
        }
    }
}
echo "</Folder>";
echo "</Folder>";
/* End of sites data */

/* Start of links data */
echo "<Folder>";
echo "<name>Links</name>";
echo "<open>0</open>";


/* Display the 2.4 LINKS */

echo "<Folder>
		<name>2.4GHz</name>
		<description>Links using the 2.4GHz spectrum</description>
		<open>0</open>";
if ($wugms_map_2ghz_link_row) {
    foreach ($wugms_map_2ghz_link_row as $x) {
        echo "<Placemark>";
        echo "<name>From: " . $x['hs_id'] . " to: " . $x['client_id'] . "</name>";
        echo "<description>SSID: &lt;b&gt;" . $x['hs_ssid'] . "&lt;/b&gt;&lt;br&gt; Frequency: &lt;b&gt;" . $x['hs_freq'] . "&lt;/b&gt;</description>";
        echo "<LineString>";
        echo "<coordinates>\n";
        echo "		" . $x['hs_long'] . "," . $x['hs_lat'] . ",0 " . $x['client_long'] . "," . $x['client_lat'] . ",0 ";
        echo "\n";
        echo "</coordinates>";
        echo "</LineString>";
        echo "<Style><LineStyle>";
        echo "<color>#FFFF0000</color>";
        echo "</LineStyle></Style>";
        echo "</Placemark>";
    }
}
echo "</Folder>";


/* Display the 5 LINKS */

echo "<Folder>
		<name>5GHz</name>
		<description>Links using the 5GHz spectrum</description>
		<open>0</open>";
if ($wugms_map_5ghz_link_row) {
    foreach ($wugms_map_5ghz_link_row as $x) {
        echo "<Placemark>";
        echo "<name>From: " . $x['hs_id'] . " to: " . $x['client_id'] . "</name>";
        echo "<description>SSID: &lt;b&gt;" . $x['hs_ssid'] . "&lt;/b&gt;&lt;br&gt; Frequency: &lt;b&gt;" . $x['hs_freq'] . "&lt;/b&gt;</description>";
        echo "<LineString>";
        echo "<coordinates>\n";
        echo "		" . $x['hs_long'] . "," . $x['hs_lat'] . ",0 " . $x['client_long'] . "," . $x['client_lat'] . ",0 ";
        echo "\n";
        echo "</coordinates>";
        echo "</LineString>";
        echo "<Style><LineStyle>";
        echo "<color>#FFFFFFFF</color>";
        echo "</LineStyle></Style>";
        echo "</Placemark>";
    }
}
echo "</Folder>";

/* Display the BGP LINKS */

echo "<Folder>
		<name>BGP</name>
		<description>BGP Links</description>
		<open>0</open>";
    if ($wugms_map_bgp_link_row) {
		foreach ($wugms_map_bgp_link_row as $x) {
			echo "<Placemark>";
			echo "<name>From: " . $x['org_sitename'] . "(" . $x['org_as'] .") to: " . $x['rem_sitename'] . "(" . $x['rem_as'] .")</name>";
/*			echo "<description>BGP &lt;b&gt;" . $x['org_sitename'] . "(" . $x['org_as'] .")&lt;/b&gt;&lt;br&gt; Frequency: &lt;b&gt;" . $x['rem_sitename'] . "(" . $x['rem_as'] .")&lt;/b&gt;</description>"; */
			echo "<LineString>";
			echo "<coordinates>\n";
			echo "		" . $x['org_long'] . "," . $x['org_lat'] . ",0 " . $x['rem_long'] . "," . $x['rem_lat'] . ",0 ";
			echo "\n";
			echo "</coordinates>";
			echo "</LineString>";
			echo "<Style><LineStyle>";
			echo "<color>#FF000000</color>";
			echo "</LineStyle></Style>";
			echo "</Placemark>";
		}
	}
echo "</Folder>";


echo "</Folder>";

/* End of links data */

/*	require($_SERVER['DOCUMENT_ROOT'] . '/kml/kml_footer.php');	*/
/*echo "</Folder>"; */
echo "</Document>";
echo "</kml>";
}
?>
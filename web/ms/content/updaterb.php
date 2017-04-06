<?php
/* No validation will be done because this is a public page */
session_start();
if (!empty($_POST)) {
	if (isset($_SESSION["username"])) {
		if (!empty($_POST['dev_id'])) {
			$_SESSION["rb_sn"] = $_POST['dev_id'];
		}
		if (!empty($_POST['dev_des'])) {
			$_SESSION["rb_des"] = $_POST['dev_des'];
		}
		if (!empty($_POST['sdev_id'])) {
			$_SESSION["rb_sns"] = $_POST['sdev_id'];
		}
		if (!empty($_POST['stor_id'])) {
			$_SESSION["rb_store"] = $_POST['stor_id'];
		}		
		if (!empty($_POST['sdev_des'])) {
			$_SESSION["rb_stordes"] = $_POST['sdev_des'];
		}
		
		if (!empty($_POST['idev_id'])) {
			$_SESSION["rb_sni"] = $_POST['idev_id'];
		}
		if (!empty($_POST['iface_id'])) {
			$_SESSION["rb_iface"] = $_POST['iface_id'];
		}		
		if (!empty($_POST['idev_des'])) {
			$_SESSION["rb_ifacedes"] = $_POST['idev_des'];
		}

		if (!empty($_POST['ssid_dev'])) {
			$_SESSION["rb_sn_ssid"] = $_POST['ssid_dev'];
		}
		if (!empty($_POST['ssid_id'])) {
			$_SESSION["rb_ssid_id"] = $_POST['ssid_id'];
		}		
		if (!empty($_POST['ssid_des'])) {
			$_SESSION["rb_ssid_des"] = $_POST['ssid_des'];
		}
		
		if (!empty($_POST['ov_ssid_id'])) {
			$_SESSION["ov_ssid_id"] = $_POST['ov_ssid_id'];
		}
		if (!empty($_POST['ov_ssid_name'])) {
			$_SESSION["ov_ssid_name"] = $_POST['ov_ssid_name'];
		}		
		if (!empty($_POST['ov_ssid_sn'])) {
			$_SESSION["ov_ssid_sn"] = $_POST['ov_ssid_sn'];
		}		
		
    }
}  
?> 		
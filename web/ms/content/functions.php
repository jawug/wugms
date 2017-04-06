<?php

// Insert the path where you unpacked log4php
require_once('log4php/Logger.php');
//echo __DIR__;
//require_once('/path/to/log4php/Logger.php');
Logger::configure(__DIR__ . '/wugms.log4php.config.xml');
$logger = Logger::getLogger(basename(__FILE__));
//$logger->info('Testing');
// Tell log4php to use our configuration file.
//Logger::configure('config.xml');
// Fetch a logger, it will inherit settings from the root logger
$log = Logger::getLogger('wugms_log');

/* Function for the user's IP address */
function getClientIP()
{
    if (isset($_SERVER)) {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];
        return $_SERVER["REMOTE_ADDR"];
    }
    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');
    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');
    return getenv('REMOTE_ADDR');
}

/* function to be used to log certain events */
function wugmsaudit($level, $action, $area, $msg)
{
    require($_SERVER['DOCUMENT_ROOT'] . '/auth/config.php');
    /* temp var used to hold the user name */
    $currentuser = "";
    if (!isset($_SESSION["username"])) {
        /* If there is no username then use generic username */
        $currentuser = "no_user_logged_in";
    } else {
        /* Use the logged in user's name */
        $currentuser = $_SESSION["username"];
    }
    /* temp var used to hold the user's ID */
    $currentuser_id = "";
    if (!isset($_SESSION["id"])) {
        /* If there is no username then use generic username */
        $currentuser_id = "no_user_logged_in2";
    } else {
        /* Use the logged in user's name */
        $currentuser_id = $_SESSION["id"];
    }
    /* The basic insert query */
    $squery        = "
	INSERT INTO tbl_base_user_audit(username,
									username_id,
									session_id,
									user_ip,
									level,
									area,
									action,
									msg,
									browser_agent,
									sid)
	VALUES (:username,
			:username_id,
			:session_id,
			:userip,
			:level,
			:area,
			:action,
			:msg,
			:browser_agent,
			:sid);";
    /* Add SID to msg*/
    /* Parameters to be used */
    $squery_params = array(
        ':username' => $currentuser,
        ':username_id' => $currentuser_id,
        ':session_id' => session_id(),
        ':browser_agent' => $_SERVER['HTTP_USER_AGENT'],
        ':userip' => getClientIP(),
        ':level' => $level,
        ':area' => $area,
        ':action' => $action,
        ':msg' => $msg,
        ':sid' => microtime(true)
    );
    /* Try to add a record */
    try {
        $sstmt   = $db->prepare($squery);
        $sresult = $sstmt->execute($squery_params);
    }
    /* If something bad happens */
    catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
}

function isValueInRoleArray($Array_tmp, $svalue)
{
    $aresult = false;
    foreach ($Array_tmp as $item) {
        if (strval($item['roll_id']) == $svalue) {
            $aresult = true;
            break;
        }
    }
    /* Return a boolean is indicate the result */
    return $aresult;
}

function StartEndDateCompare($sdate, $edate, $interval) /* Values can be either a proper datetime or "0" which means that "default" is to be used */ /* Start date default is x */ /* End date default is "now" */ 
{
    $nowdatetime = date('Y-m-d H:i:s');
    $end_date    = date('Y-m-d H:i:s');
    //$returnedDT = returnedDT();
    
    /* Create defaults based on the selected interval */
    if ($interval === "5min") {
        /* Defaults for start date based on 5min interval is 12 hours */
        $start_date = date("Y-m-d H:m:s", strtotime('-12 hours', time()));
    } else if ($interval === "60min") {
        /* Defaults for start date based on 5min interval is 12 days */
        $start_date = date("Y-m-d H:m:s", strtotime('-12 days', time()));
    } else if ($interval === "day") {
        /* Defaults for start date based on 5min interval is 12 weeks */
        $start_date = date("Y-m-d H:m:s", strtotime('-12 weeks', time()));
    } else {
        /* We'll have a default setting because I've got no idea wtf happens in the future */
        $start_date = date("Y-m-d H:m:s", strtotime('-12 hours', time()));
    }
    
    
    /* work the start date */
    if ($sdate === 0) {
        /* I use the inverse of the check */
        $start_date_chk = $start_date;
        /* The default start date is already set */
    } else {
        $start_date_chk = $sdate;
    }
    
    /* work the end date */
    if ($edate === 0) {
        $end_date_chk = $end_date;
    } else {
        $end_date_chk = $edate;
    }
    
    /* first convert the values into "time" so that it is easier to compare */
    $endtime_value   = strtotime($end_date_chk);
    $starttime_value = strtotime($start_date_chk);
    
    
    /* Compare the times */
    if ($endtime_value > $starttime_value) {
        /* If the sdate value is older than the edate which is good */
        /* Assign the values to the array*/
        
        $returnedDT['start'] = $start_date_chk;
        $returnedDT['end']   = $end_date_chk;
    } else {
        /* Seeing as the date time for start is newer than end or something like that. We'll use defaults */
        $returnedDT['start'] = $start_date;
        $returnedDT['end']   = $end_date;
    }
    return $returnedDT;
}
/* End of function */

/* Basic vars */
$api_status_code    = "";
$api_status_msg     = "";
$api_data           = "";
$api_response_code  = array(
    0 => array(
        'HTTP Response' => 400,
        'Message' => 'Unknown Error'
    ),
    1 => array(
        'HTTP Response' => 200,
        'Message' => 'Success'
    ),
    2 => array(
        'HTTP Response' => 403,
        'Message' => 'HTTPS Required'
    ),
    3 => array(
        'HTTP Response' => 401,
        'Message' => 'Authentication Required'
    ),
    4 => array(
        'HTTP Response' => 401,
        'Message' => 'Authentication Failed'
    ),
    5 => array(
        'HTTP Response' => 404,
        'Message' => 'Invalid Request'
    ),
    6 => array(
        'HTTP Response' => 400,
        'Message' => 'Invalid Response Format'
    ),
    7 => array(
        'HTTP Response' => 400,
        'Message' => 'Invalid Request'
    ),
    8 => array(
        'HTTP Response' => 204,
        'Message' => 'No Content'
    ),
    9 => array(
        'HTTP Response' => 405,
        'Message' => 'Method Not Allowed'
    )
);
$http_response_code = array(
    200 => 'OK',
    204 => 'No Content',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed'
);
$response           = "";

class IPAMException extends Exception
{
}

class IPAMClient
{
    
    private $host;
    private $app;
    private $user;
    private $pass;
    private $token;
    private $expires;
    
    // IPAM client object
    // $host - ipam host
    // $app - application name as defined in API keys
    // $user - existing IPAM user
    // $pass - password for $user
    //
    public function __construct($host, $app, $user, $pass)
    {
        $this->host = $host;
        $this->app  = $app;
        $this->user = $user;
        $this->pass = $pass;
        
        $this->login();
    }
    
    // log in to API server
    //
    private function login()
    {
        $c    = curl_init("http://" . $this->host . "/api/$this->app/user/");
        $auth = urlencode($this->user) . ":" . urlencode($this->pass);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_USERPWD, $auth);
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, "POST");
        $content = curl_exec($c);
        
        $r = json_decode($content);
        
        if (!$r || $r->code != 200 || $r->success != true) {
            throw new IPAMException("IPAM Login: " . $content);
        }
        $this->token   = $r->data->token;
        $this->expires = $r->data->expires;
    }
    
    // make sure we are still logged in
    //
    private function check_auth()
    {
        if (!isset($this->token) || strtotime($this->expires) <= time()) {
            login();
        }
    }
    
    // Perform API request
    //
    private function request($path, $method = "GET", $data = null)
    {
        $this->check_auth();
        $headers = array(
            "PHPIPAM_TOKEN: $this->token",
            "Content-type: application/x-www-form-urlencoded"
        );
        $url     = "http://" . $this->host . "/api/" . $this->app . "/" . $path;
        if (substr($url, -1) != '/') {
            $url .= "/";
        }
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, $method);
        if ($data != null) {
            if (is_array($data)) {
                $d = "";
                foreach ($data as $k => $v) {
                    if (isset($v)) {
                        $d .= "&$k=" . urlencode($v);
                    }
                }
                $data = $d;
            }
            //print_r($data);
            curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        }
        $content = curl_exec($c);
        
        $r = json_decode($content);
        
        if ($r) {
            if ($r->success == true) {
                return $r->data;
            }
            if ($r->code == 404) {
                return array();
            }
        }
        throw new IPAMException("IPAM: $content");
    }
    
    // convert IP address in "aa.bb.cc.dd" notation to a 32-bit int
    //
    private function ip2int($ip)
    {
        $matches = array();
        if (preg_match('/^(\d*)\.(\d*)\.(\d*).(\d*)/', $ip, $matches)) {
            $n = 0;
            for ($i = 1; $i <= 4; ++$i) {
                $n = $n << 8 | (int) $matches[$i];
            }
        }
        return $n;
    }
    
    // convert masklen to mask
    //
    private function mask($len)
    {
        return (0xffffffff << (32 - $len)) & 0xffffffff;
    }
    
    // check if IP is in a particular subnet
    // $net - object as retrieve by getsubnet()
    // $ip - IP in "aa.bb.cc.dd" notation
    // returns: true/false
    //
    private function contains($net, $ip)
    {
        $netip = $this->ip2int($net->subnet);
        $mask  = $this->mask($net->mask);
        $ip    = $this->ip2int($ip);
        return (($ip & $mask) == $netip);
    }
    
    // find the smallest subnet that contains a particular IP
    // $ip - IP in "aa.bb.cc.dd" notation
    // $subnetid - int, or null to start looking
    // returns: subnet object
    //
    private function smallestcontaining($ip, $subnetid = null)
    {
        if (!$subnetid) {
            // gotta start somewhere
            // and I am too lazy to hunt it down from sections. Later....
            $wug = $this->getcidr("172.16.0.0/16");
            if (!$wug) {
                throw new IPAMException("IPAM: Cannot find WUG. Does it still exist?");
            }
            $subnetid = $wug[0]->id;
        }
        $net = $this->getsubnet($subnetid);
        if (!$this->contains($net, $ip)) {
            throw new IPAMException("IPAM: WTF, got to " . $net->subnet . "/" . $net->mask . " trying to find subnet for $ip");
        }
        
        foreach ($this->getslaves($net->id) as $i) {
            if ($this->contains($i, $ip)) {
                return $this->smallestcontaining($ip, $i->id);
            }
        }
        return $net;
    }
    
    // look for, and trieve info on, one subnet
    // $subet - subnet in "aa.bb.cc.dd/22" notation
    // returns: array of subnet object, or empty array if not found
    //
    public function getcidr($subnet)
    {
        return $this->request("subnets/cidr/$subnet");
    }
    
    // retrieve info on one subnet
    // $subnetid - subnet ID
    // returns: subnet object
    //
    public function getsubnet($subnetid)
    {
        return $this->request("subnets/$subnetid");
    }
    
    // retrieve all subnets below some subnet
    // $subnetid - int id
    // return: array of subnet object
    //
    public function getslaves($subnetid)
    {
        return $this->request("subnets/$subnetid/slaves");
    }
    
    // retrieve all addresses in a subnet
    // $subnet - int id
    // returns: array of address object
    //
    public function getaddresses($subnetid)
    {
        return $this->request("subnets/$subnetid/addresses");
    }
    
    // retrieve information on an address
    // $ip - address in "aa.bb.cc.dd" notation
    // returns: array of address object
    //
    public function getaddress($ip)
    {
        return $this->request("addresses/search/$ip");
    }
    
    // add or update and address and set hostname
    // $ip - address in "aa.bb.cc.dd" notation
    // $hostname - string to set hostname to
    // returns: nothing
    //
    public function setaddress($ip, $hostname)
    {
        // see if we have this one already
        $curr = $this->getaddress($ip);
        if (isset($curr[0])) {
            $curr = $curr[0];
            unset($curr->editDate);
            unset($curr->links);
            $curr->hostname = $hostname;
            
            if (isset($IDEAL_WORLD)) {
                $this->request("addresses/" . $curr->id, "PATCH", (array) $curr);
            } else {
                $this->request("addresses/" . $curr->id, "DELETE");
                $this->request("addresses/", "POST", (array) $curr);
            }
        } else {
            // stupid API wants the network ID, so we have to track that down
            $net = $this->smallestcontaining($ip);
            $d   = array(
                "subnetId" => $net->id,
                "ip" => $ip,
                "hostname" => $hostname
            );
            return $this->request("addresses/", "POST", $d);
        }
    }
    
    // Remove address and DNS records
    // $ip - IP address in "aa.bb.cc.dd" notation
    // returns: nothing
    //
    public function deleteaddress($ip)
    {
        $addr = $this->getaddress($ip);
        if (isset($addr[0]->id)) {
            $this->request("addresses/" . $addr[0]->id, "DELETE");
        }
    }

 		// Get device(s)
    // $deviceid - id of the device record, or null for all records
    // returns: array of device object
    //
    public function getdevice($deviceid=null)
    {
        return $this->request("tools/devices/$deviceid");
    }

    // Add a device
    // $device - device object
    // returns: nothing
    //
    public function adddevice($device)
    {
        return $this->request("tools/devices/", "POST", (array)$device);
    }

    // Get device type(s)
    // $typeid - id of device type, or null for all
    // returns: array of device type
    //
    public function getdevicetype($typeid=null)
    {
        return $this->request("tools/devicetypes/$typeid");
    }
}

?>

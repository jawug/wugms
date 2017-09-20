<?php

class auditHandover
{

    /**
     *
     * @var \entityConfiguration 
     */
    private $configuration;

    /**
     *
     * @var array 
     */
    private $post_params;

    /**
     * We package the information as we need it and then send it off to the fire and forget solution
     * 
     * @param \$_SERVER $CServerArray
     * @param \$_SESSION $CSession
     * @param \voStatus $PageActions
     * @param string $sessionID
     * @param array $PageInfo
     */
    function page_metric($CServerArray, $CSession, $PageActions, $sessionID, $PageInfo)
    {
        if (array_key_exists('username', $CSession)) {
            $this->post_params["username"] = $CSession["username"];
        } else {
            $this->post_params["username"] = "no_user";
        }
        if (array_key_exists('id', $CSession)) {
            $this->post_params["user_id"] = $CSession["id"];
        } else {
            $this->post_params["user_id"] = 0;
        }
        $this->post_params["session_id"] = $sessionID;
        $this->post_params["user_ip"] = $CServerArray["REMOTE_ADDR"];
        $this->post_params["section"] = $PageInfo["section"];
        $this->post_params["area"] = $PageInfo["area"];
        $this->post_params["level"] = $PageInfo["level"];
        $this->post_params["type"] = $PageInfo["type"];
        $this->post_params["action"] = $PageInfo["action"];
        $this->post_params["page"] = $PageInfo["pagename"];
        $this->post_params["status"] = ($PageActions->Status) ? "ok" : "error";
        $this->post_params["msg"] = $PageActions->StatusCode;
        $this->post_params["browser_agent"] = $CServerArray['HTTP_USER_AGENT'];
        $this->post_params["extended_status"] = $PageActions->ExtendedStatusCode;
        $this->post_params["line"] = $PageActions->Line;
        $this->page_metric_post();
    }

    /**
     * Function for fire and forget items to the auditing sub system
     */
    private function page_metric_post()
    {
        foreach ($this->post_params as $key => &$val) {
            $post_params[] = $key . '=' . urlencode($val);
        }
        $url_host = $this->getAuditHost();
        $url_path = '/audit/audit_page.php';
        $url_port = $this->getAuditPort();
        $post_string = implode('&', $post_params);
        $output = "POST " . $url_path . " HTTP/1.1\r\n";
        $output .= "Host: " . $url_host . "\r\n";
        $output .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $output .= "Content-Length: " . strlen($post_string) . "\r\n";
        $output .= "Connection: Close\r\n\r\n";
        $output .= isset($post_string) ? $post_string : '';
        $fp = @fsockopen($url_host, $url_port, $errno, $errstr, 0.01);
        //$fp = fsockopen($url_host, $url_port, $errno, $errstr, 0.01);
        fwrite($fp, $output);
        fclose($fp);
    }

    /**
     * 
     * @param string $host
     */
    private function setAuditHost($host)
    {
        $this->audit_host = $host;
    }

    /**
     * 
     * @return string
     */
    private function getAuditHost()
    {
        return $this->audit_host;
    }

    /**
     * 
     * @param string $port
     */
    private function setAuditPort($port)
    {
        $this->audit_port = $port;
    }

    /**
     * 
     * @return string
     */
    private function getAuditPort()
    {
        return $this->audit_port;
    }

    private function loadConfig()
    {
        $string = file_get_contents($this->configuration->getConfigPath() . "settings.json");
        $json_a = json_decode($string, true);
        $this->setAuditHost($json_a["AUDIT"]["host"]);
        $this->setAuditPort($json_a["AUDIT"]["port"]);
    }

    public function __construct()
    {
        $this->configuration = new entityConfiguration();
        $this->loadConfig();
    }
}

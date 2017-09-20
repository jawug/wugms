<?php

class voSMTP
{

    /**
     *
     * @return string This is the value for smtp_host
     */
    function getSMTPHost()
    {
        return $this->smtp_host;
    }

    /**
     *
     * @param string $smtp_host This is the
     */
    function setSMTPHost($smtp_host)
    {
        $this->smtp_host = $smtp_host;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPPort()
    {
        return $this->smtp_port;
    }

    /**
     * 
     * @param string $smtp_port This is the 
     */
    function setSMTPPort($smtp_port)
    {
        $this->smtp_port = $smtp_port;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPSecure()
    {
        return $this->smtp_secure;
    }

    /**
     * 
     * @param string $smtp_secure This is the 
     */
    function setSMTPSecure($smtp_secure)
    {
        $this->smtp_secure = $smtp_secure;
    }

    /**
     * 
     * @return boolean This is the 
     */
    function getSMTPAuth()
    {
        return $this->smtp_auth;
    }

    /**
     * 
     * @param boolean $smtp_auth This is the 
     */
    function setSMTPAuth($smtp_auth)
    {
        $this->smtp_auth = $smtp_auth;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPUsername()
    {
        return $this->smtp_username;
    }

    /**
     * 
     * @param string $smtp_username This is the 
     */
    function setSMTPUsername($smtp_username)
    {
        $this->smtp_username = $smtp_username;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPPassword()
    {
        return $this->smtp_password;
    }

    /**
     * 
     * @param string $smtp_password This is the 
     */
    function setSMTPPassword($smtp_password)
    {
        $this->smtp_password = $smtp_password;
    }

    /**
     * 
     * @return string
     */
    function getNoreplyAddress()
    {
        return $this->noreply_address;
    }

    /**
     * 
     * @param string $noreply_address
     */
    function setNoreplyAddress($noreply_address)
    {
        $this->noreply_address = $noreply_address;
    }

    /**
     * 
     * @return string
     */
    function getNoreplyName()
    {
        return $this->noreply_name;
    }

    /**
     * 
     * @param string $noreply_name
     */
    function setNoreplyName($noreply_name)
    {
        $this->noreply_name = $noreply_name;
    }

    private function loadConfiguration()
    {
        $this->server_base = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        if (!$this->server_base) {
            $this->server_base = __DIR__;
        }
        $this->config_path = $this->server_base . "/../config/";
        $string = file_get_contents($this->config_path . "settings.json");
        $json_a = json_decode($string, true);
        $this->setSMTPHost($json_a["voSMTP"]["smtphost"]);
        $this->setSMTPPort($json_a["voSMTP"]["smtpport"]);
        $this->setSMTPSecure($json_a["voSMTP"]["smtpsecure"]);
        $this->setSMTPAuth($json_a["voSMTP"]["smtpauth"]);
        $this->setSMTPUsername($json_a["voSMTP"]["smtpusername"]);
        $this->setSMTPPassword($json_a["voSMTP"]["smtppassword"]);
        $this->setNoreplyAddress($json_a["voSMTP"]["noreplyaddress"]);
        $this->setNoreplyName($json_a["voSMTP"]["noreplyname"]);
    }

    function __construct()
    {
        $this->loadConfiguration();
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bwcfw
 *
 * @author duncan.ewan
 */

/**
 * This is the main pattern used for const across the project
 */
class bwcfwDecoratorPattern {

    private $server_base;

    /**
     *
     * @var string This is the external URL 
     */
    private $baseurl = 'https://wugms.bwcsystem.net';

    /**
     *
     * @var string This is the internal URL 
     */
    private $baseurlinternal = 'http://wugms.services.jawug';

    /**
     *
     * @var string This is the footer seen at the bottom of the pages 
     */
    private $footercopy;

    /**
     *
     * @var string This is the basic site name 
     */
    private $HomeSiteURL = 'wugms.bwcsystem.net';

    /**
     *
     * @var boolean This enables/disables the page 
     */
    private $isAboutUsEnabled = FALSE;

    /**
     *
     * @var boolean This enables/disables the page 
     */
    private $isContactUsEnabled = FALSE;

    /**
     *
     * @var boolean This enables/disables the page 
     */
    private $isServicesEnabled = FALSE;

    /**
     *
     * @var string This is the company's name in long format 
     */
    private $LongName = 'WUGMS';

    /**
     *
     * @var string This is the company's name in short format 
     */
    private $ShortName = 'WUGMS';

    /**
     *
     * @var boolean This enables/disables the page 
     */
    private $socialmedia = FALSE;

    /**
     *
     * @var string This is the admin's email address 
     */
    private $bwcfwadminemail = 'admin@jawug.co.za';

    /**
     *
     * @var string This is the basic site name 
     */
    private $bwcfwSiteURL = 'wugms.bwcsystem.net';

    /**
     *
     * @var string This is the short site name 
     */
    private $WShortSiteName = 'wugms';

    /**
     *
     * @var string This is the long site name 
     */
    private $WSiteName = 'Wireless User Group Managed Service';

    /**
     * 
     */
    private $log_path;

    /**
     *
     * @var string This is the location where uploaded files will be stored on the server 
     */
    private $uploads_path;

    /**
     *
     * @var string This is the location where email files will be stored on the server
     */
    private $emails_path;

    /**
     * 
     * @return string This gets the internal variable
     */
    function getBaseURL() {
        return $this->baseurl;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setBaseURL($value) {
        $this->baseurl = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getBaseURLInternal() {
        return $this->baseurlinternal;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setBaseURLInternal($value) {
        $this->baseurlinternal = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getHomeSiteURL() {
        return $this->HomeSiteURL;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setHomeSiteURL($value) {
        $this->HomeSiteURL = $value;
    }

    /**
     * 
     * @return boolean This gets the internal variable
     */
    function getisAboutUsEnabled() {
        return $this->isAboutUsEnabled;
    }

    /**
     * 
     * @param boolean $value This sets the internal variable
     */
    function setisAboutUsEnabled($value) {
        $this->isAboutUsEnabled = $value;
    }

    /**
     * 
     * @return boolean This gets the internal variable
     */
    function getisContactUsEnabled() {
        return $this->isContactUsEnabled;
    }

    /**
     * 
     * @param boolean $value This sets the internal variable
     */
    function setisContactUsEnabled($value) {
        $this->isContactUsEnabled = $value;
    }

    /**
     * 
     * @return boolean This gets the internal variable
     */
    function getisServicesEnabled() {
        return $this->isServicesEnabled;
    }

    /**
     * 
     * @param boolean $value This sets the internal variable
     */
    function setisServicesEnabled($value) {
        $this->isServicesEnabled = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getLongName() {
        return $this->LongName;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setLongName($value) {
        $this->LongName = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getShortName() {
        return $this->ShortName;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setShortName($value) {
        $this->ShortName = $value;
    }

    /**
     * 
     * @return boolean This gets the internal variable
     */
    function getSocialMedia() {
        return $this->socialmedia;
    }

    /**
     * 
     * @param boolean $value This sets the internal variable
     */
    function setSocialMedia($value) {
        $this->socialmedia = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getbwcfwAdmineMail() {
        return $this->bwcfwadminemail;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setbwcfwAdmineMail($value) {
        $this->bwcfwadminemail = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getbwcfwSiteURL() {
        return $this->bwcfwSiteURL;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setbwcfwSiteURL($value) {
        $this->bwcfwSiteURL = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getShortSiteName() {
        return $this->WShortSiteName;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setShortSiteName($value) {
        $this->WShortSiteName = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getSiteName() {
        return $this->WSiteName;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setSiteName($value) {
        $this->WSiteName = $value;
    }

    /**
     * 
     * @return string This returns the file base for where all files are located
     */
    function getServerBase() {
        return $this->server_base;
    }

    /**
     * 
     * @return string the suffix of the logging path
     */
    function getLogPath() {
//       return self::log_path;
        return $this->log_path;
    }

    /**
     * 
     * @return String Footer copyright
     */
    function getFooterCopy() {
        return $this->footer_copy;
    }

    /**
     * 
     * @param string $path
     */
    function setUploadsPath($path) {
        $this->uploads_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getUploadsPath() {
        return $this->uploads_path;
    }

    /**
     * 
     * @param string $config
     */
    function setConfigPath($config) {
        $this->config_path = $config;
    }

    /**
     * 
     * @return string
     */
    function getConfigPath() {
        return $this->config_path;
    }

    /**
     * 
     * @param string $path
     */
    function setEmailsPath($path) {
        $this->emails_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getEmailsPath() {
        return $this->emails_path;
    }

    /**
     * 
     * @param string $php_min
     */
    function setPHPMinVersion($php_min) {
        $this->php_min = $php_min;
    }

    /**
     * 
     * @param string $php_max
     */
    function setPHPMaxVersion($php_max) {
        $this->php_max = $php_max;
    }

    /**
     * 
     * @return string
     */
    function getPHPMinVersion() {
        return $this->php_min;
    }

    /**
     * 
     * @return string
     */
    function getPHPMaxVersion() {
        return $this->php_max;
    }

//    function checkPHPReqVersion() {
//        if (version_compare(PHP_VERSION, $this->getPHPMinVersion()) >= 0) {
//            
//        }
//    }

    /**
     * Main constructor function
     */
    function __construct() {
        date_default_timezone_set('Africa/Johannesburg');
        $this->server_base = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');

//        private $log_path = '/bwcfw/logging/';
        $this->uploads_path = $this->server_base . "/../data/uploads/";
        $this->emails_path = $this->server_base . "/../data/emails/";
        $this->log_path = $this->server_base . "/../logging/";
        $this->config_path = $this->server_base . "/../config/";
        $this->footer_copy = "<p style='text-align:right;'>&copy; " . $this->getLongName() . " " . date("Y") . "</p>";
        $this->config_path = $this->server_base . "/../config/";
        $string = file_get_contents($this->config_path . "settings.json");
        $json_a = json_decode($string, true);
        $this->setPHPMinVersion($json_a["MiscVO"]["php_min"]);
        $this->setPHPMaxVersion($json_a["MiscVO"]["php_max"]);
    }

}

class SMTPVO {

    /**
     *
     * @var string This is the host that the emailer needs to connect to 
     */
    var $smtp_host = "smtp.office365.com";

    /**
     *
     * @var string This si the port that the emailer connects to 
     */
    var $smtp_port = "587";

    /**
     *
     * @var string This is the secure type that gets used 
     */
    var $smtp_secure = "tls";

    /**
     *
     * @var boolean This indicates if auth needs to be used
     */
    var $smtp_auth = true;

    /**
     *
     * @var string SMTP username
     */
    var $smtp_username = "noreply@jawug.co.za";

    /**
     *
     * @var string SMTP password
     */
    var $smtp_password = "Wapo0378";

    /**
     * 
     * @return string This is the value for smtp_host
     */
    function getSMTPHost() {
        return $this->smtp_host;
    }

    /**
     * 
     * @param string $smtp_host This is the 
     */
    function setSMTPHost($smtp_host) {
        $this->smtp_host = $smtp_host;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPPort() {
        return $this->smtp_port;
    }

    /**
     * 
     * @param string $smtp_port This is the 
     */
    function setSMTPPort($smtp_port) {
        $this->smtp_port = $smtp_port;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPSecure() {
        return $this->smtp_secure;
    }

    /**
     * 
     * @param string $smtp_secure This is the 
     */
    function setSMTPSecure($smtp_secure) {
        $this->smtp_secure = $smtp_secure;
    }

    /**
     * 
     * @return boolean This is the 
     */
    function getSMTPAuth() {
        return $this->smtp_auth;
    }

    /**
     * 
     * @param boolean $smtp_auth This is the 
     */
    function setSMTPAuth($smtp_auth) {
        $this->smtp_auth = $smtp_auth;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPUsername() {
        return $this->smtp_username;
    }

    /**
     * 
     * @param string $smtp_username This is the 
     */
    function setSMTPUsername($smtp_username) {
        $this->smtp_username = $smtp_username;
    }

    /**
     * 
     * @return string This is the 
     */
    function getSMTPPassword() {
        return $this->smtp_password;
    }

    /**
     * 
     * @param string $smtp_password This is the 
     */
    function setSMTPPassword($smtp_password) {
        $this->smtp_password = $smtp_password;
    }

    /**
     * 
     * @return string
     */
    function getNoreplyAddress() {
        return $this->noreply_address;
    }

    /**
     * 
     * @param string $noreply_address
     */
    function setNoreplyAddress($noreply_address) {
        $this->noreply_address = $noreply_address;
    }

    /**
     * 
     * @return string
     */
    function getNoreplyName() {
        return $this->noreply_name;
    }

    /**
     * 
     * @param string $noreply_name
     */
    function setNoreplyName($noreply_name) {
        $this->noreply_name = $noreply_name;
    }

    function __construct() {
        $this->server_base = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        $this->config_path = $this->server_base . "/../config/";
        $string = file_get_contents($this->config_path . "settings.json");
        $json_a = json_decode($string, true);
        $this->setSMTPHost($json_a["SMTPVO"]["smtphost"]);
        $this->setSMTPPort($json_a["SMTPVO"]["smtpport"]);
        $this->setSMTPSecure($json_a["SMTPVO"]["smtpsecure"]);
        $this->setSMTPAuth($json_a["SMTPVO"]["smtpauth"]);
        $this->setSMTPUsername($json_a["SMTPVO"]["smtpusername"]);
        $this->setSMTPPassword($json_a["SMTPVO"]["smtppassword"]);
        $this->setNoreplyAddress($json_a["SMTPVO"]["noreplyaddress"]);
        $this->setNoreplyName($json_a["SMTPVO"]["noreplyname"]);
    }

}

class DBVO {

    /**
     *
     * @var string Database parameter - username
     */
    private $username = "bwcfw_admin";

    /**
     *
     * @var string Database parameter - password
     */
    private $password = "bwcfw_admin";

    /**
     *
     * @var string Database parameter - hostname/IP
     */
    private $host = "127.0.0.1";
//    private $host = "192.168.85.20";
    /**
     *
     * @var integer Database parameter - port
     */
    private $port = 3306;

    /**
     *
     * @var string Database parameter - database name
     */
    private $database = "bwcfw";

    /**
     *
     * @var array Database parameter - PDO options
     */
    private $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    /**
     *
     * @var string Database parameter - character set used 
     */
    private $charset = "utf8";

    function getUserName() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getHost() {
        return $this->host;
    }

    function getPort() {
        return $this->port;
    }

    function getDatabase() {
        return $this->database;
    }

    function getDataBaseOptions() {
        return $this->options;
    }

    function getCharset() {
        return $this->charset;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setHost($host) {
        $this->host = $host;
    }

    function setPort($port) {
        $this->port = $port;
    }

    function setDatabase($database) {
        $this->database = $database;
    }

    function setOptions($options) {
        $this->options = $options;
    }

    function setCharset($charset) {
        $this->charset = $charset;
    }

    function __construct() {
        $this->server_base = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        $this->config_path = $this->server_base . "/../config/";
        $string = file_get_contents($this->config_path . "settings.json");
        $json_a = json_decode($string, true);
        $this->setUsername($json_a["DBVO"]["username"]);
        $this->setPassword($json_a["DBVO"]["password"]);
        $this->setDatabase($json_a["DBVO"]["schema"]);
        $this->setHost($json_a["DBVO"]["host"]);
        $this->setPort($json_a["DBVO"]["port"]);
    }

}

/**
 * 
 */
class LoggingService extends bwcfwDecoratorPattern {

    /**
     *
     * @var \StatusVO  
     */
    public $PageActions;

    /**
     *
     * @var \VOFileRecord 
     */
    public $PageData;

    /**
     *
     * @var \Logger 
     */
    public $logger;

    /**
     *
     * @var integer The logging level to be used 
     */
    private $logging_level;

    /**
     * 
     */
    public function LogEntry($level) {
        switch ($level) {
            case 1:
                /* info */
                $this->logger->info('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode());
                break;
            case 2:
                /* debug */
                $this->logger->debug('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode() . ' ;; Extended Status: ' . $this->PageActions->getExtendedStatusCode() . ' ;; Line: ' . $this->PageActions->getLine());
                break;
            case 3:
                /* error */
                $this->logger->error('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode() . ' ;; Extended Status: ' . $this->PageActions->getExtendedStatusCode() . ' ;; Line: ' . $this->PageActions->getLine());
                break;
            default:
                /* debug */
                $this->logger->debug('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode() . ' ;; Extended Status: ' . $this->PageActions->getExtendedStatusCode() . ' ;; Line: ' . $this->PageActions->getLine());
        }
    }

    /**
     *
     * @var \DAO_Service 
     */
    var $DAO_Service;

    /**
     *
     * @var \audit_handover 
     */
    var $page_metric;

    /**
     * This starts up the logging sub section
     */
    public function __construct($fn = FALSE, $isSystemLevel = FALSE, $isEnableDAO = TRUE) {
        parent::__construct();
        require_once('log4php/Logger.php');
        Logger::configure(array(
            'rootLogger' => array(
                'appenders' => array('default'),
            ),
            'appenders' => array(
                'default' => array(
                    'class' => 'LoggerAppenderRollingFile',
                    'layout' => array(
                        'class' => 'LoggerLayoutPattern',
                        'params' => array(
                            'conversionPattern' => '%date{Y-m-d H:i:s,u} [%logger] %-5level %msg%n'
                        )
                    ),
                    'params' => array(
                        'file' => $this->getLogPath() . strtolower($this->getShortName()) . '.log',
                        'append' => true,
                        'maxFileSize' => '1MB',
                        'maxBackupIndex' => 10
                    )
                )
            )
        ));
        $this->PageActions = new StatusVO();
        $this->PageData = new VOFileRecord($fn, $isSystemLevel);
        $this->logger = Logger::getLogger($this->getShortName());
        $this->DAO_Service = new DAO_Service($isEnableDAO);
        $this->page_metric = new audit_handover();
    }

}

include_once 'bwcfw.classes.valueobjects.php';
include_once 'bwcfw.classes.entity.audit.php';
include_once 'bwcfw.classes.entity.leave.php';
include_once 'bwcfw.classes.entity.emailer.php';
include_once 'bwcfw.classes.entity.metrics.php';
include_once 'bwcfw.classes.entity.tickets.php';

include_once 'bwcfw.classes.entity.user.php';
include_once 'bwcfw.classes.entity.validation.php';
include_once 'bwcfw.classes.service.dao.php';
include_once 'bwcfw.classes.service.util.php';

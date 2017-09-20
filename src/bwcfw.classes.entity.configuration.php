<?php

class entityConfiguration
{

    private $server_base;

    /**
     *
     * @var string This is the external URL 
     */
    private $baseurl;

    /**
     *
     * @var string This is the internal URL 
     */
    private $baseurlinternal;

    /**
     *
     * @var string This is the footer seen at the bottom of the pages 
     */
    private $footer_copy;

    /**
     *
     * @var string This is the basic site name 
     */
    private $HomeSiteURL;

    /**
     *
     * @var string This is the company's name in long format 
     */
    private $LongName;

    /**
     *
     * @var string This is the company's name in short format 
     */
    private $ShortName;

    /**
     *
     * @var string This is the admin's email address 
     */
    private $bwcfwadminemail;

    /**
     *
     * @var string This is the basic site name 
     */
    private $bwcfwSiteURL;

    /**
     *
     * @var string This is the short site name 
     */
    private $WShortSiteName;

    /**
     *
     * @var string This is the long site name 
     */
    private $SiteName;

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
     * @var string This si the path to the vendor files 
     */
    private $vendor_path;

    /**
     *
     * @var string This is the location where email files will be stored on the server
     */
    private $emails_path;

    /**
     * 
     * @return string This gets the internal variable
     */
    function getBaseURLExternal()
    {
        return $this->baseurl;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setBaseURLExternal($value)
    {
        $this->baseurl = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getBaseURLInternal()
    {
        return $this->baseurlinternal;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setBaseURLInternal($value)
    {
        $this->baseurlinternal = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getHomeSiteURL()
    {
        return $this->HomeSiteURL;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setHomeSiteURL($value)
    {
        $this->HomeSiteURL = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getShortName()
    {
        return $this->ShortName;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setShortName($value)
    {
        $this->ShortName = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getAdminEmail()
    {
        return $this->bwcfwadminemail;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setAdminEmail($value)
    {
        $this->bwcfwadminemail = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getBWCFWSiteURL()
    {
        return $this->bwcfwSiteURL;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setBWCFWSiteURL($value)
    {
        $this->bwcfwSiteURL = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getShortSiteName()
    {
        return $this->WShortSiteName;
    }

    /**
     * 
     * @param string $value This sets the internal variable
     */
    function setShortSiteName($value)
    {
        $this->WShortSiteName = $value;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getSiteTitle()
    {
        return $this->sitetitle;
    }

    /**
     * 
     * @param string $title This sets the internal variable
     */
    function setSiteTitle($title)
    {
        $this->sitetitle = $title;
    }

    /**
     * 
     * @return string This returns the file base for where all files are located
     */
    function getServerBase()
    {
        return $this->server_base;
    }

    private function setServerBase($path)
    {
        $this->server_base = $path;
    }

    /**
     *
     * @param string $path
     */
    function setLogPath($path)
    {
        $this->log_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getLogPath()
    {
        return $this->log_path;
    }

    /**
     * 
     * @return String Footer copyright
     */
    function getFooterCopy()
    {
        return $this->footer_copy;
    }

    /**
     * 
     * @param string $string This is the Footer of the application
     */
    function setFooterCopy($string)
    {
        $this->footer_copy = $string;
    }

    /**
     * 
     * @param string $path
     */
    function setUploadsPath($path)
    {
        $this->uploads_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getUploadsPath()
    {
        return $this->uploads_path;
    }

    /**
     * 
     * @param string $path
     */
    function setVendorPath($path)
    {
        $this->vendor_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getVendorPath()
    {
        return $this->vendor_path;
    }

    /**
     * 
     * @param string $path
     */
    function setTemplatePath($path)
    {
        $this->template_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getTemplatePath()
    {
        return $this->template_path;
    }

    /**
     * 
     * @param string $config
     */
    function setConfigPath($config)
    {
        $this->config_path = $config;
    }

    /**
     * 
     * @return string
     */
    function getConfigPath()
    {
        return $this->config_path;
    }

    /**
     * 
     * @param string $path
     */
    function setIncludePath($path)
    {
        $this->include_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getIncludePath()
    {
        return $this->include_path;
    }

    /**
     * 
     * @param string $path
     */
    function setEmailsPath($path)
    {
        $this->emails_path = $path;
    }

    /**
     * 
     * @return string
     */
    function getEmailsPath()
    {
        return $this->emails_path;
    }

    /**
     *
     * @param string $path
     */
    function setFormsPath($path)
    {
        $this->forms_path = $path;
    }

    /**
     *
     * @return string
     */
    function getFormsPath()
    {
        return $this->forms_path;
    }

    /**
     * 
     * @param string $php_min
     */
    function setPHPMinVersion($php_min)
    {
        $this->php_min = $php_min;
    }

    /**
     * 
     * @param string $php_max
     */
    function setPHPMaxVersion($php_max)
    {
        $this->php_max = $php_max;
    }

    /**
     * 
     * @return string
     */
    function getPHPMinVersion()
    {
        return $this->php_min;
    }

    /**
     * 
     * @return string
     */
    function getPHPMaxVersion()
    {
        return $this->php_max;
    }

    /**
     * 
     * @return string
     */
    function getSiteDescription()
    {
        return $this->site_description;
    }

    /**
     * 
     * @param type $description
     */
    function setSiteDescription($description)
    {
        $this->site_description = $description;
    }

    /**
     * 
     * @return boolean
     */
    function getSMTPUsage()
    {
        return $this->allow_smtp;
    }

    /**
     * 
     * @param boolean $allow_smtp
     */
    function setSMTPUsage($allow_smtp)
    {
        $this->allow_smtp = $allow_smtp;
    }

    /**
     * 
     * @return string
     */
    function getAppName()
    {
        return $this->app_name;
    }

    /**
     * 
     * @param string $title
     */
    function setAppName($title)
    {
        $this->app_name = $title;
    }

    /**
     * 
     * @return string
     */
    function getSiteAbstract()
    {
        return $this->site_abstract;
    }

    /**
     * 
     * @param type $abstract
     */
    function setSiteAbstract($abstract)
    {
        $this->site_abstract = $abstract;
    }

    private function LoadConfiguration()
    {
        $string = file_get_contents($this->getConfigPath() . "settings.json");
        $json_a = json_decode($string, true);
        $this->setPHPMinVersion($json_a["MiscVO"]["php_min"]);
        $this->setPHPMaxVersion($json_a["MiscVO"]["php_max"]);

        $this->setBaseURLExternal($json_a["SITE"]["external_address"]);
        $this->setBaseURLInternal($json_a["SITE"]["internal_address"]);
        $this->setSiteTitle($json_a["SITE"]["site_title"]);
        $this->setAppName($json_a["SITE"]["app_name"]);
        $this->setAdminEmail($json_a["SITE"]["site_admin_email"]);
        $this->setSiteDescription($json_a["SITE"]["description"]);
        $this->setSiteAbstract($json_a["SITE"]["abstract"]);
        $this->setFooterCopy("&copy; " . $json_a["SITE"]["footer_text"] . " " . date("Y"));
        $this->setSMTPUsage($json_a["SITE"]["allow_smtp"]);
    }

    /**
     * Set secondary paths for teh application
     */
    private function setAppPaths()
    {
        $this->setUploadsPath($this->getServerBase() . "/../data/uploads/");
        $this->setEmailsPath($this->getServerBase() . "/../data/emails/");
        $this->setIncludePath($this->getServerBase() . "/../includes/");
        $this->setFormsPath($this->getIncludePath() . "/../forms/");
        $this->setLogPath($this->getServerBase() . "/../logging/");
        $this->setVendorPath($this->getServerBase() . "/../vendor/");
        $this->setConfigPath($this->getServerBase() . "/../config/");
        $this->setTemplatePath($this->getServerBase() . "/../templates/");
    }

    /**
     * Set the primary path for the application
     */
    private function setAppBase()
    {
        $sbase = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        if ($sbase) {
            $this->setServerBase($sbase);
        } else {
            $this->setServerBase($this->server_base = __DIR__);
        }
    }

    /**
     * Main constructor function
     */
    function __construct()
    {
        date_default_timezone_set('Africa/Johannesburg');
        $this->setAppBase();
        $this->setAppPaths();
        $this->LoadConfiguration();
    }
}

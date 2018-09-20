<?php
namespace wugms\valueobjects;

use \PDO;

class DAOConfig
{

    /**
     *
     * @var string Database parameter - username
     */
    private $username = "";

    /**
     *
     * @var string Database parameter - password
     */
    private $password = "";

    /**
     *
     * @var string Database parameter - hostname/IP. try to always use an IP. Hostnames take time to resolve
     */
    private $host = "";

    /**
     *
     * @var integer Database parameter - port
     */
    private $port = 3306;

    /**
     *
     * @var string Database parameter - database name
     */
    private $database = "";

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

    function getUserName()
    {
        return $this->username;
    }

    function getPassword()
    {
        return $this->password;
    }

    function getHost()
    {
        return $this->host;
    }

    function getPort()
    {
        return $this->port;
    }

    function getDatabase()
    {
        return $this->database;
    }

    function getDataBaseOptions()
    {
        return $this->options;
    }

    function getCharset()
    {
        return $this->charset;
    }

    function setUsername($username)
    {
        $this->username = $username;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function setHost($host)
    {
        $this->host = $host;
    }

    function setPort($port)
    {
        $this->port = $port;
    }

    function setDatabase($database)
    {
        $this->database = $database;
    }

    function setOptions($options)
    {
        $this->options = $options;
    }

    function setCharset($charset)
    {
        $this->charset = $charset;
    }

    function __construct()
    {
        $this->server_base = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        if (!$this->server_base) {
            $this->server_base = __DIR__;
        }
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

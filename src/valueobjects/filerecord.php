<?php

namespace wugms\valueobjects;

class FileRecord
{

    /**
     *
     */
    public function __construct($fn = false)
    {
        $this->PageWebStatus = new \wugms\valueobjects\WebPage();
        $this->PageActions = new \wugms\valueobjects\Status();
        $this->setRoleRequired("ADMIN");
        $this->setClientIP();
        $this->setFileRecord($fn);
    }

    /**
     *
     * @var string the name of the file that was called
     */
    private $filename;

    /**
     *
     * @var string This is the path of where the file is located
     */
    private $filepath;

    /**
     *
     * @var string This is the file extention of where the file is located
     */
    private $fileext;

    /**
     *
     * @var string the name of the file that was called without the extention
     */
    private $filenamebase;

    /**
     *
     * @var array The min role required in order to use this page
     */
    private $roles_required = array();

    /**
     *
     * @var string
     */
    private $section;

    /**
     *
     * @var string The min
     */
    private $level;

    /**
     *
     * @var string Chart/table/user
     */
    private $area;

    /**
     *
     * @var string
     */
    private $type;

    /**
     *
     * @var string add/edit/delete/get/post
     */
    private $action;

    /**
     *
     * @var string Any optional parameters that were called
     */
    private $params;

    /**
     *
     * @var array
     */
    private $pageinfoarray;

    /**
     *
     * @var \voWebPage
     */
    public $PageWebStatus;

    /**
     *
     * @var type
     */
    public $PageActions;

    /**
     *
     * @param string $name This sets the internal variable
     */
    function setName($name)
    {
        $this->filename = basename($name);
        $this->filepath = dirname($name);
        $this->fileext = pathinfo($name, PATHINFO_EXTENSION);
        $this->filenamebase = basename($name, "." . $this->fileext);
    }

    /**
     *
     * @return string This gets the internal variable
     */
    function getFileName()
    {
        return $this->filename;
    }

    /**
     *
     * @return string returns the path of the file
     */
    function getFilePath()
    {
        return $this->filepath;
    }

    /**
     *
     * @param string $role This sets the internal variable
     */
    function setRolesRequired($role)
    {
        array_push($this->roles_required, $role);
    }

    /**
     *
     * @return array This gets the internal variable
     */
    function getRolesRequired()
    {
        return $this->roles_required;
    }

    /**
     *
     * @param array $roles This contains an array with the list of roles that needs to be checked
     * @param string $akey This optional parameter is in case the array been sent has sub keys
     * @return boolean true if the roles overlap, false if they do not
     */
    function hasRoles($roles, $akey = null)
    {
        if ($akey) {
            $tmp_array = array();
            foreach ($roles as $item) {
                array_push($tmp_array, trim($item[$akey]));
            }
            $result = array_intersect(array_map('strtolower', $this->roles_required), array_map('strtolower', $tmp_array));
        } else {
            $result = array_intersect(array_map('strtolower', $this->roles_required), array_map('strtolower', $roles));
        }
        return ($result) ? true : false;
    }

    /**
     *
     * @param array $roles This contains an array with the list of roles that needs to be checked
     * @param string $required_role  This is the var which contains the singular role that needs to be checked.
     * @param type $akey  This optional parameter is in case the array been sent has sub keys
     * @return boolean true if the role overlaps, false if it does not
     */
    function hasRoleInArray($roles, $required_role, $akey = null)
    {
        $req_role_array = array();
        array_push($req_role_array, trim($required_role));
        if ($akey) {
            $tmp_array = array();
            foreach ($roles as $item) {
                array_push($tmp_array, trim($item[$akey]));
            }
            $result = array_intersect(array_map('strtolower', $req_role_array), array_map('strtolower', $tmp_array));
        } else {
            $result = array_intersect(array_map('strtolower', $req_role_array), array_map('strtolower', $roles));
        }
        return ($result) ? true : false;
    }

    /**
     *
     * @param string $section This is the section of the application that is been used.
     */
    function setSection($section)
    {
        $this->section = $section;
    }

    /**
     *
     * @return string
     */
    function getSection()
    {
        return $this->section;
    }

    /**
     *
     * @param string $level This sets the internal variable
     */
    function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     *
     * @return string This gets the internal variable
     */
    function getParams()
    {
        return $this->params;
    }

    /**
     *
     * @param string $params This sets the internal variable
     */
    function setParams($params)
    {
        $this->params = $params;
    }

    /**
     *
     * @return string This gets the internal variable
     */
    function getLevel()
    {
        return $this->level;
    }

    /**
     *
     * @param string $area This sets the internal variable
     */
    function setArea($area)
    {
        $this->area = $area;
    }

    /**
     *
     * @return string This gets the internal variable
     */
    function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param string $type This sets the internal variable
     */
    function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @return string This gets the internal variable
     */
    function getArea()
    {
        return $this->area;
    }

    /**
     *
     * @param string $action This sets the internal variable
     */
    function setAction($action)
    {
        $this->action = $action;
    }

    /**
     *
     * @return string This gets the internal variable
     */
    function getAction()
    {
        return $this->action;
    }

    /**
     *
     * @return string
     */
    function getPageWebStatusDebugMsg()
    {
        return '[' . $this->getFileName() . '] ' . 'Status: ' . $this->PageWebStatus->getAPIResponseStatus() . '; http_response_code: ' . $this->PageWebStatus->getHTTPResponseCode() . '; Status: ' . $this->PageWebStatus->getAPIResponseMessage() . '; Message: ' . $this->PageActions->StatusCode . '; Extended Status: ' . $this->PageActions->extended_StatusCode;
    }

    /**
     *
     * @return type
     */
    function getPageWebStatusInfoMsg()
    {
        return $this->action;
    }

    /**
     *
     * @var type
     */
    var $ClientIP;

    /**
     *
     * @return type
     */
    function getClientIP()
    {
        return $this->ClientIP;
    }

    /**
     *
     */
    function setClientIP()
    {
        $this->ClientIP = getenv('REMOTE_ADDR');
    }

    function setRoleRequired($role)
    {
        if (!in_array(trim(strtoupper($role)), $this->roles_required)) {
            array_push($this->roles_required, trim(strtoupper($role)));
        }
    }

    private function packPageInfo()
    {
        $this->pageinfoarray = array(
            "section" => $this->getSection(),
            "area" => $this->getArea(),
            "level" => $this->getLevel(),
            "type" => $this->getType(),
            "action" => $this->getAction(),
            "pagename" => $this->getFileName()
        );
    }

    /**
     *
     * @return array
     */
    function getPageInfo()
    {
        return $this->pageinfoarray;
    }

    private function postPageAudit()
    {
        /* Build the URL */
        $query_string = 'username=' . urlencode($foo);
        $query_string .= '&uid=' . urlencode($uid);
        $query_string .= '&level=' . urlencode($this->getLevel());
        $query_string .= '&action=' . urlencode($this->getAction());
        $query_string .= '&area=' . urlencode($this->getArea());
        $query_string .= '&type=' . urlencode($this->getType());
        $query_string .= '&file=' . urlencode($this->getFileName());

        $query_string .= '&file=' . urlencode($this->getFileName());
        $query_string .= '&file=' . urlencode($this->getFileName());
        //$parts = parse_url($url);

        $fp = fsockopen("127.0.0.1", 80);

        if (!$fp) {
            return false;
        } else {
            $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
            $out .= "Host: " . $parts['host'] . "\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "Content-Length: " . strlen($parts['query']) . "\r\n";
            $out .= "Connection: Close\r\n\r\n";
            if (isset($parts['query']))
                $out .= $parts['query'];

            fwrite($fp, $out);
            fclose($fp);
            return true;
        }
    }

    function setFileRecord($fn = false)
    {
        if ($fn) {
            $this->setName($fn);
            $fnb = explode(".", $this->filenamebase);
            if (sizeof($fnb) == 5) {
                $this->section = $fnb[0];
                $this->area = $fnb[1];
                $this->level = $fnb[2];
                $this->type = $fnb[3];
                $this->action = $fnb[4];
                $this->setRoleRequired($fnb[2]);
            } else {
                $this->section = "general";
                $this->area = "global";
                $this->level = "n/a";
                $this->type = "index";
                $this->action = "display";
            }
            $this->packPageInfo();
        }
    }
}

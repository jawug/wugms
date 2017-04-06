<?php

/**
 * Status Value Object
 */
class StatusVO {
    /**
     *
     * @var boolean This indicates if there is a problem or not
     */
//    var $Status = true;

    /**
     *
     * @var string This provides a more detailed status of what went wrong 
     */
//    var $StatusCode = "";

    /**
     *
     * @var string This provides one more level of what went wrong
     */
//    var $ExtendedStatusCode = "";

    /**
     * This function evaluates the variable @Status and returns a simple value
     * @return string 
     */
    public function getStatusStr() {
        return ($this->Status) ? "ok" : "error";
    }

    /**
     * 
     * @param boolean $Status This indicates if there is a problem or not
     */
    public function setStatus($Status) {
        $this->Status = $Status;
    }

    /**
     * 
     * @return boolean This indicates if there is a problem or not
     */
    public function getStatus() {
        return $this->Status;
    }

    /**
     * 
     * @param string $StatusCode This provides a more detailed status of what went wrong
     */
    public function setStatusCode($StatusCode) {
        $this->StatusCode = $StatusCode;
    }

    /**
     * 
     * @return string This provides a more detailed status of what went wrong
     */
    public function getStatusCode() {
        return $this->StatusCode;
    }

    /**
     * 
     * @param string $ExtendedStatusCode This provides a more detailed status of what went wrong
     */
    public function setExtendedStatusCode($ExtendedStatusCode) {
        $this->ExtendedStatusCode = $ExtendedStatusCode;
    }

    /**
     * 
     * @return string This provides a more detailed status of what went wrong
     */
    public function getExtendedStatusCode() {
        return $this->ExtendedStatusCode;
    }

    /**
     * 
     * @param string $Line This indicates the line where the error occured
     */
    public function setLine($Line) {
        $this->Line = $Line;
    }

    /**
     * 
     * @return string This indicates the line where the error occured
     */
    public function getLine() {
        return $this->Line;
    }

    /**
     * 
     */
    function __construct() {
        $this->Status = true;
        $this->StatusCode = "N/A";
        $this->ExtendedStatusCode = "N/A";
        $this->Line = "N/A";
    }

}

/**
 * Class record that holds function results
 */
//class bwcfw_function_record {

/**
 *
 * @var boolean This indicates if there is a problem or not
 */
//    public $status = true;

/**
 *
 * @var string This provides a more detailed status of what went wrong 
 */
//    public $status_code = "";

/**
 *
 * @var string This provides one more level of what went wrong
 */
//    public $extended_status_code = "";

/**
 * This function evalulates the variable @status and returns a simple value
 * @return string 
 */
//    function status_str() {
//        return ($this->status) ? "ok" : "error";
//    }
//}

class VOFileRecord {

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
     * @var boolean Set this 
     */
    private $issystemlevel;

    /**
     *
     * @var array 
     */
    private $pageinfoarray;

    /**
     *
     * @var \WebPageVO 
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
    function setName($name) {
        $this->filename = basename($name);
        $this->filepath = dirname($name);
        $this->fileext = pathinfo($name, PATHINFO_EXTENSION);
        $this->filenamebase = basename($name, "." . $this->fileext);
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getFileName() {
        return $this->filename;
    }

    /**
     * 
     * @return string returns the path of the file
     */
    function getFilePath() {
        return $this->filepath;
    }

    /**
     * 
     * @param string $role This sets the internal variable
     */
    function setRolesRequired($role) {
        array_push($this->roles_required, $role);
    }

    /**
     * 
     * @return array This gets the internal variable
     */
    function getRolesRequired() {
        return $this->roles_required;
    }

    function setSystemLevel($systemlevel) {
        $this->issystemlevel = $systemlevel;
    }

    /**
     * 
     * @param string $systemlevel This would be the user's Company_id
     * @return boolean 
     */
    function checkSystemLevel($systemlevel) {
        if ($this->issystemlevel) {
            return ($systemlevel === '1') ? TRUE : FALSE;
        }
        return TRUE;
    }

    /**
     * 
     * @param array $roles This contains an array with the list of roles that needs to be checked
     * @param string $akey This optional parameter is in case the array been sent has sub keys
     * @return boolean True if the roles overlap, false if they do not
     */
    function hasRoles($roles, $akey = null) {
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
     * @param string $role This is the var which contains the singular role that needs to be checked.
     * @return boolean True if the role overlaps, false if it does not
     */
//    function hasRequiredRole($role) {
//        $tmp_array = array();
//        array_push($tmp_array, trim($role));
//        $result = array_intersect(array_map('strtolower', $this->roles_required), array_map('strtolower', $tmp_array));
//        return ($result) ? true : false;
//    }

    /**
     * 
     * @param array $roles This contains an array with the list of roles that needs to be checked
     * @param string $required_role  This is the var which contains the singular role that needs to be checked.
     * @param type $akey  This optional parameter is in case the array been sent has sub keys
     * @return boolean True if the role overlaps, false if it does not
     */
    function hasRoleInArray($roles, $required_role, $akey = null) {
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
    function setSection($section) {
        $this->section = $section;
    }

    /**
     * 
     * @return string
     */
    function getSection() {
        return $this->section;
    }

    /**
     * 
     * @param string $level This sets the internal variable
     */
    function setLevel($level) {
        $this->level = $level;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getParams() {
        return $this->params;
    }

    /**
     * 
     * @param string $params This sets the internal variable
     */
    function setParams($params) {
        $this->params = $params;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getLevel() {
        return $this->level;
    }

    /**
     * 
     * @param string $area This sets the internal variable
     */
    function setArea($area) {
        $this->area = $area;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getType() {
        return $this->type;
    }

    /**
     * 
     * @param string $type This sets the internal variable
     */
    function setType($type) {
        $this->type = $type;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getArea() {
        return $this->area;
    }

    /**
     * 
     * @param string $action This sets the internal variable
     */
    function setAction($action) {
        $this->action = $action;
    }

    /**
     * 
     * @return string This gets the internal variable
     */
    function getAction() {
        return $this->action;
    }

    /**
     * 
     * @return string
     */
    function getPageWebStatusDebugMsg() {
        return '[' . $this->getFileName() . '] ' . 'Status: ' . $this->PageWebStatus->getAPIResponseStatus() . '; http_response_code: ' . $this->PageWebStatus->getHTTPResponseCode() . '; Status: ' . $this->PageWebStatus->getAPIResponseMessage() . '; Message: ' . $this->PageActions->StatusCode . '; Extended Status: ' . $this->PageActions->extended_StatusCode;
    }

    /**
     * 
     * @return type
     */
    function getPageWebStatusInfoMsg() {
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
    function getClientIP() {
        return $this->ClientIP;
    }

    /**
     * 
     */
    function setClientIP() {
        $this->ClientIP = getenv('REMOTE_ADDR');
    }

    function setRoleRequired($role) {
        array_push($this->roles_required, trim(strtoupper($role)));
    }

    private function packPageInfo() {
        $this->pageinfoarray = array("section" => $this->getSection(),
            "area" => $this->getArea(),
            "level" => $this->getLevel(),
            "type" => $this->getType(),
            "action" => $this->getAction(),
            "pagename" => $this->getFileName());
    }

    /**
     * 
     * @return array
     */
    function getPageInfo() {
        return $this->pageinfoarray;
    }

    private function postPageAudit() {
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

    function setFileRecord($fn = FALSE) {
        if ($fn) {
            $this->setName($fn);
            $fnb = explode(".", $this->filenamebase);
            if (sizeof($fnb) == 5) {
//            if ($fnb[0] !== 'index') {
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
//                $this->setRoleRequired("user");
            }
            $this->packPageInfo();
//            project . area        . type  . action . level
//            bwcfw    . new_tickets . chart . get    . all
//            
//            project . area        . level . type     . action
//            bwcfw    . new_tickets . all   . chart    . get
//            bwcfw    . leave       . user  . calendar . get
//            bwcfw.leave.user.calendar.get
        }
    }

//Example of use
//backgroundPost('http://example.com/slow.php?file='.
    //                     urlencode('some file.dat'));    

    /**
     * 
     */
    public function __construct($fn = FALSE, $isSystemLevel = FALSE) {
        $this->PageWebStatus = new WebPageVO();
        $this->PageActions = new StatusVO();
        $this->setRoleRequired("admin");
        $this->issystemlevel = $isSystemLevel;
        $this->setClientIP();
        $this->setFileRecord($fn);
        /*
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

         */
    }

}

class bwcfw_ticket_record {

    /**
     *
     * @var object Database object 
     */
    var $cdb;

    /**
     *
     * @var object 
     */
    var $class_actions;

    /**
     *
     * @var integer ID from the padded table entry
     */
    private $padded_id;

    /**
     *
     * @var integer ID of the original feedback
     */
    private $feedback_id;

    /**
     *
     * @var integer ID of the header
     */
    private $header_id;

    /**
     *
     * @var integer ID of the ticket owner
     */
    private $owner_fk_id;

    /**
     *
     * @var integer ID of the feedback support user
     */
    private $feedback_support_user_id;

    /**
     *
     * @var integer ID of the feedback user
     */
    private $feedback_fk_user_id;

    /**
     *
     * @var boolean Is this feedback for internal or external communication
     */
    private $isinternal_feedback;

    /**
     *
     * @var string Date of when the feedback was entered
     */
    private $feedback_date;

    /**
     *
     * @var string Text of the feedback
     */
    private $feedback_text;

    /**
     *
     * @var integer ID of the status of the ticket
     */
    private $status_id;

    /**
     *
     * @var string Status of the ticket
     */
    private $status;

    /**
     *
     * @var string Description of the status of the ticket
     */
    private $status_description;

    /**
     *
     * @var integer ID of the solution term used
     */
    private $solution_term_id;

    /**
     *
     * @var integer Time entered by the support user who added feedback
     */
    private $feedback_time_used;

    /**
     *
     * @var integer ID of Ticket owner
     */
    private $owner_id;

    /**
     *
     * @var integer ID of NEW Ticket owner
     */
    private $new_owner_id;

    /**
     *
     * @var string Ticket Owner's username
     */
    private $owner_username;

    /**
     *
     * @var string Ticket Owner's name
     */
    private $owner_name;

    /**
     *
     * @var string Ticket Owner's surname
     */
    private $owner_surname;

    /**
     *
     * @var integer Ticket Owner's company ID
     */
    private $owner_company_id;

    /**
     *
     * @var integer Ticket Owner's status ID
     */
    private $owner_user_status_id;

    /**
     *
     * @var string Ticket Owner's status
     */
    private $owner_status;

    /**
     *
     * @var integer ID of Ticket feedback user
     */
    private $feedback_user_id;

    /**
     *
     * @var string Feedback User's username
     */
    private $feedback_user_username;

    /**
     *
     * @var string Feedback User's name
     */
    private $feedback_user_name;

    /**
     *
     * @var string Feedback User's surname
     */
    private $feedback_user_surname;

    /**
     *
     * @var integer Feedback User's company ID
     */
    private $feedback_user_company_id;

    /**
     *
     * @var string Feedback User's status ID
     */
    private $feedback_user_user_status;

    /**
     *
     * @var string Feedback User's status
     */
    private $feedback_user_status;

    /**
     *
     * @var integer ID of Ticket support user
     */
    private $support_user_id;

    /**
     *
     * @var string Support User's username
     */
    private $support_user_username;

    /**
     *
     * @var string Support User's name
     */
    private $support_user_name;

    /**
     *
     * @var string Support User's surname
     */
    private $support_user_surname;

    /**
     *
     * @var integer Support User's company ID
     */
    private $support_user_company_id;

    /**
     *
     * @var string Support User's status ID
     */
    private $support_user_user_status;

    /**
     *
     * @var string Support User's status
     */
    private $support_user_status;

    /**
     *
     * @var integer ID of ticket's severity
     */
    private $severity_id;

    /**
     *
     * @var string Severity's name
     */
    private $type_serverity_name;

    /**
     *
     * @var string Severity's description
     */
    private $type_serverity_description;

    /**
     *
     * @var integer ID of the ticket type
     */
    private $type_id;

    /**
     *
     * @var string Name of the ticket type
     */
    private $type_name;

    /**
     *
     * @var string Description of the ticket type
     */
    private $type_description;

    /**
     *
     * @var integer ID of the severty
     */
    private $severties_id;

    /**
     *
     * @var string Name of the severty
     */
    private $severity_name;

    /**
     *
     * @var string Description of the severty
     */
    private $severity_description;

    /**
     *
     * @var integer ID of the company
     */
    private $company_id;

    /**
     *
     * @var string Name of the company
     */
    private $company_name;

    /**
     *
     * @var string Description of the company
     */
    private $company_description;

    /**
     *
     * @var string Description of the original header
     */
    private $header_description;

    /**
     *
     * @var string Date of original header
     */
    private $header_cdate;

    /**
     *
     * @var string unknown
     */
    private $st_email;

    /**
     *
     * @var string To which product does this ticket belong to
     */
    private $product_name;

    /**
     *
     * @var string Date used for highcharts
     */
    private $chart_date;

    /**
     *
     * @var integer Date in unix format
     */
    private $unix_date;

    /**
     * 
     * @return integer ID from the padded table entry
     */
    function getPadded_Id() {
        return $this->padded_id;
    }

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getFeedback_Id() {
        return $this->feedback_id;
    }

    /**
     * 
     * @return integer ID of the header
     */
    function getHeaderID() {
        return $this->header_id;
    }

    /**
     * 
     * @param integer $id ID of the header
     */
    function setHeaderID($id) {
        $this->header_id = $id;
    }

    /**
     * 
     * @return integer ID of the ticket owner
     */
    function getOwner_Fk_Id() {
        return $this->owner_fk_id;
    }

    /**
     * 
     * @return integer ID of the feedback support user
     */
    function getFeedbackSupportUserID() {
        return $this->feedback_support_user_id;
    }

    /**
     * 
     * @param integer $id ID of the feedback support user
     */
    function setFeedbackSupportUserID($id) {
        $this->feedback_support_user_id = $id;
    }

    /**
     * 
     * @return integer ID of the feedback user
     */
    function getFeedback_Fk_User_Id() {
        return $this->feedback_fk_user_id;
    }

    /**
     * 
     * @return boolean Is this feedback for internal or external communication
     */
    function getIsinternal_Feedback() {
        return $this->isinternal_feedback;
    }

    /**
     * 
     * @return string Date of when the feedback was entered
     */
    function getFeedback_Date() {
        return $this->feedback_date;
    }

    /**
     * 
     * @return string Text of the feedback
     */
    function getFeedbackText() {
        return $this->feedback_text;
    }

    /**
     * 
     * @param string $text Text of the feedback
     */
    function setFeedbackText($text) {
        $this->feedback_text = $text;
    }

    /**
     * 
     * @return integer ID of the status of the ticket
     */
    function getStatus_Id() {
        return $this->status_id;
    }

    /**
     * 
     * @return string Status of the ticket
     */
    function getStatus() {
        return $this->status;
    }

    /**
     * 
     * @return string Description of the status of the ticket
     */
    function getStatus_Description() {
        return $this->status_description;
    }

    /**
     * 
     * @return integer ID of the solution term used
     */
    function getSolution_Term_Id() {
        return $this->solution_term_id;
    }

    /**
     * 
     * @return integer Time entered by the support user who added feedback
     */
    function getFeedback_Time_Used() {
        return $this->feedback_time_used;
    }

    /**
     * 
     * @return integer ID of Ticket owner
     */
    function getOwnerID() {
        return $this->owner_id;
    }

    /**
     * 
     * @param integer $id The ticket owner's ID
     */
    function setOwnerID($id) {
        $this->owner_id = $id;
    }

    /**
     * 
     * @return integer ID of Ticket owner
     */
    function getNewOwnerID() {
        return $this->new_owner_id;
    }

    /**
     * 
     * @param integer $id The ticket owner's ID
     */
    function setNewOwnerID($id) {
        $this->new_owner_id = $id;
    }

    /**
     * 
     * @return string Ticket Owner's username
     */
    function getOwner_Username() {
        return $this->owner_username;
    }

    /**
     * 
     * @return string Ticket Owner's name
     */
    function getOwner_Name() {
        return $this->owner_name;
    }

    /**
     * 
     * @return string Ticket Owner's surname
     */
    function getOwner_Surname() {
        return $this->owner_surname;
    }

    /**
     * 
     * @return integer Ticket Owner's company ID
     */
    function getOwner_Company_Id() {
        return $this->owner_company_id;
    }

    /**
     * 
     * @return integer Ticket Owner's status ID
     */
    function getOwner_User_Status_Id() {
        return $this->owner_user_status_id;
    }

    /**
     * 
     * @return string Ticket Owner's status
     */
    function getOwner_Status() {
        return $this->owner_status;
    }

    /**
     * 
     * @return integer ID of Ticket feedback user
     */
    function getFeedbackUserID() {
        return $this->feedback_user_id;
    }

    /**
     * 
     * @param integer $id ID of Ticket feedback user
     */
    function setFeedbackUserID($id) {
        $this->feedback_user_id = $id;
    }

    /**
     * 
     * @return string Feedback User's username
     */
    function getFeedback_User_Username() {
        return $this->feedback_user_username;
    }

    /**
     * 
     * @return string Feedback User's name
     */
    function getFeedback_User_Name() {
        return $this->feedback_user_name;
    }

    /**
     * 
     * @return string Feedback User's surname
     */
    function getFeedback_User_Surname() {
        return $this->feedback_user_surname;
    }

    /**
     * 
     * @return integer Feedback User's company ID
     */
    function getFeedback_User_Company_Id() {
        return $this->feedback_user_company_id;
    }

    /**
     * 
     * @return string Feedback User's status ID
     */
    function getFeedback_User_User_Status() {
        return $this->feedback_user_user_status;
    }

    /**
     * 
     * @return string Feedback User's status
     */
    function getFeedback_User_Status() {
        return $this->feedback_user_status;
    }

    /**
     * 
     * @return integer ID of Ticket support user
     */
    function getSupport_User_Id() {
        return $this->support_user_id;
    }

    /**
     * 
     * @return string Support User's username
     */
    function getSupport_User_Username() {
        return $this->support_user_username;
    }

    /**
     * 
     * @return string Support User's name
     */
    function getSupport_User_Name() {
        return $this->support_user_name;
    }

    /**
     * 
     * @return string Support User's surname
     */
    function getSupport_User_Surname() {
        return $this->support_user_surname;
    }

    /**
     * 
     * @return integer Support User's company ID
     */
    function getSupport_User_Company_Id() {
        return $this->support_user_company_id;
    }

    /**
     * 
     * @return string Support User's status ID
     */
    function getSupport_User_User_Status() {
        return $this->support_user_user_status;
    }

    /**
     * 
     * @return string Support User's status
     */
    function getSupport_User_Status() {
        return $this->support_user_status;
    }

    /**
     * 
     * @return integer ID of ticket's severity
     */
    function getSeverity_Id() {
        return $this->severity_id;
    }

    /**
     * 
     * @return string Severity's name
     */
    function getType_Serverity_Name() {
        return $this->type_serverity_name;
    }

    /**
     * 
     * @return string Severity's description
     */
    function getType_Serverity_Description() {
        return $this->type_serverity_description;
    }

    /**
     * 
     * @return integer ID of the ticket type
     */
    function getType_Id() {
        return $this->type_id;
    }

    /**
     * 
     * @return string Name of the ticket type
     */
    function getType_Name() {
        return $this->type_name;
    }

    /**
     * 
     * @return string Description of the ticket type
     */
    function getType_Description() {
        return $this->type_description;
    }

    /**
     * 
     * @return integer ID of the severty
     */
    function getSeverties_Id() {
        return $this->severties_id;
    }

    /**
     * 
     * @return string Name of the severty
     */
    function getSeverity_Name() {
        return $this->severity_name;
    }

    /**
     * 
     * @return string Description of the severty
     */
    function getSeverity_Description() {
        return $this->severity_description;
    }

    /**
     * 
     * @return integer ID of the company
     */
    function getCompany_Id() {
        return $this->company_id;
    }

    /**
     * 
     * @return string Name of the company
     */
    function getCompany_Name() {
        return $this->company_name;
    }

    /**
     * 
     * @return string Description of the company
     */
    function getCompany_Description() {
        return $this->company_description;
    }

    /**
     * 
     * @return string Description of the original header
     */
    function getHeader_Description() {
        return $this->header_description;
    }

    /**
     * 
     * @return string Date of original header
     */
    function getHeader_Cdate() {
        return $this->header_cdate;
    }

    /**
     * 
     * @return string unknown
     */
    function getSt_Email() {
        return $this->st_email;
    }

    /**
     * 
     * @return string To which product does this ticket belong to
     */
    function getProduct_Name() {
        return $this->product_name;
    }

    /**
     * 
     * @return string Date used for highcharts
     */
    function getChart_Date() {
        return $this->chart_date;
    }

    /**
     * 
     * @return integer Date in unix format
     */
    function getUnix_Date() {
        return $this->unix_date;
    }

    /**
     * 
     * @return integer The ID value of the feedback
     */
    function getFeedbackID() {
        return $this->feedback_id;
    }

    /**
     * 
     * @param integer $id Set's the ID value of the feedback
     */
    function setFeedbackID($id) {
        $this->feedback_id = $id;
    }

    /*
      function __construct($feedback_id) {
      if ($feedback_id) {
      $this->feedback_id = $feedback_id;
      $this->class_actions = new bwcfw_function_record();
      }
      }

      function init_db() {
      $database_settings = new DBVO();
      $init_db_status = new bwcfw_function_record();

      try {
      $this->cdb = new PDO("mysql:host={$database_settings->getHost()};dbname={$database_settings->getDataBase()};charset={$database_settings->getCharset()}", $database_settings->getUserName(), $database_settings->getPassword(), $database_settings->getDataBaseOptions());
      } catch (PDOException $ex) {
      $init_db_status->status = false;
      $init_db_status->status_code = $ex->getMessage();
      }
      if ($init_db_status->status) {
      $this->cdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->cdb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      }
      return $init_db_status;
      }


      function getTicket() {
      $getTicket_status = new bwcfw_function_record();
      if ($this->init_db()) {
      $get_ticket_details_query = "
      SELECT id_ticket_padded AS padded_id, fk_ticket_header AS header_id,
      fk_ticket_owner AS owner_fk_id, fk_feedback_support_user AS feedback_support_user_id,
      fk_feedback_user AS feedback_fk_user_id, ticket_isinternal_feedback AS isinternal_feedback,
      ticket_feedback_date AS feedback_date, ticket_feedback_text AS feedback_text,
      fk_ticket_status AS status_id, ticket_status AS status,
      ticket_status_description AS status_description, fk_solution_term AS solution_term_id,
      ticket_feedback_time_used AS feedback_time_used, to_id AS owner_id,
      to_username AS owner_username, to_name AS owner_name,
      to_surname AS owner_surname, to_company_id AS owner_company_id,
      to_user_status AS owner_user_status_id, to_status AS owner_status,
      fbu_id AS feedback_user_id, fbu_username AS feedback_user_username,
      fbu_name AS feedback_user_name, fbu_surname AS feedback_user_surname,
      fbu_company_id AS feedback_user_company_id, fbu_user_status AS feedback_user_user_status,
      fbu_status AS feedback_user_status, su_id AS support_user_id,
      su_username AS support_user_username, su_name AS support_user_name,
      su_surname AS support_user_surname, su_company_id AS support_user_company_id,
      su_user_status AS support_user_user_status, su_status AS support_user_status,
      fk_ticket_severity AS severity_id, ticket_type_serverity_name AS type_serverity_name,
      ticket_type_serverity_description AS type_serverity_description, fk_ticket_type AS type_id,
      ticket_type_name AS type_name, ticket_type_description AS type_description,
      fk_severties AS severties_id, severity_name AS severity_name,
      severity_description AS severity_description,
      fk_company AS company_id, company_name AS company_name,
      company_description AS company_description, ticket_header_description AS header_description,
      ticket_header_cdate AS header_cdate, st_email AS st_email,
      product_name AS product_name, chart_date AS chart_date, udate AS unix_date
      FROM tbl_base_ticket_feedback_padded
      WHERE id_tbl_base_ticket_feedback = :feedback_id;";
      $get_ticket_details_query_params = array(
      ':feedback_id' => $this->feedback_id
      );
      try {
      $get_ticket_details_stmt = $this->cdb->prepare($get_ticket_details_query);
      $get_ticket_details_result = $get_ticket_details_stmt->execute($get_ticket_details_query_params);
      } catch (PDOException $ex) {
      $getTicket_status->status_code = $ex->getMessage();
      $getTicket_status->status = false;
      }
      $get_ticket_details_row = $get_ticket_details_stmt->fetchall();
      if ($get_ticket_details_row) {
      $getTicket_status->status_code = "Data Returned";
      } else {
      $getTicket_status->status_code = "No data";
      $getTicket_status->status = false;
      }
      } else {
      $getTicket_status->status_code = $this->init_db()->status_code;
      $getTicket_status->status = false;
      }
      return $getTicket_status;
      }
     */
}

/**
 * email_msg_record
 * Class to contain all the variables needed in order to send emails
 */
class email_msg_record {

    /**
     * @var string This is the "type" of email that was sent; "feedback" or "invite" or "request"
     */
    private $email_type;

    /**
     * @var string This is the "to" field that is usually used in emails
     */
    //private $email_to = array();
    private $email_to;

    /**
     * @var string This is the "cc" field that is usually used in emails
     */
    private $email_cc = array();

    /**
     * @var string This is the "bcc" field that is usually used in emails
     */
    private $email_bcc = array();

    /**
     * @var string This is the size of the main body of the email
     */
    private $email_size = 0;

    /**
     * @var boolean This is the status of when the email was sent; "true" or "false"
     */
    private $email_status = true;

    /**
     * @var string This field represents the extended error information
     */
    private $email_extended_data;

    /**
     *
     * @var string This is the subject matter for the email 
     */
    private $email_subject;

    /**
     *
     * @var string This is the contents of the email
     */
    private $email_content;

    /**
     * 
     * @param string $email_type This is the "type" of email that was sent; "feedback" or "invite" or "request"
     */
    function setEmailType($email_type) {
        $this->email_type = $email_type;
    }

    /**
     * 
     * @param string $email_to This is the "to" field that is usually used in emails
     */
    function setEmailTo($email_to) {
        //array_push($this->email_to, $email_to);
        $this->email_to = $email_to;
    }

    /**
     * 
     * @param string $email_cc This is the "cc" field that is usually used in emails
     */
    function setEmailCc($email_cc) {
        array_push($this->email_cc, $email_cc);
    }

    /**
     * 
     * @param string $email_bcc This is the "bcc" field that is usually used in emails
     */
    function setEmailBcc($email_bcc) {
        array_push($this->email_bcc, $email_bcc);
    }

    /**
     * 
     * @param integer $email_size This is the size of the main body of the email
     */
    function setEmailSize($email_size) {
        $this->email_size = $email_size;
    }

    /**
     * 
     * @param boolean $email_status This is the status of when the email was sent; "true" or "false"
     */
    function setEmailStatus($email_status) {
        $this->email_status = $email_status;
    }

    /**
     * 
     * @param type $email_extended_data This field represents the extended error information
     */
    function setEmailExtendedData($email_extended_data) {
        $this->email_extended_data = $email_extended_data;
    }

    /**
     * 
     * @param string $email_subject This is the subject matter for the email 
     */
    function setEmailSubject($email_subject) {
        $this->email_subject = $email_subject;
    }

    /**
     * 
     * @param string $email_content This is the contents of the email
     */
    function setEmailContent($email_content) {
        $this->email_content = $email_content;
    }

    /**
     * 
     * @param string $email_from_address This is the from address
     */
//    function setEmailFromAddress($email_from_address) {
//        $this->email_from_address = $email_from_address;
//    }

    /**
     * 
     * @param string $email_from_name This is the from name
     */
//    function setEmailFromName($email_from_name) {
//        $this->email_from_name = $email_from_name;
//    }

    /**
     * 
     * @return string This is the "type" of email that was sent; "feedback" or "invite" or "request"
     */
    function getEmailType() {
        return $this->email_type;
    }

    /**
     * 
     * @return array This is the "to" field that is usually used in emails
     */
    function getEmailTo() {
        return $this->email_to;
    }

    /**
     * 
     * @return array This is the "cc" field that is usually used in emails
     */
    function getEmailCc() {
        return $this->email_cc;
    }

    /**
     * 
     * @return array This is the "bcc" field that is usually used in emails
     */
    function getEmailBcc() {
        return $this->email_bcc;
    }

    /**
     * 
     * @return integer This is the size of the main body of the email
     */
    function getEmailSize() {
        return $this->email_size;
    }

    /**
     * 
     * @return boolean This is the status of when the email was sent; "true" or "false"
     */
    function getEmailStatus() {
        return $this->email_status;
    }

    /**
     * 
     * @return string This field represents the extended error information
     */
    function getEmailExtendedData() {
        return $this->email_extended_data;
    }

    /**
     * 
     * @return string This is the subject matter for the email
     */
    function getEmailSubject() {
        return $this->email_subject;
    }

    /**
     * 
     * @return string This is the contents of the email
     */
    function getEmailContent() {
        return $this->email_content;
    }

    /**
     * 
     * @return string This is the from address
     */
//    function getEmailFromAddress() {
//        return $this->email_from_address;
//    }

    /**
     * 
     * @return string This is the from name
     */
    function getEmailFromName() {
        return $this->email_from_name;
    }

}

class ticket_record {

    public $ticket_company = "";
    public $ticket_header_id = "";
    public $ticket_owner_id_current = "";
    public $ticket_owner_id_new = "";
    public $feedback_support_user = "";
    public $feedback_user_id = "";
    public $ticket_isinternal_feedback = "";
    public $ticket_feedback_date = "";
    public $ticket_feedback_text = "";
    public $ticket_status = "";
    public $solution_term = "";
    public $ticket_sla_terms = "";
    public $ticket_header_description = "";
    public $header_ticket_id = "";
    public $feedback_ticket_id = "";
    public $feedback_text = "";

}

class user_record {

    /**
     *
     * @var integer This is the user's ID 
     */
    var $user_id;

    /**
     *
     * @var string This is the user's firstname 
     */
    var $name;

    /**
     *
     * @var string This is the user's Sruname 
     */
    var $surname;

    /**
     *
     * @var string This is the user's username as well as email address  
     */
    var $username;

    /**
     *
     * @var string This is the user's account status 
     */
    var $account_status;

    /**
     *
     * @var integer This is the user's company that they belong to 
     */
    var $company_id;

    /**
     *
     * @var integer This is the user's company that they belong to 
     */
    var $user_create_date;

    /**
     *
     * @var string salt value for the password 
     */
    var $user_auth_salt;

    /**
     *
     * @var integer This is the account type that the user can have 
     */
    var $user_type;

    /**
     *
     * @var string This is the auth code 
     */
    var $user_auth_code;

    /**
     *
     * @var string This is the password 
     */
    var $password;

    /**
     *
     * @var string This is the account validation key 
     */
    var $acc_val_key;

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getID() {
        return $this->name;
    }

    /**
     * 
     * @param integer $id This sets the internal variable
     */
    function setID($id) {
        $this->user_id = $id;
    }

    /**
     * 
     * @return string User's name
     */
    function getName() {
        return $this->name;
    }

    /**
     * 
     * @param string $name This sets the internal variable
     */
    function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @return string User's surname
     */
    function getSurname() {
        return $this->surname;
    }

    /**
     * 
     * @param string $surname This sets the internal variable
     */
    function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * 
     * @return string Username
     */
    function getUserName() {
        return $this->username;
    }

    /**
     * 
     * @param string $username This sets the internal variable
     */
    function setUserName($username) {
        $this->username = $username;
    }

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getAccountStatus() {
        return $this->account_status;
    }

    /**
     * 
     * @param integer $account_status This sets the internal variable
     */
    function setAccountStatus($account_status) {
        $this->account_status = $account_status;
    }

    /**
     * 
     * @return integer ID of the company
     */
    function getCompanyID() {
        return $this->company_id;
    }

    /**
     * 
     * @param integer $company_id This sets the internal variable
     */
    function setCompanyID($company_id) {
        $this->company_id = $company_id;
    }

    /**
     * 
     * @return integer ID of the account type
     */
    function getUserType() {
        return $this->user_type;
    }

    /**
     * 
     * @param integer $user_type This sets the internal variable
     */
    function setUserType($user_type) {
        $this->user_type = $user_type;
    }

    /**
     * 
     * @return string ID of the company
     */
    function getAccValKey() {
        return $this->acc_val_key;
    }

    /**
     * 
     * @param string $acc_val_key This creates a a user account key that gets used in future operations
     */
    function setAccValKey($acc_val_key = null) {
        if ($acc_val_key) {
            $this->acc_val_key = $acc_val_key;
        } else {
            $this->user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $this->user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $this->user_auth_salt);
            for ($round = 0; $round < 65536; $round++) {
                $this->user_auth_code = hash('sha256', $this->user_auth_code . $this->user_auth_salt);
            }
            $this->acc_val_key = $this->user_auth_code;
        }
    }

    /**
     * 
     * @return string Return the auth salt
     */
    function getAuthSalt() {
        return $this->user_auth_salt;
    }

    /**
     * 
     * @param string $user_auth_salt This sets the internal variable
     */
    function setAuthSalt($user_auth_salt = null) {
        if ($user_auth_salt) {
            $this->user_auth_salt = $user_auth_salt;
        } else {
            $this->user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        }
    }

    /**
     * 
     * @return string Return the auth code
     */
    function getAuthCode() {
        $this->user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $this->user_auth_salt);

        for ($round = 0; $round < 65536; $round++) {
            $this->user_auth_code = hash('sha256', $this->user_auth_code . $this->user_auth_salt);
        }
        return $this->user_auth_code;
    }

    /**
     * 
     * @return string stuff
     */
    function getPassword() {
        return $this->password;
    }

    /**
     * 
     * @param string $password This sets the internal variable
     */
    function setPassword($password) {
        $this->password = $password;
    }

    function __construct($id = null) {
        
    }

}

class bwcfw_email_metric_record {

    /**
     * @var string This is the "type" of email that was sent; "feedback" or "invite"
     */
    public $email_type;

    /**
     * @var string This is the "to" field that is usually used in emails
     */
    public $email_to;

    /**
     * @var string This is the "cc" field that is usually used in emails
     */
    public $email_cc;

    /**
     * @var string This is the "bcc" field that is usually used in emails
     */
    public $email_bcc;

    /**
     * @var string This is the size of the main body of the email
     */
    public $email_size;

    /**
     * @var string This is the status of when the email was sent; "ok" or "Error"
     */
    public $email_status;

    /**
     * @var string This field represents the extended error information
     */
    public $email_extended_data;

    /**
     * @var string In cases where the email type is "feedback" this is used to determine the ticket ID
     */
    public $ticket_id;

    /**
     * @var string In cases where the email type is "feedback" this is used to determine the feedback ID
     */
    public $feedback_id;

}

class WebPageVO {

    /**
     *
     * @var array 
     */
    /* var $APIResponse = array('status' => 0,
      'message' => 'message',
      'data' => 'data'
      ); */
    var $APIResponse = array('status' => 0,
        'message' => 'message',
        'data' => ''
    );

    /**
     *
     * @var type 
     */
    var $HTTPResponseCode;

    /**
     * 
     * @return type
     */
    function getAPIStatusCode() {
        return $this->APIStatusCode;
    }

    /**
     * 
     * @return type
     */
    function getAPIStatusMsg() {
        return $this->APIStatusMsg;
    }

    /**
     * 
     * @return type
     */
    function getAPIData() {
        return $this->APIData;
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseCode($id) {
        return $this->APIResponseCode[$id];
    }

    /**
     * 
     * @return type
     */
    function getHTTPResponseCode() {
        //var_dump($this->HTTPResponseCode);
        return $this->HTTPResponseCode;
    }

    /**
     * 
     * @return type
     */
    function getAPIResponse() {
        return $this->APIResponse;
    }

    /**
     * 
     * @param type $APIStatusCode
     */
    function setAPIStatusCode($APIStatusCode) {
        $this->APIStatusCode = $APIStatusCode;
    }

    /**
     * 
     * @param type $HTTPResponseCode
     */
    function setHTTPResponseCode($HTTPResponseCode) {
        $this->HTTPResponseCode = $HTTPResponseCode;
    }

    /**
     * 
     * @param integer $APIResponse
     */
    function setAPIResponse($APIResponse = 1) {
        $this->APIResponse['status'] = $this->APIResponseCode[$APIResponse]['HTTP Response'];
        $this->APIResponse['message'] = $this->APIResponseCode[$APIResponse]['Message'];
        $this->HTTPResponseCode = $this->HTTPResponseCodes[$this->APIResponse['status']];
        switch ($APIResponse) {
            /* New entries */
            case 1:
                /*  so far do nothing */
                break;
            /* Default value */
            default:
                $this->APIResponse['data'] = $this->APIResponseCode[$APIResponse]['Data'];
        }
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseStatus() {
        return $this->APIResponse['status'];
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseMessage() {
        return $this->APIResponse['message'];
    }

    function setAPIResponseData($data) {
        $this->APIResponse['data'] = $data;
    }

    function setAPIResponseFeedback($feedback) {
        $this->APIResponse['feedback'] = $feedback;
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseData() {
        return $this->APIResponse['data'];
    }

    /**
     * 
     */
    function __construct() {
        $this->APIResponseCode = array(
            0 => array(
                'HTTP Response' => 400,
                'Message' => 'Unknown Error',
                'Data' => 'The server cannot or will not process the request due to an apparent client error.'
            ),
            1 => array(
                'HTTP Response' => 200,
                'Message' => 'Success',
                'Data' => ''
            ),
            2 => array(
                'HTTP Response' => 403,
                'Message' => 'HTTPS Required',
                'Data' => 'The request was a valid request, but the server is refusing to respond to it. The user might be logged in but does not have the necessary permissions for the resource.'
            ),
            3 => array(
                'HTTP Response' => 401,
                'Message' => 'Authentication Required',
                'Data' => 'User does not have sufficient permissions'
            ),
            4 => array(
                'HTTP Response' => 401,
                'Message' => 'Authentication Failed',
                'Data' => 'Unauthorized'
            ),
            5 => array(
                'HTTP Response' => 404,
                'Message' => 'Invalid Request',
                'Data' => 'The requested resource could not be found but may be available in the future'
            ),
            6 => array(
                'HTTP Response' => 400,
                'Message' => 'Invalid Response Format',
                'Data' => 'The server cannot or will not process the request due to an apparent client error'
            ),
            7 => array(
                'HTTP Response' => 400,
                'Message' => 'Invalid Request',
                'Data' => 'Invalid parameters'
            ),
            8 => array(
                'HTTP Response' => 204,
                'Message' => 'No Content',
                'Data' => 'The server successfully processed the request and is not returning any content'
            ),
            9 => array(
                'HTTP Response' => 405,
                'Message' => 'Method Not Allowed',
                'Data' => ''
            ),
            10 => array(
                'HTTP Response' => 500,
                'Message' => 'Internal Server Error',
                'Data' => 'The server lacks the ability to fulfill the request.'
            )
        );
        $this->HTTPResponseCodes = array(
            200 => 'OK',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        );
        $this->setAPIResponse(1);
    }

}

class VOFeedbackFileUpload {

    /**
     *
     * @var integer This is the max file size that can be uploaded 
     */
    var $MAX_FILE_SIZE_UPLOAD = 10485760;

    /**
     * 
     * @return integer This is the max file size that can be uploaded 
     */
    function getMaxFileSizeUpload() {
        return $this->MAX_FILE_SIZE_UPLOAD;
    }

    /**
     * 
     * @param integer $value This is the max file size that can be uploaded 
     */
    function setMaxFileSizeUpload($value) {
        $this->MAX_FILE_SIZE_UPLOAD = $value;
    }

}

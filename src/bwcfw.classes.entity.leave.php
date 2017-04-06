<?php

/**
 * This contains the various status and extended status of the actions done
 */
class entity_leave {

    /**
     *
     * @var \PHPMailer PHPMailer object
     */
    private $mailservice;

    /**
     *
     * @var array This contains the member(s) of the leave_auth group
     */
    //private $email_address_auth_admin = array();

    /**
     *
     * @var string This is the address of the person who requests the leave 
     */
    private $email_address_requestor = "";

    /**
     *
     * @var array This contains the list of who this email must to "to'd" to
     */
    private $email_to_address = array();

    /**
     *
     * @var array This contains the list of who this email must to "cc'd" to
     */
    private $email_cc_address = array();

    /**
     *
     * @var string This contains the contents of the email used for leave requests, template 
     */
    private $leave_request_email_content_template;

    /**
     *
     * @var string This contains the contents of the email used for leave accepted/declined 
     */
    private $leave_auth_email_content_template;

    /**
     *
     * @var string This contains the contents of the email used for leave changes 
     */
    private $leave_edit_email_content_template;

    /**
     *
     * @var string This contains the contents of the email used for leave accepted/declined 
     */
    private $leave_cancel_email_content_template;

    /**
     *
     * @var string This contains the contents of the email used for leave requests
     */
    private $leave_email_content;

    /**
     *
     * @var string This contains the contents of the email used for auth notifications
     */
//    private $leave_auth_email_content;

    /**
     *
     * @var string This contains the contents of the email used for edit notifications
     */
//    private $leave_edit_email_content;

    /**
     *
     * @var string This contains the contents of the email used for cancel notifications
     */
//    private $leave_cancel_email_content;

    /**
     *
     * @var \bwcfwDecoratorPattern This contains the items normally used for branding 
     */
    var $branding;

    /**
     *
     * @var type Database object
     */
    private $cdb;

    /**
     *
     * @var \SMTPVO
     */
//    var $mailer_smtp_config;

    public function __construct() {
//        require_once 'phpmailer/PHPMailerAutoload.php';
        $this->ClassActions = new StatusVO();
        $this->database_settings = new DBVO();
//        $this->mailer_smtp_config = new SMTPVO();
        /* Create a new instance */
        $this->mailservice = new entity_emailer();
        $this->branding = new bwcfwDecoratorPattern();
        $this->leave_request_email_content_template = file_get_contents($this->branding->getServerBase() . "/../lib/leave.request.template.html");
        $this->leave_auth_email_content_template = file_get_contents($this->branding->getServerBase() . "/../lib/leave.auth.template.html");
        $this->leave_edit_email_content_template = file_get_contents($this->branding->getServerBase() . "/../lib/leave.edit.template.html");
        $this->leave_cancel_email_content_template = file_get_contents($this->branding->getServerBase() . "/../lib/leave.cancel.template.html");
    }

    /**
     *
     * @var integer This is the variable that contains the audit ID 
     */
    var $leave_audit_id;

    /**
     *
     * @var integer This is the ID of the leave request
     */
    var $leave_request_id;

    /**
     *
     * @var integer This is the size of the email content that was sent
     */
    var $leave_email_size = 0;

    /**
     *
     * @var integer This is the ID of the user who wants leave
     */
    var $leave_user_id;

    /**
     *
     * @var integer This is the ID of the status of the request
     */
    var $leave_request_status_id;

    /**
     *
     * @var string This is the Name of the status of the request
     */
    var $leave_request_status_name;

    /**
     *
     * @var string This is the comment for the entry
     */
    var $leave_comment;

    /**
     *
     * @var string This is the start date of the leave request 
     */
    var $leave_start_date;

    /**
     *
     * @var string This is the end date of the leave request
     */
    var $leave_end_date;

    /**
     *
     * @var string This is the original start date of the leave request 
     */
    var $leave_start_date_orig;

    /**
     *
     * @var string This is the original end date of the leave request 
     */
    var $leave_end_date_orig;

    /**
     *
     * @var integer This is the integer of the leave type
     */
    var $leave_type_id;

    /**
     *
     * @var string This is the name of the leave type
     */
    var $leave_type_name;

    /**
     *
     * @var string This is the data the request was submitted 
     */
    var $leave_submit_date;

    /**
     *
     * @var integer This is the Id of the person who submitted the request
     */
    var $leave_requestor_id;

    /**
     *
     * @var string This is the subject of the email to be sent 
     */
    var $leave_email_subject;

    /**
     * 
     * @return integer Get ID of the leave audit
     */
    function getLeaveAuditID() {
        return $this->leave_audit_id;
    }

    /**
     * 
     * @param integer $id Set ID of the leave audit
     */
    function setLeaveAuditID($id) {
        $this->leave_audit_id = $id;
    }

    /**
     * 
     * @return integer Get ID of the leave request
     */
    function getLeaveRequestID() {
        return $this->leave_request_id;
    }

    /**
     * 
     * @param integer $id Set ID of the leave request
     */
    function setLeaveRequestID($id) {
        $this->leave_request_id = $id;
    }

    /**
     * 
     * @return string Get the name of the leave requestor
     */
    function getLeaveRequestorName() {
        return $this->leave_requestor_name;
    }

    /**
     * 
     * @param string $name Set the name of the leave requestor
     */
    function setLeaveRequestorName($name) {
        $this->leave_requestor_name = $name;
    }

    /**
     * 
     * @return string Get the surname of the leave requestor
     */
    function getLeaveRequestorSurname() {
        return $this->leave_requestor_surname;
    }

    /**
     * 
     * @param string $surname Set the surname of the leave requestor
     */
    function setLeaveRequestorSurname($surname) {
        $this->leave_requestor_surname = $surname;
    }

    /**
     * 
     * @return integer Get ID of the leave audit user
     */
    function getLeaveUserID() {
        return $this->leave_user_id;
    }

    /**
     * 
     * @return string This is the subject of the email to be sent 
     */
    function getLeaveEmailSubject() {
        return $this->leave_email_subject;
    }

    /**
     * 
     * @param string $leave_email_subject This is the subject of the email to be sent 
     */
    function setLeaveEmailSubject($leave_email_subject) {
        $this->leave_email_subject = $leave_email_subject;
    }

    /**
     * 
     * @param integer $id Set ID of the leave audit user
     */
    function setLeaveUserID($id) {
        $this->leave_user_id = $id;
    }

    /**
     * 
     * @return integer Get ID of the leave audit status
     */
    function getLeaveRequestStatusID() {
        return $this->leave_request_status_id;
    }

    /**
     * 
     * @param integer $id Set ID of the leave audit status
     */
    function setLeaveRequestStatusID($id) {
        $this->leave_request_status_id = $id;
    }

    /**
     * 
     * @return string Get ID of the leave status
     */
    function getLeaveRequestStatusName() {
        return $this->leave_request_status_name;
    }

    /**
     * 
     * @param string $leave_request_status_name Set name of the leave status
     */
    function setLeaveRequestStatusName($leave_request_status_name) {
        $this->leave_request_status_name = $leave_request_status_name;
    }

    /**
     * 
     * @return integer Get comment of the leave audit
     */
    function getLeaveComment() {
        return $this->leave_comment;
    }

    /**
     * 
     * @param integer $comment Set comment of the leave audit
     */
    function setLeaveComment($comment) {
        $this->leave_comment = $comment;
    }

    /**
     * 
     * @return string This is email address of the person who requested the leave
     */
    function getLeaveRequestorAddress() {
        return $this->email_address_requestor;
    }

    /**
     * 
     * @param string $email_address_requestor This is email address of the person who requested the leave
     */
    function setLeaveRequestorAddress($email_address_requestor) {
        $this->email_address_requestor = $email_address_requestor;
    }

    /*     * ********************************************** */

    /**
     * 
     * @return string This is the start date of the leave request 
     */
    function getLeaveStartDate() {
        return $this->leave_start_date;
    }

    /**
     * 
     * @param string $leave_start_date This is the start date of the leave request
     */
    function setLeaveStartDate($leave_start_date) {
        $this->leave_start_date = $leave_start_date;
    }

    /**
     * 
     * @return string This is the end date of the leave request 
     */
    function getLeaveEndDate() {
        return $this->leave_end_date;
    }

    /**
     * 
     * @param string $leave_end_date This is the end date of the leave request
     */
    function setLeaveEndDate($leave_end_date) {
        $this->leave_end_date = $leave_end_date;
    }

    /**
     * 
     * @return string This is the original start date of the leave request 
     */
    function getLeaveStartDateOrig() {
        return $this->leave_start_date_orig;
    }

    /**
     * 
     * @param string $leave_start_date_orig This is the original start date of the leave request
     */
    function setLeaveStartDateOrig($leave_start_date_orig) {
        $this->leave_start_date_orig = $leave_start_date_orig;
    }

    /**
     * 
     * @return string This is the original end date of the leave request 
     */
    function getLeaveEndDateOrig() {
        return $this->leave_end_date_orig;
    }

    /**
     * 
     * @param string $leave_end_date_orig This is the original end date of the leave request
     */
    function setLeaveEndDateOrig($leave_end_date_orig) {
        $this->leave_end_date_orig = $leave_end_date_orig;
    }

    /**
     * 
     * @return integer This is the integer of the leave type
     */
    function getLeaveTypeID() {
        return $this->leave_type_id;
    }

    /**
     * 
     * @param integer $leave_type_id This is the integer of the leave type
     */
    function setLeaveTypeID($leave_type_id) {
        $this->leave_type_id = $leave_type_id;
    }

    /**
     * 
     * @return string This is the name of the leave type
     */
    function getLeaveTypeName() {
        return $this->leave_type_name;
    }

    /**
     * 
     * @param string $leave_type_name This is the name of the leave type
     */
    function setLeaveTypeName($leave_type_name) {
        $this->leave_type_name = $leave_type_name;
    }

    /**
     * 
     * @return string This is the original end date of the leave request 
     */
    function getLeaveSubmitDate() {
        return $this->leave_submit_date;
    }

    /**
     * 
     * @param string $leave_submit_date This is the data the request was submitted 
     */
    function setLeaveSubmitDate($leave_submit_date) {
        $this->leave_submit_date = $leave_submit_date;
    }

    /**
     * 
     * @return integer This is the integer of the leave type
     */
    function getLeaveRequestorID() {
        return $this->leave_requestor_id;
    }

    /**
     * 
     * @param integer $leave_requestor_id This is the ID of the person who submitted the request
     */
    function setLeaveRequestorID($leave_requestor_id) {
        $this->leave_requestor_id = $leave_requestor_id;
    }

    /**
     * 
     * @param string $old_field This is the original field's value
     * @param string $new_field This is the edited field's value
     * @return string This is the results but with 
     */
    function getFieldDiffHTML($old_field, $new_field) {
        if ($old_field !== $new_field) {
            return " <span class='diff_new'>" . $new_field . "</span> <span class='diff_old'>" . $old_field . "</span>";
        }
        return $new_field;
    }

    /**
     * 
     * @param string $value This is a value that needs to be changed for null
     * @return string This is formatted
     */
    function getFieldNAHTML($value) {
        if ($value) {
            return $value;
        }
        return "N/A";
    }

    function getLeaveStatusHTML($leave_status_id) {
        switch ($leave_status_id) {
            case "1":
                return " <span class='leave_status_pending'>Pending</span>";
            case "2":
                return " <span class='leave_status_approved'>Approved</span>";
            case "3":
                return " <span class='leave_status_declined'>Declined</span>";
            case "4":
                return " <span class='leave_status_cancelled'>Cancelled</span>";
            default:
                return " <span class='leave_status_unknown'>Unknown</span>";
        }
    }

    /**
     * 
     * @param string $leave_user_name Name of the person who has requested the leave
     * @param string $leave_start_date Starting date of the request leave
     * @param string $leave_end_date Ending date of the request leave
     * @param string $leave_type What type of leave has been requested
     * @param string $leave_comment Any comment to go with the request
     * @param string $leave_days_calc Calculated amount of days off
     */
    function setLeaveRequestEmailContent($leave_user_name, $leave_start_date, $leave_end_date, $leave_type, $leave_comment, $leave_url) {

        $datetime1 = new DateTime($leave_start_date);
        $datetime2 = new DateTime($leave_end_date);
        $interval = $datetime1->diff($datetime2);

        $this->leave_email_content = str_replace(
                array(
            "{leave_user_name}",
            "{leave_request_date}",
            "{leave_status}",
            "{leave_start_date}",
            "{leave_end_date}",
            "{leave_type}",
            "{leave_comment}",
            "{leave_days_calc}",
            "{leave_url}"
                ), array(
            $leave_user_name,
            date("Y/m/d G:i:s"),
            "Pending",
            $leave_start_date,
            $leave_end_date,
            $leave_type,
            $leave_comment,
            $interval->days + 1,
            $leave_url
                ), $this->leave_request_email_content_template);
    }

    /**
     * 
     * @param string $leave_user Name of the person who has requested the leave
     * @param string $leave_date When was the Leave request logged
     * @param string $leave_status What is the current status of the leave
     * @param string $leave_start_date Starting date of the request leave
     * @param string $leave_end_date Ending date of the request leave
     * @param string $leave_type What type of leave has been requested
     * @param string $leave_comment Any comment to go with the request
     */
    function setLeaveAuthEmailContent($leave_auth_name, $leave_start_date, $leave_end_date, $leave_type, $leave_comment, $leave_days, $leave_status, $auth_comment, $leave_user) {
        $this->leave_email_content = str_replace(
                array(
            "{leave_auth_name}",
            "{leave_request_date}",
            "{leave_status}",
            "{leave_start_date}",
            "{leave_end_date}",
            "{leave_type}",
            "{leave_comment}",
            "{leave_days_calc}",
            "{auth_comment}",
            "{leave_user}"
                ), array(
            $leave_auth_name,
            date("Y/m/d G:i:s"),
            $leave_status,
            $leave_start_date,
            $leave_end_date,
            $leave_type,
            $leave_comment,
            $leave_days,
            $auth_comment,
            $leave_user
                ), $this->leave_auth_email_content_template);
    }

    /**
     * 
     * @param datetime $leave_start_date This is the first date used for compare
     * @param datetime $leave_end_date This is the second date used for compare
     * @return integer
     */
    function getLeaveDateDiff($leave_start_date, $leave_end_date) {
        $datetime1 = new DateTime($leave_start_date);
        $datetime2 = new DateTime($leave_end_date);
        $interval = $datetime1->diff($datetime2);
        return $interval->days + 1;
    }

    /**
     * 
     * @param string $leave_user_name Name of the person who has requested the leave
     * @param string $leave_status What is the current status of the leave
     * @param string $leave_start_date Starting date of the request leave
     * @param string $leave_end_date Ending date of the request leave
     * @param string $leave_type What type of leave has been requested
     * @param string $leave_comment Any comment to go with the request
     * @param string $leave_days Amount of days taken
     * @param string $leave_url URL that user/admin can click on
     */
    function setLeaveEditEmailContent($leave_user_name, $leave_start_date, $leave_end_date, $leave_type, $leave_comment, $leave_days, $leave_url) {
        $this->leave_email_content = str_replace(
                array(
            "{leave_user_name}",
            "{leave_request_date}",
            "{leave_status}",
            "{leave_start_date}",
            "{leave_end_date}",
            "{leave_type}",
            "{leave_comment}",
            "{leave_days_calc}",
            "{leave_url}"
                ), array(
            $leave_user_name,
            date("Y/m/d G:i:s"),
            "Pending",
            $leave_start_date,
            $leave_end_date,
            $leave_type,
            $leave_comment,
            $leave_days,
            $leave_url
                ), $this->leave_edit_email_content_template);
    }

    /**
     * 
     * @return string This returns the content for the email 
     */
    function getLeaveEmailContent() {
        return $this->leave_email_content;
    }

    /**
     * 
     * @param string $leave_user_name Name of the person who has requested the leave
     * @param string $leave_start_date Starting date of the request leave
     * @param string $leave_end_date Ending date of the request leave
     * @param string $leave_type What type of leave has been requested
     * @param string $leave_comment Any comment to go with the request
     * @param string $leave_days amount of days taken
     * @param string $leave_status What is the current status of the leave
     */
    function setLeaveCancelEmailContent($leave_user_name, $leave_start_date, $leave_end_date, $leave_type, $leave_comment, $leave_days, $leave_status) {
        $this->leave_email_content = str_replace(
                array(
            "{leave_user_name}",
            "{leave_request_date}",
            "{leave_status}",
            "{leave_start_date}",
            "{leave_end_date}",
            "{leave_type}",
            "{leave_comment}",
            "{leave_days_calc}"
                ), array(
            $leave_user_name,
            date("Y/m/d G:i:s"),
            $leave_status,
            $leave_start_date,
            $leave_end_date,
            $leave_type,
            $leave_comment,
            $leave_days
                ), $this->leave_cancel_email_content_template);
    }

//    function setLeaveAuthAddresses() {
//        $leave_auth_addresses_status = new bwcfw_function_record();
//        if ($this->init_db()) {
    /* SQL - Query */
//            $leave_email_addresses_query = "SELECT a.user_username FROM tbl_base_users a, (SELECT b.fk_user FROM tbl_ae_user_roles b WHERE b.fk_role = 10) AS b WHERE a.fk_company = 1 AND a.fk_status = 1 AND a.id_user = b.fk_user;";
    /* SQL - Exec */
//            try {
//                $leave_email_addresses_stmt = $this->cdb->prepare($leave_email_addresses_query);
//                $leave_auth_addresses_status->status = $leave_email_addresses_stmt->execute();
//            } catch (PDOException $ex) {
    /* SQL - Error(s) */
//                $leave_auth_addresses_status->status = false;
//                $leave_auth_addresses_status->status_code = $ex->getMessage();
//            }
    /* SQL - Check if there are results */
//            if ($leave_auth_addresses_status->status) {
    /* SQL - Get results */
//                $leave_email_addresses_row = $leave_email_addresses_stmt->fetchAll();
//                if ($leave_email_addresses_row) {
//                    foreach ($leave_email_addresses_row as $key => $value) {
//                        array_push($this->email_address_auth_admin, $value['user_username']);
//                        $this->mail->addAddress($value['user_username']);
//                    }
//                } else {
    /* There were no results so set the status to false */
//                    $leave_auth_addresses_status->status = false;
//                    $leave_auth_addresses_status->status_code = "No data";
//                }
//            }
//        } else {
//            $leave_auth_addresses_status->status_code = $this->init_db()->status_code;
//            $leave_auth_addresses_status->status = false;
//        }
//        return $leave_auth_addresses_status;
//    }

    /**
     * 
     * @param integer $id This is the ID of the record to retrieve
     * @return \StatusVO Status of function
     */
    function setLeaveRecordFields($id) {
        $leave_record_fields_status = new StatusVO();
        if ($this->init_db()) {
            /* SQL - Query */
            $leave_record_fields_query = "SELECT c.id_user_leave,
       DATE_FORMAT(c.leave_start, '%Y-%m-%d') AS leave_start,
       DATE_FORMAT(c.leave_end, '%Y-%m-%d') AS leave_end,
       c.fk_user,
       c.fk_user_leave_type,
       c.comment,
       c.submit_date,
       c.fk_leave_requestor,
       DATE_FORMAT(c.leave_start_orig, '%Y-%m-%d') AS leave_start_orig,
       DATE_FORMAT(c.leave_end_orig, '%Y-%m-%d') AS leave_end_orig,
       c.fk_user_leave_status,
       d.leave_status,
       d.leave_status_description,
       e.leave_type,
       e.leave_type_description
  FROM (SELECT a.id_user_leave,
               a.leave_start,
               a.leave_end,
               a.fk_user,
               a.fk_user_leave_type,
               a.comment,
               a.submit_date,
               a.fk_leave_requestor,
               a.leave_start_orig,
               a.leave_end_orig,
               b.fk_user_leave_status
          FROM tbl_base_user_leave a,
               (SELECT ula.fk_user_leave, ula.fk_user_leave_status
                  FROM tbl_base_user_leave_audit ula
                       JOIN
                       (SELECT fk_user_leave,
                               MAX(user_leave_audit_date)
                                  user_leave_audit_date
                          FROM tbl_base_user_leave_audit
                        GROUP BY fk_user_leave) ulag
                          ON     ula.fk_user_leave = ulag.fk_user_leave
                             AND ula.user_leave_audit_date =
                                    ulag.user_leave_audit_date) AS b
         WHERE a.id_user_leave = :id AND a.id_user_leave = b.fk_user_leave)
       AS c,
       tbl_base_user_leave_type e,
       tbl_base_user_leave_status d
 WHERE     c.fk_user_leave_type = e.id_user_leave_type
       AND c.fk_user_leave_status = d.id_user_leave_status;";
            $leave_record_fields_query_params = array(
                ':id' => $id
            );
            /* SQL - Exec */
            try {
                $leave_record_fields_stmt = $this->cdb->prepare($leave_record_fields_query);
                $leave_record_fields_status->status = $leave_record_fields_stmt->execute($leave_record_fields_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("setLeaveRecordFields");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
            /* SQL - Check if there are results */
            if ($leave_record_fields_status->status) {
                /* SQL - Get results */
                $leave_record_fields_row = $leave_record_fields_stmt->fetch();
                if ($leave_record_fields_row) {
                    $this->leave_request_id = $leave_record_fields_row["id_user_leave"];
                    $this->leave_start_date = $leave_record_fields_row["leave_start"];
                    $this->leave_end_date = $leave_record_fields_row["leave_end"];
                    $this->leave_user_id = $leave_record_fields_row["fk_user"];
                    $this->leave_type_id = $leave_record_fields_row["fk_user_leave_type"];
                    $this->leave_comment = $leave_record_fields_row["comment"];
                    $this->leave_submit_date = $leave_record_fields_row["submit_date"];
                    $this->leave_requestor_id = $leave_record_fields_row["fk_leave_requestor"];
                    $this->leave_start_date_orig = $leave_record_fields_row["leave_start_orig"];
                    $this->leave_end_date_orig = $leave_record_fields_row["leave_end_orig"];
                    $this->leave_request_status_id = $leave_record_fields_row["fk_user_leave_status"];
                    $this->leave_request_status_name = $leave_record_fields_row["leave_status"];
                    $this->leave_type_name = $leave_record_fields_row["leave_type"];
                } else {
                    $this->ClassActions->setStatus(FALSE);
                    $this->ClassActions->setStatusCode("No data");
                }
            }
        }
        return $this->ClassActions;
    }

    /**
     * 
     * @return string This returns the addresses for the TO email field
     */
    function getLeaveToAddressStr() {
        return implode(", ", $this->email_to_address);
    }

    /**
     * 
     * @return string This returns the addresses for the CC email field
     */
    function getLeaveCcAddressStr() {
        return implode(", ", $this->email_cc_address);
    }

    /**
     * 
     * @return array This returns the address(es) for the CC email field  
     */
    function getLeaveCcAddress() {
        return $this->email_cc_address;
    }

    /**
     * 
     * @param string $value The value to the CC email field
     */
    function setLeaveCcAddress($value) {
        array_push($this->email_cc_address, $value);
        $this->mailservice->addCC($value);
    }

    function getLeaveToAddress() {
        return $this->email_to_address;
    }

    function setLeaveToAddress($exclude_id = '0') {
        if ($this->init_db()) {
            switch ($this->leave_request_status_id) {
                case 1:
                    /* Pending - Only email the AUTH_ADMINS */
                    /* SQL - Query */
                    $leave_email_addresses_query = "SELECT a.user_username AS email_address FROM tbl_base_users a, tbl_ae_user_roles b WHERE b.fk_role = 10 AND b.fk_user = a.id_user AND a.fk_company = :fk_company and b.fk_user <> :ex_user";
                    /* SQL - Params */
                    $leave_email_addresses_query_params = array(
                        ':fk_company' => 1,
                        ':ex_user' => $exclude_id
                    );
                    break;
                case 2:
                    /* APPROVED - Email the LEAVE_ADMINS */
                    /* SQL - Query */
                    $leave_email_addresses_query = "SELECT a.user_username AS email_address FROM tbl_base_users a, tbl_ae_user_roles b WHERE b.fk_role = 9 AND b.fk_user = a.id_user AND a.fk_company = :fk_company";
                    /* SQL - Params */
                    $leave_email_addresses_query_params = array(
                        ':fk_company' => 1
                    );
                    break;
                case 3:
                    /* CANCELLED - Only email the LEAVE_REQUESTOR */
                    /* SQL - Query */
                    $leave_email_addresses_query = "SELECT a.user_username AS email_address FROM tbl_base_users a, tbl_base_user_leave b WHERE b.fk_user = a.id_user AND a.fk_company = :fk_company AND b.id_user_leave = :fk_user_leave;";
                    /* SQL - Params */
                    $leave_email_addresses_query_params = array(
                        ':fk_company' => 1,
                        ':fk_user_leave' => $this->leave_request_id
                    );
                    break;
//                case 4:
                /* Other other status ID and we send it to the requestor only */
                /* SQL - Query */
//                    $leave_email_addresses_query = "SELECT a.user_username AS email_address FROM tbl_base_users a, tbl_base_user_leave b WHERE b.fk_user = a.id_user AND a.fk_company = :fk_company AND b.id_user_leave = :fk_user_leave;";
                /* SQL - Params */
//                    $leave_email_addresses_query_params = array(
//                        ':fk_company' => 1,
//                        ':fk_user_leave' => $this->leave_request_id
//                    );
//                    break;
                default:
                    /* Other - Email the requestor */
                    /* SQL - Query */
                    $leave_email_addresses_query = "SELECT a.user_username AS email_address FROM tbl_base_users a, tbl_base_user_leave b WHERE b.fk_user = a.id_user AND a.fk_company = :fk_company AND b.id_user_leave = :fk_user_leave;";
                    /* SQL - Params */
                    $leave_email_addresses_query_params = array(
                        ':fk_company' => 1,
                        ':fk_user_leave' => $this->leave_request_id
                    );
            }

            /* SQL - Exec */
            try {
                $leave_email_addresses_stmt = $this->cdb->prepare($leave_email_addresses_query);
                $leave_email_addresses_stmt->execute($leave_email_addresses_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("setLeaveRecordFields");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }

            if ($this->ClassActions->getStatus()) {
                $leave_email_addresses_row = $leave_email_addresses_stmt->fetchAll();
                if ($leave_email_addresses_row) {
                    foreach ($leave_email_addresses_row as $key => $value) {
                        array_push($this->email_to_address, $value['email_address']);
                        $this->mailservice->addAddress($value['email_address']);
                    }
                }
            }
        }
        return $this->ClassActions;
    }

    /**
     * This function inits the DB so that other functions can access the database and perform actions.
     * @return \StatusVO Lots of status
     */
    function init_db() {
        try {
            $this->cdb = new PDO("mysql:host={$this->database_settings->getHost()};dbname={$this->database_settings->getDataBase()};charset={$this->database_settings->getCharset()}", $this->database_settings->getUserName(), $this->database_settings->getPassword(), $this->database_settings->getDataBaseOptions());
        } catch (PDOException $ex) {
            $this->ClassActions->setStatus(FALSE);
            $this->ClassActions->setStatusCode("init DAO");
            $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->ClassActions->setLine($ex->getLine());
        }
        if ($this->ClassActions->getStatus()) {
            $this->cdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cdb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
    }

    /**
     * 
     * @return \bwcfw_function_record This adds an entry into the leave audit table
     */
    function leave_audit() {
        if ($this->init_db()) {
            /* SQL - Query */
            $leave_audit_query = "INSERT INTO tbl_base_user_leave_audit (fk_user_leave, fk_user, fk_user_leave_status, comment) VALUES (:fk_user_leave, :fk_user, :fk_user_leave_status, :comment);";
            /* SQL - Params */
            $leave_audit_query_params = array(
                ':fk_user_leave' => $this->leave_request_id,
                ':fk_user' => $this->leave_user_id,
                ':fk_user_leave_status' => $this->leave_request_status_id,
                ':comment' => $this->leave_comment
            );
            /* SQL - Exec */
            try {
                $leave_audit_stmt = $this->cdb->prepare($leave_audit_query);
                $leave_audit_stmt->execute($leave_audit_query_params);
            } catch (PDOException $ex) {
                $this->ClassActions->setStatus(FALSE);
                $this->ClassActions->setStatusCode("leave_audit_query");
                $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
                $this->ClassActions->setLine($ex->getLine());
            }
        }
        return $this->ClassActions;
    }

    /**
     * 
     * @return \StatusVO Status
     */
    function LeaveMailNotifications() {

        $this->mailservice->mailer->Subject = $this->getLeaveEmailSubject();
        $this->mailservice->mailer->msgHTML($this->getLeaveEditEmailContent());
        $this->mailservice->mailer->send();
        $this->mailservice->mailer->send();

        /* Email file operations */
//        $fn = $this->branding->getEmailsPath() . "/emails/" . $file_prefix . "." . microtime() . ".html";
//        file_put_contents($fn, $content);
//        $this->setLeaveEmailSize(filesize($fn));
//        return $this->ClassActions;
    }

}

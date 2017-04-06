<?php

class bwcfw_ticket_entity {

    var $TicketHeaderID;
    var $TicketOwnerID;
    var $FeedbackSupportUserID;
    var $FeedbackUserID;
    var $isInternalFeedback;
    var $TicketFeedbackDate;
    var $TicketFeedbackText;
    var $TicketTime = 0;
    var $TicketStatusID;
    var $SolutionTermID;

    function getTicketHeaderID() {
        return $this->TicketHeaderID;
    }

    function getTicketOwnerID() {
        return $this->TicketOwnerID;
    }

    function getFeedbackSupportUserID() {
        return $this->FeedbackSupportUserID;
    }

    function getFeedbackUserID() {
        return $this->FeedbackUserID;
    }

    function getIsInternalFeedback() {
        return $this->isInternalFeedback;
    }

    function getTicketFeedbackDate() {
        return $this->TicketFeedbackDate;
    }

    function getTicketFeedbackText() {
        return $this->TicketFeedbackText;
    }

    function getTicketTime() {
        return $this->TicketTime;
    }

    function getTicketStatusID() {
        return $this->TicketStatusID;
    }

    function getSolutionTermID() {
        return $this->SolutionTermID;
    }

    function setTicketHeaderID($TicketHeaderID) {
        $this->TicketHeaderID = $TicketHeaderID;
    }

    function setTicketOwnerID($TicketOwnerID) {
        $this->TicketOwnerID = $TicketOwnerID;
    }

    function setFeedbackSupportUserID($FeedbackSupportUserID) {
        $this->FeedbackSupportUserID = $FeedbackSupportUserID;
    }

    function setFeedbackUserID($FeedbackUserID) {
        $this->FeedbackUserID = $FeedbackUserID;
    }

    function setIsInternalFeedback($isInternalFeedback) {
        $this->isInternalFeedback = $isInternalFeedback;
    }

    function setTicketFeedbackDate($TicketFeedbackDate) {
        $this->TicketFeedbackDate = $TicketFeedbackDate;
    }

    function setTicketFeedbackText($TicketFeedbackText) {
        $this->TicketFeedbackText = $TicketFeedbackText;
    }

    function setTicketTime($TicketTime) {
        $this->TicketTime = $TicketTime;
    }

    function setTicketStatusID($TicketStatusID) {
        $this->TicketStatusID = $TicketStatusID;
    }

    function setSolutionTermID($SolutionTermID) {
        $this->SolutionTermID = $SolutionTermID;
    }

    /**
     *
     * @var object Database object 
     */
    var $cdb;

    /**
     *
     * @var \StatusVO Results from actions 
     */
    var $ticket_entity;

    /**
     *
     * @var \bwcfw_ticket_record Record of the ticket 
     */
    var $ticket_record;

    /**
     *
     * @var \DBVO 
     */
    var $database_settings;

    /**
     *
     * @var \StatusVO 
     */
    var $ClassActions;

    /**
     *
     * @var \new entity_emailer 
     */
    var $ticket_emailer;

    /**
     *
     * @var \email_msg_record 
     */
    var $ticket_email_record;

    /**
     *
     * @var \bwcfwDecoratorPattern
     */
    var $DecoratorPattern;

    /**
     * 
     * @param type $feedback_id
     */
    function __construct($feedback_id = FALSE) {
        $this->ticket_entity = new StatusVO();
        $this->ticket_record = new bwcfw_ticket_record();
        $this->database_settings = new DBVO();
        $this->ClassActions = new StatusVO();
        $this->ticket_emailer = new entity_emailer();
        $this->ticket_email_record = new email_msg_record();
        $this->DecoratorPattern = new bwcfwDecoratorPattern();
        $this->initDAO();
        if ($feedback_id) {
            $this->ticket_record->feedback_id = $feedback_id;
        }
        return $this->ClassActions;
    }

    private function initDAO() {
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
     * @param string $file_name_org
     * @param string $file_name_fs
     * @param integer $ticket_id
     * @param integer $company_id
     * @param integer $file_size
     * @param string $fk_ticket_header
     * @return \StatusVO
     */
    function TicketUploadFile($file_name_org, $file_name_fs, $ticket_id, $company_id, $file_size, $fk_ticket_header) {
        /* SQL - Query */
        $ticket_upload_file_query = "INSERT INTO tbl_base_ticket_attachments (ticket_attachment_name, ticket_attachment_size, ticket_attachment_fs_name, fk_ticket_feedback, fk_company, fk_ticket_header) VALUES (:file_name_org, :file_size, :file_name_fs, :ticket_id, :company_id, :ticket_header);";
        /* SQL - Params */
        $ticket_upload_file_query_params = array(
            ':file_name_org' => $file_name_org,
            ':file_name_fs' => $file_name_fs,
            ':ticket_id' => $ticket_id,
            ':company_id' => $company_id,
            ':file_size' => $file_size,
            ':ticket_header' => $fk_ticket_header
        );
        /* SQL - Exec */
        try {
            $ticket_upload_file_stmt = $this->cdb->prepare($ticket_upload_file_query);
            $ticket_upload_file_stmt->execute($ticket_upload_file_query_params);
//            $ticket_upload_file_ticket_id = $db->lastInsertId();
        } catch (PDOException $ex) {
            $this->ClassActions->setStatus(FALSE);
            $this->ClassActions->setStatusCode("role_add_stmt");
            $this->ClassActions->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->ClassActions->setLine($ex->getLine());
        }
        return $this->ClassActions;
    }

    /**
     * This function connects to the database and retrieves the data based on the feedback ID
     * @return \StatusVO
     */
    function getTicket() {
        $getTicket_status = new StatusVO();

        /* SQL - Query */
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
        /* SQL - Params */
        $get_ticket_details_query_params = array(
            ':feedback_id' => $this->feedback_id
        );
        /* SQL - Exec */
        try {
            $get_ticket_details_stmt = $this->cdb->prepare($get_ticket_details_query);
            $getTicket_status->status = $get_ticket_details_stmt->execute($get_ticket_details_query_params);
        } catch (PDOException $ex) {
            /* SQL - Error(s) */
            $getTicket_status->setStatusCode($ex->getMessage());
            $getTicket_status->setStatus(FALSE);
        }
        $get_ticket_details_row = $get_ticket_details_stmt->fetchall();
        if ($get_ticket_details_row) {
            $getTicket_status->setStatusCode("Data Returned");
        } else {
            $getTicket_status->setStatusCode("No data");
            $getTicket_status->setStatus(FALSE);
        }
        return $getTicket_status;
    }

    /**
     * 
     * @return \StatusVO
     */
    function setTicketFeedback() {
        /* Init function status */
        $TicketFeedbackStatus = new StatusVO();
        /* SQL - Query */
        $get_ticket_details_query = "INSERT INTO tbl_base_ticket_feedback(fk_ticket_header, fk_feedback_support_user, fk_feedback_user, ticket_isinternal_feedback, ticket_feedback_text, fk_ticket_owner) VALUES (:fk_ticket_header, :fk_feedback_support_user, :fk_feedback_user, :ticket_isinternal_feedback, :ticket_feedback_text, :fk_ticket_owner);";
        /* SQL - Params */
        $get_ticket_details_query_params = array(
            ':fk_ticket_header' => $this->ticket_record->getHeaderID(),
            ':fk_feedback_support_user' => $this->ticket_record->getFeedbackSupportUserID(),
            ':fk_feedback_user' => $this->ticket_record->getFeedbackUserID(),
            ':ticket_isinternal_feedback' => $this->ticket_record->getIsinternal_Feedback(),
            ':ticket_feedback_text' => $this->ticket_record->getFeedbackText(),
            ':fk_ticket_owner' => $this->ticket_record->getOwnerID()
        );
        /* SQL - Exec */
        try {
            $get_ticket_details_stmt = $this->cdb->prepare($get_ticket_details_query);
            $TicketFeedbackStatus->status = $get_ticket_details_stmt->execute($get_ticket_details_query_params);
            $this->ticket_record->setFeedbackID($this->cdb->lastInsertId());
        } catch (PDOException $ex) {
            /* SQL - Error Handling */
            $TicketFeedbackStatus->setStatus(FALSE);
            $TicketFeedbackStatus->setStatusCode("get_ticket_details_stmt");
            $TicketFeedbackStatus->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $TicketFeedbackStatus->setLine($ex->getLine());
        }
        return $TicketFeedbackStatus;
    }

    /**
     * 
     * @return \StatusVO
     */
    function setTicketFeedbackStoredProc() {
        /* Init function status */
        $TicketFeedbackStoredProcStatus = new StatusVO();
        /* SQL - Query */
        $Stored_Proc_Feedback_query = "CALL proc_ticket_feedback_padding(:id);";
        /* SQL - Params */
        $Stored_Proc_Feedback_query_params = array(
            ':id' => $this->ticket_record->getFeedbackID()
        );
        /* SQL - Exec */
        try {
            $Stored_Proc_Feedback_stmt = $this->cdb->prepare($Stored_Proc_Feedback_query);
            $TicketFeedbackStoredProcStatus->setStatus($Stored_Proc_Feedback_stmt->execute($Stored_Proc_Feedback_query_params));
        } catch (PDOException $ex) {
            /* SQL - Error Handling */
            $TicketFeedbackStoredProcStatus->setStatus(FALSE);
            $TicketFeedbackStoredProcStatus->setStatusCode("Stored_Proc_Feedback_stmt");
            $TicketFeedbackStoredProcStatus->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $TicketFeedbackStoredProcStatus->setLine($ex->getLine());
        }
        return $TicketFeedbackStoredProcStatus;
    }

    function eMailTicketFeedback($feedback_id) {
//        $email_metric = new entity_metrics();
        $email_feedback_status = new StatusVO();
        $fb_email = new email_msg_record();
        $mailer = new entity_emailer();

        /* SQL - Query */
        $get_ticket_feedback_query = "SELECT tfbp.fk_ticket_header AS ticket_id, tfbp.fk_ticket_owner, tfbp.fk_feedback_support_user, tfbp.fk_feedback_user, tfbp.ticket_isinternal_feedback, tfbp.ticket_feedback_date, tfbp.ticket_feedback_text, tfbp.ticket_status, tfbp.ticket_status_description, tfbp.to_id, tfbp.to_username, tfbp.to_name, tfbp.to_surname, tfbp.fbu_username, tfbp.fbu_name, tfbp.fbu_surname, tfbp.fbu_company_id, tfbp.su_username, tfbp.su_name, tfbp.su_surname, tfbp.ticket_type_name, tfbp.ticket_type_description, tfbp.severity_name, tfbp.severity_description, tfbp.company_name, tfbp.company_description, tfbp.ticket_header_description, tfbp.ticket_header_cdate, tfbp.st_email FROM tbl_base_ticket_feedback_padded tfbp WHERE tfbp.id_tbl_base_ticket_feedback = :fb_id;";
        /* SQL - Params */
        $get_ticket_feedback_query_params = array(
            ':fb_id' => $feedback_id
        );
        /* SQL - Exec */
        try {
            $get_ticket_feedback_stmt = $this->cdb->prepare($get_ticket_feedback_query);
            $get_ticket_feedback_stmt->execute($get_ticket_feedback_query_params);
        } catch (PDOException $ex) {
            /* SQL - error(s) */
            $email_feedback_status->setStatus(FALSE);
            $email_feedback_status->setStatusCode("get_ticket_feedback_stmt");
            $email_feedback_status->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $email_feedback_status->setLine($ex->getLine());
        }
        /* SQL - Result(s) */
        if ($email_feedback_status->getStatus()) {
            $get_ticket_feedback_row = $get_ticket_feedback_stmt->fetch();
            if ($get_ticket_feedback_row) {
                $feedback_array = $get_ticket_feedback_row;
                $email_feedback_status->setStatusCode("We have data.");
            } else {
                $email_feedback_status->setStatus(FALSE);
                $email_feedback_status->setStatusCode("No record(s) found.");
            }
        }
        /* Setup vars for the email */
        if ($email_feedback_status->getStatus()) {
            /* Init the mailer */
            /* Set the "from" header */
//            $fb_email->from_name = $bwcfwnoreply_name;
//            $fb_email->from_email = $bwcfwnoreply_address;
            /* To whom does the feedback go to: all or team */
            if ($feedback_array['fbu_company_id'] === 1) {
                if ($feedback_array['ticket_isinternal_feedback'] === 0) {
                    /* If not internal FB then "TO" the client */
                    $mailer->mailer->addAddress($feedback_array['to_username']);
                }
                /* CC the TEAM */
                $mailer->mailer->addCC($feedback_array['st_email']);
            } else {
                /* "TO" the TEAM  */
                $mailer->mailer->addAddress($feedback_array['st_email']);
                /* "CC" the client */
                $mailer->mailer->addCC($feedback_array['to_username']);
            }
            /* Subject */
            $fb_email->subject = $this->DecoratorPattern->getShortSiteName() . " - Feedback: " . $feedback_array['ticket_header_description'];
            /* Get feedback template */
            $template = file_get_contents($this->DecoratorPattern->getServerBase() . "/../lib/feedback.template.html");
            $email_msg = str_replace(
                    array(
                "{fb_user}",
                "{fb_date}",
                "{fb_status}",
                "{fb_text}",
                "{fb_reply}",
                "{to_user}",
                "{fb_first_date}",
                "{fb_type}",
                "{fb_severity}",
                "{fb_header}"
                    ), array(
                $feedback_array['fbu_name'] . " " . $feedback_array['fbu_surname'],
                $feedback_array['ticket_feedback_date'],
                $feedback_array['ticket_status'],
                $feedback_array['ticket_feedback_text'],
                "Enter new feedback <a href = '" . $this->DecoratorPattern->getBaseURL() . "/bwcfw/ms/calls/feedback/ticket/" . $feedback_array['ticket_id'] . "' > External</a>&nbsp;
                <a href = '" . $this->DecoratorPattern->getBaseURLInternal() . "/bwcfw/ms/calls/feedback/ticket/" . $feedback_array['ticket_id'] . "' > Internal</a>",
                $feedback_array['to_name'] . " " . $feedback_array['to_surname'],
                $feedback_array['ticket_header_cdate'],
                $feedback_array['ticket_type_name'],
                $feedback_array['severity_name'],
                $feedback_array['ticket_header_description']
                    ), $template);

//            $fb_email->main_msg = $email_msg;
            $mailer->mailer->msgHTML($email_msg);
//            $this->mailer->msgHTML($msg_content->getEmailContent());
            /* We write the body of the email to disk in order to review it later on */
            $fn = $this->DecoratorPattern->getEmailsPath() . "/feedback." . microtime() . " . html";
            file_put_contents($fn, $email_msg);
            /* Send the email out */
            $mailer->bwcfw_emailer();
//            $email_feedback_status = mailer_smtp($fb_email);
//            $email_metric->metrics_email("feedback", $fb_email->to_email, $fb_email->cc_email, $fb_email->bcc_email, filesize($fn), $email_feedback_status->status_str(), $email_feedback_status->status_code, $feedback_array['ticket_id'], $feedback_id);
        }

        return $email_feedback_status;
    }

}

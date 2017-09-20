<?php

/**
 * voEmailer
 * Class to contain all the variables needed in order to send emails
 */
class voEmailer
{

    /**
     * @var string This is the "type" of email that was sent; "feedback" or "invite" or "request"
     */
    private $email_type;

    /**
     * @var string This is the "to" field that is usually used in emails
     */
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
    function setEmailType($email_type)
    {
        $this->email_type = $email_type;
    }

    /**
     * 
     * @param string $email_to This is the "to" field that is usually used in emails
     */
    function setEmailTo($email_to)
    {
        $this->email_to = $email_to;
    }

    /**
     * 
     * @param string $email_cc This is the "cc" field that is usually used in emails
     */
    function setEmailCc($email_cc)
    {
        array_push($this->email_cc, $email_cc);
    }

    /**
     * 
     * @param string $email_bcc This is the "bcc" field that is usually used in emails
     */
    function setEmailBcc($email_bcc)
    {
        array_push($this->email_bcc, $email_bcc);
    }

    /**
     * 
     * @param integer $email_size This is the size of the main body of the email
     */
    function setEmailSize($email_size)
    {
        $this->email_size = $email_size;
    }

    /**
     * 
     * @param boolean $email_status This is the status of when the email was sent; "true" or "false"
     */
    function setEmailStatus($email_status)
    {
        $this->email_status = $email_status;
    }

    /**
     * 
     * @param type $email_extended_data This field represents the extended error information
     */
    function setEmailExtendedData($email_extended_data)
    {
        $this->email_extended_data = $email_extended_data;
    }

    /**
     * 
     * @param string $email_subject This is the subject matter for the email 
     */
    function setEmailSubject($email_subject)
    {
        $this->email_subject = $email_subject;
    }

    /**
     * 
     * @param string $email_content This is the contents of the email
     */
    function setEmailContent($email_content)
    {
        $this->email_content = $email_content;
    }

    /**
     * 
     * @return string This is the "type" of email that was sent; "feedback" or "invite" or "request"
     */
    function getEmailType()
    {
        return $this->email_type;
    }

    /**
     * 
     * @return array This is the "to" field that is usually used in emails
     */
    function getEmailTo()
    {
        return $this->email_to;
    }

    /**
     * 
     * @return array This is the "cc" field that is usually used in emails
     */
    function getEmailCc()
    {
        return $this->email_cc;
    }

    /**
     * 
     * @return array This is the "bcc" field that is usually used in emails
     */
    function getEmailBcc()
    {
        return $this->email_bcc;
    }

    /**
     * 
     * @return integer This is the size of the main body of the email
     */
    function getEmailSize()
    {
        return $this->email_size;
    }

    /**
     * 
     * @return boolean This is the status of when the email was sent; "true" or "false"
     */
    function getEmailStatus()
    {
        return $this->email_status;
    }

    /**
     * 
     * @return string This field represents the extended error information
     */
    function getEmailExtendedData()
    {
        return $this->email_extended_data;
    }

    /**
     * 
     * @return string This is the subject matter for the email
     */
    function getEmailSubject()
    {
        return $this->email_subject;
    }

    /**
     * 
     * @return string This is the contents of the email
     */
    function getEmailContent()
    {
        return $this->email_content;
    }

    /**
     * 
     * @return string This is the from name
     */
    function getEmailFromName()
    {
        return $this->email_from_name;
    }
}

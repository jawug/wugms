<?php

class entity_emailer {

    /**
     *
     * @var integer This is the ID of the original leave/user/feedback type 
     */
    private $id;

    /**
     *
     * @var string This is the type of email sent; leave/invite/feedback 
     */
    private $type;

    /**
     *
     * @var string This is the subject of the email
     */
    private $subject;

    /**
     *
     * @var string This is the contents of the email
     */
    private $email_contents;

    function setMID($id) {
        $this->id = $id;
    }

    function getMID() {
        return $this->id;
    }

    function setMSubject($subject) {
        $this->subject = $subject;
    }

    function getMSubject() {
        return $this->subject;
    }

    function setMContents($email_contents) {
        $this->email_contents = $email_contents;
    }

    function getMContents() {
        return $this->email_contents;
    }

    function setMType($type) {
        $this->type = $type;
    }

    function getMType() {
        return $this->type;
    }

    /**
     * 
     * @return integer This is the size of the email content that was sent
     */
    function getLeaveEmailSize() {
        return $this->leave_email_size;
    }

    /**
     * 
     * @param integer $leave_email_size This is the size of the email content that was sent
     */
    function setLeaveEmailSize($leave_email_size) {
        $this->leave_email_size = $leave_email_size;
    }

    /**
     *
     * @var \PHPMailer
     */
    public $mailer;

    /**
     *
     * @var \bwcfwDecoratorPattern 
     */
    public $DecoratorPattern;

    /**
     *
     * @var \StatusVO
     */
    var $ClassActions;

    /**
     *
     * @var \SMTPVO
     */
    var $mailer_smtp_config;

    function __construct() {
        require_once 'phpmailer/PHPMailerAutoload.php';
        $this->ClassActions = new StatusVO();
        $this->mailer_smtp_config = new SMTPVO();
        $this->DecoratorPattern = new bwcfwDecoratorPattern();
        $this->mailer = new PHPMailer(true);
    }

    /**
     * 
     * @param /email_msg_record $msg_content This contains all of the information 
     * @return /StatusVO
     */
    function bwcfw_emailer() {
        try {
            $this->mailer->isSMTP();
            $this->mailer->SMTPDebug = 1;
            $this->mailer->Debugoutput = 'error_log';
            $this->mailer->Host = $this->mailer_smtp_config->getSMTPHost();
            $this->mailer->Port = $this->mailer_smtp_config->getSMTPPort();
            $this->mailer->SMTPSecure = $this->mailer_smtp_config->getSMTPSecure();
            $this->mailer->SMTPAuth = $this->mailer_smtp_config->getSMTPAuth();
            $this->mailer->Username = $this->mailer_smtp_config->getSMTPUsername();
            $this->mailer->Password = $this->mailer_smtp_config->getSMTPPassword();
            $this->mailer->setFrom($this->mailer_smtp_config->getNoreplyAddress(), $this->mailer_smtp_config->getNoreplyName());
//            $this->mailer->addAddress($msg_content->getEmailTo());
//            echo PHP_EOL;
//            var_dump($msg_content);
            //echo $msg_content->getEmailTo();
//            echo PHP_EOL;
//            $this->mailer->addCC($msg_content->getEmailCc());
//            $this->mailer->addBCC($msg_content->getEmailBcc());
//            $this->mailer->Subject = $msg_content->getEmailSubject();
//            $this->mailer->msgHTML($msg_content->getEmailContent());
            $this->mailer->Timeout = 5;
            $this->mailer->AltBody = 'This is a plain-text message body';
            $this->ClassActions->setStatus($this->mailer->send());
        } catch (phpmailerException $e) {
            $this->ClassActions->setStatus(FALSE);
            $this->ClassActions->setStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $e->getMessage())));
            $this->ClassActions->setLine($e->getLine());
        }
        if ($this->ClassActions->getStatus()) {
            $this->WriteEmailToDisk();
            $this->EmailAuditMetric();
        }
        return $this->ClassActions;
    }

    private function WriteEmailToDisk() {
        $fn = $this->DecoratorPattern->getEmailsPath() . $this->getMType() . "." . microtime() . ".html";
        file_put_contents($fn, $this->getMContents());
        $this->setLeaveEmailSize(filesize($fn));
    }

    private function EmailAuditMetric() {
        
    }

}

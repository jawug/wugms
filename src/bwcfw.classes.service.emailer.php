<?php

class serviceEmailer
{

    /**
     *
     * @var \LoggingService Logging Service 
     */
    private $configuration;

    function setMSubject($subject)
    {
        $this->subject = $subject;
    }

    function getMSubject()
    {
        return $this->subject;
    }

    function setMContents($email_contents)
    {
        $this->email_contents = $email_contents;
    }

    function getMContents()
    {
        return $this->email_contents;
    }

    function setMType($type)
    {
        $this->type = $type;
    }

    function getMType()
    {
        return $this->type;
    }

    /**
     * 
     * @return integer This is the size of the email content that was sent
     */
    function getLeaveEmailSize()
    {
        return $this->leave_email_size;
    }

    /**
     * 
     * @param integer $leave_email_size This is the size of the email content that was sent
     */
    function setLeaveEmailSize($leave_email_size)
    {
        $this->leave_email_size = $leave_email_size;
    }

    /**
     *
     * @var \PHPMailer
     */
    public $mailer;

    /**
     *
     * @var \entityConfiguration 
     */
    public $DecoratorPattern;

    /**
     *
     * @var \voStatus
     */
    var $ClassActions;

    /**
     *
     * @var \voSMTP
     */
    var $mailer_smtp_config;

    function __construct()
    {
        $this->configuration = new LoggingService(false, false, false, true);
        require_once $this->configuration->getVendorPath() . 'phpmailer/phpmailer/PHPMailerAutoload.php';
        $this->ClassActions = new voStatus();
        $this->mailer_smtp_config = new voSMTP();
        $this->mailer = new PHPMailer(true);
    }

    /**
     * 
     * @param /voEmailer $msg_content This contains all of the information 
     * @return /voStatus
     */
    function bwcfw_emailer()
    {
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
            $this->mailer->Timeout = 5;
            $this->mailer->AltBody = 'This is a plain-text message body';
            $this->ClassActions->setStatus($this->mailer->send());
        } catch (phpmailerException $e) {
            $this->ClassActions->setStatus(false);
            $this->ClassActions->setStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $e->getMessage())));
            $this->ClassActions->setLine($e->getLine());
        }
        if ($this->ClassActions->getStatus()) {
            $this->WriteEmailToDisk();
            $this->EmailAuditMetric();
        }
        return $this->ClassActions;
    }

    private function WriteEmailToDisk()
    {
        $fn = $this->DecoratorPattern->getEmailsPath() . $this->getMType() . "." . microtime() . ".html";
        file_put_contents($fn, $this->getMContents());
        $this->setLeaveEmailSize(filesize($fn));
    }

    private function EmailAuditMetric()
    {
        
    }
}

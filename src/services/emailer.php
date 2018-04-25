<?php

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//
//require_once $this->getVendorPath() . 'phpmailer/phpmailer/src/Exception.php';
//require_once $this->getVendorPath() . 'phpmailer/phpmailer/src/PHPMailer.php';
//require_once $this->getVendorPath() . 'phpmailer/phpmailer/src/SMTP.php';


class ServiceEmailer extends LoggingService
{

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    private function getSubject()
    {
        return $this->subject;
    }

    public function setContents($email_contents)
    {
        $this->email_contents = $email_contents;
    }

    private function getContents()
    {
        return $this->email_contents;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    private function getType()
    {
        return $this->type;
    }

    /**
     *
     * @return integer This is the size of the email content that was sent
     */
    private function getLeaveEmailSize()
    {
        return $this->leave_email_size;
    }

    /**
     *
     * @param integer $leave_email_size This is the size of the email content that was sent
     */
    public function setLeaveEmailSize($leave_email_size)
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
     * @var \voStatus
     */
    private $ClassActions;

    /**
     *
     * @var \voSMTP
     */
    private $mailer_smtp_config;

    public function __construct()
    {
        parent::__construct();
// require_once $this->getVendorPath() . 'phpmailer/phpmailer/PHPMailerAutoload.php';




        $this->ClassActions = new voStatus();
        $this->mailer_smtp_config = new voSMTP();
   //     $this->mailer = new PHPMailer(true);
    }

    /**
     *
     * @param /voEmailer $msg_content This contains all of the information
     * @return /voStatus
     */
    public function MailerSend()
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
            $this->ClassActions->setStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $e->getessage())));
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
        $fn = $this->DecoratorPattern->getEmailsPath() . $this->getType() . "." . microtime() . ".html";
        file_put_contents($fn, $this->getContents());
        $this->setLeaveEmailSize(filesize($fn));
    }
//    private function EmailAuditMetric()
//    {
//
//    }
}

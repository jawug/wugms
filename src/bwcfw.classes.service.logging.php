<?php

/**
 *
 */
class LoggingService extends entityConfiguration
{

    /**
     *
     * @var \Logger
     */
    public $logger;

    /**
     *
     * @param integer $level
     * @param string $area
     * @param string $StatusStr
     * @param string $StatusCode
     * @param string $ExtendedStatusCode
     * @param integer $line
     */
    public function LogBasicEntry($level = 1, $area = '', $StatusStr = '', $StatusCode = '', $ExtendedStatusCode = '', $line = '')
    {
        switch ($level) {
            case 1:
                /* info */
                $this->logger->info('[' . $area . '] -> ' . $StatusStr . ' ;; Status: ' . $StatusCode);
                break;
            case 2:
                /* debug */
                $this->logger->debug('[' . $area . '] -> ' . $StatusStr . ' ;; Status: ' . $StatusCode . ' ;; Extended Status: ' . $ExtendedStatusCode . ' ;; Line: ' . $line);
                break;
            case 3:
                /* error */
                $this->logger->error('[' . $area . '] -> ' . $StatusStr . ' ;; Status: ' . $StatusCode . ' ;; Extended Status: ' . $ExtendedStatusCode . ' ;; Line: ' . $line);
                break;
            default:
                /* debug */
                $this->logger->debug('[' . $area . '] -> ' . $StatusStr . ' ;; Status: ' . $StatusCode . ' ;; Extended Status: ' . $ExtendedStatusCode . ' ;; Line: ' . $line);
        }
    }

    /**
     * This starts up the logging sub section
     */
    public function __construct($area = null)
    {
        parent::__construct();
        require_once($this->getVendorPath() . '/apache/log4php/src/main/php/Logger.php');
        Logger::configure(array(
            'rootLogger' => array(
                'appenders' => array('default'),
            ),
            'appenders' => array(
                'default' => array(
                    'class' => 'LoggerAppenderRollingFile',
                    'layout' => array(
                        'class' => 'LoggerLayoutPattern',
                        'params' => array(
                            'conversionPattern' => '%date{Y-m-d H:i:s,u} [%logger] %-5level %msg%n'
                        )
                    ),
                    'params' => array(
                        'file' => $this->getLogPath() . strtolower($this->getAppName()) . '.log',
                        'append' => true,
                        'maxFileSize' => '1MB',
                        'maxBackupIndex' => 10
                    )
                )
            )
        ));
        if ($area) {
            $this->logger = Logger::getLogger($area);
        } else {
            $this->logger = Logger::getLogger($this->getAppName());
        }
    }
}

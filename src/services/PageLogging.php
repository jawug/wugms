<?php

namespace wugms\services;

class PageLogging extends Logging
{

    /**
     *
     * @var wugms\valueobjects\Status
     */
    public $PageActions;

    /**
     *
     * @var \voFileRecord
     */
    public $PageData;

    /**
     *
     * @var integer The logging level to be used
     */
    //  private $logging_level;

    /**
     *
     * @var \ServiceDAO
     */
    public $ServiceDAO;

    /**
     *
     * @var \AuditHandOver
     */
    public $page_metric;

    public function __construct($fn = false, $isEnableDAO = false)
    {
        parent::__construct();
        $this->PageActions = new \wugms\valueobjects\Status();
        $this->PageData = new \wugms\valueobjects\FileRecord($fn);
        $this->initDAO($isEnableDAO);
        $this->page_metric = new \wugms\services\AuditHandOver();
    }

    /**
     *
     * @param integer $level This is the level of logging for pages
     */
    public function LogPageEntry($level)
    {
        switch ($level) {
            case 1:
                /* info */
                $this->logger->info('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode());
                break;
            case 2:
                /* debug */
                $this->logger->debug('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode() . ' ;; Extended Status: ' . $this->PageActions->getExtendedStatusCode() . ' ;; Line: ' . $this->PageActions->getLine());
                break;
            case 3:
                /* error */
                $this->logger->error('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode() . ' ;; Extended Status: ' . $this->PageActions->getExtendedStatusCode() . ' ;; Line: ' . $this->PageActions->getLine());
                break;
            default:
                /* debug */
                $this->logger->debug('[' . $this->PageData->getFileName() . '] -> ' . $this->PageActions->getStatusStr() . ' ;; Status: ' . $this->PageActions->getStatusCode() . ' ;; Extended Status: ' . $this->PageActions->getExtendedStatusCode() . ' ;; Line: ' . $this->PageActions->getLine());
        }
    }

    public function initDAO($isEnableDAO)
    {
        $this->ServiceDAO = new \wugms\services\DAO($isEnableDAO);
    }
}

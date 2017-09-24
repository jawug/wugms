<?php

class ServiceDAO extends LoggingService
{

    /**
     *
     * @var \PDO This the main DAO object
     */
    public $ServicePDO;

    /**
     *
     * @var \voStatus
     */
    private $classStatus;

    /**
     *
     * @var \voDAO
     */
    private $configDAO;

    /**
     *
     * @var string
     */
    private $serverdatetime = "";

    /**
     *
     * @var boolean
     */
    private $daostatus = false;

    /**
     *
     * @return string
     */
    public function getServerDateTime()
    {
        return $this->serverdatetime;
    }

    /**
     *
     * @param string $serverdatetime
     */
    private function setServerDateTime($serverdatetime)
    {
        $this->serverdatetime = $serverdatetime;
    }

    public function getDAOStatus()
    {
        return $this->daostatus;
    }

    public function getDAOStatusCode()
    {
        return $this->daostatuscode;
    }

    /**
     *
     * @param string $daostatus
     */
    private function setDAOStatus($daostatus)
    {
        $this->daostatus = $daostatus;
    }

    /**
     *
     * @param string $daostatuscode
     */
    private function setDAOStatusCode($daostatuscode)
    {
        $this->daostatuscode = $daostatuscode;
    }

    /**
     *
     * @var string This is the schema name that was used when we connected to the DB
     */
    private $DAO_Schema;

    public function getDAOSchema()
    {
        return $this->DAO_Schema;
    }

    /**
     *
     * @param string $DAO_Schema
     */
    private function setDAOSchema($DAO_Schema)
    {
        $this->daostatus = $DAO_Schema;
    }

    public function checkDAO()
    {
        $dao_test_connection_query = "SELECT now() as value from dual where 1 = :id";
        $dao_test_connection_query_params = array(
            ':id' => 1
        );
        $status = $this->ServicePDO->getAttribute(PDO::ATTR_CONNECTION_STATUS);
        /* SQL - Exec */
        try {
            $dao_test_connection_stmt = $this->ServicePDO->prepare($dao_test_connection_query);
            $dao_test_connection_stmt->execute($dao_test_connection_query_params);
        } catch (PDOException $ex) {
            /* SQL - Error Handling */
            $this->classStatus->setStatus(false);
            $this->classStatus->setStatusCode("dao_test_connection_stmt");
            $this->classStatus->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->classStatus->setLine($ex->getLine());
            $this->LogBasicEntry(3, get_class($this->ServiceDAO), $this->classStatus->getStatusStr(), $this->classStatus->getStatusCode(), $this->classStatus->getExtendedStatusCode(), $this->classStatus->getLine());
        }
        if ($this->classStatus->getStatus()) {
            $dao_test_connection_row = $dao_test_connection_stmt->fetch();
            if ($dao_test_connection_row) {
                $this->setServerDateTime($dao_test_connection_row["value"]);
            }
        }
        $results = array("rstatus" => $this->classStatus, "status" => $status, "datetime" => $this->datetime, "voDAO" => $this->configDAO);
        return $results;
    }

    /**
     *
     * @return \voStatus
     */
    public function initDAO()
    {
        try {
            $this->ServicePDO = new PDO("mysql:host={$this->configDAO->getHost()};dbname={$this->configDAO->getDataBase()};charset={$this->configDAO->getCharset()}", $this->configDAO->getUserName(), $this->configDAO->getPassword(), $this->configDAO->getDataBaseOptions());
        } catch (PDOException $ex) {
            $this->classStatus->setStatus(false);
            $this->classStatus->setStatusCode("failed to init DAO");
            $this->classStatus->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->classStatus->setLine($ex->getLine());
        }
        if ($this->classStatus->getStatus()) {
            $this->ServicePDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->ServicePDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->classStatus->setStatusCode("DAO has been init");
            $this->setDAOSchema($this->configDAO->getDatabase());
        }
        $this->LogBasicEntry((($this->classStatus->getStatus()) ? 2 : 3), get_class($this->ServicePDO), $this->classStatus->getStatusStr(), $this->classStatus->getStatusCode(), $this->classStatus->getExtendedStatusCode(), $this->classStatus->getLine());
        $this->setDAOStatus($this->classStatus->getStatus());
        $this->setDAOStatusCode($this->classStatus->getStatusCode());
    }

    public function __construct($init = true)
    {
        parent::__construct();
        $this->configDAO = new voDAO();
        $this->classStatus = new voStatus();
        if ($init) {
            $this->initDAO();
        }
    }
}

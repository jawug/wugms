<?php

class serviceDAO extends LoggingService
{

    /**
     *
     * @var \PDO This the main DAO object 
     */
    var $serviceDAO;

    /**
     *
     * @var \voStatus 
     */
    var $classStatus;

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
    function getServerDateTime()
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

    function getDAOStatus()
    {
        return $this->daostatus;
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
     * @var string This is the schema name that was used when we connected to the DB 
     */
    private $DAO_Schema;

    function getDAOSchema()
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

    function checkDAO()
    {
        $dao_test_connection_query = "SELECT now() as value from dual where 1 = :id";
        $dao_test_connection_query_params = array(
            ':id' => 1
        );
        $status = $this->serviceDAO->getAttribute(PDO::ATTR_CONNECTION_STATUS);
        /* SQL - Exec */
        try {
            $dao_test_connection_stmt = $this->serviceDAO->prepare($dao_test_connection_query);
            $dao_test_connection_stmt->execute($dao_test_connection_query_params);
        } catch (PDOException $ex) {
            /* SQL - Error Handling */
            $this->classStatus->setStatus(false);
            $this->classStatus->setStatusCode("dao_test_connection_stmt");
            $this->classStatus->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->classStatus->setLine($ex->getLine());
            $this->LogBasicEntry(3, get_class($this->serviceDAO), $this->classStatus->getStatusStr(), $this->classStatus->getStatusCode(), $this->classStatus->getExtendedStatusCode(), $this->classStatus->getLine());
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
    function initDAO()
    {
        try {
            $this->serviceDAO = new PDO("mysql:host={$this->configDAO->getHost()};dbname={$this->configDAO->getDataBase()};charset={$this->configDAO->getCharset()}", $this->configDAO->getUserName(), $this->configDAO->getPassword(), $this->configDAO->getDataBaseOptions());
        } catch (PDOException $ex) {
            $this->classStatus->setStatus(false);
            $this->classStatus->setStatusCode("init DAO");
            $this->classStatus->setExtendedStatusCode(htmlspecialchars(str_replace(PHP_EOL, '', $ex->getMessage())));
            $this->classStatus->setLine($ex->getLine());
            $this->LogBasicEntry(3, get_class($this->serviceDAO), $this->classStatus->getStatusStr(), $this->classStatus->getStatusCode(), $this->classStatus->getExtendedStatusCode(), $this->classStatus->getLine());
        }
        if ($this->classStatus->getStatus()) {
            $this->serviceDAO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->serviceDAO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setDAOSchema($this->configDAO->getDatabase());
            $this->LogBasicEntry(2, get_class($this->serviceDAO), $this->classStatus->getStatusStr(), $this->classStatus->getStatusCode(), $this->classStatus->getExtendedStatusCode(), $this->classStatus->getLine());
        }
        $this->setDAOStatus($this->classStatus->getStatus());
//        return $this->classStatus;
    }

    function __construct($init = true)
    {
        parent::__construct();
        $this->configDAO = new voDAO();
        $this->classStatus = new voStatus();
        if ($init) {
            $this->initDAO();
        }
    }
}

<?php
namespace wugms\valueobjects;

class Status
{

    /**
     *
     */
    function __construct()
    {
        $this->setStatus(true);
        $this->setStatusCode("N/A");
        $this->setExtendedStatusCode("N/A");
        $this->setLine("N/A");
    }

    /**
     * This function evaluates the variable @Status and returns a simple value
     * @return string
     */
    public function getStatusStr()
    {
        return ($this->Status) ? "ok" : "error";
    }

    /**
     *
     * @param boolean $Status This indicates if there is a problem or not
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    /**
     *
     * @return boolean This indicates if there is a problem or not
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     *
     * @param string $StatusCode This provides a more detailed status of what went wrong
     */
    public function setStatusCode($StatusCode)
    {
        $this->StatusCode = $StatusCode;
    }

    /**
     *
     * @return string This provides a more detailed status of what went wrong
     */
    public function getStatusCode()
    {
        return $this->StatusCode;
    }

    /**
     *
     * @param string $ExtendedStatusCode This provides a more detailed status of what went wrong
     */
    public function setExtendedStatusCode($ExtendedStatusCode)
    {
        $this->ExtendedStatusCode = $ExtendedStatusCode;
    }

    /**
     *
     * @return string This provides a more detailed status of what went wrong
     */
    public function getExtendedStatusCode()
    {
        return $this->ExtendedStatusCode;
    }

    /**
     *
     * @param string $Line This indicates the line where the error occured
     */
    public function setLine($Line)
    {
        $this->Line = $Line;
    }

    /**
     *
     * @return string This indicates the line where the error occured
     */
    public function getLine()
    {
        return $this->Line;
    }
}

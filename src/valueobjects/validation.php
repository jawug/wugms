<?php

class voValidation
{

    private $RegexUserName = 'ddddd';
    private $RegexPassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,20}$/';
    private $RegexDateFormat = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
    private $RegexDefaultNameFormat = '/^[A-Za-z0-9()\s]+$/i';
    private $RegexHexColourFormat = '/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';
    private $RegexGenericName = '/^.{10,50}$/i';
    private $RegexGenericDescription = '/^.{10,250}$/i';

    /**
     * 
     * @return String Regex
     */
    function getRegexUserName()
    {
        return $this->RegexUserName;
    }

    /**
     * 
     * @return String Regex
     */
    function getRegexPassword()
    {
        return $this->RegexPassword;
    }

    /**
     * 
     * @return String Regex
     */
    function getRegexDateFormat()
    {
        return $this->RegexDateFormat;
    }

    /**
     * 
     * @return String Returns the generic name regex of '/^[A-Za-z0-9()\s]+$/i'
     */
    function getRegexDefaultNameFormat()
    {
        return $this->RegexDefaultNameFormat;
    }

    /**
     * 
     * @return String Returns the generic HEX colour checker '/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
     */
    function getRegexHexColourFormat()
    {
        return $this->RegexHexColourFormat;
    }

    /**
     * 
     * @return String Returns the expression for check the Ticket Header '/^.{10,100}$/i'
     */
    function getRegexGenericName()
    {
        return $this->RegexGenericName;
    }

    /**
     * 
     * @return String Returns the expression to check the ticket Description '/^.{10,4000}$/i'
     */
    function getRegexGenericDescription()
    {
        return $this->RegexGenericDescription;
    }
}

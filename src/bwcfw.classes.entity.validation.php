<?php

class entity_validation {

    /**
     *
     * @var String This is the regex used for the checking of the date format YYYY-MM-DD 
     */
    private $DateRegex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";

    /**
     * 
     * @param datetime $date This checks that the parameter supplied is a valid date
     * @return datetime
     * @throws Exception
     */
    function validateDate($date) {
        if (!$date) {
            throw new Exception('Date is blank');
        }
        if (!preg_match($this->DateRegex, $date)) {
            throw new Exception('Date is wrong format');
        }
        return $date;
    }

    /**
     * 
     * @param interger $value 
     * @return type boolean
     * @throws Exception
     */
    function validateCheckNumeric($value) {
        if (!is_numeric($value)) {
            throw new Exception('Value is not numeric');
        }
        return $value;
    }

    function validateStringNotEmpty($value) {
        if (!empty($value)) {
            throw new Exception('String is empty');
        }
        return $value;
    }

    /**
     * 
     * @param string $value
     * @param integer $length
     * @return string
     * @throws Exception
     */
    function validateStringLength($value, $length) {
        if ((strlen($value) > $length) || (strlen($value) < $length)) {
            throw new Exception('Value is incorrect length');
        }
        return $value;
    }

    /**
     * 
     * @param integer $number
     * @param integer $min
     * @param integer $max
     * @return boolean
     * @throws Exception
     */
    function validateNumberBTV($number, $min, $max) {
        if ($number >= $min && $number <= $max) {
            return TRUE;
        } else {
            throw new Exception('Value is out of bounds');
        }
    }

    /**
     * This function checks to see if $startdate is greater $enddate and if that is the case then fails
     * 
     * @param datetime $startdate
     * @param datetime $enddate
     * @return boolean
     * @throws Exception
     */
    function StartDateLTTEndDate($startdate, $enddate) {
        if ($startdate > $enddate) {
            throw new Exception('Start Date greater than End Date');
        }
        return TRUE;
    }

    /**
     * 
     * @param string $value
     * @param string $regex
     * @return type
     * @throws Exception
     */
    function validateStringRegex($value, $regex) {
        if (!preg_match($regex, $value)) {
            throw new Exception('String value does not match Regex');
        }
        return $value;
    }

    function validateStringLengthMinMax($value, $min, $max) {
        $i = strlen($value);
        if ($i < $min || $i > $max) {
            throw new Exception('String value does not meet min/max requirements');
        }
        return $value;
    }

    /**
     * 
     * @param string $first
     * @param string $second
     * @return boolean
     * @throws Exception
     */
    function validateStringUnique($first, $second) {
        if (strtoupper($first) === strtoupper($second)) {
            throw new Exception('Values are the same');
        }
        return TRUE;
    }

    /**
     * 
     * @param string $first
     * @param string $second
     * @return boolean
     * @throws Exception
     */
    function validateStringSame($first, $second) {
        if (strtoupper($first) !== strtoupper($second)) {
            throw new Exception('Values are not the same');
        }
        return TRUE;
    }

    /**
     * 
     * @param string $email
     * @return type
     * @throws Exception
     */
    function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('String value is not valid email');
        }
        return $email;
    }

    function __construct() {
        
    }

}

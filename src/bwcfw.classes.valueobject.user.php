<?php

class voUser
{

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getUserID()
    {
        return $this->name;
    }

    /**
     * 
     * @param integer $id This sets the internal variable
     */
    function setUserID($id)
    {
        $this->user_id = $id;
    }

    /**
     * 
     * @return string User's name
     */
    function getFirstName()
    {
        return $this->name;
    }

    /**
     * 
     * @param string $firstname This sets the internal variable
     */
    function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * 
     * @return string User's lastname
     */
    function getLastName()
    {
        return $this->lastname;
    }

    /**
     * 
     * @param string $lastname This sets the internal variable
     */
    function setLastName($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * 
     * @return string Username
     */
    function getUserName()
    {
        return $this->username;
    }

    /**
     * 
     * @param string $username This sets the internal variable
     */
    function setUserName($username)
    {
        $this->username = $username;
    }

    /**
     * 
     * @return integer ID of the original feedback
     */
    function getAccountStatus()
    {
        return $this->account_status;
    }

    /**
     * 
     * @param integer $account_status This sets the internal variable
     */
    function setAccountStatus($account_status)
    {
        $this->account_status = $account_status;
    }

    /**
     * 
     * @return string ID of the company
     */
    function getAccountValidationKey()
    {
        return $this->accountvalidationkey;
    }

    /**
     * 
     * @param string $accountvalidationkey This creates a a user account key that gets used in future operations
     */
    function setAccountValidationKey($accountvalidationkey = null)
    {
        if ($accountvalidationkey) {
            $this->accountvalidationkey = $accountvalidationkey;
        } else {
            $this->user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $this->user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $this->user_auth_salt);
            for ($round = 0; $round < 65536; $round++) {
                $this->user_auth_code = hash('sha256', $this->user_auth_code . $this->user_auth_salt);
            }
            $this->accountvalidationkey = $this->user_auth_code;
        }
    }

    /**
     * 
     * @return string Return the auth salt
     */
    function getAuthSalt()
    {
        return $this->user_auth_salt;
    }

    /**
     * 
     * @param string $user_auth_salt This sets the internal variable
     */
    function setAuthSalt($user_auth_salt = null)
    {
        if ($user_auth_salt) {
            $this->user_auth_salt = $user_auth_salt;
        } else {
            $this->user_auth_salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        }
    }

    /**
     * 
     * @return string Return the auth code
     */
    function getAuthCode()
    {
        $this->user_auth_code = hash('sha256', date("Y-m-d h:i:sa") . $this->user_auth_salt);

        for ($round = 0; $round < 65536; $round++) {
            $this->user_auth_code = hash('sha256', $this->user_auth_code . $this->user_auth_salt);
        }
        return $this->user_auth_code;
    }

    /**
     * 
     * @return string stuff
     */
    function getPassword()
    {
        return $this->password;
    }

    /**
     * 
     * @param string $password This sets the internal variable
     */
    function setPassword($password)
    {
        $this->password = $password;
    }

    function __construct($id = null)
    {
        
    }
}

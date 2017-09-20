<?php

class voWebPage
{

    /**
     *
     * @var array 
     */
    /* var $APIResponse = array('status' => 0,
      'message' => 'message',
      'data' => 'data'
      ); */
    var $APIResponse = array('status' => 0,
        'message' => 'message',
        'data' => ''
    );

    /**
     *
     * @var type 
     */
    var $HTTPResponseCode;

    /**
     * 
     * @return type
     */
    function getAPIStatusCode()
    {
        return $this->APIStatusCode;
    }

    /**
     * 
     * @return type
     */
    function getAPIStatusMsg()
    {
        return $this->APIStatusMsg;
    }

    /**
     * 
     * @return type
     */
    function getAPIData()
    {
        return $this->APIData;
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseCode($id)
    {
        return $this->APIResponseCode[$id];
    }

    /**
     * 
     * @return type
     */
    function getHTTPResponseCode()
    {
        return $this->HTTPResponseCode;
    }

    /**
     * 
     * @return type
     */
    function getAPIResponse()
    {
        return $this->APIResponse;
    }

    /**
     * 
     * @param type $APIStatusCode
     */
    function setAPIStatusCode($APIStatusCode)
    {
        $this->APIStatusCode = $APIStatusCode;
    }

    /**
     * 
     * @param type $HTTPResponseCode
     */
    function setHTTPResponseCode($HTTPResponseCode)
    {
        $this->HTTPResponseCode = $HTTPResponseCode;
    }

    /**
     * 
     * @param integer $APIResponse
     */
    function setAPIResponse($APIResponse = 1)
    {
        $this->APIResponse['status'] = $this->APIResponseCode[$APIResponse]['HTTP Response'];
        $this->APIResponse['message'] = $this->APIResponseCode[$APIResponse]['Message'];
        $this->HTTPResponseCode = $this->HTTPResponseCodes[$this->APIResponse['status']];
        switch ($APIResponse) {
            /* New entries */
            case 1:
                /*  so far do nothing */
                break;
            /* Default value */
            default:
                $this->APIResponse['data'] = $this->APIResponseCode[$APIResponse]['Data'];
        }
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseStatus()
    {
        return $this->APIResponse['status'];
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseMessage()
    {
        return $this->APIResponse['message'];
    }

    function setAPIResponseData($data)
    {
        $this->APIResponse['data'] = $data;
    }

    function setAPIResponseFeedback($feedback)
    {
        $this->APIResponse['feedback'] = $feedback;
    }

    /**
     * 
     * @return type
     */
    function getAPIResponseData()
    {
        return $this->APIResponse['data'];
    }

    /**
     * 
     */
    function __construct()
    {
        $this->APIResponseCode = array(
            0 => array(
                'HTTP Response' => 400,
                'Message' => 'Unknown Error',
                'Data' => 'The server cannot or will not process the request due to an apparent client error.'
            ),
            1 => array(
                'HTTP Response' => 200,
                'Message' => 'Success',
                'Data' => ''
            ),
            2 => array(
                'HTTP Response' => 403,
                'Message' => 'HTTPS Required',
                'Data' => 'The request was a valid request, but the server is refusing to respond to it. The user might be logged in but does not have the necessary permissions for the resource.'
            ),
            3 => array(
                'HTTP Response' => 401,
                'Message' => 'Authentication Required',
                'Data' => 'User does not have sufficient permissions'
            ),
            4 => array(
                'HTTP Response' => 401,
                'Message' => 'Authentication Failed',
                'Data' => 'Unauthorized'
            ),
            5 => array(
                'HTTP Response' => 404,
                'Message' => 'Invalid Request',
                'Data' => 'The requested resource could not be found but may be available in the future'
            ),
            6 => array(
                'HTTP Response' => 400,
                'Message' => 'Invalid Response Format',
                'Data' => 'The server cannot or will not process the request due to an apparent client error'
            ),
            7 => array(
                'HTTP Response' => 400,
                'Message' => 'Invalid Request',
                'Data' => 'Invalid parameters'
            ),
            8 => array(
                'HTTP Response' => 204,
                'Message' => 'No Content',
                'Data' => 'The server successfully processed the request and is not returning any content'
            ),
            9 => array(
                'HTTP Response' => 405,
                'Message' => 'Method Not Allowed',
                'Data' => ''
            ),
            10 => array(
                'HTTP Response' => 500,
                'Message' => 'Internal Server Error',
                'Data' => 'The server lacks the ability to fulfill the request.'
            )
        );
        $this->HTTPResponseCodes = array(
            200 => 'OK',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        );
        $this->setAPIResponse(1);
    }
}

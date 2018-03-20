<?php
/**
 * Created by PhpStorm.
 * User: kilian
 * Date: 19/03/18
 * Time: 12:23
 */

namespace AccentLabs\TrackingSdk\Exceptions;


use Exception;

class RequestExceptions extends Exception
{
    private $response, $errorMsg;

    public function __construct($code, $errorMsg)
    {
        $this->response = ['Code' => $code, 'Message' => $errorMsg];
        $this->code = $code;
        $this->errorMsg = $errorMsg;
    }


    public function getResponse()
    {
        parent::__construct($this->errorMsg, $this->code);
        return json_encode($this->response);
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

}
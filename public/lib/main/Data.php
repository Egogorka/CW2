<?php
/**
 * Created by PhpStorm.
 * User: Helene
 * Date: 24.12.2018
 * Time: 9:57
 */

/**
 * Data is created to operate with errors and statuses of data
 *
 * Statuses are defined by HTTP's status codes
 *
 * 1xx - Informational
 * 2xx - Success
 * 3xx - Redirection
 * 4xx - Client Error
 * 5xx - Server Error
 */

namespace Main;

define('OK', 200);

class Data
{

    public $errText; // String
    public $errCode; // Integer
    public $response; // Actual data (anything) if it needs

    function __construct($data = array()){
        $out = [
            'errText' => 'All ok', // Ok
            'errCode' => OK,
            'response' => null,
        ];

        $data = array_merge( $out, $data );

        $this->errText = $data['errText'];
        $this->errCode = $data['errCode'];
        $this->response = $data['response'];
    }

    public function isOk(){
        if (intdiv($this->errCode, 100) === 2 )
            return true;
            return false;
    }

    // Changes the object to worse data (if it worse) if this object is ok;
    public function changeBy(Data $data){
        if ($this->isOk()) {
            if (!$data->isOk()) {
                $this->errCode = $data->errCode;
                $this->errText = $data->errText;
                $this->response = $data->response;
            }
        } // else do nothing
        return $this;
    }

    public function error(){
        return "Error ".$this->errCode."# : ".$this->errText;
    }

    public function toArray(){
        return array(
          'errCode'  => $this->errCode,
          'errText'  => $this->errText,
          'response' => $this->response,
        );
    }

}
<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception {

    /**
     * Summary of __construct
     * @param mixed $message
     * @param mixed $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Summary of error404
     * @return void
     */
    public function error404()
    {
       // echo VIEWS;
       // die();
        http_response_code(404);
      
        require VIEWS . 'errors/404.php';
    }
}

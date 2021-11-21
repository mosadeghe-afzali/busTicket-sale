<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response as HTTPResponse;

class ReserveFailedException extends Exception
{
    public function render()
    {
        return $this->getMessage();


    }

}

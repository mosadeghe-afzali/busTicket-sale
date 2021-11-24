<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response as HTTPResponse;

class ReserveFailedException extends Exception
{
    public function render()
    {
        return response()->json([
            $this->getMessage(),
            200
        ]);
    }

}
//$( document ).ready(function() {
//    console.log( "ready!" );
//});

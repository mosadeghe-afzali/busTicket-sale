<?php

namespace App\Exceptions;

use App\Http\Requests\VehicleStoreRequest;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Throwable;
use Illuminate\Http\Response as HTTPResponse;

class Handler extends ExceptionHandler
{

    use \App\Traits\Response;
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {


        $this->renderable(function (HttpResponseException $e, $request) {
            return $this->getErrors(
                'this is a validation error'. $e->getMessage(),
            HTTPResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        });

//        if(!config('APP_DEBUG')) {
//            $this->renderable(function (Throwable $e) {
//                return 'something went worn please try later';
//            });
//        }
    }
}

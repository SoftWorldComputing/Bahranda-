<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Throwable;
use App\Response\BahrandaResponse;
class Handler extends ExceptionHandler
{
    use BahrandaResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof
                          \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->error("User token has expired",400);
            } else if ($preException instanceof
                          \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                  return $this->error("User token has expired",400);

            } else if ($preException instanceof
                     \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return $this->error("User token has expired",400);
               
           }
           if ($exception->getMessage() === 'Token not provided') {
                return $this->error("Token not supplied",400);

           }
           
        }

        if($exception instanceof UserNotAuthenticatedException)
        {
                 return $this->error("User not authenticated",403);

        }

        if($exception instanceof UnableToCompletePurchase)
        {
            return $this->error("Error completing purchase of commodity, please report this error with this timestamp to admininstrator",500);
         }

        return parent::render($request, $exception);
    }
}
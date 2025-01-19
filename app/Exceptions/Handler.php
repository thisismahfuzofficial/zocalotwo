<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
          

            if (env('APP_ENV') == 'production') {
              return  Mail::send('emails.errors', ['exception' => $exception], function ($message) {
                        $message->to('reovilsayed@gmail.com')->cc('asalaminsikder787@gmail.com')->subject('Error in  Sushi');
                });
            }
        }

        parent::report($exception);
    }
}

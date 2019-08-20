<?php

namespace App\Http\Controllers\V1\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
use App\Processors\Notification\Notification as NotificationProcessor;

class NotificationController extends Controller
{
    public function notify(NotificationProcessor $processor)
    {
        return $processor->notify($this, Input::all());
    }

    public function userDoesNotExistsError()
    {
        return $this->response->errorNotFound("User does not exists");
    }

    public function successful(){
        return response()->json(['status'=>'success','message'=>'successfully send notifications'],201);
    }

    public function BookingDoesNotExistsError()
    {
        return $this->response->errorNotFound("booking does not exists");
    }
}

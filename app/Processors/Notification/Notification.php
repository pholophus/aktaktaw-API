<?php

namespace App\Processors\Notification;

use Carbon\Carbon;
use App\Processors\Processor;
use App\Models\Notification as NotificationModel;
use App\Models\User as UserModel;
use App\Models\Booking as BookingModel;
use App\Validators\Notification as Validator;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;
class Notification extends Processor
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }


    public function notify($listener, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            throw new StoreFailed('Could not send notifications', $validator->errors());
        }

        if(is_array($inputs['booking_id'])){
            $bookings = BookingModel::whereIn('uuid',$inputs['booking_id'])->get();
            if(!$bookings){
                return $listener->BookingDoesNotExistsError();
            }
        }else{
            $booking = BookingModel::where('uuid',$inputs['booking_id'])->first();
            if(!$booking){
                return $listener->BookingDoesNotExistsError();
            }
        }
        
        NotificationModel::create([
            'user_id' => auth()->user()->id,
            'booking_id' => $booking->id,
            'title' =>  $inputs['title'],
            'description' =>  $inputs['description'], //global , personal, group
        ]);

        return $listener->successful();
    }





}

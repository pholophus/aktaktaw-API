<?php

namespace App\Processors\Booking;

use Carbon\Carbon;
use App\Models\Booking as BookingModel;
use App\Models\Type as TypeModel;
use App\Models\Role as RoleModel;
use App\Models\Expertise as ExpertiseModel;
use App\Models\User as UserModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Booking as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class Booking extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function index($listener)
    {
        // if (!checkUserAccess('management'))
        //     return setApiResponse('error', 'access');
        $booking = BookingModel::paginate(15);
        return $listener->showBookingListing($booking);
    }

    public function show($listener, $bookingUuid)
    {
        // if (!checkUserAccess('management'))
        //     return setApiResponse('error', 'access');
        if (!$bookingUuid) {
            return $listener->bookingDoesNotExistsError();
        }
        try {
            $booking = BookingModel::where('uuid', $bookingUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->bookingDoesNotExistsError();
        }
        return $listener->showBooking($booking);
    }

    public function store($listener, array $inputs)
    {
        // if (!checkUserAccess('management'))
        //     return setApiResponse('error', 'access');
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        $user = UserModel::whereHas('languages', function($q) use($inputs) {
            $q->where('language_id', $inputs['language']);
        })->whereHas('expertises', function($q) use ($inputs){
            $q->where('expertise_id', $inputs['expertise']);
        })->where('translator_status_id',0)->orderBy('booked','asc')->first();
        BookingModel::create([
            'origin' =>  $inputs['origin'],
            'booking_date' =>  $inputs['booking_date'],
            'booking_time' =>  $inputs['booking_time'],
            'end_call' =>  $inputs['end_call'],
            'notes' =>  $inputs['notes'],
            'language' =>  $inputs['language'],
            'origin_id' => auth()->user()->id,
           // 'translator_id' =>
            //'status_id'=>
            'expertise_id'=> $inputs['expertise'],

        ]);

        return setApiResponse('success', 'created', 'booking');
    }

    public function update($listener, $bookingUuid, array $inputs)
    {
        // if (!checkUserAccess('management'))
        //     return setApiResponse('error', 'access');
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update booking', $validator->errors());
        }
        try {
            $booking = BookingModel::where('uuid', $bookingUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->bookingDoesNotExistsError();
        }

        if(is_array($inputs['type_id'])){
            $types = TypeModel::whereIn('uuid',$inputs['type_id'])->get();
            if(!$types){
                return $listener->TypeDoesNotExistsError();
            }
        }else{
            $type = TypeModel::where('uuid',$inputs['type_id'])->first();
            if(!$type){
                return $listener->TypeDoesNotExistsError();
            }
        }

        if(is_array($inputs['expertise_id'])){
            $expertises = ExpertiseModel::whereIn('uuid',$inputs['expertise_id'])->get();
            if(!$expertises){
                return $listener->ExpertiseDoesNotExistsError();
            }
        }else{
            $expertise = ExpertiseModel::where('uuid',$inputs['expertise_id'])->first();
            if(!$expertise){
                return $listener->ExpertiseTypeDoesNotExistsError();
            }
        }

        $booking->update([
            'origin' =>  $inputs['origin'],
            'booking_date' =>  $inputs['booking_date'],
            'booking_time' =>  $inputs['booking_time'],
            'end_call' =>  $inputs['end_call'],
            'notes' =>  $inputs['notes'],
            'language' =>  $inputs['language'],
            'origin_id' => auth()->user()->id,
            //'translator_id' =>
            //'status_id'=>
            'expertise_id'=> $expertise->id,
            'type_id'=> $type->id
        ]);
        return setApiResponse('success', 'updated', 'booking');
    }
    public function delete($listener, $bookingUuid)
    {
        // if (!checkUserAccess('management'))
        //     return setApiResponse('error', 'access');
        if (!$bookingUuid) {
            throw new DeleteFailed('Could not delete booking');
        }

        try {
            $booking = BookingModel::where('uuid', $bookingUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->bookingDoesNotExistsError();
        }

        $booking->delete();
        return setApiResponse('success', 'deleted', 'booking');
    }
}

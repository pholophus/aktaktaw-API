<?php

namespace App\Processors\Booking;

use Carbon\Carbon;
use App\Models\Booking as BookingModel;
use App\Models\BookingBooking as BookingBookingModel;
use App\Models\Role as RoleModel;

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
        BookingModel::create([
            'origin' =>  $inputs['origin'],
            'booking_date' =>  $inputs['booking_date'],
            'booking_time' =>  $inputs['booking_time'],
            'end_call' =>  $inputs['end_call'],
            'notes' =>  $inputs['notes'],
            'language' =>  $inputs['language']
        ]);

        return setApiResponse('success', 'created', 'booking');
    }

    public function update($listener, $bookingUuid, array $inputs)
    {
        if (!checkUserAccess('management'))
            return setApiResponse('error', 'access');
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


        $booking->update([
            'code' =>  $inputs['code'],
            'name' =>  $inputs['name']
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

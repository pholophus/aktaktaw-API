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

        //     $language = languageModel::where('uuid',$inputs['language_id'])->first();
        //     if(!$language){
        //         return $listener->LanguageDoesNotExistsError();
        //     }

        $expertise = ExpertiseModel::where('uuid',$inputs['expertise_id'])->first();
        if(!$expertise){
            return $listener->ExpertiseDoesNotExistsError();
        }

        $translator = UserModel::where('uuid',$inputs['translator_id'])->with('roles')->role('translator')->first();
            if(!$translator){
                return $listener->TranslatorDoesNotExistsError();
            }

            // $hasExpertises = $translator->expertise;
            // foreach( $hasExpertises as $hasExpertise)
            // {
            //     if(!$hasExpertise->where('expertise_id',$inputs['expertise_id'])){
            //      return $listener->TranslatorDoesNotHaveThisExpertiseError();
            //     }
            // }

            // $hasLanguages = $translator->language;
            // foreach($hasLanguages as $hasLanguage)
            // {
            //     if(!$hasLanguage->where('language_id',$inputs['language_id'])){
            //      return $listener->TranslatorDoesNotHaveThisLanguageError();
            //     }
            // }

        $requester = UserModel::where('uuid',$inputs['requester_id'])->role('general_user')->first();
        if(!$requester){
            return $listener->RequesterDoesNotExistsError();
        }
        

       // $origin = auth()->user()->role('administrator') ? 'admin' : 'user';

        BookingModel::create([
            //'origin' =>  $origin,
            'booking_date' =>  $inputs['booking_date'],
            'booking_time' =>  $inputs['booking_time'],
            'booking_type' => $inputs['booking_type'],
            'end_call' =>  $inputs['end_call'],
            'call_duration' => $inputs['call_duration'],
            'notes' =>  $inputs['notes'],
            'origin_id' => auth()->user()->id,
            'translator_id' =>$translator->id,
            'booking_fee' => $inputs['booking_fee'],
            //'language_id'=> $language->id,
            'expertise_id'=> $expertise->id,
            'requester_id'=> $requester->id

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

        $translator = UserModel::where('uuid',$inputs['translator_id'])->role('translator')->first();
            if(!$translator){
                return $listener->TranslatorDoesNotExistsError();
            }

        $booking->update([
            //'origin' =>  $inputs['origin'],
            'booking_date' =>  $inputs['booking_date'],
            'booking_time' =>  $inputs['booking_time'],
            'booking_fee' => $inputs['booking_fee'],
            'booking_status' => $inputs['booking_status'],
            'call_duration' =>  $inputs['call_duration'],
            'end_call' =>  $inputs['end_call'],
            'notes' =>  $inputs['notes'],
            'translator_id' => $translator->id
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

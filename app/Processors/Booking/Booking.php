<?php

namespace App\Processors\Booking;

use Carbon\Carbon;
use App\Models\Booking as BookingModel;
use App\Models\Role as RoleModel;
use App\Models\Expertise as ExpertiseModel;
use App\Models\User as UserModel;
use App\Models\Language as LanguageModel;
use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Booking as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
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

        $language = LanguageModel::where('uuid',$inputs['language_id'])->first();
        if(!$language){
            return $listener->LanguageDoesNotExistsError();
        }

        $expertise = ExpertiseModel::where('uuid',$inputs['expertise_id'])->first();
        if(!$expertise){
            return $listener->ExpertiseDoesNotExistsError();
        }
       
        $requester = UserModel::where('uuid',$inputs['requester_id'])->role('general_user')->first();
        if(!$requester){
            return $listener->RequesterDoesNotExistsError();
        }

        if(isset($inputs['translator_id']))
        {
            $translator = UserModel::where('uuid',$inputs['translator_id'])->with('roles')->role('translator')->first();
            if(!$translator){
                return $listener->TranslatorDoesNotExistsError();
            }

            //check whether the translator has the expertise
            $hasExpertises = $translator->expertises->where('id',$expertise->id)->first();
            if(!$hasExpertises){
                return $listener->TranslatorDoesNotHaveThisExpertiseError();
            }

            //check whether the translator has the language
            $hasLanguages = $translator->languages->where('id',$language->id)->first();
            if(!$hasLanguages){
            return $listener->TranslatorDoesNotHaveThisLanguageError();
            }

        }
        else{

            $translator = UserModel::whereHas('languages', function($q) use($language) {
            $q->where('language_id', $language->id);
            })->whereHas('expertises', function($q) use ($expertise){
            $q->where('expertise_id', $expertise->id);
            })->where('translator_status',1)->orderBy('booked','asc')->first();

            if(!$translator){
                return $listener->BookingError();
            }

        }
  
       // $origin = auth()->user()->role('administrator') ? 'admin' : 'user';
        
        BookingModel::create([
            'booking_date' =>  $inputs['booking_date'],
            'booking_time' =>  $inputs['booking_time'],
            'booking_type' => $inputs['booking_type'],
            'booking_status' => $inputs['booking_status'],
            'end_call' =>  $inputs['end_call'],
            'call_duration' => $inputs['call_duration'],
            'notes' =>  $inputs['notes'],
            'origin_id' => auth()->user()->id,
            'booking_fee' => $inputs['booking_fee'],
            'translator_id' =>$translator->id,
            'language_id'=> $language->id,
            'expertise_id'=> $expertise->id, 
            'requester_id'=> $requester->id,

        ]);

         $translator->increment('booked',1);

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

        $language = LanguageModel::where('id',$booking->language_id)->first();  
        $expertise = ExpertiseModel::where('id',$booking->expertise_id)->first();

        if(isset($inputs['translator_id']))
        {   
            //dd($language);
            $translator = UserModel::where('uuid',$inputs['translator_id'])->with('roles')->role('translator')->first();
            if(!$translator){
                return $listener->TranslatorDoesNotExistsError();
            }

            //check whether the translator has the expertise
            $hasExpertises = $translator->expertises->where('id',$expertise->id)->first();
            if(!$hasExpertises){
                return $listener->TranslatorDoesNotHaveThisExpertiseError();
            }
            
            //check whether the translator has the language
            $hasLanguages = $translator->languages->where('id',$language->id)->first();
            if(!$hasLanguages){
            return $listener->TranslatorDoesNotHaveThisLanguageError();
            }

        }
        else{

            $translator = UserModel::whereHas('languages', function($q) use($language) {
            $q->where('language_id', $language->id);
            })->whereHas('expertises', function($q) use ($expertise){
            $q->where('expertise_id', $expertise->id);
            })->where('translator_status',1)->orderBy('booked','asc')->first();

            if(!$translator){
                return $listener->BookingError();
            }

        }

        $booking->update([
            //'origin' =>  $inputs['origin'],
            'booking_date' =>  $inputs['booking_date'],
            'booking_time' =>  $inputs['booking_time'],
            'booking_fee' => $inputs['booking_fee'],
            'translator_id' =>$translator->id,
            'booking_status' => $inputs['booking_status'],
            'call_duration' =>  $inputs['call_duration'],
            'end_call' =>  $inputs['end_call'],
            'notes' =>  $inputs['notes'],
        ]);
        $translator->increment('booked',1);

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

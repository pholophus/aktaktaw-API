<?php

namespace App\Processors\Booking;

use DB;
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
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        $language = LanguageModel::where('uuid', $inputs['requested_language_id'])->first();
        if(!$language){
            return $listener->LanguageDoesNotExistsError();
        }

        $expertise = ExpertiseModel::where('uuid',$inputs['expertise_id'])->first();
        if(!$expertise){
            return $listener->ExpertiseDoesNotExistsError();
        }
       
        $requester = UserModel::where('uuid', $inputs['requester_id'])->role('general_user')->first();
        if(!$requester){
            return $listener->RequesterDoesNotExistsError();
        }
  
        // $origin = auth()->user()->role('administrator') ? 'admin' : 'user';

        $booking = BookingModel::create([
            'start_call_at' =>  Carbon::parse($inputs['start_call'])->toDateTimeString(),
            'type' => $inputs['type'],
            'notes' =>  $inputs['notes'],
            'status' => 'pending',
            'origin_id' => auth()->user()->id,
            'requested_language_id'=> $language->id,
            'expertise_id'=> $expertise->id, 
            'requester_id'=> $requester->id,

        ]);

        // $translator->increment('booked', 1);

        return $listener->showBooking($booking);
    }

    /**
     * Add translator to booking
     */
    public function addTranslator($listener, $bookingUuid, array $inputs) {
        
        try {
            $booking = BookingModel::where('uuid', $bookingUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->bookingDoesNotExistsError();
        }

        $validator = $this->validator->on('translator')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Missing translator ID', $validator->errors());
        }

        $language = LanguageModel::where('uuid',$inputs['spoken_language_id'])->first();
        if(!$language){
            return $listener->LanguageDoesNotExistsError();
        }

        $translator = UserModel::where('uuid', $inputs['translator_id'])->with('roles')->role('translator')->first();
        if(!$translator){
            return $listener->TranslatorDoesNotExistsError();
        }
        
        //check whether the translator has the expertise
        // $hasExpertises = $translator->expertises->where('id', $expertise->id)->first();
        // if(!$hasExpertises){
        //     return $listener->TranslatorDoesNotHaveThisExpertiseError();
        // }

        //check whether the translator has the language
        // $hasLanguages = $translator->languages->where('id', $language->id)->first();
        // if(!$hasLanguages){
        //     return $listener->TranslatorDoesNotHaveThisLanguageError();
        // }

        $booking->update([
            'translator_id' => $translator->id,
            'spoken_language_id' => $language->id,
            'status' => 'open'
        ]);

        return $listener->showBooking($booking);
    }

    /**
     * Add translator to booking
     */
    public function endBooking($listener, $bookingUuid, array $inputs) {
        
        try {
            $booking = BookingModel::where('uuid', $bookingUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->bookingDoesNotExistsError();
        }

        $validator = $this->validator->on('callingEnd')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Missing end date time', $validator->errors());
        }

        $booking->update([
            'end_call_at' => Carbon::parse($inputs['end_call'])->toDateTimeString(),
            'status' => 'close'
        ]);

        return $listener->showBooking($booking);
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

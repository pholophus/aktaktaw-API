<?php

namespace App\Http\Controllers\V1\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
use App\Http\Transformers\BookingTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Booking\Booking as BookingProcessor;

class BookingController extends Controller
{
    public function index(BookingProcessor $processor){
        return $processor->index($this);
    }

    public function show($uuid,BookingProcessor $processor){
        return $processor->show($this,$uuid);
    }
    public function store(BookingProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function addTranslator(BookingProcessor $processor, $bookingUuid) {
        return $processor->addTranslator($this, $bookingUuid, Input::all());
    }

    public function endBooking(BookingProcessor $processor, $bookingUuid) {
        return $processor->endBooking($this, $bookingUuid, Input::all());
    }

    // public function update(BookingProcessor $processor,$BookingUuid)
    // {
    //     return $processor->update($this, $BookingUuid, Input::all());
    // }

    public function destroy(BookingProcessor $processor, $BookingUuid)
    {
        return $processor->delete($this, $BookingUuid);
    }

    public function showBookingListing($Booking)
    {
        return $this->response->paginator($Booking, new BookingTransformer);
    }

    public function showBooking($Booking)
    {
        return $this->response->item($Booking, new BookingTransformer);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Create Booking failed ,Missing Parameters', $errors);
    }

    public function BookingDoesNotExistsError()
    {
        return $this->response->errorNotFound("Booking does not exists");
    }

    public function ExpertiseDoesNotExistsError()
    {
        return $this->response->errorNotFound("expertise does not exists");
    }
    
    public function LanguageDoesNotExistsError()
    {
        return $this->response->errorNotFound("language does not exists");
    }

    public function TranslatorDoesNotExistsError()
    {
        return $this->response->errorNotFound("translator does not exists");
    }
    public function RequesterDoesNotExistsError()
    {
        return $this->response->errorNotFound("requester does not exists");
    }
    public function TranslatorDoesNotHaveThisExpertiseError()
    {
        return $this->response->errorNotFound("translator does not have this expertise");
    }
    public function TranslatorDoesNotHaveThisLanguageError()
    {
        return $this->response->errorNotFound("translator does not have this language");
    }
    public function BookingError()
    {
        return $this->response->errorNotFound("Cannot find translator who matched this expertise and language");
    }



}

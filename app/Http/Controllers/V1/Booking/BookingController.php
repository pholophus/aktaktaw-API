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

    public function update(BookingProcessor $processor,$bookingUuid)
    {
        return $processor->update($this, $bookingUuid, Input::all());
    }

    public function destroy(BookingProcessor $processor, $bookingUuid)
    {
        return $processor->delete($this, $bookingUuid);
    }

    public function showBookingListing($booking)
    {
        return $this->response->paginator($booking, new BookingTransformer);
    }

    public function showBooking($booking)
    {
        return $this->response->item($booking, new BookingTransformer);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Create booking failed ,Missing Parameters', $errors);
    }

    public function bookingDoesNotExistsError()
    {
        return $this->response->errorNotFound("booking does not exists");
    }

    public function TypeDoesNotExistsError()
    {
        return $this->response->errorNotFound("Type does not exists");
    }

    public function ExpertiseDoesNotExistsError()
    {
        return $this->response->errorNotFound("expertise does not exists");
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



}

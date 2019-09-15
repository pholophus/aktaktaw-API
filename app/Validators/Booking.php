<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Booking extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['booking_date'] = ['required'];
        $this->rules['booking_time'] = ['required'];
        $this->rules['call_duration'] = ['required'];
        $this->rules['booking_fee'] = ['required'];
        $this->rules['call_duration'] = ['required'];
        $this->rules['end_call'] = ['required'];
        $this->rules['notes'] = ['required'];        
        $this->rules['language_id'] = ['required'];
        $this->rules['requester_id'] = ['required'];
        //$this->rules['translator_id'] = ['required'];            
        $this->rules['expertise_id'] = ['required'];   
        $this->rules['booking_status'] = ['required'];     
    
    }

    public function onUpdate()
    {
        $this->rules['booking_date'] = ['required'];
        $this->rules['booking_time'] = ['required'];
        $this->rules['call_duration'] = ['required'];
        $this->rules['end_call'] = ['required'];
        $this->rules['notes'] = ['required'];        
        $this->rules['booking_fee'] = ['required'];
        $this->rules['booking_status'] = ['required'];
        //$this->rules['translator_id'] = ['required'];            
    }

    public function onSearch()
    {
        $this->rules['query'] = ['required'];
    }
}

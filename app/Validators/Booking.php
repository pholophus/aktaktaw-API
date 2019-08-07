<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Booking extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['origin'] = ['required'];
        $this->rules['booking_date'] = ['required'];
        $this->rules['booking_time'] = ['required'];
        //$this->rules['call_duration'] = ['required'];
        $this->rules['end_call'] = ['required'];
        $this->rules['notes'] = ['required'];        
        $this->rules['language'] = ['required'];        
    
    }

    public function onUpdate()
    {
        $this->rules['origin'] = ['required'];
        $this->rules['booking_date'] = ['required'];
        $this->rules['booking_time'] = ['required'];
        //$this->rules['call_duration'] = ['required'];
        $this->rules['end_call'] = ['required'];
        $this->rules['notes'] = ['required'];        
        $this->rules['language'] = ['required'];

    }

    public function onSearch()
    {
        $this->rules['query'] = ['required'];
    }
}

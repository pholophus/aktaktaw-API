<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Booking extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['start_call'] = ['required'];   
        $this->rules['requested_language_id'] = ['required'];
        $this->rules['requester_id'] = ['required'];          
        $this->rules['expertise_id'] = ['required'];
    }

    public function onTranslator()
    {
        $this->rules['translator_id'] = ['required'];
        $this->rules['spoken_language_id'] = ['required'];
    }

    public function onCallingEnd()
    {
        $this->rules['end_call'] = ['required'];
    }

    public function onSearch()
    {
        $this->rules['query'] = ['required'];
    }
}

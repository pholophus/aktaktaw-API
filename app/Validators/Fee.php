<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Fee extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['fee_name'] = ['required'];  
        $this->rules['fee_duration'] = ['required'];
        $this->rules['fee_rate'] = ['required'];
        $this->rules['fee_status'] = ['required'];   
    }

    public function onUpdate()
    {
        $this->rules['fee_name'] = ['required'];  
        $this->rules['fee_duration'] = ['required'];
        $this->rules['fee_rate'] = ['required'];
        $this->rules['fee_status'] = ['required'];
    }

}

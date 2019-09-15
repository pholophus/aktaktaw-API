<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Expertise extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['expertise_name'] = ['required']; 
        $this->rules['fee_rate'] = ['required'];      
    }

    public function onUpdate()
    {
        $this->rules['fee_rate'] = ['required'];      
        $this->rules['expertise_name'] = ['required'];
        $this->rules['expertise_status'] = ['required'];

    }

}

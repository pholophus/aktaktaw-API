<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Expertise extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['name'] = ['required']; 
        $this->rules['fee_rate'] = ['required'];      
    }

    public function onUpdate()
    {
        $this->rules['fee_rate'] = ['required'];      
        $this->rules['name'] = ['required'];
        $this->rules['is_active'] = ['required'];

    }

}

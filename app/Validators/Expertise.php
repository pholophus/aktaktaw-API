<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Expertise extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['expertise_name'] = ['required'];       
    }

    public function onUpdate()
    {
        $this->rules['expertise_name'] = ['required'];
    }

}

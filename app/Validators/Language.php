<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Language extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['name'] = ['required'];
        $this->rules['code'] = ['required'];
        $this->rules['is_active'] = ['required'];

    }

    public function onUpdate()
    {
        $this->rules['name'] = ['required'];
        $this->rules['code'] = ['required'];
        $this->rules['is_active'] = ['required'];
    }

}

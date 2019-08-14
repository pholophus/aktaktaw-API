<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class LanguageUser extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['language_name'] = ['required'];
        $this->rules['language_code'] = ['required'];
        $this->rules['type_id'] = ['required'];
    }

    public function onUpdate()
    {
        $this->rules['language_name'] = ['required'];
        $this->rules['language_code'] = ['required'];
        $this->rules['type_id'] = ['required'];
    }

}

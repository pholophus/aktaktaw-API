<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Type extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['name'] = ['required'];
        $this->rules['category'] = ['required'];
    }

    public function onUpdate()
    {
        $this->rules['name'] = ['required'];
        $this->rules['category'] = ['required'];
    }

}

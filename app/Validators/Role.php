<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Role extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['name'] = ['required'];
    }
    public function onUpdate()
    {
        $this->rules['name'] = ['required'];
    }
}

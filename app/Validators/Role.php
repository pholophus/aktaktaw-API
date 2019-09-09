<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Role extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['role_name'] = ['required'];
        $this->rules['display_name'] = ['required'];
    }
    public function onUpdate()
    {
        $this->rules['role_name'] = ['required'];
        $this->rules['display_name'] = ['required'];
    }
}

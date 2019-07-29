<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Notification extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['assignee_id'] = ['required'];
        $this->rules['message'] = ['required'];
        $this->rules['type'] = ['required'];
    }

}

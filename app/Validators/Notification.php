<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Notification extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        //$this->rules['user_id'] = ['required'];
        $this->rules['notification_title'] = ['required'];
        $this->rules['notification_description'] = ['required'];
    }

}

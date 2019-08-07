<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Wallet extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['amount'] = ['required'];
    }

    public function onUpdate()
    {
        $this->rules['amount'] = ['required'];
    }


}

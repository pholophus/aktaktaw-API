<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Profile extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['name'] = ['required'];
        $this->rules['phone_no'] = ['required'];
    }

    public function onUpdate()
    {
        $this->rules['name'] = ['required'];
        $this->rules['languages'] = ['required'];
        $this->rules['image'] = ['required'];
        $this->rules['resume'] = ['required'];
        $this->rules['expertise'] = ['required'];
        $this->rules['translator_status'] = ['required'];
        $this->rules['is_new'] = ['required'];
        $this->rules['phone_no'] = ['required'];
    }

    public function onSearch()
    {
        $this->rules['query'] = ['required'];
    }
}

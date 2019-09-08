<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class User extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['email'] = ['required'];
        $this->rules['name'] = ['required'];
        $this->rules['role_id'] = ['required'];
        $this->rules['password'] = ['required'];
    }

    public function onLogin()
    {
        $this->rules['email'] = ['required'];
        $this->rules['password'] = ['required'];
    }

    public function onUpdate()
    {
        $this->rules['expertise'] = ['required'];
        $this->rules['user_status'] = ['required'];
        $this->rules['translator_status'] = ['required'];
    }

    public function onVerify()
    {
        $this->rules['verification_token'] = ['required'];
    }


    public function onPassword()
    {
        $this->rules['password'] = ['required'];
    }
    public function onEmail()
    {
        $this->rules['email'] = ['required'];
    }

    public function onReset()
    {
        $this->rules['email'] = ['required'];
        $this->rules['password'] = ['required'];
    }
    public function onSearch()
    {
        $this->rules['query'] = ['required'];
    }
}

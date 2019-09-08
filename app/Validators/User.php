<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class User extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['email'] = ['required'];
        //$this->rules['name'] = ['required'];
        //$this->rules['role_id'] = ['required'];
    }

    public function onLogin()
    {
        $this->rules['email'] = ['required'];
        //$this->rules['password'] = ['required'];
    }

    public function onUpdate()
    {
        //$this->rules['nickname'] = ['required'];
        //$this->rules['name'] = ['required'];
        //$this->rules['phone_no'] = ['required'];
    }

    public function onVerify()
    {
        $this->rules['verification_token'] = ['required'];
    }


    public function onPassword()
    {
        $this->rules['current_password'] = ['required'];
        $this->rules['password'] = ['required'];
        $this->rules['retype_password'] = ['required'];
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

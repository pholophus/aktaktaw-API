<?php

namespace App\Validators;

use Orchestra\Support\Validator;

class Profile extends Validator
{
    protected $rules = [];

    public function onCreate()
    {
        $this->rules['first_name'] = ['required'];
        $this->rules['last_name'] = ['required'];
        $this->rules['phone_no'] = ['required'];
    }

    public function onUpdate()
    {
        $this->rules['first_name'] = ['required'];
        $this->rules['last_name'] = ['required'];
        $this->rules['phone_no'] = ['required'];
    }

    public function onSearch()
    {
        $this->rules['query'] = ['required'];
    }

    public function onImage()
    {
        $this->rules['avatar_file_path'] = ['required','image'];
    }

    public function onResume()
    {
        $this->rules['resume_file_path'] = ['required'];
    }
}

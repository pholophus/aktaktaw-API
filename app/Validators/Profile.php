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

    public function onUpdateTranslator()
    {
        $this->rules['name'] = ['required'];
        $this->rules['language_id'] = ['required'];
        $this->rules['language_type'] = ['required'];
        $this->rules['expertise_id'] = ['required'];
        $this->rules['translator_status'] = ['required'];
        $this->rules['is_new'] = ['required'];
        $this->rules['phone_no'] = ['required'];
    }
    public function onUpdateUser()
    {
        $this->rules['name'] = ['required'];
        $this->rules['language_id'] = ['required'];
        $this->rules['language_type'] = ['required'];
        $this->rules['translator_status'] = ['required'];
        $this->rules['is_new'] = ['required'];
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

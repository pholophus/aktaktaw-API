<?php

namespace App\Http\Controllers\V1\Language;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\LanguageTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Language\Language as LanguageProcessor;

class LanguageController extends Controller
{
    public function index(LanguageProcessor $processor){
        return $processor->index($this);
    }

    public function show($uuid,LanguageProcessor $processor){
        return $processor->show($this,$uuid);
    }

    public function store(LanguageProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(LanguageProcessor $processor,$LanguageUuid)
    {
        return $processor->update($this, $LanguageUuid, Input::all());
    }

    public function destroy(LanguageProcessor $processor, $LanguageUuid)
    {
        return $processor->delete($this, $LanguageUuid);
    }

    public function showLanguageListing($Language)
    {
        return $this->response->paginator($Language, new LanguageTransformer);
    }

    public function showLanguage($Language)
    {
        return $this->response->item($Language, new LanguageTransformer);
    }

    public function LanguageDoesNotExistsError()
    {
        return $this->response->errorNotFound("Language does not exists");
    }
    public function TypeDoesNotExistsError()
    {
        return $this->response->errorNotFound("Type does not exists");
    }


}

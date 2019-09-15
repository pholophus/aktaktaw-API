<?php

namespace App\Processors\Language;

use Carbon\Carbon;
use App\Models\Language as LanguageModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Language as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class Language extends Processor 
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function index($listener){
        $Language = LanguageModel::paginate(15);
        return $listener->showLanguageListing($Language);
    }

    public function store($listener, array $inputs)
    {
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        LanguageModel::create([
            'language_name' => $inputs['language_name'],
            'language_code' => $inputs['language_code'],
            'language_status' => $inputs['language_status'],
        ]);

        return setApiResponse('success', 'created', 'Language');
    }

    public function show($listener, $uuid)
    {
        if (!$uuid) {
            return $listener->LanguageDoesNotExistsError();
        }
        try {
            $Language = LanguageModel::where('uuid', $uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->LanguageDoesNotExistsError();
        }
        return $listener->showLanguage($Language);
    }

    public function update($listener, $uuid, array $inputs)
    {
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update Language', $validator->errors());
        }
        try {
            $Language = LanguageModel::where('uuid', $uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->LanguageDoesNotExistsError();
        }

        $Language->update([
            'language_name' => $inputs['language_name'],
            'language_code' => $inputs['language_code'],
            'language_status' => $inputs['language_status'],
        ]);

        return setApiResponse('success', 'updated', 'Language');
    }

    public function delete($listener, $uuid)
    {
        if (!$uuid) {
            throw new DeleteFailed('Could not delete Language');
        }

        try {
            $language = LanguageModel::where('uuid', $uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->LanguageDoesNotExistsError();
        }

        $language->delete();

        return setApiResponse('success', 'deleted', 'Language deleted');
    }

}
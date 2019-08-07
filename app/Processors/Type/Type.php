<?php

namespace App\Processors\Type;

use Carbon\Carbon;
use App\Models\Type as TypeModel;
use App\Models\Language_User as Language_UserModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Type as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class Type extends Processor 
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function store($listener, array $inputs)
    {
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        $id = TypeModel::create([
            'name' => $inputs['name'],
            'category' => $inputs['category'],
        ]);

        $User = auth('api')->id;
        $Language = new Language_UserModel;
        $Language->where('user_id','=',$User)->where('uuid','=',$uuid)
            ->update([
            'id' => $id,
        ]);

        return setApiResponse('success', 'created', 'type added');

    }

    public function show($listener, $uuid)
    {
        if (!$uuid) {
            return $listener->TypeDoesNotExistsError();
        }
        try {
            $User = auth('api')->id;
            $Language = new TypeModel;
            $Type = $Language->where('user_id','=',$User)->where('uuid','=',$uuid)
            ->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->TypeDoesNotExistsError();
        }
        return $listener->showType($Type);
    }

    public function update($listener, $uuid, array $inputs)
    {
        /*if (!checkUserAccess('management'))
            return setApiResponse('error', 'access');*/
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update language', $validator->errors());
        }
        try {
            $User = auth('api')->id;
            $Language = new TypeModel;
            $Type = $Language->where('user_id','=',$User)->where('uuid','=',$uuid)
            ->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->TypeDoesNotExistsError();
        }

        $User = auth('api')->id;
        $Language = new TypeModel;
        $Language->where('user_id','=',$User)->where('uuid','=',$uuid)->update([
            'language_name' => $inputs['language_name'],
            'language_code' => $inputs['language_code'],
        ]);

        return setApiResponse('success', 'updated', 'Language');
    }

    public function delete($listener, $uuid)
    {
        if (!$uuid) {
            throw new DeleteFailed('Could not delete language');
        }

        try {
            $User = auth('api')->id;
            $Language = new TypeModel;
            $Type = $Language->where('user_id','=',$User)->where('uuid','=',$uuid)
            ->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->TypeDoesNotExistsError();
        }

        $Type->delete();

        return setApiResponse('success', 'deleted', 'language');
    }

}
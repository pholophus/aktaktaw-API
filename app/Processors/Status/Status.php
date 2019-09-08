<?php

namespace App\Processors\Status;

use Carbon\Carbon;
use App\Models\Status as StatusModel;
use App\Models\User as UserModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Status as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class Status extends Processor 
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function show($listener, $uuid)
    {
        if (!$uuid) {
            return $listener->StatusDoesNotExistsError();
        }
        try {
            // $User = auth('api')->id;
            // $Language = new StatusModel;
            // $Status = $Language->where('user_id','=',$User)->where('uuid','=',$uuid)
            // ->firstorfail();
            $Status = StatusModel::where('uuid',$uuid)->firstorfail();

        } catch (ModelNotFoundException $e) {
            return $listener->StatusDoesNotExistsError();
        }
        return $listener->showStatus($Status);
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
            // $User = auth('api')->id;
            // $Language = new StatusModel;
            // $Status = $Language->where('user_id','=',$User)->where('uuid','=',$uuid)
            // ->firstorfail();
            $Status = StatusModel::where('uuid',$uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->StatusDoesNotExistsError();
        }

        // $User = auth('api')->id;
        // $Language = new StatusModel;
        // $Language->where('user_id','=',$User)->where('uuid','=',$uuid)->update([
        //     'language_name' => $inputs['language_name'],
        //     'language_code' => $inputs['language_code'],
        // ]);

        $Status->update([
            'name' => $inputs['name'],
            'category' => $inputs['category'],
        ]);

        return setApiResponse('success', 'updated', 'Status');
    }

    public function delete($listener, $uuid)
    {
        if (!$uuid) {
            throw new DeleteFailed('Could not delete language');
        }

        try {
            // $User = auth('api')->id;
            // $Language = new StatusModel;
            // $Status = $Language->where('user_id','=',$User)->where('uuid','=',$uuid)
            // ->firstorfail();
            $Status = StatusModel::where('uuid',$uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->StatusDoesNotExistsError();
        }

        $Status->delete();

        return setApiResponse('success', 'deleted', 'language');
    }

}
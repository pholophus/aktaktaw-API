<?php

namespace App\Processors\LanguageUser;

use Carbon\Carbon;
use App\Models\Language as LanguageUserModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\LanguageUser as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class LanguageUser extends Processor 
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function index($listener){
        // if(!checkUserAccess('management'))
        // //     return setApiResponse('error','access');
        // $User = auth()->user()->id;
        // $Language = new LanguageUserModel;
        // $LanguageUser = $Language->where('user_id','=',$User)->get();
        // return $listener->showLanguageUserListing($LanguageUser);

        $LanguageUser = LanguageUserModel::paginate(15);
        return $listener->showLanguageUserListing($LanguageUser);
    }

    // public function getWithoutPagination($listener)
    // {
    //     $User = auth('api')->id;
    //     $Language = new LanguageUserModel;
    //     $LanguageUser = $Language->where('user_id','=',$User)->all();
    //     return $listener->showLanguageUserListingNoPaginate($LanguageUser);
    // }

    public function store($listener, array $inputs)
    {
        /*if (!checkUserAccess('management'))
            return setApiResponse('error', 'access');*/
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        

        $User = auth()->user()->id;
        LanguageUserModel::create([
            'language_name' => $inputs['language_name'],
            'language_code' => $inputs['language_code'],
            'user_id' => $User,
            'type_id' => $type->id,
        ]);

        return setApiResponse('success', 'created', 'LanguageUser');

    }

    public function show($listener, $uuid)
    {
        if (!$uuid) {
            return $listener->LanguageUserDoesNotExistsError();
        }
        try {
            // $User = auth()->user()->id;
            // $Language = new LanguageUserModel;
            // $LanguageUser = $Language->where('uuid','=',$uuid)->where('user_id','=',$User)->firstorfail();
            $LanguageUser = LanguageUserModel::where('uuid', $uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->LanguageUserDoesNotExistsError();
        }
        return $listener->showLanguageUser($LanguageUser);
    }

    public function update($listener, $uuid, array $inputs)
    {
        /*if (!checkUserAccess('management'))
            return setApiResponse('error', 'access');*/
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update LanguageUser', $validator->errors());
        }
        try {
             $User = auth()->user()->id;
            // $Language = new LanguageUserModel;
            // $LanguageUser = $Language->where('uuid', $uuid)->where('user_id','=',$User)->firstorfail();
            $LanguageUser = LanguageUserModel::where('uuid', $uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->LanguageUserDoesNotExistsError();
        }


        $LanguageUser->update([
            'language_name' => $inputs['language_name'],
            'language_code' => $inputs['language_code'],
        ]);

        // $type = new TypeModel;
        // $TypeID = $Language->where('uuid', $uuid)->value('type_id');

        // $type->where('id','=',$TypeID)->update([
        //     'name' => $inputs['name'],
        //     'category' => $inputs['category'],
        // ]);

        return setApiResponse('success', 'updated', 'LanguageUser');
    }

    public function delete($listener, $uuid)
    {
        if (!$uuid) {
            throw new DeleteFailed('Could not delete LanguageUser');
        }

        try {
            $language = LanguageUserModel::where('uuid', $uuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->LanguageUserDoesNotExistsError();
        }
        // $Type= new TypeModel;

        // $LanguageUser->delete();
        // $typeID = $Language->where('uuid','=',$uuid)->value('type_id');
        // $Type->where('id','=',$typeID)->delete();

        $language->delete();

        return setApiResponse('success', 'deleted', 'LanguageUser deleted');
    }

}
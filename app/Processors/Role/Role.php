<?php

namespace App\Processors\Role;

use Carbon\Carbon;
use App\Models\Role as RoleModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Role as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class Role extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function index($listener)
    {
        $role = RoleModel::paginate(15);
        return $listener->showRoleListing($role);
    }

    public function show($listener, $roleUuid)
    {
        if (!$roleUuid) {
            return $listener->roleDoesNotExistsError();
        }
        try {
            $role = RoleModel::where('uuid', $roleUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->roleDoesNotExistsError();
        }
        return $listener->showRole($role);
    }

    public function store($listener, array $inputs)
    {
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        RoleModel::updateOrcreate([
            'name' =>  $inputs['name'],
            'guard_name' => 'api',

        ], [
            'slug' =>  str_slug($inputs['name']),
            'name_display' =>  str_slug($inputs['name'], '_'),
        ]);

        return setApiResponse('success', 'created', 'role');
    }


    public function update($listener, $roleUuid, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }
        try {
            $role = RoleModel::where('uuid', $roleUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->roleDoesNotExistsError();
        }


        $role->update([
            'code' =>  $inputs['code'],
            'name' =>  $inputs['name'],
            'slug' =>  str_slug($inputs['name']),
            'name_display' =>  str_slug($inputs['name'], '_')
        ]);

        return setApiResponse('success', 'updated', 'role');
    }
    public function delete($listener, $roleUuid)
    {
        if (!$roleUuid) {
            throw new DeleteFailed('Could not delete role');
        }

        try {
            $role = RoleModel::where('uuid', $roleUuid)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->roleDoesNotExistsError();
        }

        $role->delete();

        return setApiResponse('success', 'deleted', 'role');
    }
}

<?php
namespace App\Http\Controllers\V1\Role;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
use App\Http\Transformers\RoleTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Role\Role as RoleProcessor;

class RoleController extends Controller
{
    public function index(RoleProcessor $processor){
        return $processor->index($this);
    }

    public function show($uuid,RoleProcessor $processor){
        return $processor->show($this,$uuid);
    }
    public function store(RoleProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(RoleProcessor $processor,$roleUuid)
    {
        return $processor->update($this, $roleUuid, Input::all());
    }

    public function destroy(RoleProcessor $processor, $roleUuid)
    {
        return $processor->delete($this, $roleUuid);
    }

    public function showRoleListing($role)
    {
        return $this->response->paginator($role, new RoleTransformer);
    }

    public function showRole($role)
    {
        return $this->response->item($role, new RoleTransformer);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Create role failed ,Missing Parameters', $errors);
    }

    public function roleDoesNotExistsError()
    {
        return $this->response->errorNotFound("role does not exists");
    }

}

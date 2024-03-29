<?php

namespace App\Processors\Expertise;

use Carbon\Carbon;
use DB;
use App\Models\Expertise as ExpertiseModel;
use App\Models\Fee as FeeModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Expertise as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
class Expertise extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function index($listener){

        $expertise = ExpertiseModel::where('is_active', 1)->paginate(15);
        return $listener->showExpertiseListing($expertise);
    }

    public function show($listener,$expertiseUuid){
        if(!$expertiseUuid){
            return $listener->expertiseDoesNotExistsError();
        }
        try {
            $expertise = ExpertiseModel::where('uuid', $expertiseUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->expertiseDoesNotExistsError();
        }
        return $listener->showExpertise($expertise);
    }

    public function store($listener, array $inputs)
    {
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        $fee = FeeModel::where('uuid', $inputs['fee_rate'])->first();
        if(!$fee){
            return $listener->FeeDoesNotExistsError();
        }

        $expertise = ExpertiseModel::updateOrcreate([
            'name' =>  $inputs['name'],
        ],[
            'is_active' => $inputs['is_active'],
            'slug'=>  str_slug($inputs['name']),
        ]);

        $expertise->fees()->attach($fee->id);

        return setApiResponse('success','created','expertise');
    }

    public function update($listener, $expertiseUuid, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }
        try {
            $expertise = ExpertiseModel::where('uuid', $expertiseUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->expertiseDoesNotExistsError();
        }

        $fee = FeeModel::where('uuid',$inputs['fee_rate'])->first();
        if(!$fee){
            return $listener->FeeDoesNotExistsError();
        }

        $expertise->update([
            'name' =>  $inputs['name'],
            'slug'=>  str_slug($inputs['name']),
            'is_active' => $inputs['is_active'],
        ]);

        $expertise->fees()->where('id', $expertise->id)->sync([
            'id' => $fee->id,
        ]);

        return setApiResponse('success','updated','expertise');
    }
    
    public function delete($listener,$expertiseUuid)
    {
        if(!$expertiseUuid){
            throw new DeleteFailed('Could not delete expertise');
        }

        try {
            $expertise = ExpertiseModel::where('uuid', $expertiseUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->expertiseDoesNotExistsError();
        }

        $expertise->delete();

       return setApiResponse('success','deleted','expertise');
    }
}


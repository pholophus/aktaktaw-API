<?php

namespace App\Processors\Expertise;

use Carbon\Carbon;
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
        $expertise = ExpertiseModel::paginate(15);
        return $listener->showExpertiseListing($expertise);
    }

    public function show($listener,$expertiseUuid){
        if(!$expertiseUuid){
            return $listener->expertiseDoesNotExistsError();
        }
        try {
            $expertise = ExpertiseModel::where('uuid',$expertiseUuid)->firstorfail();
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

        $expertise = ExpertiseModel::updateOrcreate([
            'expertise_name' =>  $inputs['expertise_name'],
        ],[
            'slug'=>  str_slug($inputs['expertise_name']),
        ]);

        $expertise->fees()->attach($inputs['fee_rate']);

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
            $expertise = ExpertiseModel::where('uuid',$expertiseUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->expertiseDoesNotExistsError();
        }

        $expertise->update([
            'expertise_name' =>  $inputs['expertise_name'],
            'slug'=>  str_slug($inputs['expertise_name'])
        ]);

        $id = ExpertiseModel::where('uuid',$expertiseUuid)->value('id');

        $expertise->fees()->where('expertise_id',$id)->sync([
            'fee_id' => $inputs['fee_rate'],
        ]);

        return setApiResponse('success','updated','expertise');
    }
    public function delete($listener,$expertiseUuid)
    {
        if(!$expertiseUuid){
            throw new DeleteFailed('Could not delete expertise');
        }

        try {
            $expertise = ExpertiseModel::where('uuid',$expertiseUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->expertiseDoesNotExistsError();
        }

        $expertise->delete();

       return setApiResponse('success','deleted','expertise');
    }
}


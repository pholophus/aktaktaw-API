<?php

namespace App\Processors\Fee;

use Carbon\Carbon;
use App\Models\Fee as FeeModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Fee as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
class Fee extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function index($listener){
        $Fee = FeeModel::paginate(15);
        return $listener->showFeeListing($Fee);
    }

    public function show($listener,$FeeUuid){
        if(!$FeeUuid){
            return $listener->FeeDoesNotExistsError();
        }
        try {
            $Fee = FeeModel::where('uuid',$FeeUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->FeeDoesNotExistsError();
        }
        return $listener->showFee($Fee);
    }

    public function store($listener, array $inputs)
    {
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        $Fee = FeeModel::updateOrcreate([
            'fee_name' =>  $inputs['fee_name'],
            'fee_duration' => $inputs['fee_duration'],
            'fee_rate' => $inputs['fee_rate'],
            'fee_status'=> $inputs['fee_status'],
        ]);

        return setApiResponse('success','created','Fee');
    }

    public function update($listener, $FeeUuid, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }
        try {
            $Fee = FeeModel::where('uuid',$FeeUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->FeeDoesNotExistsError();
        }

        $Fee->update([
            'fee_name' =>  $inputs['fee_name'],
            'fee_duration' => $inputs['fee_duration'],
            'fee_rate' => $inputs['fee_rate'],
            'fee_status'=> $inputs['fee_status'],
        ]);

        return setApiResponse('success','updated','Fee');
    }
    public function delete($listener,$FeeUuid)
    {
        if(!$FeeUuid){
            throw new DeleteFailed('Could not delete Fee');
        }

        try {
            $Fee = FeeModel::where('uuid',$FeeUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->FeeDoesNotExistsError();
        }

        $Fee->delete();

       return setApiResponse('success','deleted','Fee');
    }
}


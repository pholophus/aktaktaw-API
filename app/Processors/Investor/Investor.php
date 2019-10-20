<?php

namespace App\Processors\Investor;

use Carbon\Carbon;
use App\Models\Investor as InvestorModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
class Investor extends Processor
{


    public function index($listener){
        $Investor = InvestorModel::paginate(15);
        return $listener->showInvestorListing($Investor);
    }

    public function show($listener,$InvestorUuid){
        if(!$InvestorUuid){
            return $listener->InvestorDoesNotExistsError();
        }
        try {
            $Investor = InvestorModel::where('id',1)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->InvestorDoesNotExistsError();
        }
        return $listener->showInvestor($Investor);
    }

    public function store($listener, array $inputs)
    {

        $Investor = InvestorModel::updateOrcreate([
            'value' =>  $inputs['value'],
            'quantity' => $inputs['quantity'],
            'fromWhere' => $inputs['fromWhere'],
        ]);

        return setApiResponse('success','created','Investor');
    }

    public function update($listener, $InvestorUuid, array $inputs)
    {
        //use validator when retrieving input
        try {
            $Investor = InvestorModel::where('uuid',$InvestorUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->InvestorDoesNotExistsError();
        }

        $money = InvestorModel::where('id',1)->value('account');
        $change = $money - $inputs['investment'];

        $Investor->update([
            'account' =>  $change,
        ]);

        return setApiResponse('success','updated','Investor');
    }
    public function delete($listener,$InvestorUuid)
    {
        if(!$InvestorUuid){
            throw new DeleteFailed('Could not delete Investor');
        }
        try {
            $Investor = InvestorModel::where('uuid',$InvestorUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->InvestorDoesNotExistsError();
        }

        $Investor->delete();

       return setApiResponse('success','deleted','Investor');
    }
}


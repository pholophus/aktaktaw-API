<?php

namespace App\Http\Controllers\V1\Status;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\StatusTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Status\Status as StatusProcessor;

class StatusController extends Controller
{
    public function store(StatusProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(StatusProcessor $processor,$StatusUuid)
    {
        return $processor->update($this, $StatusUuid, Input::all());
    }

    public function destroy(StatusProcessor $processor, $StatusUuid)
    {
        return $processor->delete($this, $StatusUuid);
    }
}

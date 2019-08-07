<?php

namespace App\Processors\Notification;

use Carbon\Carbon;
use App\Processors\Processor;
use App\Models\Notification as NotificationModel;
use App\Models\User as UserModel;

use App\Validators\Notification as Validator;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;
class Notification extends Processor
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }


    public function notify($listener, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            throw new StoreFailed('Could not sent notifications', $validator->errors());
        }

        NotificationModel::create([
            'user_id' => auth()->user()->id,
            'notification_title' =>  $inputs['notification_title'],
            'notification_description' =>  $inputs['notification_description'], //global , personal, group
        ]);

        return $listener->successful();
    }





}

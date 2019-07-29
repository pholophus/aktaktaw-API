<?php

namespace App\Processors\Auth;

use Carbon\Carbon;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\User as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function login($listener, array $inputs)
    {
        $validator = $this->validator->on('login')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }
        $email = $inputs['email'];
        $password = $inputs['password'];

        try {
            $user = UserModel::where('email',$inputs['email'])->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->accountDoesNotExistsError();
        }

        if (! $token = auth()->attempt(['email' => $email, 'password' => $password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $listener->accountAuthenticated($token);
    }

    public function register($listener, array $inputs)
    {
        $validator = $this->validator->on('register')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }
        $name = $inputs('name');

        // check user
        try {
            $user = UserModel::where('email',$inputs['email'])->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->accountDoesNotExistsError();
        }


        // check role
        try {
            $user = UserModel::where('name',$inputs['role'])->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->accountDoesNotExistsError();
        }
        $password = randomPassword();
        UserModel::create([
            'email' => $inputs['email'],
            'name' => $inputs['name'],
            'password'=>bcrypt($password)
        ]);



        return $listener->accountAuthenticated($token);
    }

    public function resetPassword($listener, array $inputs)
    {
        if(!checkUserAccess('management'))
            return setApiResponse('error','access');
        $validator = $this->validator->on('reset')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not reset password', $validator->errors());
        }

        $password = $inputs['password'];

        try {
            $user = UserModel::where('email',$inputs['email'])->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->accountDoesNotExistsError();
        }

        $user->update([
            'password' =>bcrypt($password)
        ]);

        return setApiResponse('success','updated','user');
    }


}

<?php

namespace App\Http\Controllers\V1\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Auth\Authenticate as AuthProcessor;
use App\Http\Transformers\AuthTransformer;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(AuthProcessor $processor)
    {
        return $processor->login($this, Input::all());
    }
    public function resetPassword(AuthProcessor $processor)
    {
        return $processor->resetPassword($this, Input::all());
    }

    public function logout()
    {
        Auth::logout();
        return $this->response->array([
            'status' => 'success',
            'message' => 'Successfully logout from the system',
        ]);
    }



    public function accountAuthenticated($token){
        return $this->response->array(['data' => [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]]);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Error authenticating account', $errors);
    }

    public function accountDoesNotExistsError()
    {
        return $this->response->errorNotFound("Account does not exists");
    }

    public function successMessage($type){
        switch($type){
            case 'updated' : $typeInfo = 'successfully update password';
            break;
            default : $typeInfo = 'Something missing.';
            break;
        }

        $response = [
            "status" => "success",
            "message" => $typeInfo
        ];
        return response()->json($response,200);
    }

}

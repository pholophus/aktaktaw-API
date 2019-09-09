<?php

namespace App\Processors\Profile;

use Carbon\Carbon;
use App\Models\User as UserModel;
use App\Models\Media as MediaModel;
use App\Models\Profile as ProfileModel;
use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Profile as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class Profile extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function show($listener){
        // $userId= auth()->user()->id;

        // $profile = ProfileModel::where('user_id',$userId)->firstorfail();

        return $listener->showUserProfile(auth()->user());
    }

    public function update($listener, array $inputs)
    {
        //use validator when retrieving input
        if  (!Input::has('avatar_file_path') && !Input::hasFile('resume_file_path')) 
        {
            $validator = $this->validator->on('update')->with($inputs);
            if ($validator->fails()) {
                throw new UpdateFailed('Could not update user', $validator->errors());
            }
            $profile = auth()->user()->profile();
            $profile->update([
                'first_name' =>  $inputs['first_name'] ,
                'last_name' =>  $inputs['last_name'] ,
                'phone_no' => cleanPhoneNumber($inputs['phone_no']),
            ]);

            $user = auth()->user();

            $user->update([
                'translator_status_id' => $inputs['translator_status'],
                'is_new' => $inputs['is_new']
            ]);

            $id = auth()->user()->id;

            $user->languages()->where('user_id',$id)->sync([
                'language_id' => $inputs['languages'],
            ]);

            $user->expertises()->where('user_id',$id)->sync([
                'expertise_id' => $inputs['expertise'],
            ]);
        }

       if(Input::hasFile('avatar_file_path')){
            $validator = $this->validator->on('image')->with($inputs);
            $user = auth()->user()->profile();
            $media = auth()->user()->media();
            $image = Input::file('avatar_file_path');

            $image_name = time() . '-'. $image->getClientOriginalName();
            $image_mime = $image->getMimeType();

            Storage::disk('public')->put('uploads/'.$image_name, 'public');

            $user->update([
                'avatar_file_path' => asset('uploads/'.$image_name),
            ]);

            $media = MediaModel::updateorcreate([
                'file_name' => $image_name,
                'type' => 'Image',
                'folder' => 'uploads',
                'path' =>  'uploads/'.$image_name,
                'mime_type' =>  $image_mime,
                'user_id' => auth()->user()->id
            ]);
       }

        if (Input::hasFile('resume_file_path')){
            $validator = $this->validator->on('resume')->with($inputs);
            $user = auth()->user()->profile();
            $media = auth()->user()->media();
            $resume = Input::file('resume_file_path');
            //dd($resume);
            $resume_name = time() . '-'. $resume->getClientOriginalName();
            $resume_mime = $resume->getClientMimeType();

            Storage::disk('public')->put('uploads/'.$resume_name, 'public');
            
            $user->update([
                'resume_file_path' => asset('uploads/'.$resume_name),
            ]);

            $media = MediaModel::updateorcreate([
                'file_name' => $resume_name,
                'type' => 'Resume',
                'folder' => 'uploads',
                'path' =>  'uploads/'.$resume_name,
                'mime_type' =>  $resume_mime,
                'user_id' => auth()->user()->id
            ]);
       }

        return setApiResponse('success','updated','user profile');
    }

    public function updatePassword($listener, array $inputs){
        $validator = $this->validator->on('Password')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update user', $validator->errors());
        }

        $user = auth()->user();

        $password = $inputs['password'];
        $user->update([
            'password' => bcrypt($password),
        ]);
        
        return setApiResponse('success','updated','user password');
    }

}


<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    // public __constructor() {
    //     $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all()->sortByDesc('created_at');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|min:8'
        ]);

        $hash = Hash::make(request()->password, [ 'rounds' => 12 ]);
        request()['password'] = $hash;

        if ($validate) {
            $user = User::create(request()->all());
        }

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function profile()
    {   
        $user = auth('api')->user();
        // $user->profile_picture =  $user->profile_picture;

        return $user;
    }
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        // Converting the Base64 encoding to a string 
        if($request->profile_picture && !$user->profile_picture){
            $name = time().'.' . explode('/', explode(':', substr($request->profile_picture, 0, strpos($request->profile_picture, ';')))[1])[1];
            \Image::make($request->profile_picture)->save(public_path('img/profile/').$name);
            $currentPhoto = $request->merge(['profile_picture' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;

             if(file_exists($userPhoto)){
                $request->profile_picture = $userPhoto;
                @unlink($userPhoto);
            }

        }else{
            $request->profile_picture = $user->profile_picture;
        }
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',
            'profile_photo' => 'sometimes|string|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validate) {
            $user->update($request->all());
        }

       return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8'
        ]);

        if ($validate) {
            $user->update($request->all());
        }

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['response' => true];
    }
}

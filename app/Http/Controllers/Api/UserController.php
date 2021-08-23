<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;

class UserController extends Controller
{   
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        $profile = auth()->user();
        return response()->json([
            'message' => 'Profile retrieved',
            'response' => compact('profile')
        ], 200);
    }
    /**
     * Get the update User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRules($id, $password) {
        $rules = [
            'name' => 'required|string|max:255',            
            'avatar' => 'required|mimes:jpeg,jpg,png,gif',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id.',id',
        ];
        if ($password) {
            $rules['password'] = 'required|string|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }
        return $rules;
    }
    public function updateProfile(Request $request) { 
        $user = auth()->user();
        $validator = Validator::make($request->all(), self::storeRules($user->id, $request->password));
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], 401);
        }
        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            return response()->json([
                'message' => "The email must be a valid email address.",
            ], 401);
        }
        /*list($width, $height) = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($width != '256' || $height != 256) {
            return response()->json([
                'message' => "Image dimension is required: 256px x 256px.",
            ], 400);
        }*/
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->file('avatar')) {
            $user->avatar = $this->fileuploadExtra($request, 'avatar');
        }  
        if ($request->input('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->updated_at = new DateTime;
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }
}
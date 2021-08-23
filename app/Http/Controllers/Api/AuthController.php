<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    OtpVerification
};
use JWTAuth;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;


class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginRules() {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), self::loginRules($request));
        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()->first()], 401);        }
        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            return response()->json(['message' => "The email must be a valid email address."], 401);
        }
        $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => "Oppes! You have entered invalid credentials." ], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRules() {
        return [
            'email' => 'required|string|email|max:255|unique:users'
        ];
    }
    public function register(Request $request) {
        $validator = Validator::make($request->all(), self::storeRules());
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], 400);
        }
        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            return response()->json([
                'message' => "The email must be a valid email address.",
            ], 400);
        }

        $otp = rand(000000, 111111);

        $user = new User();
        $user->email = $request->email;
        $user->activation_key = $otp;
        $user->user_role = 'user';
        $user->created_at = new DateTime;
        $user->updated_at = new DateTime;
        $user->save();

        $name = 'Dear';
        $email = $request->input('email');
        $emailSubject = 'Activation Link At Demo Site';
        $activation_key = $otp;
        $emailBody = view('Email.RegisterVerifyEmailLink', compact('name', 'activation_key', 'email'));
        $this->SendEmail($email, $emailSubject, $emailBody, [], '', '', '', '');
        return Response()->json(['status'=>'success', 'message' => 'For account Activation email has been sent you.', 'response' => compact('otp') ],200);

    }

    public function storeCompleteRules() {
        return [
            'otp' => 'required',
            'name' => 'required',
            'user_name' => 'required|string|min:4|max:20|unique:users',
            'avatar' => 'required|mimes:jpeg,jpg,png,gif',
            'password' => 'required|min:8|max:13'
        ];
    }
    public function completeRegisteration(Request $request) {
        $validator = Validator::make($request->all(), self::storeCompleteRules());
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], 400);
        }
        list($width, $height) = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($width != '256' || $height != 256) {
            return response()->json([
                'message' => "Image dimension is required: 256px x 256px.",
            ], 400);
        }
        $activation_key = $request->otp;

        $user = User::where('activation_key', $activation_key)->get()->first();
        if (!$user) {
            return response()->json([
                'message' => "No User found, please check your activation key.",
            ], 400);
        }
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        if ($request->file('avatar')) {
            $user->avatar = $this->fileuploadExtra($request, 'avatar');
        }  
        $user->password = Hash::make($request->password);
        $user->activation_key = '';
        $user->registered_at = new DateTime;
        $user->updated_at = new DateTime;
        $user->save();
        return Response()->json(['status'=>'success', 'message' => 'Profile complete now you can login to your account.', 'response' => compact('user') ],200);

    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }    

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
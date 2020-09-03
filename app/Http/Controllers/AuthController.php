<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $params         = $request->only('email', 'name', 'password');
        $user           = new User();
        $user->email    = $params['email'];
        $user->name     = $params['name'];
        $user->password = bcrypt($params['password']);
        $user->save();
        return response()->json($user, Response::HTTP_OK);
    }

//if (Auth::attempt(['userName' => $request->userName, 'password' => $request->passHash])) {
//    // Do something
//}else if(Auth::attempt(['loginName' => $request->loginName, 'password' =>
//    $request->passHash])){
//    //Do something too
//}

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!($token = JWTAuth::attempt($credentials))) {
            return response()->json(\getResponse([], META_CODE_ERROR, MSG_LOGIN_FAIL), Response::HTTP_BAD_REQUEST);
        }
        $remember_token       = explode(".", $token);
        $user                 = User::where('email','like',$credentials['email'])->first();
        $user->remember_token = $remember_token[2];
        $user->save();
        return response()->json(\getResponse(['token' => $token, 'userInfo' => $user, 'type'=> $user->role], META_CODE_SUCCESS));
    }

    public function user(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response($user, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_BAD_REQUEST);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'password'     => 'required | max:255',
                'passwordNew'     => 'required | max:27 | min:6',
                'passwordConfirm' => 'required | max:27 | min:6',
                'email'           => 'required | email',
            ]);
            if($validator->fails() || $input['password'] == $input['passwordNew'] || $input['passwordNew'] != $input['passwordConfirm']){
                return response()->json(\getResponse([], META_CODE_ERROR, MSG_CHANGE_PASSWORD_VALIDATE), Response::HTTP_BAD_REQUEST);
            }
            $credentials = $request->only('email', 'password');
            if (!($token = JWTAuth::attempt($credentials))) {
                return response()->json(\getResponse([], META_CODE_ERROR, MSG_CHANGE_PASSWORD_PASS_FAIL), Response::HTTP_BAD_REQUEST);
            }
            $userNew           = Auth::user();
            $userNew->password = bcrypt($request->passwordNew);
            $userNew->save();
            return response()->json(\getResponse($user, META_CODE_SUCCESS, MSG_CHANGE_PASSWORD_SUCCESS), Response::HTTP_OK);
        }

        return response(null, Response::HTTP_BAD_REQUEST);
    }

    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json('You have successfully logged out.', Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json('Failed to logout, please try again.', Response::HTTP_BAD_REQUEST);
        }
    }

    public function refresh()
    {
        return response(JWTAuth::getToken(), Response::HTTP_OK);
    }
}

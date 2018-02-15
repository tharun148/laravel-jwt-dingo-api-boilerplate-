<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignupRequest;
use App\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function signUp(SignupRequest $request)
    {
        $user = new User($request->all());
        try{
            $user->save(); // returns false
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 'ok',
                'message' => $e->getMessage()
            ], 201);
        }
        return response()->json([
            'status' => 'ok'
        ], 201);
    }

    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);
        try {
            $token = Auth::guard()->attempt($credentials);
            if(!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            throw new HttpException(500);
        }
        return response()
            ->json([
                'status' => 'ok',
                'token' => $token,
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        Auth::guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function sendResetEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', '=', $request->get('email'))->first();
        if(!$user) {
            throw new NotFoundHttpException();
        }
        $broker = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink($request->only('email'));
        if($sendingResponse !== Password::RESET_LINK_SENT) {
            throw new HttpException(500);
        }
        return response()->json([
            'status' => 'ok'
        ], 200);
    }
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function getPasswordBroker()
    {
        return Password::broker();
    }

    public function resetPassword(ResetPasswordRequest $request, JWTAuth $JWTAuth)
    {
        $response = $this->getPasswordBroker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->reset($user, $password);
        }
        );
        if($response !== Password::PASSWORD_RESET) {
            throw new HttpException(500);
        }
        return response()->json([
            'status' => 'ok',
        ]);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  ResetPasswordRequest  $request
     * @return array
     */
    protected function credentials(ResetPasswordRequest $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function reset($user, $password)
    {
        $user->password = $password;
        $user->save();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = Auth::guard()->refresh();
        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'expires_in' => Auth::guard()->factory()->getTTL() * 60
        ]);
    }

}

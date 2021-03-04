<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JWTAuthController extends Controller
{
    /**
     * The validation logic that will be applied to validate user input.
     *
     * @var array
     */
    private $register_validation_rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string',
    ];
    private $login_validation_rules = [
        'email' => 'required|string',
        'password' => 'required|string',
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $this->validate($request, $this->register_validation_rules);
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (Exception $exception) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!', "detail"=>$exception], 409);
        }

    }


    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        try{//validate incoming request
            $this->validate($request, $this->login_validation_rules);

            $credentials = $request->only(['email', 'password']);

            if (! $token = Auth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $user = User::where('email',$request->input('email'))->first ();

            return $this->respondWithToken($token, $user);
        }catch (Exception $exception) {
            //return error message
            return response()->json(['message' => 'User Login Failed!', "detail"=>$exception], 405);
        }
    }
}

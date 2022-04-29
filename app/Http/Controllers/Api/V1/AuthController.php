<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location\Mapbox;
use App\Utils\Api\V1\ApiResponder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'city' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ApiResponder::response(null, ApiResponder::HTTP_UNPROCESSABLE_ENTITY, $validator->getMessageBag());
        }

        $mapbox = new Mapbox();
        $locationFeatures = $mapbox->getLocation($request->city);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'city' => ucfirst($request->city),
            'longitude' => $locationFeatures['longitude'],
            'latitude' => $locationFeatures['latitude']
        ]);

        if ($user) {
            return ApiResponder::response($user, ApiResponder::HTTP_CREATED, 'Your registration was successful');
        }
        return ApiResponder::response(null, ApiResponder::HTTP_UNPROCESSABLE_ENTITY, 'There was a problem registering you.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return ApiResponder::response(null, ApiResponder::HTTP_UNPROCESSABLE_ENTITY, $validator->getMessageBag());
        }

        $user = User::where('email', $request->email)->first();

        if (is_null($user) || !Hash::check($request->password, $user->password)) {
            return ApiResponder::response(null, ApiResponder::HTTP_UNAUTHORIZED, 'email or password is incorrect');
        }

        $token = $user->createToken('nitaco')->plainTextToken;

        return ApiResponder::response([
            'user' => $user,
            'token' => $token
        ], ApiResponder::HTTP_OK, 'Your information and access token is as follows:');
    }
}

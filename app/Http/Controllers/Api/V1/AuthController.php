<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location\Mapbox;
use App\Traits\Api\V1\ApiResponser as V1ApiResponser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use V1ApiResponser;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'city' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(422, $validator->getMessageBag());
        }

        $mapbox = new Mapbox();
        $locationFeatures = $mapbox->getLocation($request->city);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'city' => $request->city,
            'longitude' => $locationFeatures['longitude'],
            'latitude' => $locationFeatures['latitude']
        ]);

        if ($user) {
            return $this->successResponse($user, 201, 'Your registration was successful');
        }
        return $this->errorResponse(422, 'There was a problem registering you.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(422, $validator->getMessageBag());
        }

        $user = User::where('email', $request->email)->first();

        if (is_null($user) || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse(422, 'Username or password is incorrect');
        }

        $token = $user->createToken('nitaco')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token
        ], 200, 'Your information and access token is as follows:');
    }
}

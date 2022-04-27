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
}

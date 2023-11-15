<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Knuckles\Scribe\Attributes\Group;

#[Group("Token")]
class AuthTokenController extends Controller
{
    public function create(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $credentials)->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
//            return response()->json(['error' => $e->getMessage()], 500);
            throw ValidationException::withMessages(['email' => 'Provided credentials do not match any record']);
        }

        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token' => $token]);
    }

//    public function imitate(ImitateRequest $request)
//    {
//        $fields = $request->validated();
//        $user = User::where('email', $fields['email'])->first();
//
//        if ($user->accounts()->count() == 0) {
//            throw ValidationException::withMessages(['email' => 'Can not imitate user with no accounts.']);
//        }
//
//        $token = $user->createToken('gpx-imitation')->plainTextToken;
//        return response()->json(['token' => $token]);
//    }

    public function destroy(Request $request)
    {
        $token = $request->user()?->currentAccessToken();
        if (!$token) {
            return response()->json(['message' => 'ok']);
        }
        $token->relatedToken?->delete();
        $token->delete();
        return response()->json(['message' => 'ok']);
    }
}

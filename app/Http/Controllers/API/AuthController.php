<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        dd($request->all());
        $request->validate([
            'email'    => 'required|string|email|max:255',
            'password' => 'required|min:8|max:15',
        ]);
        dd($request->all());
//         $user =
//         dd($request->all());*/
    }

    public function register(Request $request)
    {
        $request->validate([
            'user_id'       => 'required',
            'first_name'    => 'required|min:3|max:255',
            'last_name'     => 'required|min:3|max:255',
            'email'         => 'required|email|unique:users,email',
            'mobile_number' => 'required|digits:10',
            'password'      => 'required|min:8|max:15',
            'birth_of_date' => 'required|date|before_or_equal:today',
            'profile'       => 'required|file|mimes:png,jpg|max:6144',
        ]);

        try {
            $user = new User;
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $fileName = time() . '.' . $file->getClientOriginalName();
                $file->move('profile_image', $fileName);
                $user->profile = $fileName;
            }
            $user->user_id = $request->user_id;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->mobile_number = $request->mobile_number;
            $user->password = Hash::make($request->password);
            $user->bod = $request->birth_of_date;
            $user->save();
            $token = $user->createToken('API Token')->accessToken;

            return response()->json([
                'status'  => 200,
                'massage' => 'User registered successfully',
                'token'   => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 200,
                'massage' => $e->getMessage()
            ]);
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->user_role == "super-admin") {
            $users = User::whereNot('user_role', 'super-admin')->latest()->Paginate(5);
        } else {
            $users = User::where('user_id', Auth::id())->latest()->Paginate(5);
        }

        if ($request->ajax()) {
            if (Auth::user()->user_role == "super-admin") {
                $users = User::whereNot('user_role', 'super-admin')->latest()->Paginate(5);
            } else {
                $users = User::where('user_id', Auth::id())->latest()->Paginate(5);
            }
            return view('user.user-pagination', compact('users'))->render();
        }

        return view('user.index', compact('users'));
    }


    public function fetchUserEdit(Request $request)
    {
        $user = User::find($request->user_id);
        return response()->json([
            'status'  => true,
            'data'    => $user,
            'massage' => 'user data fetched successfully'
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user_id == 0) {
            $request->validate([
                'name'     => 'required|min:3|max:255',
                'email'    => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8|max:15',
            ]);
        } else {
            $request->validate([
                'name'     => 'required|min:3|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $request->user_id,
                'password' => 'nullable|min:8|max:15',
            ]);
        }
        try {
            if (!empty($request->user_id)) {
                $user = User::find($request->user_id);
                $sucessMassage = "updated";
            } else {
                $user = new User;
                $sucessMassage = "stored";
            }
            $user->name = $request->name;
            $user->email = $request->email;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return response()->json([
                'status'  => true,
                'data'    => $request->user_id,
                'message' => 'User ' . $sucessMassage . ' successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $user = User::find($request->userId);
            if (isset($user)) {
                $user->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'User deleted successfully'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => "User not found!"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}

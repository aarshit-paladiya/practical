<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
                $users = User::whereNot('user_role', 'super-admin');
                if ($request->has('search') && $request->search != null) {
                    $users->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%')
                        ->orWhere('mobile_number', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                }
                if ($request->filled('startDate') && $request->filled('endDate')) {
                    $users->whereBetween('created_at', [$request->startDate, date('Y-m-d', strtotime($request->endDate . ' +1 day'))]);
                } elseif ($request->filled('startDate')) {
                    $users->where('created_at', '>=', $request->startDate);
                } elseif ($request->filled('endDate')) {
                    $users->where('created_at', '<=', date('Y-m-d', strtotime($request->endDate . ' +1 day')));
                }
                if ($request->has('status') && $request->status != null) {
                    $users->where('status', $request->status);
                }
                $users = $users->latest()->Paginate(5);
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
                'first_name'    => 'required|min:3|max:255',
                'last_name'     => 'required|min:3|max:255',
                'email'         => 'required|email|max:255|unique:users,email',
                'mobile_number' => 'required|integer|digits:10',
                'bod'           => 'required|date|before_or_equal:today',
                'profile'       => 'required|file|mimes:png,jpg|max:6144',
                'password'      => 'required|min:8|max:15',
            ]);
        } else {
            $request->validate([
                'first_name'    => 'required|min:3|max:255',
                'last_name'     => 'required|min:3|max:255',
                'email'         => 'required|email|max:255|unique:users,email,' . $request->user_id,
                'mobile_number' => 'required|integer|digits:10',
                'bod'           => 'required|date|before_or_equal:today',
                'profile'       => 'nullable|mimes:png,jpg|max:6144',
                'password'      => 'nullable|min:8|max:15',
            ]);
        }
        try {
            if (!empty($request->user_id)) {
                $user = User::find($request->user_id);
                $successMassage = "updated";
            } else {
                $user = new User;
                $successMassage = "stored";
            }
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $fileName = time() . '.' . $file->getClientOriginalName();
                $file->move('profile_image', $fileName);
                $user->profile = $fileName;
            }
            $user->mobile_number = $request->mobile_number;
            $user->bod = $request->bod;
            $dob = Carbon::parse($request->bod);
            $age = $dob->diff(Carbon::now())->format('%y.%m');
            $user->age = $age;
            $user->status = $request->status == 'on' ? '1' : '0';
            $user->save();
            return response()->json([
                'status'  => true,
                'data'    => $request->user_id,
                'message' => 'User ' . $successMassage . ' successfully'
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

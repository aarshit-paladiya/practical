<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::latest();
            if ($request->has('search') && $request->search != "") {
                $users->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('mobile_number', 'like', '%' . $request->search . '%');
            }
            if ($request->has('status') && $request->status != "") {
                $users->where('status', $request->status);
            }
            $users = $users->paginate(6);
            return view('user-list.ajax-paginate-user', compact('users'))->render();
        }
        $users = User::latest()->paginate(6);
        return view('user-list.index', compact('users'));
    }
}

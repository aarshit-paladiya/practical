@extends('layout.app')
@section('title') Home @endsection
@section('content')
    <div class="row mt-4" id="user-page-search">
        <div class="col-12">
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="card-body">
                    <div class="text-info">Welcome to {{ config('app.name') }} . Your role
                        is {{\Illuminate\Support\Facades\Auth::user()->user_role}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

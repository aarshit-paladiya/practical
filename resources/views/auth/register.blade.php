@extends('auth.layout.app')
@section('title') Register @endsection
@section('content')
    <style>
        label.error {
            color: red;
        }
    </style>
    <div class="row justify-content-around align-items-center" style="height: 100vh">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Register
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('register.post')}}" method="post" id="register">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <label class="justify-content-end  d-flex">Name :</label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="name" name="name"
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <span class="text-danger">{{$massage}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <label class="justify-content-end  d-flex">Email :</label>
                            </div>
                            <div class="col-8">
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <span class="text-danger">{{$massage}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <label class="justify-content-end  d-flex">Password :</label>
                            </div>
                            <div class="col-8">
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="text-danger">{{$massage}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{route('login')}}" class="btn btn-secondary">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#register').validate({

            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                },
            },
            messages: {
                name: {
                    required: "Please specify your name",
                },
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of demo@example.com"
                }
            },
        });
    </script>
@endpush

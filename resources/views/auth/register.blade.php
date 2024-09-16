@extends('layouts.app', ['pageTitle' => 'Signup'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h1 class="text-center mt-5">Create your account</h1>
            <form class="card" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">New Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Create Account</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted mt-3">
                Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app', ['pageTitle' => 'Login'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h1 class="text-center mt-5">Login to your account</h1>
            <form class="card" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password

                            @if (Route::has('password.request'))
                                <span class="form-label-description">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">I forgot password</a>
                                </span>
                            @endif
                        </label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted mt-3">
                Don't have an account yet? <a href="{{ route('register') }}" class="text-decoration-none">Create an account</a>
            </div>
        </div>
    </div>
</div>
@endsection

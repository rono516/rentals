@extends('layouts.app', ['pageTitle' => 'Reset Password'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h1 class="text-center mt-5">Reset Password</h1>
            <form class="card card-md" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted mt-3">
                Forget it, <a href="{{ route('login') }}" class="text-decoration-none">send me back</a> to the sign in screen.
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app', ['pageTitle' => 'Set Password'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1>Set Password</h1>
                <p>Set the password to your tenant account.</p>
            </div>
            <form role="form" method="POST" action="{{ route('tenants.password.store', ['inviteUuid' => $tenant->invite_code]) }}">
                @csrf
                <input type="hidden" name="email" value="{{ $tenant->user->email }}">
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
                    <button type="submit" class="btn btn-primary w-100">Set Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
